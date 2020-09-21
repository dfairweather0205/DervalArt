<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpBase\OptionsPages\OptionsPagesUtil;
use Pikart\WpBase\Shop\Wishlist\WishlistHelper;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\WishlistShortcode' ) ) {

	/**
	 * Class WishlistShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 *
	 * @since 1.3.0
	 */
	class WishlistShortcode extends AbstractShortcode {

		/**
		 * @var WishlistHelper
		 */
		private $wishlistHelper;

		/**
		 * @var OptionsPagesUtil
		 */
		private $optionsPagesUtil;

		/**
		 * ProductsShortcode constructor.
		 *
		 * @param WishlistHelper $wishlistHelper
		 * @param OptionsPagesUtil $optionsPagesUtil
		 */
		public function __construct( WishlistHelper $wishlistHelper, OptionsPagesUtil $optionsPagesUtil ) {
			$this->wishlistHelper   = $wishlistHelper;
			$this->optionsPagesUtil = $optionsPagesUtil;
			parent::__construct();
		}

		/**
		 * @inheritdoc
		 */
		public function enabled() {
			return $this->wishlistHelper->isWishlistAllowed() && $this->optionsPagesUtil->isWishlistEnabled();
		}

		/**
		 * @inheritdoc
		 */
		public function isSelfClosing() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function isFinal() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function processTemplateData( array &$data ) {
			$wishlistProductIds = $this->wishlistHelper->getWishlist();

			$data['wishlist'] = array();

			foreach ( $wishlistProductIds as $productId ) {
				$product = wc_get_product( $productId );

				if ( $product ) {
					$data['wishlist'][ $productId ] = $product;
				}
			}
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$builder->cssClass();
		}
	}
}