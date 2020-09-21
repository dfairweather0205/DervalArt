<?php

namespace Pikart\WpCore\Post\Options\Config;

if ( ! interface_exists( __NAMESPACE__ . '\\PostTypeOptionsConfig' ) ) {

	/**
	 * Interface PostTypeOptionsConfig
	 * @package Pikart\WpCore\Post\Options\Config
	 */
	interface PostTypeOptionsConfig {

		/**
		 * @return string post type slug
		 */
		public function getSlug();

		/**
		 * @return array configuration for custom fields
		 */
		public function getMetaBoxesConfig();

		/**
		 * @return array js handles needed by this cpt in admin area
		 */
		public function getAdminJsAssetHandles();

		/**
		 * @return array css handles needed by this cpt in admin area
		 */
		public function getAdminCssAssetHandles();
	}
}