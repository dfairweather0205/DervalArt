<?php

namespace Pikart\WpBase\Admin\Migration;

use Pikart\WpBase\NavigationMenus\NavigationMenusOption;
use Pikart\WpBase\NavigationMenus\NavigationMenusUtil;
use Pikart\WpCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpCore\Admin\Migration\MigrationFilterName;
use Pikart\WpCore\Common\DataSanitizer;
use Pikart\WpCore\Shortcode\ShortcodeConfig;
use WP_Import;

if ( ! class_exists( __NAMESPACE__ . '\\WpImporterExtension' ) ) {

	/**
	 * Class WpImporterExtension
	 * @package Pikart\WpBase\Admin\Migration
	 */
	class WpImporterExtension {

		/**
		 * @var DataSanitizer
		 */
		private $dataSanitizer;

		/**
		 * WpImporterExtension constructor.
		 *
		 * @param DataSanitizer $dataSanitizer
		 */
		public function __construct( DataSanitizer $dataSanitizer ) {
			$this->dataSanitizer = $dataSanitizer;
		}

		public function run() {
			$this->processPostContent();
			$this->processPostMetaFields();
			$this->importNavigationMenuItemsOptions();
		}

		/**
		 * @return array
		 */
		private function getShortcodesToCheck() {
			return array( 'album', 'projects', 'products' );
		}

		/**
		 * @return array
		 */
		private function getShortcodeAttributesToCheck() {
			return array( 'categories', 'tags' );
		}

		private function processPostContent() {
			$replaceOldTermIdsInShortcodesCallback = $this->replaceOldTermIdsInShortcodesCallback();

			add_filter( 'wp_import_post_data_processed', function ( $postdata ) use (
				$replaceOldTermIdsInShortcodesCallback
			) {
				$postdata['post_content'] = $replaceOldTermIdsInShortcodesCallback( $postdata['post_content'] );

				return $postdata;
			} );
		}

		private function processPostMetaFields() {
			$replaceOldTermIdsCallback             = $this->replaceOldTermIdsCallback();
			$replaceOldTermIdsInShortcodesCallback = $this->replaceOldTermIdsInShortcodesCallback();

			$metaFieldNameMapper = function ( $metaFiled ) {
				return MetaBoxConfigBuilder::DB_PREFIX . $metaFiled;
			};

			add_filter( 'wp_import_post_meta', function ( $postMeta ) use (
				$replaceOldTermIdsCallback, $replaceOldTermIdsInShortcodesCallback, $metaFieldNameMapper
			) {

				$metaFieldsWithShortcodes = array_map(
					$metaFieldNameMapper, apply_filters( MigrationFilterName::metaFieldsWithShortcodes(), array() ) );
				$metaFieldsWithTermIds    = array_map(
					$metaFieldNameMapper, apply_filters( MigrationFilterName::metaFieldsWithTermIds(), array() ) );

				foreach ( $postMeta as &$meta ) {
					if ( in_array( $meta['key'], $metaFieldsWithShortcodes ) ) {
						$meta['value'] = $replaceOldTermIdsInShortcodesCallback( $meta['value'] );
						continue;
					}

					if ( ! in_array( $meta['key'], $metaFieldsWithTermIds ) ) {
						continue;
					}

					$metaValue = maybe_unserialize( $meta['value'] );

					if ( empty( $metaValue ) || ! is_array( $metaValue ) ) {
						continue;
					}

					$meta['value'] = maybe_serialize( $replaceOldTermIdsCallback( $metaValue ) );
				}

				return $postMeta;
			} );
		}

		/**
		 * @return \Closure
		 */
		private function replaceOldTermIdsInShortcodesCallback() {
			$replaceOldTermIdsInShortcodeAttributesCallback = $this->replaceOldTermIdsInShortcodeAttributesCallback();

			$shortcodesToCheck = array_map( function ( $shortcodeName ) {
				return ShortcodeConfig::NAME_PREFIX . $shortcodeName;
			}, $this->getShortcodesToCheck() );

			return function ( $data ) use ( $shortcodesToCheck, $replaceOldTermIdsInShortcodeAttributesCallback ) {
				$shortcodeRegexPattern = '/' . get_shortcode_regex() . '/s';

				$doReplaceOldTermIds = function ( $text ) use (
					$shortcodeRegexPattern, $shortcodesToCheck,
					$replaceOldTermIdsInShortcodeAttributesCallback, &$doReplaceOldTermIds
				) {
					return preg_replace_callback( $shortcodeRegexPattern, function ( $matches ) use (
						$shortcodesToCheck, $replaceOldTermIdsInShortcodeAttributesCallback, $doReplaceOldTermIds
					) {

						$shortcodeName = $matches[2];
						$input         = $matches[0];

						if ( in_array( $shortcodeName, $shortcodesToCheck ) ) {
							$newAttributesText = $replaceOldTermIdsInShortcodeAttributesCallback( $matches[3] );
							$input             = str_ireplace( $matches[3], $newAttributesText, $input );
						}

						// if shortcode has no content
						if ( empty( $matches[5] ) ) {
							return $input;
						}

						$newContent = $doReplaceOldTermIds( $matches[5] );

						return str_ireplace( $matches[5], $newContent, $input );
					}, $text );
				};

				return $doReplaceOldTermIds( $data );
			};
		}

		/**
		 * @return \Closure
		 */
		private function replaceOldTermIdsInShortcodeAttributesCallback() {
			$replaceOldTermIdsCallback = $this->replaceOldTermIdsCallback();
			$attributesToCheck         = $this->getShortcodeAttributesToCheck();

			return function ( $text ) use ( $replaceOldTermIdsCallback, $attributesToCheck ) {

				return preg_replace_callback( get_shortcode_atts_regex(), function ( $matches ) use (
					$replaceOldTermIdsCallback, $attributesToCheck
				) {
					$attributeName = strtolower( $matches[1] );

					if ( empty( $attributeName ) || ! in_array( $attributeName, $attributesToCheck )
					     || empty( $matches[2] )
					) {
						return $matches[0];
					}

					$attributeValue = $matches[2];
					$termIds        = explode( ',', $attributeValue );

					$newAttributeValue = implode( ',', $replaceOldTermIdsCallback( $termIds ) );

					return sprintf( '%s="%s" ', $attributeName, $newAttributeValue );
				}, $text );
			};
		}

		/**
		 * @return \Closure
		 */
		private function replaceOldTermIdsCallback() {
			return function ( $oldTermIds ) {
				if ( empty( $oldTermIds ) ) {
					return array();
				}

				/** @var WP_Import $wpImport */
				$wpImport        = $GLOBALS['wp_import'];
				$oldToNewTermIds = $wpImport->processed_terms;

				$newTermIds = array();

				foreach ( $oldTermIds as $termId ) {
					// do not replace non-numeric values: slugs, names ...
					if ( ! is_numeric( $termId ) ) {
						$newTermIds[] = $termId;
						continue;
					}

					if ( isset( $oldToNewTermIds[ $termId ] ) ) {
						$newTermIds[] = $oldToNewTermIds[ $termId ];
					}
				}

				return array_unique( $newTermIds );
			};
		}

		/**
		 * @since 1.4.0
		 */
		private function importNavigationMenuItemsOptions() {
			$dataSanitizer     = $this->dataSanitizer;
			$importedMenuItems = array();

			add_filter( 'wp_import_posts', function ( $posts ) use ( &$importedMenuItems ) {
				$importedMenuItems = array_filter( $posts, function ( $post ) {
					return 'nav_menu_item' === $post['post_type'];
				} );

				return $posts;
			} );

			add_action( 'import_end', function () use ( &$importedMenuItems, $dataSanitizer ) {
				/* @var WP_Import $wpImport */
				$wpImport = $GLOBALS['wp_import'];

				$menuItemOptionNameMapper = function ( $option ) {
					return NavigationMenusUtil::MENU_ITEM_DB_PREFIX . $option;
				};

				$options            = array_map( $menuItemOptionNameMapper, NavigationMenusOption::getOptions() );
				$optionsWithPostIds = array_map( $menuItemOptionNameMapper, array(
					NavigationMenusOption::BACKGROUND_IMAGE
				) );

				foreach ( $importedMenuItems as $menuItem ) {
					if ( ! isset( $wpImport->processed_menu_items[ $menuItem['post_id'] ] ) ) {
						continue;
					}

					$menuItemDbId = $wpImport->processed_menu_items[ $menuItem['post_id'] ];

					foreach ( $menuItem['postmeta'] as $meta ) {
						$option      = $meta['key'];
						$optionValue = $meta['value'];

						if ( ! in_array( $option, $options ) || empty( $optionValue ) ) {
							continue;
						}

						// replace old postId with the new one
						if ( in_array( $option, $optionsWithPostIds )
						     && isset( $wpImport->processed_posts[ $optionValue ] ) ) {
							$optionValue = $wpImport->processed_posts[ $optionValue ];
						}

						update_post_meta( $menuItemDbId, $option, $dataSanitizer->sanitize( $optionValue ) );
					}
				}
			} );
		}
	}
}