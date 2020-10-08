<?php

namespace Pikart\WpBase\Admin\Media\WpGallery;

use Pikart\WpBase\Common\AssetHandle;

if ( ! class_exists( __NAMESPACE__ . '\WpGalleryBlockCustomizer' ) ) {

	/**
	 * Class WpGalleryBlockCustomizer
	 * @package Pikart\WpBase\Admin\Media\WpGallery
	 *
	 * @since 1.5.7
	 */
	class WpGalleryBlockCustomizer {

		const GALLERY_BLOCK_NAME = 'core/gallery';
		const COLUMNS_SPACING_SETTING = 'columnsSpacing';

		/**
		 * @var WpGalleryShortcodeContentFilter
		 */
		private $wpGalleryShortcodeContentFilter;

		/**
		 * WpGalleryCustomizer constructor.
		 *
		 * @param WpGalleryShortcodeContentFilter $wpGalleryShortcodeContentFilter
		 */
		public function __construct( WpGalleryShortcodeContentFilter $wpGalleryShortcodeContentFilter ) {
			$this->wpGalleryShortcodeContentFilter = $wpGalleryShortcodeContentFilter;
		}

		public function customize() {
			$this->enqueueAssets();
			$this->applyColumnsSpacing();
		}

		private function applyColumnsSpacing() {
			$wpGalleryShortcodeContentFilter = $this->wpGalleryShortcodeContentFilter;

			add_filter( 'render_block', function ( $content, $block ) use ( $wpGalleryShortcodeContentFilter ) {
				if ( $block['blockName'] !== WpGalleryBlockCustomizer::GALLERY_BLOCK_NAME ) {
					return $content;
				}

				$attributes           = $block['attrs'];
				$columnsSpacingConfig = WpGalleryConfig::getColumnsSpacingConfig();
				$columnsSpacing       = isset( $attributes[ WpGalleryBlockCustomizer::COLUMNS_SPACING_SETTING ] )
					? $attributes[ WpGalleryBlockCustomizer::COLUMNS_SPACING_SETTING ] : $columnsSpacingConfig['default'];

				return $wpGalleryShortcodeContentFilter->filter( $content, array(
					WpGalleryConfig::COLUMNS_SPACING_SETTING => $columnsSpacing
				) );
			}, 10, 2 );
		}

		private function enqueueAssets() {
			add_action( 'enqueue_block_editor_assets', function () {
				wp_enqueue_script( AssetHandle::adminBlockCoreGallery() );

				wp_localize_script( AssetHandle::adminBlockCoreGallery(),
					PIKART_SLUG . 'GalleryConfig',
					array(
						'settings' => array(
							WpGalleryBlockCustomizer::COLUMNS_SPACING_SETTING => WpGalleryConfig::getColumnsSpacingConfig()
						)
					) );
			} );
		}
	}
}