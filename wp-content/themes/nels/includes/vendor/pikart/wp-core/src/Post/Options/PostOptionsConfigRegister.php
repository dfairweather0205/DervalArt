<?php

namespace Pikart\WpThemeCore\Post\Options;

use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxFacade;
use Pikart\WpThemeCore\Post\Options\Config\PostTypeOptionsConfig;
use Pikart\WpThemeCore\Post\PostFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\PostOptionsConfigRegister' ) ) {

	/**
	 * Class PostOptionsConfigRegister
	 * @package Pikart\WpThemeCore\Post\Options
	 */
	class PostOptionsConfigRegister {

		/**
		 * @var MetaBoxFacade
		 */
		private $metaBoxFacade;

		/**
		 * PostOptionsConfigRegister constructor.
		 *
		 * @param MetaBoxFacade $metaBoxFacade
		 */
		public function __construct( MetaBoxFacade $metaBoxFacade ) {
			$this->metaBoxFacade = $metaBoxFacade;
		}


		/**
		 * @param PostTypeOptionsConfig $postOptionsConfig
		 */
		public function register( PostTypeOptionsConfig $postOptionsConfig ) {
			$this->enqueueAdminAssets( $postOptionsConfig );
			$this->registerMetaBoxesConfig( $postOptionsConfig );
			$this->registerPostOptionDefaultValueFilters( $postOptionsConfig );
		}

		/**
		 * @param PostTypeOptionsConfig $postOptionsConfig
		 */
		private function enqueueAdminAssets( PostTypeOptionsConfig $postOptionsConfig ) {
			add_action( 'admin_enqueue_scripts', function ( $hook ) use ( $postOptionsConfig ) {

				if ( ! in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) {
					return;
				}

				$screen = get_current_screen();

				if ( ! $screen || $postOptionsConfig->getSlug() !== $screen->post_type ) {
					return;
				}

				$cssAssetHandles = $postOptionsConfig->getAdminCssAssetHandles();

				array_walk( $cssAssetHandles, function ( $assetHandle ) {
					wp_enqueue_style( $assetHandle );
				} );

				$jsAssetHandles = $postOptionsConfig->getAdminJsAssetHandles();

				array_walk( $jsAssetHandles, function ( $assetHandle ) {
					wp_enqueue_script( $assetHandle );
				} );
			} );
		}

		/**
		 * @param PostTypeOptionsConfig $postOptionsConfig
		 */
		private function registerMetaBoxesConfig( PostTypeOptionsConfig $postOptionsConfig ) {
			$metaBoxFacade = $this->metaBoxFacade;

			add_action( 'wp_loaded', function () use ( $postOptionsConfig, $metaBoxFacade ) {
				$metaBoxesConfig = $postOptionsConfig->getMetaBoxesConfig();

				if ( ! empty( $metaBoxesConfig ) ) {
					$metaBoxFacade->registerMetaBoxes( $postOptionsConfig->getSlug(), $metaBoxesConfig );
				}
			} );
		}

		/**
		 * @param PostTypeOptionsConfig $postOptionsConfig
		 */
		private function registerPostOptionDefaultValueFilters( PostTypeOptionsConfig $postOptionsConfig ) {
			add_action( 'wp_loaded', function () use ( $postOptionsConfig ) {
				foreach ( $postOptionsConfig->getMetaBoxesConfig() as $metaBoxConfig ) {
					foreach ( $metaBoxConfig['fields'] as $config ) {
						if ( ! isset( $config['default'] ) ) {
							continue;
						}

						$shortOptionName = str_replace( MetaBoxConfigBuilder::DB_PREFIX, '', $config['id'] );
						add_filter( PostFilterName::postOptionDefaultValue( $shortOptionName ),
							function () use ( $config ) {
								return $config['default'];
							} );
					}
				}
			} );
		}
	}
}