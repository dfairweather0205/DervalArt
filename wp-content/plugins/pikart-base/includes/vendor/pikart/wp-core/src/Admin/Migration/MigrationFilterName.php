<?php

namespace Pikart\WpCore\Admin\Migration;


if ( ! class_exists( __NAMESPACE__ . '\\MigrationFilterName' ) ) {

	/**
	 * Class MigrationFilterName
	 * @package Pikart\WpCore\Admin\Migration
	 */
	class MigrationFilterName {

		/**
		 * @return string
		 */
		public static function metaFieldsWithShortcodes() {
			return static::buildFilter( 'migration_meta_fields_with_shortcodes' );
		}

		/**
		 * @return string
		 */
		public static function metaFieldsWithTermIds() {
			return static::buildFilter( 'migration_meta_fields_with_term_ids' );
		}

		/**
		 * @param string $name
		 *
		 * @return string
		 */
		private static function buildFilter( $name ) {
			return sprintf( '%s_%s', PIKART_SLUG, $name );
		}
	}
}