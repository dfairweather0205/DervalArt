<?php

namespace Pikart\WpCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\CorePathsUtil' ) ) {
	/**
	 * Class CorePathsUtil
	 * @package Pikart\WpCore\Common
	 */
	class CorePathsUtil {

		const PIKART_CORE_VENDOR_PATH = 'vendor/pikart/wp-core/';

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
		 * @var string
		 */
		private static $baseCoreDir;

		/**
		 * @param string $baseContentUrl
		 */
		public static function registerBaseContentUrl( $baseContentUrl ) {
			self::$baseContentUrl = $baseContentUrl;
			self::setupUrls();
		}

		/**
		 * @param string $baseDir
		 */
		public static function registerBaseDir( $baseDir ) {
			self::$baseDir = $baseDir;
			self::setupDirs();
		}

		/**
		 * @param string $baseDir
		 * @param string $baseContentUrl
		 */
		public static function registerBaseDirAndUrl( $baseDir, $baseContentUrl ) {
			self::registerBaseDir( $baseDir );
			self::registerBaseContentUrl( $baseContentUrl );
		}

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
		 * @return string
		 */
		public static function getCssUrl( $file = '' ) {
			return self::getAssetsUrl( 'css/' . $file );
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
		public static function getAssetsVendorUrl( $file = '' ) {
			return self::getAssetsUrl( 'vendor/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getTemplatesDir( $file = '' ) {
			return self::getResourcesDir( 'templates/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getCacheDir( $file = '' ) {
			return self::getBaseCoreDir( 'cache/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getResourcesDir( $file = '' ) {
			return self::getBaseCoreDir( 'resources/' . $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		private static function getBaseCoreDir( $file = '' ) {
			self::checkBaseDir();

			return self::$baseCoreDir . $file;
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

			self::setupDirs();
		}

		private static function checkBaseContentUrl() {
			if ( ! empty( self::$baseContentUrl ) ) {
				return;
			}

			self::setupUrls();
		}

		private static function setupUrls() {
			self::$assetsUrl = self::$baseContentUrl . '/includes/' . self::PIKART_CORE_VENDOR_PATH . 'assets/';
		}

		private static function setupDirs() {
			self::$baseCoreDir = self::$baseDir . '/includes/' . self::PIKART_CORE_VENDOR_PATH . '/';
		}
	}
}