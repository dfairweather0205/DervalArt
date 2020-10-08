<?php

namespace Pikart\WpCore\Admin\MetaBoxes;

use Pikart\WpCore\Admin\MetaBoxes\Generator\MetaBoxGenerator;
use Pikart\WpCore\Common\CoreAssetHandle;
use Pikart\WpCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxFacade' ) ) {
	/**
	 * Class MetaBoxFacade
	 * @package Pikart\WpCore\Admin\MetaBoxes
	 */
	class MetaBoxFacade {
		/**
		 * @var Util
		 */
		private $utils;

		/**
		 * @var MetaBoxDal
		 */
		private $metaBoxDal;

		/**
		 * @var MetaBoxGenerator
		 */
		private $metaBoxGenerator;

		/**
		 * @var MetaBoxCustomizedCssGenerator
		 */
		private $metaBoxCustomizedCssGenerator;

		/**
		 * MetaBoxFacade constructor.
		 *
		 * @param Util $utils
		 * @param MetaBoxDal $metaBoxDal
		 * @param MetaBoxGenerator $metaBoxGenerator
		 * @param MetaBoxCustomizedCssGenerator $metaBoxCustomizedCssGenerator
		 */
		public function __construct(
			Util $utils,
			MetaBoxDal $metaBoxDal,
			MetaBoxGenerator $metaBoxGenerator,
			MetaBoxCustomizedCssGenerator $metaBoxCustomizedCssGenerator
		) {
			$this->utils                         = $utils;
			$this->metaBoxDal                    = $metaBoxDal;
			$this->metaBoxGenerator              = $metaBoxGenerator;
			$this->metaBoxCustomizedCssGenerator = $metaBoxCustomizedCssGenerator;
		}

		/**
		 * @param string $postType
		 * @param array $metaBoxesConfig
		 */
		public function registerMetaBoxes( $postType, array $metaBoxesConfig ) {
			$this->registerMetaBoxesGeneration( $postType, $metaBoxesConfig );
			$this->registerMetaBoxesUpdate( $postType, $metaBoxesConfig );
			$this->enqueueAdminAssets();
			$this->generateCustomizedCss( $postType, $metaBoxesConfig );
		}

		/**
		 * @param string $postType
		 * @param array $metaBoxesConfig
		 */
		private function registerMetaBoxesGeneration( $postType, array $metaBoxesConfig ) {
			$generateMetaBoxesCallback = $this->generateMetaBoxesCallback();

			add_action( MetaBoxConfig::getMetaBoxesAddFilter( $postType ), function () use (
				$postType, $metaBoxesConfig, $generateMetaBoxesCallback
			) {
				$generateMetaBoxesCallback( $postType, $metaBoxesConfig );
			} );
		}

		/**
		 * @return \Closure
		 */
		private function generateMetaBoxesCallback() {
			$generateMetaBoxCallback = $this->generateMetaBoxCallback();

			return function ( $postType, array $metaBoxesConfig ) use ( $generateMetaBoxCallback ) {
				foreach ( $metaBoxesConfig as $metaBoxConfig ) {
					$generateMetaBoxCallback( $postType, $metaBoxConfig );
				}
			};
		}

		/**
		 * @return \Closure
		 */
		private function generateMetaBoxCallback() {
			$metaBoxGenerator = $this->metaBoxGenerator;

			return function ( $postType, array $metaBoxConfig ) use ( $metaBoxGenerator ) {
				$metaBoxGenerator->generate( $postType, $metaBoxConfig );
			};
		}

		/**
		 * @param string $postType
		 * @param array $metaBoxesConfig
		 */
		private function registerMetaBoxesUpdate( $postType, array $metaBoxesConfig ) {
			$metaBoxDal = $this->metaBoxDal;

			add_action( 'save_post_' . $postType, function ( $postId ) use ( $metaBoxesConfig, $metaBoxDal ) {
				foreach ( $metaBoxesConfig as $metaBoxConfig ) {
					$metaBoxDal->saveMetaBoxData( $postId, $metaBoxConfig );
				}
			} );
		}

		private function enqueueAdminAssets() {
			add_action( 'admin_enqueue_scripts', function () {
				wp_enqueue_style( CoreAssetHandle::adminMetaBoxesStyle() );
				wp_enqueue_script( CoreAssetHandle::adminMetaBoxes() );

				if ( is_rtl() ) {
					wp_enqueue_style( CoreAssetHandle::adminMetaBoxesRtlStyle() );
				}

			} );
		}

		/**
		 * @param string $postType
		 * @param $metaBoxesConfig
		 */
		private function generateCustomizedCss( $postType, $metaBoxesConfig ) {
			$metaBoxCustomizedCssGenerator = $this->metaBoxCustomizedCssGenerator;

			add_action( 'wp_enqueue_scripts', function () use (
				$postType, $metaBoxesConfig, $metaBoxCustomizedCssGenerator
			) {
				if ( ! is_singular( $postType ) ) {
					return;
				}

				wp_add_inline_style(
					Util::getThemeStyleHandle(), $metaBoxCustomizedCssGenerator->generate( $metaBoxesConfig ) );
			}, 20 );
		}
	}
}
