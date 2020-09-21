<?php

namespace Pikart\WpCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\GenericPluginPathsUtil' ) ) {

	/**
	 * Class GenericPluginPathsUtil
	 * @package Pikart\WpCore\Common
	 */
	class GenericPluginPathsUtil {

		/**
		 * @var array
		 */
		private static $baseContentUrl = array();

		/**
		 * @var array
		 */
		private static $assetsUrl = array();

		/**
		 * @var array
		 */
		private static $baseDir = array();

		/**
		 * @param string $pluginBaseUrl
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginJsUrl( $pluginBaseUrl, $file = '' ) {
			return self::getPluginAssetsUrl( $pluginBaseUrl, 'js/' . $file );
		}

		/**
		 * @param string $pluginBaseUrl
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginCssUrl( $pluginBaseUrl, $file = '' ) {
			return self::getPluginAssetsUrl( $pluginBaseUrl, 'css/' . $file );
		}

		/**
		 * @param string $pluginBaseUrl
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginFontsUrl( $pluginBaseUrl, $file = '' ) {
			return self::getPluginAssetsUrl( $pluginBaseUrl, 'fonts/' . $file );
		}

		/**
		 * @param string $pluginBaseUrl
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginImagesUrl( $pluginBaseUrl, $file = '' ) {
			return self::getPluginAssetsUrl( $pluginBaseUrl, 'images/' . $file );
		}

		/**
		 * @param string $pluginBaseUrl
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginAssetsVendorUrl( $pluginBaseUrl, $file = '' ) {
			return self::getPluginAssetsUrl( $pluginBaseUrl, 'vendor/' . $file );
		}

		/**
		 * @param string $pluginBaseUrl
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginBaseUrl( $pluginBaseUrl, $file = '' ) {
			self::checkBaseContentUrl( $pluginBaseUrl );

			return self::$baseContentUrl[ $pluginBaseUrl ] . $file;
		}

		/**
		 * @param string $pluginBaseDir
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginTemplatesDir( $pluginBaseDir, $file = '' ) {
			return self::getPluginResourcesDir( $pluginBaseDir, 'templates/' . $file );
		}

		/**
		 * @param string $pluginBaseDir
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginResourcesDir( $pluginBaseDir, $file = '' ) {
			self::checkBaseDir( $pluginBaseDir );

			return self::$baseDir[ $pluginBaseDir ] . 'resources/' . $file;
		}

		/**
		 * @param string $pluginBaseDir
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getPluginCacheDir( $pluginBaseDir, $file = '' ) {
			self::checkBaseDir( $pluginBaseDir );

			return self::$baseDir[ $pluginBaseDir ] . 'cache/' . $file;
		}

		/**
		 * @param string $pluginBaseUrl
		 * @param string $file
		 *
		 * @return string
		 */
		private static function getPluginAssetsUrl( $pluginBaseUrl, $file = '' ) {
			self::checkBaseContentUrl( $pluginBaseUrl );

			return self::$assetsUrl[ $pluginBaseUrl ] . $file;
		}

		/**
		 * @param string $pluginBaseDir
		 */
		private static function checkBaseDir( $pluginBaseDir ) {
			if ( ! empty( self::$baseDir[ $pluginBaseDir ] ) ) {
				return;
			}

			self::$baseDir[ $pluginBaseDir ] = $pluginBaseDir . 'includes/';
		}

		/**
		 * @param string $pluginBaseUrl
		 */
		private static function checkBaseContentUrl( $pluginBaseUrl ) {
			if ( ! empty( self::$baseContentUrl[ $pluginBaseUrl ] ) ) {
				return;
			}

			self::$baseContentUrl[ $pluginBaseUrl ] = $pluginBaseUrl;
			self::$assetsUrl[ $pluginBaseUrl ]      = self::$baseContentUrl[ $pluginBaseUrl ] . 'assets/';
		}
	}
}