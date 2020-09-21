<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\PostOptionsMetaBoxId;
use Pikart\Nels\Post\Options\Type\VideoPostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

if ( ! class_exists( __NAMESPACE__ . '\\VideoFormatOptionsConfig' ) ) {

	/**
	 * Class VideoFormatOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	class VideoFormatOptionsConfig extends GenericPostFormatOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostFormatSlug::VIDEO;
		}

		/**
		 * @inheritdoc
		 */
		protected function getFormatSpecificMetaBoxTitle() {
			return esc_html__( 'Video Options', 'nels' );
		}

		/**
		 * @inheritdoc
		 */
		protected function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->checkbox( VideoPostOptions::FEATURED_VIDEO,
					esc_html__( 'Featured Video', 'nels' ),
					esc_html__( 'Display Featured Video on Single Post Page', 'nels' ),
					array(
						'default' => 1
					) )
				->checkbox( VideoPostOptions::POST_EXCERPT_ENABLED, esc_html__( 'Display excerpt', 'nels' ),
					esc_html__( 'Display Post Excerpt on Blog page', 'nels' ),
					array(
						'default' => 1
					) )
				->select( VideoPostOptions::VIDEO_TYPE, esc_html__( 'Type', 'nels' ),
					esc_html__( 'Choose the type of video', 'nels' ), array(
						'default' => 'online_service',
						'options' => array(
							'online_service' => esc_html__( 'Online service', 'nels' ),
							'self_hosted'    => esc_html__( 'Self hosted', 'nels' )
						)
					) )
				->metaBox( PostOptionsMetaBoxId::VIDEO_ONLINE_SERVICE_OPTIONS,
					esc_html__( 'Video Online Service Options', 'nels' ) )
				->textArea( VideoPostOptions::SOURCE, esc_html__( 'Video source', 'nels' ),
					esc_html__( 'Enter Youtube/Vimeo video link or embed code here', 'nels' ) )
				->metaBox(
					PostOptionsMetaBoxId::VIDEO_SELF_HOSTED_OPTIONS, esc_html__( 'Video Self Hosted Options', 'nels' ) )
				->text( VideoPostOptions::VIDEO_UPLOADED_LINK, esc_html__( 'Uploaded Video Link', 'nels' ),
					esc_html__( 'Enter the link of previously uploaded video in Media Library', 'nels' ) )
				->checkbox( VideoPostOptions::VIDEO_AUTOPLAY, esc_html__( 'Autoplay', 'nels' ),
					esc_html__( 'Video plays automatically', 'nels' ),
					array(
						'default' => 0
					)
				);
		}
	}
}