<?php

namespace Pikart\WpThemeCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\CoreAssetHandle' ) ) {

	/**
	 * Class CoreAssetHandle
	 * @package Pikart\WpThemeCore\Common
	 */
	class CoreAssetHandle {

		/**
		 * @return string
		 */
		public static function themeStyle() {
			return self::buildThemeHandleName( 'theme-style' );
		}

		/**
		 * @return string
		 */
		public static function themeRtlStyle() {
			return self::buildThemeHandleName( 'theme-rtl-style' );
		}

		/**
		 * @return string
		 */
		public static function customScript() {
			return self::buildThemeHandleName( 'custom-script' );
		}

		/**
		 * @return string
		 */
		public static function jquery() {
			return 'jquery';
		}

		/**
		 * @return string
		 */
		public static function jqueryUiSlider() {
			return 'jquery-ui-slider';
		}

		/**
		 * @return string
		 */
		public static function jqueryUiTabs() {
			return 'jquery-ui-tabs';
		}

		/**
		 * @return string
		 */
		public static function jqueryUiCore() {
			return 'jquery-ui-core';
		}

		/**
		 * @return string
		 */
		public static function jqueryUiDatepicker() {
			return 'jquery-ui-datepicker';
		}

		/**
		 * @return string
		 */
		public static function wpColorPicker() {
			return 'wp-color-picker';
		}

		/**
		 * @return string
		 */
		public static function commentReply() {
			return 'comment-reply';
		}

		/**
		 * @return string
		 */
		public static function customizePreview() {
			return 'customize-preview';
		}

		/**
		 * @return string
		 */
		public static function multipleSelect() {
			return 'multiple-select';
		}

		/**
		 * @return string
		 */
		public static function limitSlider() {
			return 'limitslider';
		}

		/**
		 * @return string
		 */
		public static function jqueryUi() {
			return 'jquery-ui';
		}

		/**
		 * @return string
		 */
		public static function fontAwesome() {
			return 'font-awesome';
		}

		/**
		 * @since 1.3.0
		 *
		 * @return string
		 */
		public static function twitterWidgets() {
			return 'twitter-widgets';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function animateCss() {
			return 'animate-css';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function elegantIcons() {
			return 'elegant-icons';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function magnificPopup() {
			return 'magnific-popup';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function owlCarousel() {
			return 'owl-carousel';
		}

		/**
		 * @since 1.6.3
		 *
		 * @return string
		 */
		public static function slickCarousel() {
			return 'slick-carousel';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function foundation() {
			return 'foundation';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function imagesloaded() {
			return 'imagesloaded';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function isotope() {
			return 'isotope';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function jqueryAppear() {
			return 'jquery-appear';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function jqueryZoom() {
			return 'jquery-zoom';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function stickyKit() {
			return 'sticky-kit';
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function simpleLineIcons() {
			return 'simple-line-icons';
		}

		/**
		 * @return string
		 */
		public static function customGallery() {
			return self::buildCoreHandleName( 'custom-gallery' );
		}

		/**
		 * @return string
		 */
		public static function customGalleryImage() {
			return self::buildCoreHandleName( 'custom-gallery-image' );
		}

		/**
		 * @return string
		 */
		public static function adminCoreCustomizer() {
			return self::buildCoreHandleName( 'admin-core-customizer' );
		}

		/**
		 * @return string
		 */
		public static function googleFonts() {
			return self::buildCoreHandleName( 'google-fonts' );
		}

		/**
		 * @return string
		 */
		public static function adminCustomizeControls() {
			return self::buildCoreHandleName( 'admin-customize-controls' );
		}

		/**
		 * @return string
		 */
		public static function adminMetaBoxes() {
			return self::buildCoreHandleName( 'admin-meta-boxes' );
		}

		/**
		 * @return string
		 */
		public static function adminMetaBoxesStyle() {
			return self::buildCoreHandleName( 'admin-meta-boxes-style' );
		}

		/**
		 * @return string
		 */
		public static function adminMetaBoxesRtlStyle() {
			return self::buildCoreHandleName( 'admin-meta-boxes-rtl-style' );
		}

		public static function adminUtil() {
			return self::buildCoreHandleName( 'admin-util' );
		}

		/**
		 * @return string
		 */
		public static function adminOptionsPagesStyle() {
			return self::buildCoreHandleName( 'admin-options-pages-style' );
		}

		/**
		 * @param string $handle
		 *
		 * @return string
		 */
		protected static function buildThemeHandleName( $handle ) {
			return sprintf( '%s-%s', PIKART_THEME_SLUG, $handle );
		}

		/**
		 * @param string $handle
		 *
		 * @return string
		 */
		private static function buildCoreHandleName( $handle ) {
			return sprintf( '%s-%s', PIKART_SLUG, $handle );
		}
	}
}