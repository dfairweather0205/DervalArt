<?php

namespace Pikart\Nels\Post\Options;

if ( ! class_exists( __NAMESPACE__ . '\\PostOptionsMetaBoxId' ) ) {

	/**
	 * Class PostOptionsMetaBoxId
	 * @package Pikart\Nels\Post\Options
	 */
	class PostOptionsMetaBoxId {
		const COMMON_OPTIONS = 'common_options';

		const PAGE_OPTIONS = 'page_options';
		const PAGE_BLOG_OPTIONS = 'page_blog_options';

		const ALBUM_ITEM_OPTIONS = 'album_item_options';
		const ALBUM_VIDEO_OPTIONS = 'album_video_options';
		const VIDEO_ONLINE_SERVICE_OPTIONS = 'video_online_service_options';
		const VIDEO_SELF_HOSTED_OPTIONS = 'video_self_hosted_options';

		const PROJECT_COMMON_OPTIONS = 'project_common_options';
		const PROJECT_MASONRY_OPTIONS = 'project_masonry_options';
		const PROJECT_SLIDER_OPTIONS = 'project_slider_options';
		const PROJECT_CAROUSEL_OPTIONS = 'project_carousel_options';

		const PRODUCT_OPTIONS = 'product_options';
		const PRODUCT_SECOND_FEATURED_IMAGE = 'product_second_featured_image';

		const MASONRY_ARCHIVE_OPTIONS = 'masonry_archive_options';
		const SLIDER_ARCHIVE_OPTIONS = 'slider_archive_options';

		/**
		 * @param string $postType
		 *
		 * @return string
		 */
		public static function postOptions( $postType ) {
			return sprintf( 'post_%s_options', $postType );
		}
	}
}