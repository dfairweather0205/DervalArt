<?php

namespace Pikart\WpBase\Shop\Wishlist;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpBase\OptionsPages\OptionsPagesUtil;
use Pikart\WpCore\Common\Util;
use Pikart\WpCore\Shop\ShopFilterName;
use Pikart\WpCore\Shop\ShopUtil;

if ( ! class_exists( __NAMESPACE__ . '\\WishlistHelper' ) ) {

	/**
	 * Class WishlistHelper
	 * @package Pikart\WpBase\Shop\Wishlist
	 *
	 * @since 1.3.0
	 */
	class WishlistHelper {

		/**
		 * @var WishlistDal
		 */
		private $wishlistDal;

		/**
		 * @var OptionsPagesUtil
		 */
		private $optionsPagesUtil;

		/**
		 * @var Util
		 *
		 * @since 1.4.0
		 */
		private $util;

		/**
		 * WishlistHelper constructor.
		 *
		 * @param WishlistDal $wishlistDal
		 * @param OptionsPagesUtil $optionsPagesUtil
		 * @param Util $util
		 */
		public function __construct( WishlistDal $wishlistDal, OptionsPagesUtil $optionsPagesUtil, Util $util ) {
			$this->wishlistDal      = $wishlistDal;
			$this->optionsPagesUtil = $optionsPagesUtil;
			$this->util             = $util;
		}

		/**
		 * @return bool
		 */
		public function isWishlistAllowed() {
			return ShopUtil::isShopActivated() && apply_filters( ShopFilterName::wishlistAllowed(), true );
		}

		public function addInputProductToWishlist() {
			if ( ! $this->isInputValid() ) {
				wp_send_json_error();
			}

			$wishlist = $this->wishlistDal->addProductToWishList( $this->getProductId() );

			wp_send_json_success( array( 'wishlist' => array_keys( $wishlist ) ) );
		}

		public function removeInputProductFromWishlist() {
			if ( ! $this->isInputValid() ) {
				wp_send_json_error();
			}

			$wishlist = $this->wishlistDal->removeProductFromWishList( $this->getProductId() );

			wp_send_json_success( array(
				'wishlist'     => array_keys( $wishlist ),
				'wishlistHtml' => do_shortcode( '[pkrt_wishlist]' )
			) );
		}

		/**
		 * @param int $productId
		 *
		 * @return bool
		 */
		public function wishlistHasProduct( $productId ) {
			$wishlist = $this->getWishlist();

			return isset( $wishlist[ $productId ] );
		}

		public function localizeWishlistConfigData() {
			if ( ! $this->isWishlistAllowed() || ! $this->optionsPagesUtil->isWishlistEnabled() ) {
				return;
			}

			wp_localize_script( AssetHandle::pikartBaseCustom(), PIKART_SLUG . 'WishlistConfig', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( $this->getWishlistNonceAction() )
			) );
		}

		/**
		 * @return array
		 */
		public function getWishlist() {
			return $this->wishlistDal->loadWishList();
		}

		/**
		 * @return int
		 */
		public function getWishlistItemsNumber() {
			return count( $this->getWishlist() );
		}

		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public function getWishlistPartialContent( $slug, $name = '' ) {
			$self = $this;

			return $this->util->captureOutput( function () use ( $self, $slug, $name ) {
				$self->wishlistPartial( $slug, $name );
			} );
		}

		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @since 1.4.0
		 */
		public function wishlistPartial( $slug, $name = '' ) {
			if ( ! $this->isWishlistAllowed() || ! $this->optionsPagesUtil->isWishlistEnabled() ) {
				return;
			}

			$wishlistPageId  = $this->optionsPagesUtil->getWishlistPageId();
			$wishlistPageUrl = get_permalink( $wishlistPageId );

			if ( ! $wishlistPageId || ! $wishlistPageUrl ) {
				return;
			}

			set_query_var( 'wishlistPageId', $wishlistPageId );
			set_query_var( 'wishlistPageUrl', $wishlistPageUrl );
			set_query_var( 'wishlistItemsNumber', $this->getWishlistItemsNumber() );

			$this->util->pikartBasePartial( $slug, $name );
		}

		/**
		 * @return string
		 */
		private function getWishlistNonceAction() {
			return PIKART_SLUG . '_wishlist';
		}

		/**
		 * @return bool
		 */
		private function isInputValid() {
			return check_ajax_referer( $this->getWishlistNonceAction(), 'nonce', false ) && $this->getProductId();
		}

		/**
		 * @return int
		 */
		private function getProductId() {
			return filter_input( INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT );
		}
	}
}