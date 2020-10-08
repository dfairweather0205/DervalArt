<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ColumnShortcode' ) ) {
	/**
	 * Class ColumnShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class ColumnShortcode extends AbstractShortcode {

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
			return false;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$builder
				->number( 'size', esc_html__( 'Size', 'pikart-base' ) )
				->cssClass()
				->textArea( 'content', '', array(
					'is_content' => true,
					'default'    => esc_html__( 'Content goes here', 'pikart-base' )
				) );
		}
	}
}