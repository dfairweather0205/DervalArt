<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\Type\LinkPostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

if ( ! class_exists( __NAMESPACE__ . '\\LinkFormatOptionsConfig' ) ) {

	/**
	 * Class LinkFormatOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	class LinkFormatOptionsConfig extends GenericPostFormatOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostFormatSlug::LINK;
		}

		/**
		 * @inheritdoc
		 */
		protected function getFormatSpecificMetaBoxTitle() {
			return esc_html__( 'Link Options', 'nels' );
		}

		/**
		 * @inheritdoc
		 */
		protected function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->checkbox( LinkPostOptions::FEATURED_LINK,
					esc_html__( 'Featured Link', 'nels' ),
					esc_html__( 'Display Featured Link on Single Post Page', 'nels' ),
					array(
						'default' => 1
					) )
				->url( LinkPostOptions::URL, esc_html__( 'Insert link', 'nels' ),
					esc_html__( 'Enter the link you want to emphasize', 'nels' ) )
				->text( LinkPostOptions::LINK_TEXT, esc_html__( 'Insert link text', 'nels' ),
					esc_html__( 'Enter the text link', 'nels' ) );
		}
	}
}