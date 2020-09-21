<?php

namespace Pikart\WpThemeCore\Admin\MetaBoxes\Generator;

use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfig;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxGenerator' ) ) {

	/**
	 * Class MetaBoxGenerator
	 * @package Pikart\WpThemeCore\Admin\MetaBoxes\Generator
	 */
	class MetaBoxGenerator {
		const DEFAULT_META_BOX_CONTEXT = MetaBoxContext::NORMAL;
		const DEFAULT_META_BOX_PRIORITY = MetaBoxPriority::HIGH;

		/**
		 * @var MetaBoxGeneratorHelper
		 *
		 * @since 1.7.0
		 */
		private $metaBoxGeneratorHelper;

		/**
		 * MetaBoxGenerator constructor.
		 *
		 * @param MetaBoxGeneratorHelper $metaBoxGeneratorHelper
		 */
		public function __construct( MetaBoxGeneratorHelper $metaBoxGeneratorHelper ) {
			$this->metaBoxGeneratorHelper = $metaBoxGeneratorHelper;
		}

		/**
		 * @param string $postType
		 * @param array $metaBoxConfig
		 */
		public function generate( $postType, array $metaBoxConfig ) {
			$context  = isset( $metaBoxConfig['context'] )
				? $metaBoxConfig['context'] : self::DEFAULT_META_BOX_CONTEXT;
			$priority = isset( $metaBoxConfig['priority'] )
				? $metaBoxConfig['priority'] : self::DEFAULT_META_BOX_PRIORITY;

			$genMetaBoxFieldsCallback = $this->genMetaBoxFieldsCallback();
			$addMetaBoxMethod         = MetaBoxConfig::getMetaBoxAddMethod();

			if ( ! is_callable( $addMetaBoxMethod ) ) {
				return;
			}

			$addMetaBoxMethod( $metaBoxConfig['id'], $metaBoxConfig['label'],
				function ( $post ) use ( $metaBoxConfig, $genMetaBoxFieldsCallback ) {
					echo call_user_func( $genMetaBoxFieldsCallback, null === $post ? null : $post->ID, $metaBoxConfig );
				}, $postType, $context, $priority
			);
		}

		/**
		 * @return \Closure
		 */
		private function genMetaBoxFieldsCallback() {
			$metaBoxGeneratorHelper = $this->metaBoxGeneratorHelper;
			$generateNonceCallback  = $this->generateNonceCallback();

			return function ( $postId, array $metaBoxConfig ) use ( $metaBoxGeneratorHelper, $generateNonceCallback ) {
				$metaBoxFields = isset( $metaBoxConfig['fields'] ) ? $metaBoxConfig['fields'] : array();

				return $generateNonceCallback( $metaBoxConfig )
				       . $metaBoxGeneratorHelper->generateMetaBoxFields( $metaBoxConfig['id'], $postId, $metaBoxFields );
			};
		}

		/**
		 * @return \Closure
		 */
		private function generateNonceCallback() {
			return function ( $metaBoxConfig ) {
				return isset ( $metaBoxConfig['nonce'] )
					? wp_nonce_field( $metaBoxConfig['nonce']['action'], $metaBoxConfig['nonce']['name'], true, false )
					: '';
			};
		}
	}
}