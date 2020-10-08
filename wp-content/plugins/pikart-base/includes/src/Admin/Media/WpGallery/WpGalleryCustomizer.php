<?php

namespace Pikart\WpBase\Admin\Media\WpGallery;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpCore\Admin\Media\MediaFilter;
use Pikart\WpCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\WpGalleryCustomizer' ) ) {
	/**
	 * Class WpGalleryCustomizer
	 * @package Pikart\WpCore\Admin\Media
	 */
	class WpGalleryCustomizer {

		const GALLERY_SHORTCODE_NAME = 'gallery';

		/**
		 * @var WpGalleryCustomTemplateHandler
		 */
		private $customTemplateHandler;

		/**
		 * @var WpGalleryShortcodeContentFilter
		 */
		private $wpGalleryShortcodeContentFilter;

		/**
		 * @var WpGalleryBlockCustomizer
		 */
		private $wpGalleryBlockCustomizer;

		/**
		 * WpGalleryCustomizer constructor.
		 *
		 * @param WpGalleryCustomTemplateHandler $customTemplateHandler
		 * @param WpGalleryShortcodeContentFilter $wpGalleryShortcodeContentFilter
		 * @param WpGalleryBlockCustomizer $wpGalleryBlockCustomizer
		 */
		public function __construct(
			WpGalleryCustomTemplateHandler $customTemplateHandler,
			WpGalleryShortcodeContentFilter $wpGalleryShortcodeContentFilter,
			WpGalleryBlockCustomizer $wpGalleryBlockCustomizer
		) {
			$this->customTemplateHandler           = $customTemplateHandler;
			$this->wpGalleryShortcodeContentFilter = $wpGalleryShortcodeContentFilter;
			$this->wpGalleryBlockCustomizer        = $wpGalleryBlockCustomizer;
		}

		public function customize() {
			add_action( 'after_setup_theme', array( $this, '_customize' ) );
		}

		/**
		 * @internal used as wp action callback
		 */
		public function _customize() {
			if ( ! apply_filters( MediaFilter::wpBaseGalleryCustomizerEnabled(), true ) ) {
				return;
			}

			$this->enqueueAssets();
			$this->customTemplateHandler->handle();
			$this->applyColumnsSpacingForGalleryShortcode();
			$this->manageMediaGalleryCustomWidget();
			$this->wpGalleryBlockCustomizer->customize();
		}

		private function manageMediaGalleryCustomWidget() {
			/** Media Gallery Widget is available @since 4.9 */
			if ( version_compare( $GLOBALS['wp_version'], '4.9', '<' ) ) {
				return;
			}

			add_filter( "widget_media_gallery_instance_schema", function ( $schema ) {
				return array_merge( $schema, WpGalleryConfig::getCustomSettings() );
			} );

			add_action( 'widgets_init', function () {
				register_widget(
					new MediaGalleryCustomWidget( new WpGalleryShortcodeContentFilter( new Util() ) ) );
			} );
		}

		private function applyColumnsSpacingForGalleryShortcode() {
			$wpGalleryShortcodeContentFilter = $this->wpGalleryShortcodeContentFilter;

			add_filter( 'do_shortcode_tag', function (
				$output, $shortcodeName, $attributes
			) use ( $wpGalleryShortcodeContentFilter ) {

				if ( WpGalleryCustomizer::GALLERY_SHORTCODE_NAME !== $shortcodeName ) {
					return $output;
				}

				return $wpGalleryShortcodeContentFilter->filter( $output, $attributes );

			}, 10, 3 );
		}

		private function enqueueAssets() {
			add_action( 'admin_enqueue_scripts', function () {
				wp_enqueue_style( AssetHandle::adminMediaCustomFieldsStyle() );

				if ( is_rtl() ) {
					wp_enqueue_style( AssetHandle::adminMediaCustomFieldsRtlStyle() );
				}
			} );
		}
	}
}