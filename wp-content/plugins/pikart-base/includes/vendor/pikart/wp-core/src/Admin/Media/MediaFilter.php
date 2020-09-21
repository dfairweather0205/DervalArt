<?php

namespace Pikart\WpCore\Admin\Media;

if ( ! class_exists( __NAMESPACE__ . '\MediaFilter' ) ) {
	/**
	 * Class MediaFilter
	 * @package Pikart\WpCore\Admin\Media
	 */
	class MediaFilter {

		/**
		 * @return string
		 */
		public static function customGalleryImageHooks() {
			return PIKART_SLUG . 'custom_gallery_image_hooks';
		}

		/**
		 * @return string
		 */
		public static function customGalleryHooks() {
			return PIKART_SLUG . 'custom_gallery_hooks';
		}

		/**
		 * @since 1.8.0
		 *
		 * @return string
		 */
		public static function customGalleryVideoUrlEnabled() {
			return PIKART_SLUG . '_custom_gallery_video_url';
		}

		/**
		 * @since 1.8.0
		 *
		 * @return string
		 */
		public static function wpBaseGalleryCustomizerEnabled() {
			return PIKART_SLUG . '_wp_base_gallery_customizer_enabled';
		}
	}
}