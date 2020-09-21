<?php

namespace Pikart\WpCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\PathsUtil' ) ) {
	/**
	 * Class PathsUtil
	 * @package Pikart\WpCore\Common
	 */
	class ThemePathsUtil {
		/**
		 * @var string
		 */
		private static $baseContentUrl;

		/**
		 * @var string
		 */
		private static $assetsUrl;

		/**
		 * @var string
		 */
		private static $baseDir;

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getJsUrl( $file = '' ) {
			return self::getAssetsUrl( 'js/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function getJsVendorUrl( $file = '' ) {
			return self::getJsUrl( 'vendor/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getCssUrl( $file = '' ) {
			return self::getAssetsUrl( 'css/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function getCssVendorUrl( $file = '' ) {
			return self::getCssUrl( 'vendor/' . $file );
		}


		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getFontsUrl( $file = '' ) {
			return self::getAssetsUrl( 'fonts/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getImagesUrl( $file = '' ) {
			return self::getAssetsUrl( 'images/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getAssetsVendorUrl( $file = '' ) {
			return self::getAssetsUrl( 'vendor/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getBaseUrl( $file = '' ) {
			return self::$baseContentUrl . $file;
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getResourcesDir( $file = '' ) {
			self::checkBaseDir();

			return self::$baseDir . 'resources/' . $file;
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getCacheDir( $file = '' ) {
			self::checkBaseDir();

			return self::$baseDir . 'cache/' . $file;
		}

		/**
		 * @param string $file
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public static function getPluginsDir( $file = '' ) {
			return self::getResourcesDir( 'plugins/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		private static function getAssetsUrl( $file = '' ) {
			self::checkBaseContentUrl();

			return self::$assetsUrl . $file;
		}

		private static function checkBaseDir() {
			if ( ! empty( self::$baseDir ) ) {
				return;
			}

			self::$baseDir = get_template_directory() . '/includes/';
		}

		private static function checkBaseContentUrl() {
			if ( ! empty( self::$baseContentUrl ) ) {
				return;
			}

			self::$baseContentUrl = get_template_directory_uri() . '/';
			self::setupUrls();
		}

		private static function setupUrls() {
			self::$assetsUrl = self::$baseContentUrl . 'assets/';
		}
	}
}