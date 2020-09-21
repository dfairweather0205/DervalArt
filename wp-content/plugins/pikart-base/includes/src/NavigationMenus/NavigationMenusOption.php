<?php

namespace Pikart\WpBase\NavigationMenus;

if ( ! class_exists( __NAMESPACE__ . '\\NavigationMenusOption' ) ) {

	/**
	 * Class NavigationMenusOption
	 * @package Pikart\WpBase\NavigationMenus
	 *
	 * @since 1.4.0
	 */
	final class NavigationMenusOption {
		const WIDE_MENU = 'wide_menu';
		const NB_COLUMNS = 'nb_columns';
		const BACKGROUND_IMAGE = 'background_image';
		const CUSTOM_WIDGET_AREA = 'custom_widget_area';
		const ALTERNATIVE_LABEL = 'alternative_label';
		const ALTERNATIVE_LABEL_COLOR = 'alternative_label_color';
		const ALTERNATIVE_LABEL_BACKGROUND_COLOR = 'alternative_label_background_color';

		/**
		 * @return array
		 */
		public static function getOptions() {
			return array(
				self::WIDE_MENU,
				self::NB_COLUMNS,
				self::BACKGROUND_IMAGE,
				self::CUSTOM_WIDGET_AREA,
				self::ALTERNATIVE_LABEL,
				self::ALTERNATIVE_LABEL_COLOR,
				self::ALTERNATIVE_LABEL_BACKGROUND_COLOR,
			);
		}
	}
}