<?php

namespace Pikart\WpThemeCore\Post\Options\Config\Format;

use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;

if ( ! interface_exists( __NAMESPACE__ . '\\PostFormatOptionsConfig' ) ) {

	/**
	 * Interface PostFormatOptionsConfig
	 * @package Pikart\WpThemeCore\Post\Options\Config\Format
	 */
	interface PostFormatOptionsConfig {

		/**
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 */
		public function buildMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder );

		/**
		 * @return string
		 */
		public function getSlug();

		/**
		 * whether or not a format is enabled
		 *
		 * @return bool
		 */
		public function enabled();
	}
}