<?php

namespace Pikart\WpThemeCore\OptionsPages;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesConfig' ) ) {

	/**
	 * Class OptionsPagesConfig
	 * @package Pikart\WpThemeCore\OptionsPages
	 */
	class OptionsPagesConfig {

		const DB_OPTION_KEY_PATTERN = 'pkrt_%s_settings';
		const DEFAULT_CONTROL_TYPE = OptionsPagesControlType::TEXT;

		/**
		 * @return array
		 */
		public static function getArrayControlTypes() {
			return array(
				OptionsPagesControlType::MULTI_CHECKBOX,
				OptionsPagesControlType::MULTI_SELECT
			);
		}

		/**
		 * @param string $pageId
		 *
		 * @return string
		 */
		public static function getOptionsPageDbKey( $pageId ) {
			return sprintf( self::DB_OPTION_KEY_PATTERN, str_replace( '-', '_', $pageId ) );
		}
	}
}