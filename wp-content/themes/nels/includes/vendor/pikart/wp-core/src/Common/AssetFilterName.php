<?php

namespace Pikart\WpThemeCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\AssetFilterName' ) ) {

	/**
	 * Class AssetFilterName
	 * @package Pikart\WpThemeCore\Common
	 */
	class AssetFilterName {

		/**
		 * @return string
		 */
		public static function loadAddthisScript() {
			return PIKART_SLUG . '%s_load_addthis_script';
		}
	}
}