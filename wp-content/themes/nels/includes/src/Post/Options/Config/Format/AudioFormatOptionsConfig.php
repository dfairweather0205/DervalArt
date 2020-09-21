<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\Type\AudioPostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

if ( ! class_exists( __NAMESPACE__ . '\\AudioFormatOptionsConfig' ) ) {

	/**
	 * Class AudioFormatOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	class AudioFormatOptionsConfig extends GenericPostFormatOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostFormatSlug::AUDIO;
		}

		/**
		 * @inheritdoc
		 */
		protected function getFormatSpecificMetaBoxTitle() {
			return esc_html__( 'Audio Options', 'nels' );
		}

		/**
		 * @inheritdoc
		 */
		protected function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->checkbox( AudioPostOptions::FEATURED_AUDIO,
					esc_html__( 'Featured Audio', 'nels' ),
					esc_html__( 'Display Featured Audio on Single Post Page', 'nels' ),
					array(
						'default' => 1
					) )
				->textArea( AudioPostOptions::SOURCE, esc_html__( 'Audio source', 'nels' ),
					esc_html__( 'Enter the audio link or embedded code here', 'nels' ) )
				->checkbox( AudioPostOptions::POST_EXCERPT_ENABLED, esc_html__( 'Display excerpt', 'nels' ),
					esc_html__( 'Display Post Excerpt on Blog page', 'nels' ),
					array(
						'default' => 1
					) );
		}
	}
}