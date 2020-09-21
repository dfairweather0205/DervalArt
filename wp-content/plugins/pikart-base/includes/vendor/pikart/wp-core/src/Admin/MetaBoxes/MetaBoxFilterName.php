<?php

namespace Pikart\WpCore\Admin\MetaBoxes;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxFilterName' ) ) {

	/**
	 * Class MetaBoxFilterName
	 * @package Pikart\WpCore\Admin\MetaBoxes
	 */
	class MetaBoxFilterName {

		/**
		 * @param string $metaBoxId
		 * @param string $fieldId
		 *
		 * @return string
		 */
		public static function fieldConfig( $metaBoxId, $fieldId ) {
			return strtolower( sprintf( '%s_meta_box_%s_%s_config', PIKART_SLUG, $metaBoxId, $fieldId ) );
		}
	}
}