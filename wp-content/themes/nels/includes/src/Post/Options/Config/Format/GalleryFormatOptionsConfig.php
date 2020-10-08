<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\Type\GalleryPostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

if ( ! class_exists( __NAMESPACE__ . '\\GalleryFormatOptionsConfig' ) ) {

	/**
	 * Class GalleryFormatOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	class GalleryFormatOptionsConfig extends GenericPostFormatOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostFormatSlug::GALLERY;
		}

		/**
		 * @inheritdoc
		 */
		protected function getFormatSpecificMetaBoxTitle() {
			return esc_html__( 'Gallery Options', 'nels' );
		}

		/**
		 * @inheritdoc
		 */
		protected function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->checkbox( GalleryPostOptions::FEATURED_GALLERY,
					esc_html__( 'Featured Gallery', 'nels' ),
					esc_html__( 'Display Featured gallery on Single Post Page', 'nels' ),
					array(
						'default' => 1
					) )
				->gallery( GalleryPostOptions::IMAGES, esc_html__( 'Images', 'nels' ),
					esc_html__( 'Upload images to your gallery from Media Library', 'nels' ) )
				->checkbox( GalleryPostOptions::POST_EXCERPT_ENABLED, esc_html__( 'Display excerpt', 'nels' ),
					esc_html__( 'Display Post Excerpt on Blog page', 'nels' ),
					array(
						'default' => 1
					) );
		}
	}
}