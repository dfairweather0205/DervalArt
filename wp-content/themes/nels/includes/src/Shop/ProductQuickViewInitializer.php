<?php

namespace Pikart\Nels\Shop;

use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! class_exists( __NAMESPACE__ . '\ProductQuickViewInitializer' ) ) {

	/**
	 * Class ProductQuickViewInitializer
	 * @package Pikart\Nels\Shop
	 */
	class ProductQuickViewInitializer {

		const PRODUCT_QUICK_VIEW_ACTION = 'pikart_product_quick_view';

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * ProductQuickViewInitializer constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
		}


		public function init() {
			$this->registerProductQuickViewAjaxCall();
		}

		private function registerProductQuickViewAjaxCall() {
			$util = $this->util;

			$ajaxCallback = function () use ( $util ) {
				$productId = filter_input( INPUT_GET, 'productId', FILTER_SANITIZE_NUMBER_INT );

				if ( ! check_ajax_referer( ProductQuickViewInitializer::PRODUCT_QUICK_VIEW_ACTION, 'nonce', false )
				     || ! $productId ) {
					wp_die( esc_html__( 'Invalid input', 'nels' ), 400 );
				}

				ShopUtil::setupGlobalProduct( $productId );
				$GLOBALS['post'] = get_post( ShopUtil::getGlobalProduct()->get_id() );
				setup_postdata( $GLOBALS['post'] );

				$util->partial( 'single/product/quick-view-details' );
				wp_die();
			};

			add_action( 'wp_ajax_' . self::PRODUCT_QUICK_VIEW_ACTION, $ajaxCallback );
			add_action( 'wp_ajax_nopriv_' . self::PRODUCT_QUICK_VIEW_ACTION, $ajaxCallback );
		}
	}
}
