<?php

namespace Pikart\WpBase\NavigationMenus;

if ( ! class_exists( __NAMESPACE__ . '\\NavigationMenusUtil' ) ) {

	/**
	 * Class NavigationMenusUtil
	 * @package Pikart\WpBase\NavigationMenus
	 *
	 * @since 1.4.0
	 */
	class NavigationMenusUtil {

		const MENU_ITEM_DB_PREFIX = '_menu_item_';

		/**
		 * @param string $menuItemId
		 * @param string $option
		 *
		 * @return mixed
		 */
		public function getMenuItemOption( $menuItemId, $option ) {
			return get_post_meta( $menuItemId, self::MENU_ITEM_DB_PREFIX . $option, true );
		}

		/**
		 * @param string $menuItemId
		 * @param string $option
		 * @param mixed $value
		 */
		public function updateMenuItemOption( $menuItemId, $option, $value ) {
			update_post_meta( $menuItemId, self::MENU_ITEM_DB_PREFIX . $option, $value );
		}

		/**
		 * @param string $menuItemId
		 *
		 * @return string
		 */
		public function getBackgroundImageUrl( $menuItemId ) {
			return wp_get_attachment_url(
				$this->getMenuItemOption( $menuItemId, NavigationMenusOption::BACKGROUND_IMAGE ) );
		}
	}
}