<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\SeparatorShortcode' ) ) {
	/**
	 * Class SeparatorShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class SeparatorShortcode extends AbstractShortcode {

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
						'default' => 'down',
						'options' => array(
							'up'   => 'Up',
							'down' => 'Down'
						)
					)
				)
				->listBox( 'alignment', esc_html__( 'Alignment', 'pikart-base' ), array(
						'default' => 'left',
						'options' => array(
							'left'   => 'Left',
							'center' => 'Center',
							'right'  => 'Right',
						)
					)
				)
				->cssClass();
		}
	}
}