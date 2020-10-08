<?php

namespace Pikart\WpCore\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsFilterName' ) ) {

	/**
	 * Class ThemeOptionsFilterName
	 * @package Pikart\WpCore\ThemeOptions
	 */
	class ThemeOptionsFilterName {

		/**
		 * @return string
		 */
		public static function googleFonts() {
			return PIKART_THEME_SLUG . '_google_fonts';
		}

		/**
		 * @return string
		 */
		public static function registeredGoogleFonts() {
			return PIKART_THEME_SLUG . '_registered_google_fonts';
		}

		/**
		 * @return string
		 */
		public static function defaultGoogleFonts() {
			return PIKART_THEME_SLUG . '_default_google_fonts';
		}

		/**
		 * @return string
		 */
		public static function googleFontsSubsets() {
			return PIKART_THEME_SLUG . '_default_google_fonts_subsets';
		}

		/**
		 * @return string
		 */
		public static function themeOptionsConfig() {
			return PIKART_THEME_SLUG . '_theme_options_config';
		}

		/**
		 * @return string
		 */
		public static function themeCustomOptionsConfig() {
			return PIKART_THEME_SLUG . '_theme_custom_options_config';
		}

		/**
		 * @return string
		 */
		public static function themeWpOptionsConfig() {
			return PIKART_THEME_SLUG . '_theme_wp_options_config';
		}

		/**
		 * @return string
		 */
		public static function customizerJsData() {
			return PIKART_THEME_SLUG . '_customizer_js_data';
		}

		/**
		 * @param string $panelId
		 *
		 * @return string
		 */
		public static function panelConfig( $panelId ) {
			return static::itemConfig( 'panel', $panelId );
		}

		/**
		 * @param string $sectionId
		 *
		 * @return string
		 */
		public static function sectionConfig( $sectionId ) {
			return static::itemConfig( 'section', $sectionId );
		}

		/**
		 * @param string $controlId
		 *
		 * @return string
		 */
		public static function controlConfig( $controlId ) {
			return static::itemConfig( 'control', $controlId );
		}

		/**
		 * @param string $itemType
		 * @param string $itemId
		 *
		 * @return string
		 */
		private static function itemConfig( $itemType, $itemId ) {
			return sprintf( '%s_theme_options_config_%s_%s', PIKART_THEME_SLUG, $itemType, $itemId );
		}

	}
}