<?php

namespace Pikart\WpThemeCore\ThemeOptions;

use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ThemeOptions;

if ( ! interface_exists( __NAMESPACE__ . '\\ThemeOptionsProvider' ) ) {

	/**
	 * Interface ThemeOptionsProvider
	 * @package Pikart\WpThemeCore\ThemeOptions
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