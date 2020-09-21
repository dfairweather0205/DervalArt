<?php

namespace Pikart\WpThemeCore\Admin\Sidebars;

if ( ! class_exists( __NAMESPACE__ . '\\SidebarUtil' ) ) {

	/**
	 * Class SidebarUtil
	 * @package Pikart\WpThemeCore\Admin\Sidebars
	 */
	class SidebarUtil {

		/**
		 * @return array
		 */
		public function getCustomSidebars() {
			return get_option( CustomSidebarConfig::getSidebarsOptionKey(), array() );
		}
	}
}