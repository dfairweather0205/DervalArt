<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ProgressBarShortcode' ) ) {
	/**
	 * Class ProgressBarShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class ProgressBarShortcode extends AbstractShortcode {

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
				->textBox( 'title', esc_html__( 'Title', 'pikart-base' ) )
				->number( 'progress', esc_html__( 'Progress', 'pikart-base' ), array(
					'min'         => 0,
					'max'         => 100,
					'placeholder' => esc_html__( 'Loading value', 'pikart-base' )
				) )
				->cssClass();
		}
	}
}