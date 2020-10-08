<?php

namespace Pikart\WpBase\Post\Type;

use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\Product' ) ) {

	/**
	 * Class Product
	 * @package Pikart\WpBase\Post\Type
	 */
	class Product extends GenericPostType {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::PRODUCT;
		}

		/**
		 * @inheritdoc
		 */
		public function getTaxonomyConfig() {
			return PostTypeSlug::PRODUCT_CATEGORY;
		}

		/**
		 * @inheritdoc
		 */
		public function isCustom() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		public function supportsTags() {
			return true;
		}
	}
}