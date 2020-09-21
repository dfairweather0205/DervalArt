<?php

namespace Pikart\WpBase\Post\Type;

use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\Page' ) ) {

	/**
	 * Class Page
	 * @package Pikart\WpBase\Post\Type
	 */
	class Page extends GenericPostType {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::PAGE;
		}

		/**
		 * @inheritdoc
		 */
		public function isCustom() {
			return false;
		}
	}
}