<?php

namespace Pikart\WpBase\Elementor;

use Elementor\Widget_Base;
use Pikart\WpBase\Elementor\Widget\ProjectsWidget;

if ( ! class_exists( __NAMESPACE__ . '\\WidgetsProvider' ) ) {

	/**
	 * Class WidgetsProvider
	 * @package Pikart\WpBase\Elementor
	 *
	 * @since 1.6.0
	 */
	class WidgetsProvider {

		/**
		 * @var Widget_Base[]
		 */
		private $widgets = array();

		/**
		 * WidgetsProvider constructor.
		 */
		public function __construct() {
			$self = $this;

			add_action( 'elementor/widgets/widgets_registered', function () use ( $self ) {
				$self->setWidgets( array(
					new ProjectsWidget()
				) );
			}, 1 );
		}

		/**
		 * @param Widget_Base[] $widgets
		 */
		public function setWidgets( array $widgets ) {
			$this->widgets = $widgets;
		}

		/**
		 * @return Widget_Base[]
		 */
		public function getWidgets() {
			return $this->widgets;
		}
	}
}