<?php

namespace Pikart\Nels\Post\Options\Config;

use Pikart\Nels\Common\AssetHandle;
use Pikart\Nels\Post\Options\Config\Template\BlogTemplateOptionsConfig;
use Pikart\Nels\Post\Options\PostOptionsMetaBoxId;
use Pikart\Nels\Post\Options\Type\PageOptions;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Admin\Sidebars\SidebarUtil;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\PageOptionsConfig' ) ) {

	/**
	 * Class PageOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config
	 */
	class PageOptionsConfig extends GenericPostOptionsConfig {

		/**
		 * @var BlogTemplateOptionsConfig
		 */
		private $blogTemplateOptionsConfig;

		/**
		 * PageOptionsConfig constructor.
		 *
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 * @param SidebarUtil $sidebarUtil
		 * @param BlogTemplateOptionsConfig $blogTemplateOptionsConfig
		 */
		public function __construct(
			MetaBoxConfigBuilder $metaBoxConfigBuilder,
			SidebarUtil $sidebarUtil,
			BlogTemplateOptionsConfig $blogTemplateOptionsConfig
		) {
			$this->blogTemplateOptionsConfig = $blogTemplateOptionsConfig;
			parent::__construct( $metaBoxConfigBuilder, $sidebarUtil );
		}

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::PAGE;
		}

		/**
		 * @inheritdoc
		 */
		public function getAdminJsAssetHandles() {
			return array(
				AssetHandle::adminPage()
			);
		}

		/**
		 * @inheritdoc
		 */
		protected function buildPostTypeSpecificConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$metaBoxConfigBuilder
				->metaBox( PostOptionsMetaBoxId::PAGE_OPTIONS, esc_html__( 'Page Options', 'nels' ) )
				->wpEditor( PageOptions::HERO_HEADER, esc_html__( 'Hero Header', 'nels' ),
					esc_html__( 'Enter Hero Header content here', 'nels' ), array(
						'editor_settings' => array(
							'editor_height' => 300,
							'textarea_rows' => 8,
						)
					) );

			$this->blogTemplateOptionsConfig->buildMetaBoxesConfig( $this->metaBoxConfigBuilder );
		}
	}
}