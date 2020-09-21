<?php

namespace Pikart\WpBase\Admin\Media\WpGallery;

if ( ! class_exists( __NAMESPACE__ . '\WpGalleryConfig' ) ) {

	/**
	 * Class WpGalleryConfig
	 * @package Pikart\WpCore\Admin\Media\WpGallery
	 */
	class WpGalleryConfig {

		const COLUMNS_SPACING_SETTING = 'columns_spacing';

		/**
		 * @return array
		 */
		public static function getCustomSettings() {
			return array(
				self::COLUMNS_SPACING_SETTING => self::getColumnsSpacingConfig()
			);
		}

		/**
		 * @return array
		 */
		public static function getColumnsSpacingConfig() {
			return array(
				'default' => 36,
				'minimum' => 0,
				'maximum' => 120
			);
		}
	}
}