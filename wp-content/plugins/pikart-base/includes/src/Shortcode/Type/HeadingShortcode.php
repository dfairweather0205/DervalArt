<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\HeadingShortcode' ) ) {
	/**
	 * Class HeadingShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class HeadingShortcode extends AbstractShortcode {

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
		public function enabled() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$builder
				->textBox( 'title', esc_html__( 'Title', 'pikart-base' ) )
				->textBox( 'subtitle', esc_html__( 'Subtitle', 'pikart-base' ) )
				->listBox( 'alignment', esc_html__( 'Alignment', 'pikart-base' ), array(
					'default' => 'left',
					'options' => array(
						'left'   => 'Left',
						'center' => 'Center',
						'right'  => 'Right',
					),
				) )
				->cssClass();
		}
	}
}