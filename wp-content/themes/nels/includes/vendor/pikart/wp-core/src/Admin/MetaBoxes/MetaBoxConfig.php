<?php

namespace Pikart\WpThemeCore\Admin\MetaBoxes;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxConfig' ) ) {

	/**
	 * Class MetaBoxConfig
	 * @package Pikart\WpThemeCore\Admin\MetaBoxes
	 *
	 * @since 1.4.0
	 */
	class MetaBoxConfig {

		/**
		 * @var string
		 */
		private static $metaBoxAddMethod;

		/**
		 * @var string
		 */
		private static $metaBoxesAddFilter;

		/**
		 * @return string
		 */
		public static function getMetaBoxAddMethod() {
			return self::$metaBoxAddMethod;
		}

		/**
		 * @param string $postType
		 *
		 * @return string
		 */
		public static function getMetaBoxesAddFilter( $postType ) {
			return self::$metaBoxesAddFilter ? sprintf( '%s_%s', self::$metaBoxesAddFilter, $postType ) : '';
		}

		/**
		 * @param string $metaBoxAddMethod
		 */
		public static function setMetaBoxAddMethod( $metaBoxAddMethod ) {
			self::$metaBoxAddMethod = $metaBoxAddMethod;
		}

		/**
		 * @param string $metaBoxesAddFilter
		 */
		public static function setMetaBoxesAddFilter( $metaBoxesAddFilter ) {
			self::$metaBoxesAddFilter = $metaBoxesAddFilter;
		}
	}
}