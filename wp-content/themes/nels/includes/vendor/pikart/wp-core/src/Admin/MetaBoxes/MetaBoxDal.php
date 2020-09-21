<?php

namespace Pikart\WpThemeCore\Admin\MetaBoxes;

use Pikart\WpThemeCore\Common\DataSanitizer;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxDal' ) ) {
	/**
	 * Class MetaBoxDal
	 * @package Pikart\WpThemeCore\Admin\MetaBoxes
	 */
	class MetaBoxDal {

		/**
		 * @var DataSanitizer
		 */
		private $dataSanitizer;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * MetaBoxDal constructor.
		 *
		 * @param DataSanitizer $dataSanitizer
		 * @param Util $util
		 */
		public function __construct( DataSanitizer $dataSanitizer, Util $util ) {
			$this->dataSanitizer = $dataSanitizer;
			$this->util          = $util;
		}

		/**
		 * @param int $postId
		 * @param array $metaBoxConfig
		 */
		public function saveMetaBoxData( $postId, array $metaBoxConfig ) {
			if ( ! isset( $metaBoxConfig['nonce'] ) || ! isset( $metaBoxConfig['fields'] ) ) {
				return;
			}

			$nonceValue   = filter_input( INPUT_POST, $metaBoxConfig['nonce']['name'], FILTER_SANITIZE_STRING );
			$isValidNonce = $nonceValue && wp_verify_nonce( $nonceValue, $metaBoxConfig['nonce']['action'] );

			if ( ! $isValidNonce || wp_is_post_autosave( $postId ) || ! current_user_can( 'edit_post', $postId ) ) {
				return;
			}

			$this->updateMetaBoxFields( $postId, $metaBoxConfig['fields'] );
		}

		/**
		 * @param int $postId
		 * @param array $fieldConfig
		 *
		 * @return mixed
		 */
		public function getFieldValue( $postId, array $fieldConfig ) {
			if ( isset( $fieldConfig['persist'] ) && ! $fieldConfig['persist'] ) {
				return '';
			}

			if ( isset( $fieldConfig['value'] ) ) {
				return $fieldConfig['value'];
			}

			$isNewPostPage = $this->util->isNewPostPage();

			if ( ! $isNewPostPage && ! metadata_exists( PostTypeSlug::POST, $postId, $fieldConfig['id'] ) ) {
				return isset( $fieldConfig['default'] ) ? $fieldConfig['default'] : '';
			}

			$fieldValue = get_post_meta( $postId, $fieldConfig['id'], true );

			if ( $fieldValue === 0 || $fieldValue === 0.0 || $fieldValue === '0' ) {
				return $fieldValue;
			}

			return isset( $fieldConfig['default'] ) && ( $isNewPostPage || empty( $fieldValue ) )
				? $fieldConfig['default'] : $fieldValue;
		}

		/**
		 * @param int $postId
		 * @param array $fields
		 */
		private function updateMetaBoxFields( $postId, $fields ) {
			foreach ( $fields as $fieldConfig ) {
				if ( isset( $fieldConfig['persist'] ) && ! $fieldConfig['persist'] ) {
					continue;
				}

				if ( MetaBoxConfigBuilder::TAB === $fieldConfig['type'] ) {
					$this->updateMetaBoxFields( $postId, $fieldConfig['fields'] );
					continue;
				}

				$inputValue = $this->dataSanitizer->sanitize(
					$this->filterInputField( $fieldConfig ), $fieldConfig['type'] );

				update_post_meta( $postId, $fieldConfig['id'], $inputValue );
			}
		}

		private function filterInputField( $config ) {
			$filter        = isset( $config['input_filter'] ) ? $config['input_filter'] : FILTER_SANITIZE_STRING;
			$filterOptions = isset( $config['input_filter_options'] ) ? $config['input_filter_options'] : null;

			return filter_input( INPUT_POST, $config['id'], $filter, $filterOptions );
		}
	}
}