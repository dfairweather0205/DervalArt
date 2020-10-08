<?php

namespace Pikart\WpBase\Shop\Wishlist;

if ( ! class_exists( __NAMESPACE__ . '\\WishlistFacade' ) ) {

	/**
	 * Class WishlistFacade
	 * @package Pikart\WpBase\Shop\Wishlist
	 *
	 * @since 1.3.0
	 */
	class WishlistFacade {

		/**
		 * @var WishlistHelper
		 */
		private $wishlistHelper;

		/**
		 * WishlistFacade constructor.
		 *
		 * @param WishlistHelper $wishlistHelper
		 */
		public function __construct( WishlistHelper $wishlistHelper ) {
			$this->wishlistHelper = $wishlistHelper;
		}

		public function manageWishlist() {
			add_action( 'wp_enqueue_scripts', array( $this->wishlistHelper, 'localizeWishlistConfigData' ) );

			$this->registerAddProductToWishlistAjaxCall();
			$this->registerRemoveProductFromWishlistAjaxCall();
		}

		private function registerAddProductToWishlistAjaxCall() {
			add_action( sprintf( 'wp_ajax_%s_add_product_to_wishlist', PIKART_SLUG ),
				array( $this->wishlistHelper, 'addInputProductToWishlist' ) );
			add_action( sprintf( 'wp_ajax_nopriv_%s_add_product_to_wishlist', PIKART_SLUG ),
				array( $this->wishlistHelper, 'addInputProductToWishlist' ) );
		}

		private function registerRemoveProductFromWishlistAjaxCall() {
			add_action( sprintf( 'wp_ajax_%s_remove_product_from_wishlist', PIKART_SLUG ),
				array( $this->wishlistHelper, 'removeInputProductFromWishlist' ) );
			add_action( sprintf( 'wp_ajax_nopriv_%s_remove_product_from_wishlist', PIKART_SLUG ),
				array( $this->wishlistHelper, 'removeInputProductFromWishlist' ) );
		}
	}
}