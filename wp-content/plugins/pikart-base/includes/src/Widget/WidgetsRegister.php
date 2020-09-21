<?php

namespace Pikart\WpBase\Widget;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpBase\Common\PluginPathsUtil;
use Pikart\WpCore\Widget\WidgetFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\WidgetsRegister' ) ) {

	/**
	 * Class WidgetsRegister
	 * @package Pikart\WpBase\Widget
	 *
	 * @since 1.1.0
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

			add_action( 'widgets_init', function () use ( $widgetsProvider ) {
				$widgets = apply_filters( WidgetFilterName::widgetList(), $widgetsProvider->getWidgets() );

				foreach ( $widgets as $widget ) {
					register_widget( $widget );
				}
			} );

			add_action( 'admin_enqueue_scripts', function ( $hook ) {
				if ( $hook !== 'widgets.php' ) {
					return;
				}

				wp_enqueue_style( AssetHandle::adminWidgetsStyle() );
				wp_enqueue_script( AssetHandle::adminWidgets() );
			} );

			add_action( 'wp_enqueue_scripts', function () {
				wp_enqueue_style( AssetHandle::fontAwesome() );
			} );

			add_action( 'elementor/editor/after_enqueue_scripts', function () {
				wp_enqueue_script(
					AssetHandle::adminWidgets(),
					PluginPathsUtil::getJsUrl( 'admin/widgets.js' ),
					array( AssetHandle::jquery() ),
					PIKART_BASE_VERSION,
					true
				);
			} );

			add_action( 'elementor/editor/after_enqueue_styles', function () {
				wp_enqueue_style(
					AssetHandle::adminWidgetsStyle(),
					PluginPathsUtil::getCssUrl( 'admin/widgets.css' ),
					array(),
					PIKART_BASE_VERSION );
			} );
		}
	}
}