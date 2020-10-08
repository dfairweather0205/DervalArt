<?php

namespace Pikart\Nels\Common;

use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\WpThemeCore\Common\CoreAssetsRegister;
use Pikart\WpThemeCore\Common\Env;
use Pikart\WpThemeCore\Common\ThemePathsUtil;

if ( ! class_exists( __NAMESPACE__ . '\\AssetsRegister' ) ) {

	/**
	 * Class AssetsRegister
	 * @package Pikart\Nels\Common
	 */
	class AssetsRegister extends CoreAssetsRegister {

		/**
		 * @return \Closure
		 */
		protected function registerAssetsCallback() {
			$registerScriptCallback       = $this->registerScriptCallback();
			$registerStyleCallback        = $this->registerStyleCallback();
			$registerVendorAssetsCallback = $this->registerVendorAssetsCallback();
			$vendorCssHandles             = $this->getVendorCssHandles();
			$vendorJsHandles              = $this->getVendorJsHandles();

			return function () use (
				$registerStyleCallback, $registerScriptCallback, $registerVendorAssetsCallback,
				$vendorCssHandles, $vendorJsHandles
			) {

				$registerVendorAssetsCallback();

				$registerStyleCallback(
					AssetHandle::jqueryUi(),
					ThemePathsUtil::getAssetsVendorUrl( 'jquery-ui/themes/base/jquery-ui.min.css' )
				);

				$registerStyleCallback(
					AssetHandle::fontAwesome(),
					ThemePathsUtil::getAssetsVendorUrl( 'font-awesome/css/font-awesome.min.css' )
				//'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
				);

				$registerScriptCallback(
					AssetHandle::multipleSelect(),
					ThemePathsUtil::getAssetsVendorUrl( 'multiple-select/multiple-select.js' ),
					array( AssetHandle::jquery() )
				);

				$registerStyleCallback(
					AssetHandle::multipleSelect(),
					ThemePathsUtil::getAssetsVendorUrl( 'multiple-select/multiple-select.css' )
				);

				$registerScriptCallback(
					AssetHandle::adminThemeCustomizer(),
					ThemePathsUtil::getJsUrl( 'admin/theme-customizer.js' ),
					array( AssetHandle::customizePreview(), AssetHandle::adminCoreCustomizer() )
				);

				$registerScriptCallback(
					AssetHandle::adminShortcodes(),
					ThemePathsUtil::getJsUrl( 'admin/shortcodes.js' )
				);

				$registerStyleCallback(
					AssetHandle::adminThemeCustomizerStyle(),
					ThemePathsUtil::getCssUrl( 'admin/theme-customizer.css' )
				);

				$registerStyleCallback(
					AssetHandle::adminThemeCustomizerRtlStyle(),
					ThemePathsUtil::getCssUrl( 'admin/theme-customizer-rtl.css' ),
					array( AssetHandle::adminThemeCustomizerStyle() )
				);

				$registerStyleCallback(
					AssetHandle::themeStyle(),
					ThemePathsUtil::getCssUrl( 'style.css' ),
					$vendorCssHandles,
					true
				);

				$registerStyleCallback(
					AssetHandle::themeRtlStyle(),
					ThemePathsUtil::getCssUrl( 'rtl.css' ),
					array( AssetHandle::themeStyle() ),
					true
				);

				$registerScriptCallback(
					AssetHandle::customScript(),
					ThemePathsUtil::getJsUrl( 'custom.js' ),
					PikartBaseUtil::addShortcodesDependency( $vendorJsHandles ),
					true
				);

				$registerScriptCallback(
					AssetHandle::adminProject(),
					ThemePathsUtil::getJsUrl( 'admin/project.js' ),
					array(
						AssetHandle::jquery(),
						AssetHandle::jqueryUiCore(),
						AssetHandle::jqueryUiDatepicker()
					)
				);

				$registerScriptCallback(
					AssetHandle::adminAlbum(),
					ThemePathsUtil::getJsUrl( 'admin/album.js' ),
					array( AssetHandle::jquery() )
				);

				$registerScriptCallback(
					AssetHandle::adminPost(),
					ThemePathsUtil::getJsUrl( 'admin/post.js' ),
					array( AssetHandle::jquery() )
				);

				$registerScriptCallback(
					AssetHandle::adminPage(),
					ThemePathsUtil::getJsUrl( 'admin/page.js' ),
					array( AssetHandle::jquery() )
				);
			};
		}

		/**
		 * @inheritdoc
		 */
		protected function getAssetVersion() {
			return PIKART_THEME_VERSION;
		}

		/**
		 * @return \Closure
		 */
		private function registerVendorAssetsCallback() {
			$registerScriptCallback = $this->registerScriptCallback();
			$registerStyleCallback  = $this->registerStyleCallback();
			$vendorCssHandles       = $this->getVendorCssHandles();
			$vendorJsHandles        = $this->getVendorJsHandles();

			return function () use (
				$registerStyleCallback, $registerScriptCallback, $vendorCssHandles, $vendorJsHandles
			) {
				if ( ! Env::isDev() ) {
					$registerStyleCallback( AssetHandle::vendor(), ThemePathsUtil::getCssVendorUrl( 'vendor.min.css' ) );
					$registerScriptCallback(
						AssetHandle::vendor(),
						ThemePathsUtil::getJsVendorUrl( 'vendor.min.js' ),
						array( AssetHandle::jquery() )
					);

					return;
				}


				foreach ( $vendorCssHandles as $handle ) {
					$registerStyleCallback( $handle, ThemePathsUtil::getCssVendorUrl( $handle . '.min.css' ) );
				}

				foreach ( $vendorJsHandles as $handle ) {
					$registerScriptCallback(
						$handle,
						ThemePathsUtil::getJsVendorUrl( $handle . '.min.js' ),
						array( AssetHandle::jquery() )
					);
				}
			};
		}

		/**
		 * @return array
		 */
		private function getVendorCssHandles() {
			if ( Env::isDev() ) {
				return array(
					AssetHandle::animateCss(),
					AssetHandle::elegantIcons(),
					AssetHandle::simpleLineIcons(),
					AssetHandle::magnificPopup(),
					AssetHandle::owlCarousel(),
					AssetHandle::slickCarousel(),
				);
			}

			return array( AssetHandle::vendor() );
		}

		/**
		 * @return array
		 */
		private function getVendorJsHandles() {
			if ( Env::isDev() ) {
				return array(
					AssetHandle::foundation(),
					AssetHandle::imagesloaded(),
					AssetHandle::isotope(),
					AssetHandle::jqueryAppear(),
					AssetHandle::jqueryZoom(),
					AssetHandle::magnificPopup(),
					AssetHandle::owlCarousel(),
					AssetHandle::stickyKit(),
					AssetHandle::slickCarousel(),
				);
			}

			return array( AssetHandle::vendor() );
		}
	}
}