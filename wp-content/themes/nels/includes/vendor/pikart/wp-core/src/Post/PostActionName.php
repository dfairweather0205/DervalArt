<?php

namespace Pikart\WpThemeCore\Post;

use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\PostActionName' ) ) {

	/**
	 * Class PostActionName
	 * @package Pikart\WpThemeCore\Post
	 */
	class PostActionName {

		/**
		 * @param string $postType
		 * @param string $metaBoxId
		 *
		 * @return string
		 */
		public static function postTypeMetaBoxesConfig( $postType, $metaBoxId = null ) {
			$metaBoxIdKey = $metaBoxId === null ? '' : '_' . $metaBoxId;

			return sprintf( '%s_post_type_%s_meta_boxes_config%s', PIKART_SLUG, $postType, $metaBoxIdKey );
		}

		/**
		 * @param string $postFormat
		 *
		 * @return string
		 */
		public static function postFormatMetaBoxesConfig( $postFormat ) {
			return sprintf( '%s_post_type_%s_%s_meta_boxes_config', PIKART_SLUG, PostTypeSlug::POST, $postFormat );
		}
	}
}