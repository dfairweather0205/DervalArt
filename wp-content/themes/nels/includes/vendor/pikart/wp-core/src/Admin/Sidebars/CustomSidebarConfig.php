<?php

namespace Pikart\WpThemeCore\Admin\Sidebars;


if ( ! class_exists( __NAMESPACE__ . '\\CustomSidebarConfig' ) ) {

	/**
	 * Class CustomSidebarConfig
	 * @package Pikart\WpThemeCore\Admin\Sidebars
	 */
	class CustomSidebarConfig {

		/**
		 * @return string
		 */
		public static function getSidebarsOptionKey() {
			return sprintf( '%s_%s', PIKART_THEME_SLUG, 'custom_sidebars' );
		}

		/**
		 * @return string
		 */
		public static function getSidebarNamePrefix() {
			return PIKART_THEME_SLUG . '-custom-sidebar-';
		}
	}
}