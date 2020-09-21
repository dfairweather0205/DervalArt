<?php

namespace Pikart\WpCore\Shortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodeActionName' ) ) {

	/**
	 * Class ShortcodeActionName
	 * @package Pikart\WpCore\Shortcode
	 */
	class ShortcodeActionName {

		/**
		 * @param string $shortcodeName
		 *
		 * @return string
		 */
		public static function attributesConfigBuild( $shortcodeName ) {
			return ShortcodeFilterName::buildName( $shortcodeName, 'shortcode_attributes_config_build' );
		}

		/**
		 * @param string $shortcodeName
		 *
		 * @return string
		 */
		public static function shortcode( $shortcodeName ) {
			return ShortcodeFilterName::buildName( $shortcodeName, 'shortcode' );
		}
	}
}