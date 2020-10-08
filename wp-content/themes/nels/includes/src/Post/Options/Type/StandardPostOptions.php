<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\StandardPostOptions' ) ) {

	/**
	 * Class StandardPostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class StandardPostOptions extends CommonPostOptions {

		const FEATURED_IMAGE = 'standard_featured_image';
		const POST_EXCERPT_ENABLED = 'standard_post_excerpt_enabled';

		/**
		 * @return bool
		 */
		public function isFeaturedImage() {
			return $this->getBoolOption( self::FEATURED_IMAGE );
		}

		/**
		 * @return bool
		 */
		public function isPostExcerptEnabled() {
			return $this->getBoolOption( self::POST_EXCERPT_ENABLED );
		}
	}
}