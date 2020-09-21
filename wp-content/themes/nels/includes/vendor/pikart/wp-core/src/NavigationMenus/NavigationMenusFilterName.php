<?php

namespace Pikart\WpThemeCore\NavigationMenus;

if ( ! class_exists( __NAMESPACE__ . '\\NavigationMenusFilterName' ) ) {

	/**
	 * Class NavigationMenusFilterName
	 * @package Pikart\WpThemeCore\Admin\NavigationMenus
	 *
	 * @since 1.1.0
	 */
	class NavigationMenusFilterName {

		/**
		 * @return string
		 */
		public static function wideMenuEnabled() {
			return sprintf( '%s_navigation_menus_wide_menu_enabled', PIKART_BASE_SLUG );
		}

		/**
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public static function alternativeLabelsEnabled() {
			return sprintf( '%s_navigation_menus_alternative_lables_enabled', PIKART_BASE_SLUG );
		}
	}
}