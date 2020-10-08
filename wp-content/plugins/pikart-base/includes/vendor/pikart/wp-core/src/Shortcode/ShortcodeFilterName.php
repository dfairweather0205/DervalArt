<?php

namespace Pikart\WpCore\Shortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodeFilterName' ) ) {

	/**
	 * Class ShortcodeFilterName
	 * @package Pikart\WpCore\Shortcode
	 */
	class ShortcodeFilterName {

		/**
		 * @since 1.8.3
		 *
		 * @return string
		 */
		public static function shortcodesEnabled() {
			return ShortcodeConfig:: NAME_PREFIX . '_shortcodes_enabled';
		}

		/**
		 * @return string
		 */
		public static function shortcodeList() {
			return ShortcodeConfig:: NAME_PREFIX . '_shortcode_list';
		}

		/**
		 * @param string $shortcodeName
		 *
		 * @return string
		 */
		public static function attributesConfig( $shortcodeName ) {
			return static::buildName( $shortcodeName, 'shortcode_attributes_config' );
		}

		/**
		 * @return string
		 */
		public static function teamMemberHeaderBrandingBackgroundColor() {
			return static::buildName( 'team_member', 'shortcode_header_branding_background_color' );
		}

		/**
		 * @param string $postType
		 *
		 * @return string
		 */
		public static function postFieldsWithShortcodes( $postType ) {
			return sprintf( '%s_%s_options_with_shortcodes', ShortcodeConfig:: NAME_PREFIX, $postType );
		}


		/**
		 * @param string $shortcodeName
		 * @param string $suffix
		 *
		 * @return string
		 */
		public static function buildName( $shortcodeName, $suffix ) {
			if ( stripos( ShortcodeConfig::NAME_PREFIX, $shortcodeName ) === false ) {
				$shortcodeName = ShortcodeConfig::NAME_PREFIX . $shortcodeName;
			}

			return sprintf( '%s_%s', strtolower( $shortcodeName ), $suffix );
		}
	}
}