<?php

namespace Pikart\Nels\Post\Options\Config;

use Pikart\Nels\Post\Options\PostOptionsMetaBoxId;
use Pikart\Nels\Post\Options\Type\ProductOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\Generator\MetaBoxContext;
use Pikart\WpThemeCore\Admin\MetaBoxes\Generator\MetaBoxPriority;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\ProductOptionsConfig' ) ) {

	/**
	 * Class ProductOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config
	 */
	class ProductOptionsConfig extends GenericPostOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::PRODUCT;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildPostTypeSpecificConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$this->buildProductCommonConfig( $metaBoxConfigBuilder )
			     ->buildMasonryArchiveConfig( $metaBoxConfigBuilder )
			     ->buildSecondFeaturedImageConfig( $metaBoxConfigBuilder );
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 *
		 * @return $this
		 */
		private function buildProductCommonConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::PRODUCT_OPTIONS, esc_html__( 'Product Options', 'nels' ) )
				->checkbox( ProductOptions::PRODUCT_GALLERY_ENABLE,
					esc_html__( 'Product Image & Gallery', 'nels' ),
					esc_html__( 'Display Product Image & Product Thumbnails Gallery on Single Product Page', 'nels' ),
					array(
						'default' => 1
					) )
				->checkbox( ProductOptions::PRODUCT_HEADER_FULL_WIDTH, esc_html__( 'Full width', 'nels' ),
					esc_html__( 'Product Header takes screen full width size', 'nels' ),
					array(
						'default' => 0
					) )
				->wpEditor( ProductOptions::HERO_HEADER, esc_html__( 'Hero Header', 'nels' ),
					esc_html__( 'Enter Hero Header content here', 'nels' ), array(
						'editor_settings' => array(
							'editor_height' => 300,
							'textarea_rows' => 8,
						)
					) )
				->select( ProductOptions::PRODUCT_DETAILS_POSITION, esc_html__( 'Details Position', 'nels' ),
					esc_html__( 'Choose the position for Product Details', 'nels' ),
					array(
						'default' => 'right',
						'options' => array(
							'top'    => esc_html__( 'Top', 'nels' ),
							'right'  => esc_html__( 'Right', 'nels' ),
							'bottom' => esc_html__( 'Bottom', 'nels' ),
							'left'   => esc_html__( 'Left', 'nels' ),
						)
					) )
				->checkbox( ProductOptions::PRODUCT_DETAILS_STICKY, esc_html__( 'Sticky Details', 'nels' ),
					esc_html__( 'Product Details are sticky while scrolling for Right and Left positions', 'nels' ),
					array(
						'default' => 0
					)
				)
				->text( ProductOptions::PRODUCT_VIDEO_URL, esc_html__( 'Product Video URL', 'nels' ),
					esc_html__( 'Enter Youtube or Vimeo video link here. Video shows up while clicking on Gallery Video button', 'nels' ) )
				->checkbox( ProductOptions::THUMBNAILS_GALLERY_ENABLED, esc_html__( 'Thumbnails Gallery', 'nels' ),
					esc_html__( 'Enable Product Thumbnails Gallery near Product Main Image', 'nels' ),
					array(
						'default' => 1
					)
				)
				->select( ProductOptions::THUMBNAILS_GALLERY_POSITION, esc_html__( 'Thumbnails Gallery Position', 'nels' ),
					esc_html__( 'Choose the position for Product Thumbnails Gallery', 'nels' ),
					array(
						'default' => 'vertical',
						'options' => array(
							'horizontal' => esc_html__( 'Horizontal', 'nels' ),
							'vertical'   => esc_html__( 'Vertical', 'nels' ),
						)
					) )
				->select( ProductOptions::THUMBNAILS_GALLERY_NB_SLIDES, esc_html__( 'Thumbnails Gallery Slides', 'nels' ),
					esc_html__( 'Choose the number of slides for Product Thumbnails Gallery', 'nels' ),
					array(
						'default' => 4,
						'options' => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
							5 => 5,
							6 => 6,
						)
					) )
				->checkbox( ProductOptions::THUMBNAILS_GALLERY_NAVIGATION, esc_html__( 'Thumbnails Gallery Navigation', 'nels' ),
					esc_html__( 'Add navigation buttons to Product Thumbnails Gallery', 'nels' ),
					array(
						'default' => 0
					)
				);

			return $this;
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 *
		 * @return $this
		 */
		private function buildSecondFeaturedImageConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::PRODUCT_SECOND_FEATURED_IMAGE,
					esc_html__( 'Hover Image', 'nels' ),
					MetaBoxPriority::LOW, MetaBoxContext::SIDE )
				->galleryImage( ProductOptions::SECOND_FEATURED_IMAGE );

			return $this;
		}
	}
}