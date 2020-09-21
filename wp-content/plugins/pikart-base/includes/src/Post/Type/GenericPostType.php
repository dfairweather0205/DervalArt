<?php

namespace Pikart\WpBase\Post\Type;

use Pikart\WpCore\Post\PostFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\GenericPostType' ) ) {

	/**
	 * Class GenericPostType
	 * @package Pikart\WpBase\Post\Type
	 */
	abstract class GenericPostType implements PostType {

		/**
		 * @inheritdoc
		 */
		public function getTaxonomySlug() {
			return '';
		}

		/**
		 * @inheritdoc
		 */
		public function getConfig() {
			return array();
		}

		/**
		 * @inheritdoc
		 */
		public function getTaxonomyConfig() {
			return array();
		}

		/**
		 * @inheritdoc
		 */
		public function isCustom() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function supportsTags() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		public function supportsPostFormats() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		final public function enabled() {
			return apply_filters( PostFilterName::postTypeEnabled( $this->getSlug() ), true );
		}
	}
}