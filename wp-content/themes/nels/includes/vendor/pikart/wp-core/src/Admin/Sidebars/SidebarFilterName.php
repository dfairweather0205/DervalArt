<?php

namespace Pikart\WpThemeCore\Admin\Sidebars;

if ( ! class_exists( __NAMESPACE__ . '\\SidebarFilterName' ) ) {

	/**
	 * Class SidebarFilterName
	 * @package Pikart\WpThemeCore\Admin\Sidebars
	 */
	class SidebarFilterName {

		/**
		 * @return string
		 */
		public static function customSidebarArguments() {
			return PIKART_THEME_SLUG . '_custom_sidebar_arguments';
		}
	}
}