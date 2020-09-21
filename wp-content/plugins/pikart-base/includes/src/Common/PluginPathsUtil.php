<?php

namespace Pikart\WpBase\Common;

use Pikart\WpCore\Common\GenericPluginPathsUtil;

if ( ! class_exists( __NAMESPACE__ . '\\PluginPathsUtil' ) ) {

	/**
	 * Class PluginPathsUtil
	 * @package Pikart\WpBase\Common
	 */
	class PluginPathsUtil extends GenericPluginPathsUtil {

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getJsUrl( $file = '' ) {
			return static::getPluginJsUrl( PIKART_BASE_URL, $file );
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
			return static::getPluginCssUrl( PIKART_BASE_URL, $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getFontsUrl( $file = '' ) {
			return static::getPluginFontsUrl( PIKART_BASE_URL, $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getImagesUrl( $file = '' ) {
			return static::getPluginImagesUrl( PIKART_BASE_URL, $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getAssetsVendorUrl( $file = '' ) {
			return static::getPluginAssetsVendorUrl( PIKART_BASE_URL, $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getBaseUrl( $file = '' ) {
			return static::getPluginBaseUrl( PIKART_BASE_URL, $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getTemplatesDir( $file = '' ) {
			return static::getPluginTemplatesDir( PIKART_BASE_PATH, $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getResourcesDir( $file = '' ) {
			return static::getPluginResourcesDir( PIKART_BASE_PATH, $file );
		}

		/**
		 * @param string $file
		 *
		 * @return string
		 */
		public static function getCacheDir( $file = '' ) {
			return static::getPluginCacheDir( PIKART_BASE_PATH, $file );
		}
	}
}