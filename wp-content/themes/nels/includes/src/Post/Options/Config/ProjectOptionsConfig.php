<?php

namespace Pikart\Nels\Post\Options\Config;

use Pikart\Nels\Common\AssetHandle;
use Pikart\Nels\Post\Options\PostOptionsMetaBoxId;
use Pikart\Nels\Post\Options\Type\ProjectOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\ProjectOptionsConfig' ) ) {

	/**
	 * Class ProjectOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config
	 */
	class ProjectOptionsConfig extends GenericPostOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::PROJECT;
		}

		/**
		 * @inheritdoc
		 */
		public function getAdminJsAssetHandles() {
			return array(
				AssetHandle::adminProject()
			);
		}

		/**
		 * @inheritdoc
		 */
		protected function buildPostTypeSpecificConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$this->buildProjectCommonConfig( $metaBoxConfigBuilder )
			     ->buildMasonryConfig( $metaBoxConfigBuilder )
			     ->buildCarouselConfig( $metaBoxConfigBuilder )
			     ->buildMasonryArchiveConfig( $metaBoxConfigBuilder );
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 *
		 * @return $this
		 */
		private function buildProjectCommonConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::PROJECT_COMMON_OPTIONS, esc_html__( 'Project Options', 'nels' ) )
				->select( ProjectOptions::TYPE, esc_html__( 'Type', 'nels' ),
					esc_html__( 'Choose how the project images will be displayed', 'nels' ), array(
						'default' => 'masonry',
						'options' => array(
							'masonry'  => esc_html__( 'Masonry', 'nels' ),
							'carousel' => esc_html__( 'Carousel', 'nels' ),
						)
					) )
				->checkbox( ProjectOptions::PROJECT_HEADER_FULL_WIDTH, esc_html__( 'Full width', 'nels' ),
					esc_html__( 'Project Header takes screen full width size', 'nels' ),
					array(
						'default' => 0
					) )
				->gallery( ProjectOptions::IMAGES, esc_html__( 'Upload', 'nels' ),
					esc_html__( 'Choose images for your projects', 'nels' ) )
				->wpEditor( ProjectOptions::HERO_HEADER, esc_html__( 'Hero Header', 'nels' ),
					esc_html__( 'Enter Hero Header content here', 'nels' ), array(
						'editor_settings' => array(
							'editor_height' => 300,
							'textarea_rows' => 8,
						)
					) )
				->select( ProjectOptions::PROJECT_DETAILS_POSITION, esc_html__( 'Details Position', 'nels' ),
					esc_html__( 'Choose the position for Project Details', 'nels' ),
					array(
						'default' => 'bottom',
						'options' => array(
							'top'    => esc_html__( 'Top', 'nels' ),
							'right'  => esc_html__( 'Right', 'nels' ),
							'bottom' => esc_html__( 'Bottom', 'nels' ),
							'left'   => esc_html__( 'Left', 'nels' ),
						)
					) )
				->checkbox( ProjectOptions::PROJECT_DETAILS_STICKY, esc_html__( 'Sticky Details', 'nels' ),
					esc_html__( 'Project Details are sticky while scrolling for Right and Left positions', 'nels' ),
					array(
						'default' => 0
					) )
				->date( ProjectOptions::PROJECT_DATE, esc_html__( 'Project Date', 'nels' ),
					esc_html__( 'Set up the date for project', 'nels' ) )
				->wpEditor( ProjectOptions::PROJECT_DESCRIPTION,
					esc_html__( 'Project short description', 'nels' ),
					esc_html__( 'Enter the project description here', 'nels' ), array(
						'editor_settings' => $this->getTinyWpEditorSettings()
					) );

			return $this;
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 *
		 * @return $this
		 */
		private function buildMasonryConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::PROJECT_MASONRY_OPTIONS, esc_html__( 'Masonry Options', 'nels' ) )
				->select( ProjectOptions::NB_COLUMNS, esc_html__( 'Number of columns', 'nels' ),
					esc_html__( 'Choose the number of columns the project gallery will display', 'nels' ), array(
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
				->number( ProjectOptions::COLUMNS_SPACING, esc_html__( 'Columns spacing', 'nels' ),
					esc_html__( 'Enter the spacing between columns (pixels)', 'nels' ), array(
						'default'    => 36,
						'attributes' => array(
							'min' => 0
						),
					) );

			return $this;
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 *
		 * @return $this
		 */
		private function buildCarouselConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::PROJECT_CAROUSEL_OPTIONS, esc_html__( 'Carousel Options', 'nels' ) )
				->select( ProjectOptions::CAROUSEL_NB_SLIDES, esc_html__( 'Number of slides', 'nels' ),
					esc_html__( 'Choose the number of slides the carousel will display', 'nels' ), array(
						'default' => 1,
						'options' => array(
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
							5 => 5,
							6 => 6,
						)
					) )
				->number( ProjectOptions::CAROUSEL_SLIDES_SPACING, esc_html__( 'Slides spacing', 'nels' ),
					esc_html__( 'Enter the spacing between slides (pixels)', 'nels' ), array(
						'default' => 0
					) );

			return $this;
		}
	}
}