<?php

namespace Pikart\WpCore\Shop;

if ( ! class_exists( __NAMESPACE__ . '\\ShopFilterName' ) ) {

	/**
	 * Class ShopFilterName
	 * @package Pikart\WpCore\Shop
	 *
	 * @since 1.3.0
	 */
	class ShopFilterName {

		/**
		 * @return string
		 */
		public static function wishlistAllowed() {
			return sprintf( '%s_wishlist_allowed', PIKART_SLUG );
		}

		/**
		 * @return string
		 */
		public static function productsCompareAllowed() {
			return sprintf( '%s_products_compare_allowed', PIKART_SLUG );
		}
	}
}