<?php

namespace Pikart\WpCore\Post;

if ( ! class_exists( __NAMESPACE__ . '\\PostFilterName' ) ) {

	/**
	 * Class PostFilterName
	 * @package Pikart\WpCore\Post
	 */
	class PostFilterName {

		/**
		 * @param string $postType
		 *
		 * @return string
		 */
		public static function postTypeEnabled( $postType ) {
			return sprintf( '%s_post_type_%s_enabled', PIKART_SLUG, $postType );
		}

		/**
		 * @param string $postFormat
		 *
		 * @return string
		 */
		public static function postFormatOptionsEnabled( $postFormat ) {
			return sprintf( '%s_post_format_options_%s_enabled', PIKART_SLUG, $postFormat );
		}

		/**
		 * @param $option
		 *
		 * @return string
		 */
		public static function postOptionDefaultValue( $option ) {
			return sprintf( '%s_post_option_value_%s', PIKART_SLUG, $option );
		}

		/**
		 * @since 1.2.0
		 *
		 * @return string
		 */
		public static function postLikesNumberText() {
			return sprintf( '%s_post_likes_number_text', PIKART_SLUG );
		}

		/**
		 * @since 1.3.0
		 *
		 * @return string
		 */
		public static function contentFilterName() {
			return sprintf( '%s_content_filter_name', PIKART_SLUG );
		}
	}
}