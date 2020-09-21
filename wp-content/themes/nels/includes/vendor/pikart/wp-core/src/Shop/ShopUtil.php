<?php

namespace Pikart\WpThemeCore\Shop;

use WC_DateTime;
use WC_Product;

if ( ! class_exists( __NAMESPACE__ . '\ShopUtil' ) ) {

	/**
	 * Class ShopUtil
	 * @package Pikart\WpThemeCore\Shop
	 *
	 * @since 1.1.0
	 */
	class ShopUtil {

		/**
		 * @return bool
		 */
		public static function isShopActivated() {
			return class_exists( 'WooCommerce' );
		}

		/**
		 * @return bool
		 */
		public static function isShop() {
			return self::isShopActivated() && is_shop();
		}

		/**
		 * @return bool
		 */
		public static function shopHasCustomizerOptions() {
			return self::isShopActivated() && version_compare( WC()->version, '3.3.0', '>=' );
		}

		/**
		 * @since 1.3.0
		 *
		 * @return int
		 */
		public static function getMyAccountPageId() {
			return get_option( 'woocommerce_myaccount_page_id' );
		}

		/**
		 * @param string $slug
		 * @param string $name
		 */
		public static function partial( $slug, $name = null ) {
			if ( ! self::isShopActivated() ) {
				return;
			}

			if ( ! $name ) {
				$name = version_compare( WC()->version, '3.3', '<' ) ? '3.2' : null;
			}

			get_template_part( 'templates/partials/' . $slug, $name );
		}

		/**
		 * @return string
		 */
		public static function captureProductSubcategoriesContent() {
			ob_start();

			if ( function_exists( 'woocommerce_output_product_categories' ) ) {
				woocommerce_output_product_categories();
			} else {
				woocommerce_product_subcategories();
			}

			return ob_get_clean();
		}

		/**
		 * @return int
		 */
		public static function getShopPageId() {
			return wc_get_page_id( 'shop' );
		}

		/**
		 * @param int $productId
		 *
		 * @return WC_Product
		 */
		public static function getGlobalProduct( $productId = null ) {
			self::setupGlobalProduct( $productId );

			return $GLOBALS['product'];
		}

		/**
		 * @param int $productId
		 */
		public static function setupGlobalProduct( $productId = null ) {
			if ( ! isset( $GLOBALS['product'] ) || ! ( $GLOBALS['product'] instanceof WC_Product ) ) {
				$productId          = $productId ? $productId : get_the_ID();
				$GLOBALS['product'] = wc_get_product( $productId );
			}
		}

		/**
		 * @return bool
		 */
		public static function shopPageDisplayIsSubcategories() {
			return get_option( 'woocommerce_shop_page_display' ) === 'subcategories' && self::isShop();
		}

		/**
		 * @return bool
		 */
		public static function categoryDisplayIsSubcategories() {
			return get_option( 'woocommerce_category_archive_display' ) === 'subcategories' && is_product_category();
		}

		/**
		 * @param WC_Product $product
		 * @param int $lastDays
		 *
		 * @since 1.3.0
		 * @return bool
		 * @throws \Exception
		 */
		public static function isProductNew( WC_Product $product, $lastDays = 1 ) {
			if ( $product->get_date_created() === null ) {
				return true;
			}

			$now          = new WC_DateTime( '@' . time() );
			$dateInterval = $now->diff( $product->get_date_created() );

			return $lastDays > 0 && ( $dateInterval->days < $lastDays );
		}

		/**
		 * @param WC_Product $product
		 * @param int $precision
		 *
		 * @since 1.3.0
		 */
		public static function getProductSaleReductionInPercentage( WC_Product $product, $precision = 0 ) {
			return round( ( 1 - $product->get_sale_price() / $product->get_regular_price() ) * 100, $precision ) . '%';
		}
	}
}
