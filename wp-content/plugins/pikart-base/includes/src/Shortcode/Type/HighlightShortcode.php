<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\HighlightShortcode' ) ) {
	/**
	 * Class HighlightShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class HighlightShortcode extends AbstractShortcode {

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
				->listBox( 'type', esc_html__( 'Type', 'pikart-base' ), array(
					'default' => 'fill',
					'options' => array(
						'fill'   => 'Fill',
						'shadow' => 'Shadow',
					),
				) )
				->customColorPicker( 'text_color', esc_html__( 'Text color', 'pikart-base' ) )
				->customColorPicker( 'background_color', esc_html__( 'Background color', 'pikart-base' ) )
				->cssClass()
				->textArea( 'label', '', array(
					'placeholder' => esc_html__( 'Content', 'pikart-base' )
				) );
		}
	}
}