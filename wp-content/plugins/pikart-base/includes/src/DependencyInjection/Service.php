<?php

namespace Pikart\WpBase\DependencyInjection;

use Pikart\WpBase\NavigationMenus\CustomWalkerNavMenu;
use Pikart\WpBase\OptionsPages\OptionsPagesUtil;
use Pikart\WpBase\Post\PostLikesFacade;
use Pikart\WpBase\Setup\Bootstrap;
use Pikart\WpBase\Shop\ProductsCompare\ProductsCompareHelper;
use Pikart\WpBase\Shop\ProductsCompare\ProductsCompareTemplateUtil;
use Pikart\WpBase\Shop\Wishlist\WishlistHelper;
use Pikart\WpCore\DependencyInjection\CoreService;

if ( ! class_exists( __NAMESPACE__ . '\\Service' ) ) {

	/**
	 * Service container wrapper used for service type hinting
	 *
	 * Class Service
	 * @package Pikart\WpBase\DependencyInjection
	 */
	class Service extends CoreService {

		/**
		 * @var ServiceContainer
		 */
		private static $serviceContainer;

		/**
		 * @return Bootstrap
		 */
		public static function bootstrap() {
			return static::getService( 'bootstrap' );
		}

		/**
		 * @return OptionsPagesUtil
		 */
		public static function optionsPagesUtil() {
			return static::getService( 'optionsPagesUtil' );
		}

		/**
		 * @since 1.3.0
		 *
		 * @return WishlistHelper
		 */
		public static function wishlistHelper() {
			return static::getService( 'wishlistHelper' );
		}

		/**
		 * @since 1.3.0
		 *
		 * @return ProductsCompareHelper
		 */
		public static function productsCompareHelper() {
			return static::getService( 'productsCompareHelper' );
		}

		/**
		 * @since 1.3.0
		 *
		 * @return ProductsCompareTemplateUtil
		 */
		public static function productsCompareTemplateUtil() {
			return static::getService( 'productsCompareTemplateUtil' );
		}

		/**
		 * @since 1.3.0
		 *
		 * @return PostLikesFacade
		 */
		public static function postLikesFacade() {
			return static::getService( 'postLikesFacade' );
		}

		/**
		 * @since 1.4.0
		 *
		 * @return CustomWalkerNavMenu
		 */
		public static function customWalkerNavMenu() {
			return static::getService( 'customWalkerNavMenu' );
		}

		/**
		 * @param string $service
		 *
		 * @return object
		 */
		protected static function getService( $service ) {
			if ( null === static::$serviceContainer ) {
				static::$serviceContainer = new ServiceContainer();
			}

			return static::$serviceContainer->getService( $service );
		}
	}
}