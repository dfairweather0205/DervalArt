<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\TestimonialShortcode' ) ) {
	/**
	 * Class TestimonialShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class TestimonialShortcode extends AbstractShortcode {

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
				->textBox( 'author', '', array(
					'placeholder' => esc_html__( 'Author', 'pikart-base' ),
					'dataField'   => 'author'
				) )
				->textBox( 'title', '', array(
					'placeholder' => esc_html__( 'Title', 'pikart-base' ),
					'dataField'   => 'title'
				) )
				->url( 'author_link', '', array(
					'placeholder' => esc_html__( 'Author Link', 'pikart-base' ),
					'dataField'   => 'author_link'
				) )
				->checkBox( 'new_tab', esc_html__( 'New tab', 'pikart-base' ), array(
					'default' => false,
					'text'    => 'New tab',
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