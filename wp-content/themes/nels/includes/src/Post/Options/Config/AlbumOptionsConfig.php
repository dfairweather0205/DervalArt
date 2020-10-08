<?php

namespace Pikart\Nels\Post\Options\Config;

use Pikart\Nels\Common\AssetHandle;
use Pikart\Nels\Post\Options\PostOptionsMetaBoxId;
use Pikart\Nels\Post\Options\Type\AlbumOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\AlbumOptionsConfig' ) ) {

	/**
	 * Class AlbumOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config
	 */
	class AlbumOptionsConfig extends GenericPostOptionsConfig {
		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::ALBUM;
		}

		/**
		 * @inheritdoc
		 */
		public function getAdminJsAssetHandles() {
			return array(
				AssetHandle::adminAlbum()
			);
		}

		/**
		 * @inheritdoc
		 */
		protected function buildPostTypeSpecificConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$this->buildAlbumCommonConfig( $metaBoxConfigBuilder )
			     ->buildMasonryArchiveConfig( $metaBoxConfigBuilder )
			     ->buildAlbumVideoConfig( $metaBoxConfigBuilder );
		}

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 *
		 * @return $this
		 */
		private function buildAlbumCommonConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::ALBUM_ITEM_OPTIONS, esc_html__( 'Album Item Options', 'nels' ) )
				->wpEditor( AlbumOptions::TITLE, esc_html__( 'Title', 'nels' ),
					esc_html__( 'Enter the title here. Leave empty, if not needed', 'nels' ), array(
						'editor_settings' => $this->getTinyWpEditorSettings()
					) )
				->wpEditor( AlbumOptions::SUBTITLE, esc_html__( 'Subtitle', 'nels' ),
					esc_html__( 'Enter the subtitle here. Leave empty, if not needed', 'nels' ), array(
						'editor_settings' => $this->getTinyWpEditorSettings()
					) )
				->wpEditor( AlbumOptions::DESCRIPTION, esc_html__( 'Description', 'nels' ),
					esc_html__( 'Enter the subtitle here. Leave empty, if not needed', 'nels' ), array(
						'editor_settings' => $this->getTinyWpEditorSettings()
					) )
				->text( AlbumOptions::BUTTON_LABEL, esc_html__( 'Button label', 'nels' ),
					esc_html__( 'Leave empty, if you do not need button', 'nels' ) )
				->url( AlbumOptions::BUTTON_LINK, esc_html__( 'Link', 'nels' ),
					esc_html__( 'Insert the link here. Leave empty, if not needed', 'nels' ) )
				->checkbox( AlbumOptions::NEW_TAB, esc_html__( 'New Tab', 'nels' ),
					esc_html__( 'It opens the inserted link in a New Tab', 'nels' ),
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
		private function buildAlbumVideoConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::ALBUM_VIDEO_OPTIONS, esc_html__( 'Video Options', 'nels' ) )
				->select( AlbumOptions::VIDEO_TYPE, esc_html__( 'Type', 'nels' ),
					esc_html__( 'Choose the type of video', 'nels' ), array(
						'default' => 'online_service',
						'options' => array(
							'online_service' => esc_html__( 'Online service', 'nels' ),
							'self_hosted'    => esc_html__( 'Self hosted', 'nels' )
						)
					) )
				->metaBox( PostOptionsMetaBoxId::VIDEO_ONLINE_SERVICE_OPTIONS,
					esc_html__( 'Video Online Service Options', 'nels' ) )
				->textArea( AlbumOptions::VIDEO_SOURCE, esc_html__( 'Video source', 'nels' ),
					esc_html__( 'Enter Youtube/Vimeo video link or embed code here', 'nels' ) )
				->metaBox(
					PostOptionsMetaBoxId::VIDEO_SELF_HOSTED_OPTIONS, esc_html__( 'Video Self Hosted Options', 'nels' ) )
				->text( AlbumOptions::VIDEO_UPLOADED_LINK, esc_html__( 'Uploaded Video Link', 'nels' ),
					esc_html__( 'Enter the link of previously uploaded video in Media Library', 'nels' ) )
				->checkbox( AlbumOptions::VIDEO_AUTOPLAY, esc_html__( 'Autoplay', 'nels' ),
					esc_html__( 'Video plays automatically', 'nels' ),
					array(
						'default' => 0
					) );

			return $this;
		}

		protected function buildCommonConfig() {
			//no common config necessary for album
		}
	}
}