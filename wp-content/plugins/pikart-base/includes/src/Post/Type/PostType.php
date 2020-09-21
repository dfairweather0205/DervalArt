<?php

namespace Pikart\WpBase\Post\Type;

if ( ! interface_exists( __NAMESPACE__ . '\\PostType' ) ) {

	/**
	 * Interface PostType
	 * @package Pikart\WpBase\Post\Type
	 */
	interface PostType {

		/**
		 * @return string custom post type slug
		 */
		public function getSlug();

		/**
		 * @return string custom post type category slug
		 */
		public function getTaxonomySlug();

		/**
		 * @return array configuration of the custom post type
		 */
		public function getConfig();

		/**
		 * @return array configuration of the custom post type category
		 */
		public function getTaxonomyConfig();

		/**
		 * @return boolean
		 */
		public function isCustom();

		/**
		 * whether or not a post type is enabled
		 *
		 * @return bool
		 */
		public function enabled();

		/**
		 * @return boolean
		 */
		public function supportsTags();

		/**
		 * @return boolean
		 */
		public function supportsPostFormats();
	}
}