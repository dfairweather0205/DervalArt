<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ButtonShortcode' ) ) {
	/**
	 * Class ButtonShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class ButtonShortcode extends AbstractShortcode {

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
				->textBox( 'label', esc_html__( 'Label', 'pikart-base' ) )
				->listBox( 'size', esc_html__( 'Size', 'pikart-base' ), array(
					'default' => 'medium',
					'options' => array(
						'small'  => 'Small',
						'medium' => 'Medium',
						'large'  => 'Large',
					),
				) )
				->listBox( 'text_size', esc_html__( 'Text size', 'pikart-base' ), array(
					'default' => 'medium',
					'options' => array(
						'small'  => 'Small',
						'medium' => 'Medium',
						'large'  => 'Large',
					)
				) )
				->url( 'link', esc_html__( 'Link', 'pikart-base' ) )
				->checkBox( 'new_tab', esc_html__( 'New tab', 'pikart-base' ), array(
					'default' => false,
				) )
				->cssClass()
				->label( esc_html__( 'Button Colors', 'pikart-base' ), array(
					'classes' => 'pikode-inner-subtitle',
				) )
				->customColorPicker( 'text_color', esc_html__( 'Text', 'pikart-base' ) )
				->customColorPicker( 'text_hover_color', esc_html__( 'Text hover', 'pikart-base' ) )
				->customColorPicker( 'background_color', esc_html__( 'Background', 'pikart-base' ) )
				->customColorPicker( 'background_hover_color', esc_html__( 'Background hover', 'pikart-base' ) )
				->customColorPicker( 'border_color', esc_html__( 'Border', 'pikart-base' ) )
				->customColorPicker( 'border_hover_color', esc_html__( 'Border hover', 'pikart-base' ) );
		}
	}
}