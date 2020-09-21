<?php

namespace Pikart\WpBase\Elementor;

use Pikart\WpCore\Elementor\ElementorFilterName;
use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\ElementorInitializer' ) ) {

	/**
	 * Class ElementorInitializer
	 * @package Pikart\WpBase\Elementor
	 *
	 * @since 1.6.0
	 */
	class ElementorInitializer {

		/**
		 * @var WidgetsRegister
		 */
		private $widgetsRegister;

		/**
		 * ElementorInitializer constructor.
		 *
		 * @param WidgetsRegister $widgetsRegister
		 */
		public function __construct( WidgetsRegister $widgetsRegister ) {
			$this->widgetsRegister = $widgetsRegister;
		}

		public function initialize() {
			// minimum php supported version in elementor is 5.4
			if ( version_compare( PHP_VERSION, '5.4' ) < 0 ) {
				return;
			}

			$widgetsRegister = $this->widgetsRegister;

			add_action( 'init', function () use ( $widgetsRegister ) {
				if ( ! apply_filters( ElementorFilterName::pikartBaseElementorAllowed(), false ) ) {
					return;
				}

				$widgetsRegister->register();

				$cptSupport = get_option( 'elementor_cpt_support' );

				if ( $cptSupport === false ) {
					$cptSupport = array( PostTypeSlug::PAGE, PostTypeSlug::POST, PostTypeSlug::PROJECT );
					update_option( 'elementor_cpt_support', $cptSupport );
				}
			} );
		}
	}
}