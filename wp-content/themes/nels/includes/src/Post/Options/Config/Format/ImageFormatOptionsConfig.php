<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\Type\ImagePostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

if ( ! class_exists( __NAMESPACE__ . '\\ImageFormatOptionsConfig' ) ) {

	/**
	 * Class ImageFormatOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	class ImageFormatOptionsConfig extends GenericPostFormatOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostFormatSlug::IMAGE;
		}

		/**
		 * @inheritdoc
		 */
		protected function getFormatSpecificMetaBoxTitle() {
			return esc_html__( 'Image Options', 'nels' );
		}

		/**
		 * @inheritdoc
		 */
		protected function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->checkbox( ImagePostOptions::FEATURED_IMAGE, esc_html__( 'Featured Image', 'nels' ),
					esc_html__( 'Display Featured Image on Single Post Page', 'nels' ),
					array(
						'default' => 1
					) );
		}
	}
}