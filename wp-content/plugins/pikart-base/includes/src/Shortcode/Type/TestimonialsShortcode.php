<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeConfig;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\TestimonialsShortcode' ) ) {
	/**
	 * Class TestimonialsShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class TestimonialsShortcode extends AbstractShortcode {

		const TESTIMONIAL_SHORTCODE_KEY = 'testimonial';

		/**
		 * TestimonialsShortcode constructor.
		 *
		 * @param TestimonialShortcode $shortcode
		 */
		public function __construct( TestimonialShortcode $shortcode ) {
			parent::__construct();

			$this->addChildShortcode( $shortcode, self::TESTIMONIAL_SHORTCODE_KEY );
		}

		/**
		 * @inheritdoc
		 */
		public function isSelfClosing() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		public function isFinal() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function enabled() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$testimonialShortcode = $this->getChildShortcode( self::TESTIMONIAL_SHORTCODE_KEY );

			$builder
				->tabs( 'slides', esc_html__( 'Slides', 'pikart-base' ), array(
					'id'          => ShortcodeConfig::NAME_PREFIX . 'slides',
					'newTabLabel' => esc_html__( 'New slide', 'pikart-base' ),
					'tabLabel'    => esc_html__( 'Slide', 'pikart-base' ),
					'tabItems'    => $testimonialShortcode->getAttributesConfig(),
					'shortcode'   => $this->getJsShortcodeConfig( $testimonialShortcode )
				) )
				->listBox( 'transition', esc_html__( 'Transition', 'pikart-base' ), array(
					'default' => 'fade',
					'options' => array(
						'fade' => esc_html__( 'Fade', 'pikart-base' ),
						'move' => esc_html__( 'Move', 'pikart-base' ),
					)
				) )
				->listBox( 'alignment', esc_html__( 'Content alignment', 'pikart-base' ), array(
					'default' => 'left',
					'options' => array(
						'left'   => esc_html__( 'Left', 'pikart-base' ),
						'center' => esc_html__( 'Center', 'pikart-base' ),
						'right'  => esc_html__( 'Right', 'pikart-base' ),
					)
				) )
				->cssClass();
		}
	}
}