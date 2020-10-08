<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\LinkPostOptions' ) ) {

	/**
	 * Class LinkPostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class LinkPostOptions extends CommonPostOptions {

		const URL = 'link_url';
		const LINK_TEXT = 'link_text';
		const FEATURED_LINK = 'link_featured_link';

		/**
		 * @return string
		 */
		public function getUrl() {
			return $this->getOption( self::URL );
		}

		/**
		 * @return string
		 */
		public function getLinkText() {
			return $this->getOption( self::LINK_TEXT );
		}

		/**
		 * @return bool
		 */
		public function isFeaturedLink() {
			return $this->getBoolOption( self::FEATURED_LINK );
		}
	}
}