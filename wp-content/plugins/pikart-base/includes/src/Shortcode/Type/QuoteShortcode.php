<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\QuoteShortcode' ) ) {
	/**
	 * Class QuoteShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class QuoteShortcode extends AbstractShortcode {

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
				->listBox( 'text_size', esc_html__( 'Text size', 'pikart-base' ), array(
					'default' => 'medium',
					'options' => array(
						'small'  => 'Small',
						'medium' => 'Medium',
						'large'  => 'Large',
					)
				) )
				->textBox( 'author', esc_html__( 'Author', 'pikart-base' ) )
				->url( 'author_link', esc_html__( 'Author Link', 'pikart-base' ) )
				->checkBox( 'new_tab', esc_html__( 'New tab', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'If enabled, Author Link opens in a New tab', 'pikart-base' ),
					'default' => false
				) )
				->listBox( 'text_alignment', esc_html__( 'Text alignment', 'pikart-base' ), array(
					'default' => 'left',
					'options' => array(
						'left'   => 'Left',
						'center' => 'Center',
						'right'  => 'Right',
					),
				) )
				->cssClass()
				->textArea( 'label', '', array(
					'placeholder' => esc_html__( 'Content', 'pikart-base' )
				) );
		}
	}
}