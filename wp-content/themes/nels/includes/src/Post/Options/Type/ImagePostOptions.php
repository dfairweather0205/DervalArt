<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\ImagePostOptions' ) ) {

	/**
	 * Class ImagePostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class ImagePostOptions extends CommonPostOptions {

		const FEATURED_IMAGE = 'image_featured_image';

		/**
		 * @return bool
		 */
		public function isFeaturedImage() {
			return $this->getBoolOption( self::FEATURED_IMAGE );
		}
	}
}