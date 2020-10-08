<?php

namespace Pikart\WpBase\Common;

use Pikart\WpCore\Common\CoreAssetHandle;
use Pikart\WpCore\Common\Env;

if ( ! class_exists( __NAMESPACE__ . '\\AssetHandle' ) ) {

	/**
	 * Class AssetHandle
	 * @package Pikart\WpBase\Common
	 */
	class AssetHandle extends CoreAssetHandle {

		/**
		 * @return string
		 */
		public static function adminShortcodesStyle() {
			return self::buildHandleName( 'admin-shortcodes-style' );
		}

		/**
		 * @return string
		 */
		public static function adminShortcodesRtlStyle() {
			return self::buildHandleName( 'admin-shortcodes-rtl-style' );
		}

		/**
		 * @return string
		 */
		public static function shortcodes() {
			return self::buildPikartBaseName( 'shortcodes' );
		}

		/**
		 * @return string
		 */
		public static function pikartBaseCustom() {
			return self::buildPikartBaseName( 'pikart-base-custom' );
		}

		/**
		 * @since 1.5.0
		 *
		 * @return string
		 */
		public static function pikartBase() {
			return self::buildHandleName( 'pikart-base' );
		}

		/**
		 * @return string
		 */
		public static function addthis() {
			return self::buildHandleName( 'addthis' );
		}

		/**
		 * @return string
		 */
		public static function gmapApi() {
			return self::buildHandleName( 'gmap-api' );
		}

		public static function postLikes() {
			return self::buildPikartBaseName( 'post-likes' );
		}

		/**
		 * @return string
		 */
		public static function adminCustomSidebars() {
			return self::buildHandleName( 'admin-custom-sidebars' );
		}

		/**
		 * @since 1.1.0
		 *
		 * @return string
		 */
		public static function adminNavigationMenus() {
			return self::buildHandleName( 'admin-navigation-menus' );
		}

		/**
		 * @since 1.1.0
		 *
		 * @return string
		 */
		public static function adminNavigationMenusStyle() {
			return self::buildHandleName( 'admin-navigation-menus-style' );
		}

		/**
		 * @since 1.1.0
		 *
		 * @return string
		 */
		public static function adminWidgets() {
			return self::buildHandleName( 'admin-widgets' );
		}

		/**
		 * @since 1.1.0
		 *
		 * @return string
		 */
		public static function adminWidgetsStyle() {
			return self::buildHandleName( 'admin-widgets-style' );
		}

		/**
		 * @return string
		 */
		public static function adminCustomSidebarsStyle() {
			return self::buildHandleName( 'admin-custom-sidebars-style' );
		}

		/**
		 * @return string
		 */
		public static function adminCustomSidebarsRtlStyle() {
			return self::buildHandleName( 'admin-custom-sidebars-rtl-style' );
		}

		/**
		 * @return string
		 */
		public static function adminMediaCustomFieldsStyle() {
			return self::buildHandleName( 'admin-media-custom-fields-style' );
		}

		/**
		 * @return string
		 */
		public static function adminMediaCustomFieldsRtlStyle() {
			return self::buildHandleName( 'admin-media-custom-fields-rtl-style' );
		}

		/**
		 * @since 1.5.7
		 *
		 * @return string
		 */
		public static function adminBlockCoreGallery() {
			return self::buildHandleName( 'admin-block-core-gallery' );
		}

		/**
		 * @param string $handle
		 *
		 * @return string
		 */
		protected static function buildHandleName( $handle ) {
			return sprintf( '%s-%s', PIKART_BASE_SLUG, $handle );
		}

		/**
		 * for non-dev env load the minified base version which contains all the custom base js code
		 *
		 * @since 1.5.0
		 *
		 * @return string
		 */
		protected static function buildPikartBaseName( $handle ) {
			return ! Env::isDev() ? self::pikartBase() : self::buildHandleName( $handle );
		}
	}
}