<?php

namespace Pikart\Nels\Post\Options\Config\Format;

use Pikart\Nels\Post\Options\Type\AsidePostOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

if ( ! class_exists( __NAMESPACE__ . '\\AsideFormatOptionsConfig' ) ) {

	/**
	 * Class AsideFormatOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config\Format
	 */
	class AsideFormatOptionsConfig extends GenericPostFormatOptionsConfig {

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostFormatSlug::ASIDE;
		}

		/**
		 * @inheritdoc
		 */
		protected function getFormatSpecificMetaBoxTitle() {
			return esc_html__( 'Aside Options', 'nels' );
		}

		/**
		 * @inheritdoc
		 */
		protected function buildFormatSpecificMetaBoxesConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->wpEditor( AsidePostOptions::HERO_HEADER, esc_html__( 'Hero Header', 'nels' ),
					esc_html__( 'Enter Hero Header content here', 'nels' ), array(
						'editor_settings' => array(
							'editor_height' => 300,
							'textarea_rows' => 8,
						)
					) )
				->checkbox( AsidePostOptions::POST_EXCERPT_ENABLED, esc_html__( 'Display excerpt', 'nels' ),
					esc_html__( 'Display Post Excerpt on Blog page', 'nels' ),
					array(
						'default' => 1
					) );
		}
	}
}