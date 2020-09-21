<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\GalleryPostOptions' ) ) {

	/**
	 * Class GalleryPostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class GalleryPostOptions extends CommonPostOptions {

		const IMAGES = 'gallery_images';
		const POST_EXCERPT_ENABLED = 'gallery_post_excerpt_enabled';
		const FEATURED_GALLERY = 'gallery_featured_gallery';

		/**
		 * @return array
		 */
		public function getImages() {
			return $this->getArrayOption( self::IMAGES );
		}

		/**
		 * @return bool
		 */
		public function isPostExcerptEnabled() {
			return $this->getBoolOption( self::POST_EXCERPT_ENABLED );
		}

		/**
		 * @return bool
		 */
		public function isFeaturedGallery() {
			return $this->getBoolOption( self::FEATURED_GALLERY );
		}
	}
}