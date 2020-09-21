<?php

namespace Pikart\Nels\Site;

if ( ! class_exists( __NAMESPACE__ . '\SidebarName' ) ) {

	/**
	 * Class SidebarName
	 * @package Pikart\Nels\Site
	 */
	class SidebarId {

		/**
		 * @return string
		 */
		public static function archive() {
			return PIKART_THEME_SLUG . '-sidebar-archive';
		}

		/**
		 * @return string
		 */
		public static function header() {
			return PIKART_THEME_SLUG . '-sidebar-header';
		}

		/**
		 * @return string
		 */
		public static function content() {
			return PIKART_THEME_SLUG . '-sidebar-content';
		}

		/**
		 * @param $index
		 *
		 * @return string
		 */
		public static function footer( $index ) {
			return PIKART_THEME_SLUG . '-sidebar-footer-' . $index;
		}

		/**
		 * @return string
		 */
		public static function shopFilter() {
			return PIKART_THEME_SLUG . '-sidebar-shop-filter';
		}

	}
}