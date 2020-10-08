<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\TabShortcode' ) ) {
	/**
	 * Class TabShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class TabShortcode extends AbstractShortcode {

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
				->textBox( 'title', '', array(
					'placeholder' => esc_html__( 'Title', 'pikart-base' ),
					'dataField'   => 'title'
				) )
				->textArea( 'content', '', array(
					'is_content'  => true,
					'placeholder' => esc_html__( 'Content', 'pikart-base' ),
					'dataField'   => 'content',
					'rows'        => 10,
				) );
		}
	}
}