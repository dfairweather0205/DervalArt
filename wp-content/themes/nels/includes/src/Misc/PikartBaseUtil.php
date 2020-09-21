<?php

namespace Pikart\Nels\Misc;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpBase\DependencyInjection\Service as PikartBaseService;
use Pikart\WpBase\NavigationMenus\CustomWalkerNavMenu;
use Pikart\WpBase\OptionsPages\OptionsPage;
use Pikart\WpBase\OptionsPages\PageOption;
use Pikart\WpThemeCore\OptionsPages\OptionsPagesConfig;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! class_exists( __NAMESPACE__ . '\\PikartBaseUtil' ) ) {

	/**
	 * Class PikartBaseUtil
	 * @package Pikart\Nels\Misc
	 */
	class PikartBaseUtil {

		/**
		 * @return bool
		 */
		public static function isWishlistEnabled() {
			return ShopUtil::isShopActivated()
			       && self::wishlistHelperServiceMethodExists( 'isWishlistAllowed' )
			       && PikartBaseService::wishlistHelper()->isWishlistAllowed()
			       && self::optionsPagesUtilServiceMethodExists( 'isWishlistEnabled' )
			       && PikartBaseService::optionsPagesUtil()->isWishlistEnabled();
		}

		/**
		 * @param int $productId
		 *
		 * @return boolean
		 */
		public static function wishlistHasProduct( $productId ) {
			return self::wishlistHelperServiceMethodExists( 'wishlistHasProduct' )
				? PikartBaseService::wishlistHelper()->wishlistHasProduct( $productId ) : false;
		}

		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @return string
		 */
		public static function getWishlistPartialContent( $slug, $name = '' ) {
			return self::wishlistHelperServiceMethodExists( 'getWishlistPartialContent' )
				? PikartBaseService::wishlistHelper()->getWishlistPartialContent( $slug, $name ) : '';
		}

		/**
		 * @param string $slug
		 * @param string $name
		 */
		public static function wishlistPartial( $slug, $name = '' ) {
			if ( self::wishlistHelperServiceMethodExists( 'wishlistPartial' ) ) {
				PikartBaseService::wishlistHelper()->wishlistPartial( $slug, $name );
			}
		}

		/**
		 * @param int $productId
		 *
		 * @return boolean
		 */
		public static function compareListHasProduct( $productId ) {
			return self::productsCompareHelperServiceMethodExists( 'compareListHasProduct' )
				? PikartBaseService::productsCompareHelper()->compareListHasProduct( $productId ) : false;
		}

		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @return string
		 */
		public static function getProductsComparePartialContent( $slug, $name = '' ) {
			return self::productsCompareHelperServiceMethodExists( 'getProductsComparePartialContent' )
				? PikartBaseService::productsCompareHelper()->getProductsComparePartialContent( $slug, $name ) : '';
		}


		/**
		 * @param string $slug
		 * @param string $name
		 *
		 * @since 1.0.3
		 */
		public static function productsComparePartial( $slug, $name = '' ) {
			echo self::getProductsComparePartialContent( $slug, $name );
		}

		/**
		 * @return CustomWalkerNavMenu
		 */
		public static function getCustomWalkerNavMenu() {
			return self::pikartBaseServiceExists( 'customWalkerNavMenu' )
				? PikartBaseService::customWalkerNavMenu() : '';
		}

		/**
		 * @return array
		 */
		public static function getSocialServices() {
			return self::optionsPagesUtilServiceMethodExists( 'getSocialServices' )
				? PikartBaseService::optionsPagesUtil()->getSocialServices() : array();
		}

		/**
		 * @param string $value
		 *
		 * @return bool
		 */
		public static function isSocialShareVisible( $value ) {
			return self::optionsPagesUtilServiceMethodExists( 'isSocialShareVisible' )
				? PikartBaseService::optionsPagesUtil()->isSocialShareVisible( $value ) : false;
		}

		/**
		 * @param array $dependencies
		 *
		 * @return array
		 */
		public static function addShortcodesDependency( array $dependencies ) {
			if ( PIKART_BASE_ENABLED && method_exists( 'Pikart\WpBase\Common\AssetHandle', 'shortcodes' ) ) {
				$dependencies[] = AssetHandle::shortcodes();
			}

			return $dependencies;
		}

		/**
		 * @param int $pageId
		 */
		public static function updateWishlistPageId( $pageId ) {
			if ( PIKART_BASE_ENABLED ) {
				$optionId = OptionsPage::PIKART_BASE;
				// unregister pikart base settings in order not to reset the default settings values
				unregister_setting( $optionId, OptionsPagesConfig::getOptionsPageDbKey( $optionId ) );
				self::updatePikartBasePageOption( PageOption::WISHLIST_PAGE, (int) $pageId );
			}
		}

		/**
		 * @param string $optionId
		 * @param mixed $optionValue
		 *
		 * @since 1.0.2
		 */
		public static function updatePikartBasePageOption( $optionId, $optionValue ) {
			if ( PIKART_BASE_ENABLED && self::optionsPagesUtilServiceMethodExists( 'updatePikartBasePageOption' ) ) {
				PikartBaseService::optionsPagesUtil()->updatePikartBasePageOption( $optionId, $optionValue );
			}
		}

		/**
		 * @param string $methodName
		 *
		 * @return bool
		 */
		private static function optionsPagesUtilServiceMethodExists( $methodName ) {
			return PIKART_BASE_ENABLED
			       && method_exists( 'Pikart\WpBase\OptionsPages\OptionsPagesUtil', $methodName );
		}

		/**
		 * @param string $methodName
		 *
		 * @return bool
		 */
		private static function productsCompareHelperServiceMethodExists( $methodName ) {
			return PIKART_BASE_ENABLED
			       && method_exists( 'Pikart\WpBase\Shop\ProductsCompare\ProductsCompareHelper', $methodName );
		}

		/**
		 * @param string $methodName
		 *
		 * @return bool
		 */
		private static function wishlistHelperServiceMethodExists( $methodName ) {
			return PIKART_BASE_ENABLED && method_exists( 'Pikart\WpBase\Shop\Wishlist\WishlistHelper', $methodName );
		}

		/**
		 * @param string $serviceName
		 *
		 * @return bool
		 */
		private static function pikartBaseServiceExists( $serviceName ) {
			return PIKART_BASE_ENABLED && method_exists( 'Pikart\WpBase\DependencyInjection\Service', $serviceName );
		}
	}
}
