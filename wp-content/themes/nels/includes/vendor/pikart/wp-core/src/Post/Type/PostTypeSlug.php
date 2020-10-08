<?php

namespace Pikart\WpThemeCore\Post\Type;

if ( ! class_exists( __NAMESPACE__ . '\\PostTypeSlug' ) ) {

	/**
	 * Class PostTypeSlug
	 * @package Pikart\WpThemeCore\Post\Type
	 */
	class PostTypeSlug {
		const POST = 'post';
		const POST_CATEGORY = 'category';

		/**
		 * @since 1.3.0
		 */
		const POST_TAG = 'post_tag';

		const PAGE = 'page';

		const PROJECT = 'pikart-project';
		const PROJECT_CATEGORY = 'pikart-project-category';

		const ALBUM = 'pikart-album';
		const ALBUM_CATEGORY = 'pikart-album-category';

		const PRODUCT = 'product';
		const PRODUCT_CATEGORY = 'product_cat';

		/**
		 * @since 1.3.0
		 */
		const PRODUCT_TAG = 'product_tag';
	}
}