<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\DropcapShortcode' ) ) {
	/**
	 * Class DropcapShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class DropcapShortcode extends AbstractShortcode {

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
			return true;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$builder
				->textBox( 'label', esc_html__( 'Character/Text', 'pikart-base' ), array(
					'placeholder' => esc_html__( 'Content', 'pikart-base' ),
				) )
				->listBox( 'type', esc_html__( 'Type', 'pikart-base' ), array(
					'default' => 'normal',
					'options' => array(
						'normal' => 'Normal',
						'square' => 'Square',
					),
				) )
				->number( 'text_size', esc_html__( 'Font size', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'pixels', 'pikart-base' ),
					'default' => 36,
					'min'     => 1,
					'max'     => 72
				) )
				->listBox( 'font_weight', esc_html__( 'Font weight', 'pikart-base' ), array(
					'default' => '400',
					'options' => array(
						'100' => '100 Thin',
						'200' => '200 Extra Light',
						'300' => '300 Light',
						'400' => '400 Normal',
						'500' => '500 Medium',
						'600' => '600 Semi Bold',
						'700' => '700 Bold',
						'800' => '800 Extra Bold',
						'900' => '900 Black',
					)
				) )
				->number( 'square_size', esc_html__( 'Square size', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'pixels', 'pikart-base' ),
					'default' => 48,
					'min'     => 1,
					'max'     => 100
				) )
				->customColorPicker( 'text_color', esc_html__( 'Text color', 'pikart-base' ) )
				->customColorPicker( 'background_color', esc_html__( 'Background color', 'pikart-base' ) )
				->customColorPicker( 'border_color', esc_html__( 'Border color', 'pikart-base' ) )
				->cssClass();
		}
	}
}