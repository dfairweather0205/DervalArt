<?php

namespace Pikart\Nels\ThemeOptions\Config;

if ( ! class_exists( __NAMESPACE__ . '\ThemeOptionsConfigHelper' ) ) {

	/**
	 * Class ThemeOptionsConfigHelper
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ThemeOptionsConfigHelper {

		/**
		 * @return array
		 */
		public static function getDisplayTypes() {
			return array(
				'default' => esc_html__( 'Default', 'nels' ),
				'fade'    => esc_html__( 'Fade', 'nels' ),
				'pinned'  => esc_html__( 'Pinned', 'nels' ),
				'plain'   => esc_html__( 'Plain', 'nels' ),
			);
		}

		/**
		 * @return array
		 */
		public static function getItemColumnsNumber() {
			return array(
				1 => 1,
				2 => 2,
				3 => 3,
				4 => 4,
				5 => 5,
				6 => 6,
			);
		}
	}
}