<?php

namespace Pikart\WpCore\Post;

use Pikart\WpCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\PostUtil' ) ) {

	/**
	 * Class PostUtil
	 * @package Pikart\WpCore\Post
	 */
	class PostUtil {

		/**
		 * @var array
		 */
		private static $postOptionsCache = array();

		/**
		 * @param int $postId
		 * @param string $option
		 *
		 * @param mixed $value
		 *
		 * @return string
		 */
		public function saveOption( $postId, $option, $value ) {
			return update_post_meta( $postId, MetaBoxConfigBuilder::DB_PREFIX . $option, $value );
		}

		/**
		 * @param int $postId
		 * @param string $option
		 *
		 * @return string
		 */
		public function getOption( $postId, $option ) {
			return maybe_unserialize( get_post_meta( $postId, MetaBoxConfigBuilder::DB_PREFIX . $option, true ) );
		}

		/**
		 * @param int $postId
		 *
		 * @return array
		 */
		public function getOptions( $postId ) {
			if ( ! $postId ) {
				return array();
			}

			if ( isset( self::$postOptionsCache[ $postId ] ) ) {
				return self::$postOptionsCache[ $postId ];
			}

			$meta = get_post_meta( $postId );

			$options = array();

			if ( ! is_array( $meta ) ) {
				return $options;
			}

			foreach ( $meta as $key => $value ) {
				$options[ str_replace( MetaBoxConfigBuilder::DB_PREFIX, '', $key ) ] = maybe_unserialize( $value[0] );
			}

			self::$postOptionsCache[ $postId ] = $options;

			return $options;
		}

		/**
		 * @since 1.4.0 `$excludeKeys`
		 *
		 * @param int $postId
		 * @param array $excludeKeys
		 *
		 * @return array
		 */
		public function getCustomFields( $postId, $excludeKeys = array() ) {
			$meta = get_post_meta( $postId );

			$customFields = array();

			foreach ( $meta as $key => $value ) {

				if ( strpos( $key, '_' ) === 0 || in_array( $key, $excludeKeys ) ) {
					continue;
				}

				$customFields[ $key ] = $value[0];
			}

			return $customFields;
		}

		/**
		 * @param int|object $post
		 *
		 * @return string
		 */
		public function getPostPrimaryTaxonomySlug( $post = null ) {
			$postType = get_post_type( $post );

			$postToCategorySlugs = array(
				PostTypeSlug::POST    => PostTypeSlug::POST_CATEGORY,
				PostTypeSlug::PROJECT => PostTypeSlug::PROJECT_CATEGORY,
				PostTypeSlug::ALBUM   => PostTypeSlug::ALBUM_CATEGORY,
				PostTypeSlug::PRODUCT => PostTypeSlug::PRODUCT_CATEGORY,
			);

			return isset ( $postToCategorySlugs[ $postType ] ) ? $postToCategorySlugs[ $postType ] : null;
		}

		/**
		 * @param int|object $post
		 *
		 * @return bool
		 */
		public function postHasCategory( $post = null ) {
			return has_term( '', $this->getPostPrimaryTaxonomySlug( $post ), $post );
		}

		/**
		 * @param int $postId
		 *
		 * @return array
		 */
		public function getPostGalleryIdList( $postId ) {
			$gallery = get_post_gallery( $postId, false );

			if ( ! $gallery ) {
				return array();
			}

			if ( isset( $gallery['ids'] ) ) {
				return explode( ',', $gallery['ids'] );
			}

			$media = get_attached_media( 'image', $postId );

			return array_keys( $media );
		}

		/**
		 * @param int $postId
		 *
		 * @return int
		 */
		public function getPostAttachedImageId( $postId ) {
			$media = get_attached_media( 'image', $postId );

			if ( empty( $media ) ) {
				return null;
			}

			$mediaIds = array_keys( $media );

			return $mediaIds[0];
		}
	}
}