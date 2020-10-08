<?php

namespace Pikart\WpBase\Shortcode;

use Pikart\WpCore\Shortcode\Type\Shortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodeRegister' ) ) {

	/**
	 * Class ShortcodeRegister
	 * @package Pikart\WpBase\Shortcode
	 */
	class ShortcodeRegister {

		/**
		 * @var ShortcodeRenderer
		 */
		private $shortcodeRenderer;

		/**
		 * ShortcodeRegister constructor.
		 *
		 * @param ShortcodeRenderer $shortcodeRenderer
		 */
		public function __construct( ShortcodeRenderer $shortcodeRenderer ) {
			$this->shortcodeRenderer = $shortcodeRenderer;
		}

		/**
		 * @param Shortcode $shortcode
		 *
		 * @throws ShortcodeException
		 */
		public function register( Shortcode $shortcode ) {
			if ( ! $shortcode->enabled() ) {
				throw new ShortcodeException( "Registration not allowed, shortcode is disabled" );
			}

			$shortcodeRenderer = $this->shortcodeRenderer;

			add_shortcode( $shortcode->getName(),
				function ( $userAttributes = array(), $content = '' ) use ( $shortcode, $shortcodeRenderer ) {
					return $shortcodeRenderer->renderTemplate( $shortcode, $userAttributes, $content );
				}
			);

			foreach ( $shortcode->getChildrenShortcodes() as $childrenShortcode ) {
				$this->register( $childrenShortcode );
			}
		}
	}
}