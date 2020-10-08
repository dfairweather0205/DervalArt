<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\TeamMemberShortcode' ) ) {
	/**
	 * Class TeamMemberShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class TeamMemberShortcode extends AbstractShortcode {

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
				->textBox( 'name', esc_html__( 'Name', 'pikart-base' ) )
				->textBox( 'title', esc_html__( 'Title', 'pikart-base' ) )
				->textArea( 'description', esc_html__( 'Description', 'pikart-base' ) )
				->wpGallery( 'image', esc_html__( 'Image', 'pikart-base' ) )
				->url( 'image_link', esc_html__( 'Image Link', 'pikart-base' ) )
				->checkBox( 'new_tab', esc_html__( 'New tab', 'pikart-base' ), array( 'default' => false ) )
				->cssClass()
				->label( esc_html__( 'Social Links', 'pikart-base' ), array( 'classes' => 'pikode-inner-subtitle' ) )
				->url( 'facebook', esc_html__( 'Facebook', 'pikart-base' ) )
				->url( 'linkedin', esc_html__( 'LinkedIn', 'pikart-base' ) )
				->url( 'twitter', esc_html__( 'Twitter', 'pikart-base' ) )
				->url( 'pinterest', esc_html__( 'Pinterest', 'pikart-base' ) );
		}
	}
}