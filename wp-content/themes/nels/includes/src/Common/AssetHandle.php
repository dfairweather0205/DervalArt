<?php

namespace Pikart\Nels\Common;

use Pikart\WpThemeCore\Common\CoreAssetHandle;

if ( ! class_exists( __NAMESPACE__ . '\\AssetHandle' ) ) {

	/**
	 * Class AssetHandle
	 * @package Pikart\Nels\Common
	 */
	class AssetHandle extends CoreAssetHandle {

		/**
		 * @return string
		 */
		public static function adminThemeCustomizer() {
			return self::buildThemeHandleName( 'admin-theme-customizer' );
		}

		/**
		 * @return string
		 */
		public static function adminThemeCustomizerStyle() {
			return self::buildThemeHandleName( 'admin-theme-customizer-style' );
		}

		/**
		 * @return string
		 */
		public static function adminThemeCustomizerRtlStyle() {
			return self::buildThemeHandleName( 'admin-theme-customizer-rtl-style' );
		}

		/**
		 * @return string
		 */
		public static function adminShortcodes() {
			return self::buildThemeHandleName( 'admin-shortcodes' );
		}

		/**
		 * @return string
		 */
		public static function adminProject() {
			return self::buildThemeHandleName( 'admin-project' );
		}

		/**
		 * @return string
		 */
		public static function adminAlbum() {
			return self::buildThemeHandleName( 'admin-album' );
		}

		/**
		 * @return string
		 */
		public static function adminPost() {
			return self::buildThemeHandleName( 'admin-post' );
		}

		/**
		 * @return string
		 */
		public static function adminPage() {
			return self::buildThemeHandleName( 'admin-page' );
		}

		/**
		 * @return string
		 */
		public static function vendor() {
			return self::buildThemeHandleName( 'vendor' );
		}
	}
}