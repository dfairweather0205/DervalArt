<?php

namespace Pikart\WpThemeCore\Elementor;

if ( ! class_exists( __NAMESPACE__ . '\ElementorFilterName' ) ) {

	/**
	 * Class ElementorUtil
	 * @package Pikart\WpThemeCore\Elementor
	 *
	 * @since 1.6.5
	 */
	class ElementorFilterName {

		/**
		 * @return string
		 */
		public static function pikartBaseElementorAllowed() {
			return sprintf( '%s_elementor_allowed', PIKART_BASE_SLUG );
		}

		/**
		 * @param string $widgetId
		 *
		 * @return string
		 */
		public static function widgetsControlsRegisterConfigBefore( $widgetId ) {
			return sprintf( '%s_elementor_%s_widget_controls_config_before', PIKART_BASE_SLUG, $widgetId );
		}

		/**
		 * @param string $widgetId
		 *
		 * @return string
		 */
		public static function widgetsControlsRegisterConfigAfter( $widgetId ) {
			return sprintf( '%s_elementor_%s_widget_controls_config_after', PIKART_BASE_SLUG, $widgetId );
		}

		/**
		 * @param string $widgetId
		 * @param string $sectionId
		 *
		 * @return string
		 */
		public static function widgetsControlsRegisterConfigAfterSectionStart( $widgetId, $sectionId ) {
			return sprintf( '%s_elementor_%s_widget_controls_config_after_section_%s_start',
				PIKART_BASE_SLUG, $widgetId, $sectionId );
		}

		/**
		 * @param string $widgetId
		 * @param string $sectionId
		 *
		 * @return string
		 */
		public static function widgetsControlsRegisterConfigBeforeSectionEnd( $widgetId, $sectionId ) {
			return sprintf( '%s_elementor_%s_widget_controls_config_before_section_%s_end',
				PIKART_BASE_SLUG, $widgetId, $sectionId );
		}

		/**
		 * @param string $widgetId
		 *
		 * @since 1.8.0
		 *
		 * @return string
		 */
		public static function widgetAttributes( $widgetId ) {
			return sprintf( '%s_elementor_%s_widget_attributes', PIKART_BASE_SLUG, $widgetId );
		}
	}
}
