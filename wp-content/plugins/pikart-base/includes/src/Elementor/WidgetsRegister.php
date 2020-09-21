<?php

namespace Pikart\WpBase\Elementor;

use Elementor\Plugin;

if ( ! class_exists( __NAMESPACE__ . '\\WidgetsRegister' ) ) {

	/**
	 * Class WidgetsRegister
	 * @package Pikart\WpBase\Elementor
	 *
	 * @since 1.6.0
	 */
	class WidgetsRegister {

		/**
		 * @var WidgetsProvider
		 */
		private $widgetsProvider;

		/**
		 * WidgetsRegister constructor.
		 *
		 * @param WidgetsProvider $widgetsProvider
		 */
		public function __construct( WidgetsProvider $widgetsProvider ) {
			$this->widgetsProvider = $widgetsProvider;
		}

		public function register() {
			$widgetsProvider = $this->widgetsProvider;

			add_action( 'elementor/widgets/widgets_registered', function () use ( $widgetsProvider ) {
				foreach ( $widgetsProvider->getWidgets() as $widget ) {
					Plugin::instance()->widgets_manager->register_widget_type( $widget );
				}
			} );
		}
	}
}