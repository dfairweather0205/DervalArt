<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\Type\StandardPostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

if ( ! class_exists( __NAMESPACE__ . '\\StandardFormatOptionsConfig' ) ) {

	/**
	 * Class StandardFormatOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	class StandardFormatOptionsConfig extends GenericPostFormatOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostFormatSlug::STANDARD;
		}

		/**
		 * @inheritdoc
		 */
		protected function getFormatSpecificMetaBoxTitle() {
			return esc_html__( 'Standard Options', 'nels' );
		}

		/**
		 * @inheritdoc
		 */
		protected function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->checkbox( StandardPostOptions::FEATURED_IMAGE, esc_html__( 'Featured Image', 'nels' ),
					esc_html__( 'Display Featured Image on Single Post Page', 'nels' ),
					array(
						'default' => 1
					) )
				->checkbox( StandardPostOptions::POST_EXCERPT_ENABLED, esc_html__( 'Display excerpt', 'nels' ),
					esc_html__( 'Display Post Excerpt on Blog page', 'nels' ),
					array(
						'default' => 1
					) );
		}
	}
}