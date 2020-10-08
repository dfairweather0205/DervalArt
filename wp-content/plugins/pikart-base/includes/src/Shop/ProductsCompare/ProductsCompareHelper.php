<?php

namespace Pikart\WpBase\Shop\ProductsCompare;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpBase\OptionsPages\OptionsPagesUtil;
use Pikart\WpCore\Common\Util;
use Pikart\WpCore\Shop\ShopFilterName;
use Pikart\WpCore\Shop\ShopUtil;
use WC_Product;

if ( ! class_exists( __NAMESPACE__ . '\\ProductsCompareHelper' ) ) {

	/**
	 * Class ProductsCompareHelper
	 * @package Pikart\WpBase\Shop\ProductsCompare
	 *
	 * @since 1.3.0
	 */
	class ProductsCompareHelper {

		/**
		 * @var ProductsCompareDal
		 */
		private $productsCompareDal;

		/**
		 * @var OptionsPagesUtil
		 */
		private $optionsPagesUtil;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * ProductsCompareHelper constructor.
		 *
		 * @param ProductsCompareDal $productsCompareDal
		 * @param OptionsPagesUtil $optionsPagesUtil
		 * @param Util $util
		 */
		public function __construct( ProductsCompareDal $productsCompareDal, OptionsPagesUtil $optionsPagesUtil, Util $util ) {
			$this->productsCompareDal = $productsCompareDal;
			$this->optionsPagesUtil   = $optionsPagesUtil;
			$this->util               = $util;
		}

		/**
		 * @return bool
		 */
		public function isProductsCompareAllowed() {
			return ShopUtil::isShopActivated() && apply_filters( ShopFilterName::productsCompareAllowed(), true );
		}

		public function addInputProductToCompareList() {
			if ( ! $this->isInputValid() ) {
				wp_send_json_error();
			}

			$this->productsCompareDal->addProductToCompareList( $this->getProductId() );

			wp_send_json_success( $this->getCompareListDataForJs() );
		}

		public function removeInputProductFromCompareList() {
			if ( ! $this->isInputValid() ) {
				wp_send_json_error();
			}

			$this->productsCompareDal->removeProductFromCompareList( $this->getProductId() );

			wp_send_json_success( $this->getCompareListDataForJs() );
		}

		/**
		 * @param int $productId
		 *
		 * @return bool
		 */
		public function compareListHasProduct( $productId ) {
			$products = $this->getCompareList();

			return isset( $products[ $productId ] );
		}

		public function localizeCompareListConfigData() {
			if ( ! $this->isProductsCompareAllowed() || ! $this->optionsPagesUtil->isProductsCompareEnabled() ) {
				return;
			}

			wp_localize_script( AssetHandle::pikartBaseCustom(), PIKART_SLUG . 'ProductsCompareListConfig', array(
				'ajaxurl'         => admin_url( 'admin-ajax.php' ),
				'nonce'           => wp_create_nonce( $this->getCompareProductsNonceAction() ),
				'compareListData' => $this->getCompareListDataForJs()
			) );
		}

		/**
		 * @return array
		 */
		public function getCompareList() {
			return $this->productsCompareDal->loadCompareList();
		}

		/**
		 * @return int
		 */
		public function getCompareListProductsNumber() {
			return count( $this->getCompareList() );
		}

		/**
		 * @return WC_Product[]
		 */
		public function getCompareListWithProductsDetails() {
			$productIds = $this->getCompareList();
			$products   = array();

			foreach ( $productIds as $productId ) {
				$product = wc_get_product( $productId );

				if ( $product ) {
					$products[ $productId ] = $product;
				}
			}

			return $products;
		}

		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public function getProductsComparePartialContent( $slug, $name = '' ) {
			if ( ! $this->isProductsCompareAllowed() || ! $this->optionsPagesUtil->isProductsCompareEnabled() ) {
				return '';
			}

			set_query_var( 'compareListItemsNumber', $this->getCompareListProductsNumber() );

			return $this->util->getPikartBasePartialContent( $slug, $name );
		}

		/**
		 * @return array
		 */
		private function getCompareListDataForJs() {
			$products = $this->getCompareList();

			return array(
				'productsCompareList' => array_keys( $products ),
				'productsCompareHtml' => $this->getProductsCompareTableHtml()
			);
		}

		/**
		 * @return string
		 */
		private function getProductsCompareTableHtml() {
			return $this->util->getPikartBasePartialContent( 'shop/products-compare/container' );
		}

		/**
		 * @return string
		 */
		private function getCompareProductsNonceAction() {
			return PIKART_SLUG . '_compare_products';
		}

		/**
		 * @return bool
		 */
		private function isInputValid() {
			return $this->isNonceValid() && $this->getProductId();
		}

		/**
		 * @since 1.5.3
		 *
		 * @return bool|int
		 */
		private function isNonceValid() {
			return check_ajax_referer( $this->getCompareProductsNonceAction(), 'nonce', false );
		}

		/**
		 * @return int
		 */
		private function getProductId() {
			return filter_input( INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT );
		}
	}
}