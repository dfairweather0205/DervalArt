<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\Type\QuotePostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

if ( ! class_exists( __NAMESPACE__ . '\\QuoteFormatOptionsConfig' ) ) {

	/**
	 * Class QuoteFormatOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	class QuoteFormatOptionsConfig extends GenericPostFormatOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostFormatSlug::QUOTE;
		}

		/**
		 * @inheritdoc
		 */
		protected function getFormatSpecificMetaBoxTitle() {
			return esc_html__( 'Quote Options', 'nels' );
		}

		/**
		 * @inheritdoc
		 */
		protected function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->checkbox( QuotePostOptions::FEATURED_QUOTE,
					esc_html__( 'Featured Quote', 'nels' ),
					esc_html__( 'Display Featured Quote on Single Post Page', 'nels' ),
					array(
						'default' => 1
					) )
				->textArea( QuotePostOptions::CONTENT, esc_html__( 'Content', 'nels' ),
					esc_html__( 'Please enter the text for your quote here', 'nels' ) )
				->text( QuotePostOptions::AUTHOR_NAME, esc_html__( 'Author name', 'nels' ),
					esc_html__( 'Enter the name of quote author', 'nels' ) )
				->url( QuotePostOptions::AUTHOR_LINK, esc_html__( 'Author link', 'nels' ),
					esc_html__( 'Enter the link to connect author to any address', 'nels' ) );
		}
	}
}