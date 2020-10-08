<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\GeolocationShortcode' ) ) {
	/**
	 * Class GeolocationShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class GeolocationShortcode extends AbstractShortcode {

		/**
		 * @inheritdoc
		 */
		public function isSelfClosing() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function isFinal() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$builder
				->number( 'lat', '', array(
					'min'         => - 90,
					'max'         => 90,
					'placeholder' => esc_html__( 'Latitude from GMaps', 'pikart-base' ),
				) )
				->number( 'long', '', array(
					'min'         => - 180,
					'max'         => 180,
					'placeholder' => esc_html__( 'Longitude from GMaps', 'pikart-base' ),
				) )
				->textBox( 'title', '', array(
					'placeholder' => esc_html__( 'Title', 'pikart-base' ),
				) )
				->textBox( 'description', '', array(
					'placeholder' => esc_html__( 'Description', 'pikart-base' ),
				) );
		}
	}
}