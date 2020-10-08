<?php

namespace Pikart\WpCore\ThemeOptions;

use Pikart\WpCore\ThemeOptions\ConfigBuilder\ThemeOptions;

if ( ! interface_exists( __NAMESPACE__ . '\\ThemeOptionsProvider' ) ) {

	/**
	 * Interface ThemeOptionsProvider
	 * @package Pikart\WpCore\ThemeOptions
	 */
	interface ThemeOptionsProvider {

		/**
		 * @return ThemeOptions
		 */
		public function getThemeOptions();

		/**
		 * @return array
		 */
		public function getOptionsForCustomJs();
	}
}