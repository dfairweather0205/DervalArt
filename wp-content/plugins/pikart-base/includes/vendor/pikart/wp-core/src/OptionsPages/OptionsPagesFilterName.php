<?php

namespace Pikart\WpCore\OptionsPages;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesFilterName' ) ) {

	/**
	 * Class OptionsPagesFilterName
	 * @package Pikart\WpCore\OptionsPages
	 */
	class OptionsPagesFilterName {

		/**
		 * @param string $pageId
		 * @param string $settingId
		 *
		 * @return string
		 */
		public static function settingDefaultValue( $pageId, $settingId ) {
			return self::getFilterName( $pageId, $settingId, 'default_value' );
		}

		/**
		 * @param string $pageId
		 * @param string $settingId
		 *
		 * @return string
		 */
		public static function settingValueOptions( $pageId, $settingId ) {
			return self::getFilterName( $pageId, $settingId, 'value_options' );
		}

		/**
		 * @param string $pageId
		 * @param string $sectionId
		 *
		 * @since 1.8.0
		 *
		 * @return string
		 */
		public static function sectionEnabled( $pageId, $sectionId ) {
			return sprintf( '%s_options_page_%s_section_%s_enabled', PIKART_SLUG, $pageId, $sectionId );
		}

		/**
		 * @param string $pageId
		 * @param string $settingId
		 *
		 * @since 1.8.0
		 *
		 * @return string
		 */
		public static function settingEnabled( $pageId, $settingId ) {
			return sprintf( '%s_options_page_%s_setting_%s_enabled', PIKART_SLUG, $pageId, $settingId );
		}

		/**
		 * @param string $pageId
		 * @param string $settingId
		 * @param string $filter
		 *
		 * @return string
		 */
		private static function getFilterName( $pageId, $settingId, $filter ) {
			return sprintf( '%s_options_page_%s_setting_%s_%s', PIKART_BASE_SLUG, $pageId, $settingId, $filter );
		}
	}
}