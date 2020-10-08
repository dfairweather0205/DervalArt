<?php

namespace Pikart\WpCore\Widget;

if ( ! class_exists( __NAMESPACE__ . '\\WidgetFilterName' ) ) {

	/**
	 * Class WidgetFilterName
	 * @package Pikart\WpCore\Widget
	 *
	 * @since 1.6.4
	 */
	class WidgetFilterName {

		/**
		 * @return string
		 */
		public static function widgetList() {
			return PIKART_SLUG . '_widget_list';
		}
	}
}