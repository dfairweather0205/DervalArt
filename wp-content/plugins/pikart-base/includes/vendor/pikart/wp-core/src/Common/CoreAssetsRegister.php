<?php

namespace Pikart\WpCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\CoreAssetsRegister' ) ) {

	/**
	 * Class CoreAssetsRegister
	 * @package Pikart\WpCore\Common
	 */
	class CoreAssetsRegister {

		public function register() {
			$this->enqueueAllScriptsInFooter();

			$registerAssetsCallback = $this->registerAssetsCallback();
			$registerScriptCallback = $this->registerScriptCallback();
			$registerStyleCallback  = $this->registerStyleCallback();

			add_action( 'init', function () use (
				$registerAssetsCallback, $registerStyleCallback, $registerScriptCallback
			) {

				$registerStyleCallback(
					CoreAssetHandle::adminMetaBoxesStyle(),
					CorePathsUtil::getCssUrl( 'admin/meta-boxes.css' ),
					array(
						CoreAssetHandle::jqueryUi(),
						CoreAssetHandle::multipleSelect(),
						CoreAssetHandle::wpColorPicker()
					)
				);

				$registerStyleCallback(
					CoreAssetHandle::adminMetaBoxesRtlStyle(),
					CorePathsUtil::getCssUrl( 'admin/meta-boxes-rtl.css' ),
					array( CoreAssetHandle::adminMetaBoxesStyle() )
				);

				$registerStyleCallback(
					CoreAssetHandle::adminOptionsPagesStyle(),
					CorePathsUtil::getCssUrl( 'admin/options-pages.css' )
				);

				$registerScriptCallback( CoreAssetHandle::customGallery(),
					CorePathsUtil::getJsUrl( 'admin/custom-gallery.js' ),
					array( CoreAssetHandle::jquery() )
				);

				$registerScriptCallback( CoreAssetHandle::customGalleryImage(),
					CorePathsUtil::getJsUrl( 'admin/custom-gallery-image.js' ),
					array( CoreAssetHandle::jquery() )
				);

				$registerScriptCallback( CoreAssetHandle::adminCoreCustomizer(),
					CorePathsUtil::getJsUrl( 'admin/core-customizer.js' ),
					array( CoreAssetHandle::customizePreview(), CoreAssetHandle::adminUtil() )
				);

				$registerScriptCallback( CoreAssetHandle::adminCustomizeControls(),
					CorePathsUtil::getJsUrl( 'admin/customize-controls.js' ),
					array( CoreAssetHandle::jquery() )
				);

				$registerScriptCallback( CoreAssetHandle::adminMetaBoxes(),
					CorePathsUtil::getJsUrl( 'admin/meta-boxes.js' ),
					array(
						CoreAssetHandle::jquery(),
						CoreAssetHandle::multipleSelect(),
						CoreAssetHandle::wpColorPicker(),
						CoreAssetHandle::adminUtil()
					)
				);

				$registerScriptCallback( CoreAssetHandle::adminUtil(),
					CorePathsUtil::getJsUrl( 'admin/util.js' ),
					array( CoreAssetHandle::jquery() )
				);

				$registerAssetsCallback();
			} );
		}

		protected function registerAssetsCallback() {
			return function () {

			};
		}

		/**
		 * @return \Closure
		 */
		protected function registerScriptCallback() {
			$version = $this->getAssetVersion();

			return function ( $handle, $src, $dependencies = array(), $isMinified = false, $isExternal = false ) use (
				$version
			) {
				$debugScript = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

				if ( $isExternal ) {
					$version = null;
				}

				if ( $isMinified && ! Env::isDev() && ! $debugScript ) {
					$src = preg_replace( '/\.js$/i', '.min.js', $src );
				}

				wp_register_script(
					$handle,
					$src,
					$dependencies,
					$version,
					true
				);
			};
		}

		/**
		 * @return \Closure
		 */
		protected function registerStyleCallback() {
			$version = $this->getAssetVersion();

			return function ( $handle, $src, $dependencies = array(), $isMinified = false, $isExternal = false ) use (
				$version
			) {
				$debugScript = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

				if ( $isExternal ) {
					$version = null;
				}

				if ( $isMinified && ! Env::isDev() && ! $debugScript ) {
					$src = preg_replace( '/\.css$/i', '.min.css', $src );
				}

				wp_register_style(
					$handle,
					$src,
					$dependencies,
					$version
				);
			};
		}

		/**
		 * @return string
		 */
		protected function getAssetVersion() {
			return PIKART_VERSION;
		}

		/**
		 * @since 1.5.0
		 *
		 * @return bool
		 */
		protected function enqueueAllScriptsInFooterAllowed() {
			return false;
		}

		/**
		 * @since 1.5.0
		 */
		protected function enqueueAllScriptsInFooter() {
			if ( ! $this->enqueueAllScriptsInFooterAllowed() ) {
				return;
			}

			add_action( 'wp_enqueue_scripts', function () {
				$scripts = wp_scripts();
				$handles = array_keys( $scripts->registered );

				foreach ( $handles as $handle ) {
					if ( $scripts->get_data( $handle, 'group' ) !== 1 ) {
						$scripts->add_data( $handle, 'group', 1 );
					}
				}

			}, 999 );
		}
	}
}