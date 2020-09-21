<?php

namespace Pikart\WpThemeCore\Elementor;

use Elementor\Plugin;

if ( ! class_exists( __NAMESPACE__ . '\ElementorUtil' ) ) {

	/**
	 * Class ElementorUtil
	 * @package Pikart\WpThemeCore\Elementor
	 *
	 * @since 1.6.5
	 */
	class ElementorUtil {

		/**
		 * @return bool
		 */
		public static function isElementorActivated() {
			return defined( 'ELEMENTOR_VERSION' );
		}

		/**
		 * @return bool
		 */
		public static function isPreviewMode() {
			return self::isElementorActivated() && Plugin::$instance->preview->is_preview_mode();
		}
	}
}
