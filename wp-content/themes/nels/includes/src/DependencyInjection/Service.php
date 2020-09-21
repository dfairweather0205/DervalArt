<?php

namespace Pikart\Nels\DependencyInjection;

use Pikart\Nels\Blog\CustomWalkerComment;
use Pikart\Nels\Blog\Options\BlogOptionsLoader;
use Pikart\Nels\Misc\TemplatesUtil;
use Pikart\Nels\Post\Options\PostOptionsLoader;
use Pikart\Nels\Setup\Bootstrap;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\DependencyInjection\CoreService;

if ( ! class_exists( __NAMESPACE__ . '\\Service' ) ) {

	/**
	 * Service container wrapper used for service type hinting
	 *
	 * Class Service
	 * @package Pikart\Nels\DependencyInjection
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
		 * @return CustomWalkerComment
		 */
		public static function customWalkerComment() {
			return static::getService( 'customWalkerComment' );
		}

		/**
		 * @return ThemeOptionsUtil
		 */
		public static function themeOptionsUtil() {
			return static::getService( 'themeOptionsUtil' );
		}

		/**
		 * @return BlogOptionsLoader
		 */
		public static function blogOptionsLoader() {
			return static::getService( 'blogOptionsLoader' );
		}

		/**
		 * @return TemplatesUtil
		 */
		public static function templatesUtil() {
			return static::getService( 'templatesUtil' );
		}

		/**
		 * @return PostOptionsLoader
		 */
		public static function postOptionsLoader() {
			return static::getService( 'postOptionsLoader' );
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