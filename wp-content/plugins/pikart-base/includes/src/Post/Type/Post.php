<?php

namespace Pikart\WpBase\Post\Type;

use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\Post' ) ) {

	/**
	 * Class Post
	 * @package Pikart\WpBase\Post\Type
	 */
	class Post extends GenericPostType {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::POST;
		}

		/**
		 * @inheritdoc
		 */
		public function getTaxonomySlug() {
			return PostTypeSlug::POST_CATEGORY;
		}

		public function isCustom() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		public function supportsTags() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function supportsPostFormats() {
			return true;
		}
	}
}