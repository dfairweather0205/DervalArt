<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\ShopHeaderConfig' ) ) {

	/**
	 * Class ShopHeaderConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ShopHeaderConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			return $this->controlConfigBuilder
				->checkboxMultiple( ThemeOption::SHOP_HEADER_ICONS_VISIBILITY )
				->label( esc_html__( 'Shop Icons Visibility', 'nels' ) )
				->defaultVal( array(
					'wishlist',
					'my_account',
					'cart',
				) )
				->choices( $this->getShopHeaderIconsVisibilityList() )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'wishlist_icon_title' )
				->label( esc_html__( 'Wishlist Icon', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_HEADER_WISHLIST_ICON_ITEMS_BACKGROUND_COLOR )
				->defaultVal( '#88b04b' )
				->description( esc_html__( '_items background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.wishlist-icon__background'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_HEADER_WISHLIST_ICON_ITEMS_TEXT_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_items text', 'nels' ) )
				->css( array(
					'color' => array(
						'.wishlist-icon__items-number'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'product_compare_icon_title' )
				->label( esc_html__( 'Products Compare Icon', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_HEADER_PRODUCTS_COMPARE_ICON_ITEMS_BACKGROUND_COLOR )
				->defaultVal( '#88b04b' )
				->description( esc_html__( '_items background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.products-compare-icon__background'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_HEADER_PRODUCTS_COMPARE_ICON_ITEMS_TEXT_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_items text', 'nels' ) )
				->css( array(
					'color' => array(
						'.products-compare-icon__items-number'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'my_account_icon_title' )
				->label( esc_html__( 'My Account Icon', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_HEADER_MY_ACCOUNT_POPUP )
				->defaultVal( 1 )
				->label( esc_html__( 'Enable My Account Popup', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'cart_icon_title' )
				->label( esc_html__( 'Cart Icon', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_HEADER_CART_ICON_ITEMS_BACKGROUND_COLOR )
				->defaultVal( '#88b04b' )
				->description( esc_html__( '_items background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.shop-cart-icon__background'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_HEADER_CART_ICON_ITEMS_TEXT_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_items text', 'nels' ) )
				->css( array(
					'color' => array(
						'.shop-cart-icon__items-number'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'cart_popup_title' )
				->label( esc_html__( 'Cart Popup', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SHOP_CART_ICON_LINK )
				->defaultVal( 'cart_popup' )
				->description( esc_html__( '_cart icon link', 'nels' ) )
				->choices( array(
					'cart_popup' => esc_html__( 'Cart Popup', 'nels' ),
					'cart_page'  => esc_html__( 'Cart Page', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::ADD_TO_CART_POPUP )
				->defaultVal( 1 )
				->label( esc_html__( 'Add to Cart Popup', 'nels' ) )
				->description( esc_html__(
					'_if enabled, Cart Popup appears when Add to Cart is triggered on archives pages. This is effective just when Add to Cart does not redirect to the Cart Page',
					'nels'
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::HEADER_PRODUCTS_SEARCH_MODE )
				->defaultVal( 0 )
				->label( esc_html__( 'Enable Products Search Mode', 'nels' ) )
				->description( esc_html__(
					'_if you want search icon from Site Header to search just for products', 'nels' ) )
				->build();
		}

		/**
		 * @return array
		 */
		private function getShopHeaderIconsVisibilityList() {
			return array(
				'wishlist'         => esc_html__( '_Wislist', 'nels' ),
				'products_compare' => esc_html__( '_Products Compare', 'nels' ),
				'my_account'       => esc_html__( '_My Account', 'nels' ),
				'cart'             => esc_html__( '_Cart', 'nels' ),
			);
		}
	}
}