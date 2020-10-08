<?php

namespace Pikart\WpBase\Shop\ProductsCompare;

if ( ! class_exists( __NAMESPACE__ . '\\ProductsCompareFacade' ) ) {

	/**
	 * Class ProductsCompareFacade
	 * @package Pikart\WpBase\Shop\ProductsCompare
	 */
	class ProductsCompareFacade {

		/**
		 * @var ProductsCompareHelper
		 */
		private $productsCompareHelper;

		/**
		 * ProductsCompareFacade constructor.
		 *
		 * @param ProductsCompareHelper $productsCompareHelper
		 */
		public function __construct( ProductsCompareHelper $productsCompareHelper ) {
			$this->productsCompareHelper = $productsCompareHelper;
		}

		public function manageProductsCompare() {
			add_action( 'wp_enqueue_scripts', array( $this->productsCompareHelper, 'localizeCompareListConfigData' ) );

			$this->registerAddProductToCompareListAjaxCall();
			$this->registerRemoveProductFromCompareListAjaxCall();
		}

		private function registerAddProductToCompareListAjaxCall() {
			add_action( sprintf( 'wp_ajax_%s_add_product_to_compare_list', PIKART_SLUG ),
				array( $this->productsCompareHelper, 'addInputProductToCompareList' ) );
			add_action( sprintf( 'wp_ajax_nopriv_%s_add_product_to_compare_list', PIKART_SLUG ),
				array( $this->productsCompareHelper, 'addInputProductToCompareList' ) );
		}

		private function registerRemoveProductFromCompareListAjaxCall() {
			add_action( sprintf( 'wp_ajax_%s_remove_product_from_compare_list', PIKART_SLUG ),
				array( $this->productsCompareHelper, 'removeInputProductFromCompareList' ) );
			add_action( sprintf( 'wp_ajax_nopriv_%s_remove_product_from_compare_list', PIKART_SLUG ),
				array( $this->productsCompareHelper, 'removeInputProductFromCompareList' ) );
		}
	}
}