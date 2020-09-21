<?php

namespace Pikart\WpBase\Shop\ProductsCompare;

if ( ! class_exists( __NAMESPACE__ . '\\ProductsCompareDal' ) ) {

	/**
	 * Class ProductsCompareDal
	 * @package Pikart\WpBase\Shop\ProductsCompare
	 *
	 * @since 1.3.0
	 */
	class ProductsCompareDal {

		/**
		 * @var array
		 */
		private $compareList;

		/**
		 * @param int $productId
		 *
		 * @return array
		 */
		public function addProductToCompareList( $productId ) {
			$compareList = $this->loadCompareList();
			$productId   = (int) $productId;

			if ( isset( $compareList[ $productId ] ) ) {
				return $compareList;
			}

			$compareList[ $productId ] = $productId;

			$this->saveCompareList( $compareList );

			return $compareList;
		}

		/**
		 * @param int $productId
		 *
		 * @return array
		 */
		public function removeProductFromCompareList( $productId ) {
			$compareList = $this->loadCompareList();

			if ( ! isset( $compareList[ $productId ] ) ) {
				return $compareList;
			}

			unset( $compareList[ $productId ] );

			$this->saveCompareList( $compareList );

			return $compareList;
		}

		/**
		 * @return array
		 */
		public function loadCompareList() {
			if ( is_array( $this->compareList ) ) {
				return $this->compareList;
			}

			$compareListMetaKey = $this->getCompareListMetaKey();
			$compareList        = filter_input( INPUT_COOKIE, $compareListMetaKey );
			$this->compareList  = $compareList ? (array) json_decode( $compareList, true ) : array();

			if ( empty( $this->compareList ) || ! is_array( $this->compareList ) ) {
				$this->compareList = array();

				return $this->compareList;
			}

			$values = filter_var_array( $this->compareList, FILTER_SANITIZE_NUMBER_INT );

			$this->compareList = array_combine( $values, $values );

			return $this->compareList;
		}

		/**
		 * @param array $compareList
		 */
		private function saveCompareList( array $compareList ) {
			$compareListMetaKey = $this->getCompareListMetaKey();

			setcookie( $compareListMetaKey, json_encode( $compareList ), 0, COOKIEPATH, COOKIE_DOMAIN );

			$this->compareList = $compareList;
		}

		/**
		 * @return string
		 */
		private function getCompareListMetaKey() {
			return PIKART_SLUG . '_products_compare_list';
		}
	}
}