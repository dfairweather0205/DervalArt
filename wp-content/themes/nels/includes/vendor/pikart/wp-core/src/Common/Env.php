<?php

namespace Pikart\WpThemeCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\Env' ) ) {

	final class Env {
		const PROD = 'prod';
		const STAGE = 'stage';
		const DEV = 'dev';

		/**
		 * @return bool
		 */
		public static function isDev() {
			return self::isEnv( self::DEV );
		}

		/**
		 * @return bool
		 */
		public static function isStage() {
			return self::isEnv( self::STAGE );
		}

		/**
		 * @return bool
		 */
		public static function isProd() {
			return self::isEnv( self::PROD );
		}

		/**
		 * @return bool
		 */
		public static function isPikartThemeActive() {
			return defined( 'PIKART_THEME_ACTIVE' ) && PIKART_THEME_ACTIVE;
		}

		/**
		 * @param string $env
		 *
		 * @return bool
		 */
		private static function isEnv( $env ) {
			return defined( 'PIKART_APP_ENV' ) && PIKART_APP_ENV === $env;
		}
	}
}