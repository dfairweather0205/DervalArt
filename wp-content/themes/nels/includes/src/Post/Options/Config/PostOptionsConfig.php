<?php

namespace Pikart\Nels\Post\Options\Config;

use Pikart\Nels\Common\AssetHandle;
use Pikart\Nels\Post\Options\PostFormatOptionsConfigProvider;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Admin\Sidebars\SidebarUtil;
use Pikart\WpThemeCore\Post\PostActionName;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\PostOptionsConfig' ) ) {

	/**
	 * Class PostOptionsConfig
	 * @package Pikart\Nels\Post\Options\Config
	 */
	class PostOptionsConfig extends GenericPostOptionsConfig {

		/**
		 * @var PostFormatOptionsConfigProvider
		 */
		private $postFormatOptionsConfigProvider;

		/**
		 * PostOptionsConfig constructor.
		 *
		 * @param MetaBoxConfigBuilder $metaBoxConfigBuilder
		 * @param SidebarUtil $sidebarUtil
		 * @param PostFormatOptionsConfigProvider $postFormatOptionsConfigProvider
		 */
		public function __construct(
			MetaBoxConfigBuilder $metaBoxConfigBuilder,
			SidebarUtil $sidebarUtil,
			PostFormatOptionsConfigProvider $postFormatOptionsConfigProvider
		) {
			$this->postFormatOptionsConfigProvider = $postFormatOptionsConfigProvider;
			parent::__construct( $metaBoxConfigBuilder, $sidebarUtil );
		}

		/**
		 * @inheritdoc
		 */
		public function getSlug() {
			return PostTypeSlug::POST;
		}

		/**
		 * @inheritdoc
		 */
		public function getAdminJsAssetHandles() {
			return array(
				AssetHandle::adminPost()
			);
		}

		/**
		 * @inheritdoc
		 */
		protected function buildPostTypeSpecificConfig( MetaBoxConfigBuilder $metaBoxConfigBuilder ) {
			$this->buildMasonryArchiveConfig( $metaBoxConfigBuilder );

			foreach ( $this->postFormatOptionsConfigProvider->getPostFormatOptionsConfigList() as $optionsConfig ) {
				$optionsConfig->buildMetaBoxesConfig( $this->metaBoxConfigBuilder );

				do_action(
					PostActionName::postFormatMetaBoxesConfig( $optionsConfig->getSlug() ),
					$this->metaBoxConfigBuilder
				);
			}
		}
	}
}