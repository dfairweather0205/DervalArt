<?php

namespace Pikart\WpBase\Shop\Wishlist;

if ( ! class_exists( __NAMESPACE__ . '\\WishlistDal' ) ) {

	/**
	 * Class WishlistDal
	 * @package Pikart\WpBase\Shop\Wishlist
	 *
	 * @since 1.3.0
	 */
	class WishlistDal {

		/**
		 * @var array
		 */
		private $wishlist;

		/**
		 * @param int $productId
		 *
		 * @return array
		 */
		public function addProductToWishList( $productId ) {
			$wishlist  = $this->loadWishList();
			$productId = (int) $productId;

			if ( isset( $wishlist[ $productId ] ) ) {
				return $wishlist;
			}

			$wishlist[ $productId ] = $productId;

			$this->saveWishlist( $wishlist );

			return $wishlist;
		}

		/**
		 * @param int $productId
		 *
		 * @return array
		 */
		public function removeProductFromWishList( $productId ) {
			$wishlist = $this->loadWishList();

			if ( ! isset( $wishlist[ $productId ] ) ) {
				return $wishlist;
			}

			unset( $wishlist[ $productId ] );

			$this->saveWishlist( $wishlist );

			return $wishlist;
		}

		/**
		 * @return array
		 */
		public function loadWishList() {
			if ( is_array( $this->wishlist ) ) {
				return $this->wishlist;
			}

			$wishlistMetaKey = $this->getWishlistMetaKey();

			if ( is_user_logged_in() ) {
				$this->wishlist = get_user_meta( get_current_user_id(), $wishlistMetaKey, true );
			}

			if ( empty( $this->wishlist ) ) {
				$wishlist       = filter_input( INPUT_COOKIE, $wishlistMetaKey );
				$this->wishlist = $wishlist ? (array) json_decode( $wishlist, true ) : array();
			}

			if ( empty( $this->wishlist ) || ! is_array( $this->wishlist ) ) {
				$this->wishlist = array();

				return $this->wishlist;
			}

			$values = filter_var_array( $this->wishlist, FILTER_SANITIZE_NUMBER_INT );

			$this->wishlist = array_combine( $values, $values );

			return $this->wishlist;
		}

		/**
		 * @param array $wishlist
		 */
		private function saveWishlist( array $wishlist ) {
			$wishlistMetaKey = $this->getWishlistMetaKey();

			if ( is_user_logged_in() ) {
				update_user_meta( get_current_user_id(), $wishlistMetaKey, $wishlist );
			}

			setcookie(
				$wishlistMetaKey, json_encode( $wishlist ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );

			$this->wishlist = $wishlist;
		}

		/**
		 * @return string
		 */
		private function getWishlistMetaKey() {
			return PIKART_SLUG . '_wishlist';
		}
	}
}