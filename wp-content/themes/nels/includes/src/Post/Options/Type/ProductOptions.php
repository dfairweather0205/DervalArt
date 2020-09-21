<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\ProductOptions' ) ) {

	/**
	 * Class ProductOptions
	 * @package Pikart\Nels\Post\Options
	 */
	class ProductOptions extends CommonPostOptions {

		const PRODUCT_GALLERY_ENABLE = 'product_gallery_enable';
		const PRODUCT_HEADER_FULL_WIDTH = 'product_header_full_width';
		const HERO_HEADER = 'product_hero_header';
		const PRODUCT_DETAILS_POSITION = 'product_details_position';
		const PRODUCT_DETAILS_STICKY = 'product_details_sticky';
		const PRODUCT_VIDEO_URL = 'product_video_url';
		const SECOND_FEATURED_IMAGE = 'product_second_featured_image';
		const THUMBNAILS_GALLERY_ENABLED = 'product_thumbnails_enabled';
		const THUMBNAILS_GALLERY_POSITION = 'product_thumbnails_position';
		const THUMBNAILS_GALLERY_NB_SLIDES = 'product_thumbnails_nb_slides';
		const THUMBNAILS_GALLERY_NAVIGATION = 'product_thumbnails_navigation';


		/**
		 * @return bool
		 */
		public function getProductGalleryEnable() {
			return $this->getBoolOption( self::PRODUCT_GALLERY_ENABLE );
		}

		/**
		 * @return bool
		 */
		public function getProductHeaderFullWidth() {
			return $this->getBoolOption( self::PRODUCT_HEADER_FULL_WIDTH );
		}

		/**
		 * @return string
		 */
		public function getHeroHeader() {
			return $this->getOption( self::HERO_HEADER );
		}

		/**
		 * @return string
		 */
		public function getProductDetailsPosition() {
			return $this->getOption( self::PRODUCT_DETAILS_POSITION );
		}

		/**
		 * @return bool
	*/
		public function getProductDetailsSticky() {
			return $this->getBoolOption( self::PRODUCT_DETAILS_STICKY );
		}

		/**
		 * @return string
		 */
		public function getProductVideoUrl() {
			return $this->getOption( self::PRODUCT_VIDEO_URL );
		}

		/**
		 * @return int
		 */
		public function getSecondFeaturedImage() {
			return $this->getIntOption( self::SECOND_FEATURED_IMAGE );
		}

		/**
		 * @return bool
		 */
		public function getProductThumbnailsEnabled() {
			return $this->getBoolOption( self::THUMBNAILS_GALLERY_ENABLED );
		}

		/**
		 * @return string
		 */
		public function getProductThumbnailsPosition() {
			return $this->getOption( self::THUMBNAILS_GALLERY_POSITION );
		}

		/**
		 * @return string
		 */
		public function getProductThumbnailsNbSlides() {
			return $this->getOption( self::THUMBNAILS_GALLERY_NB_SLIDES );
		}

		/**
		 * @return bool
		 */
		public function getProductThumbnailsNavigation() {
			return $this->getBoolOption( self::THUMBNAILS_GALLERY_NAVIGATION );
		}
	}
}