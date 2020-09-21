<?php

namespace Pikart\WpBase\Common;

use Pikart\WpBase\OptionsPages\OptionsPagesUtil;
use Pikart\WpBase\OptionsPages\PageOption;
use Pikart\WpCore\Common\AssetFilterName;
use Pikart\WpCore\Common\CoreAssetsRegister;

if ( ! class_exists( __NAMESPACE__ . '\\AssetsRegister' ) ) {

	/**
	 * Class AssetsRegister
	 * @package Pikart\WpBase\Common
	 */
	class AssetsRegister extends CoreAssetsRegister {

		/**
		 * @var OptionsPagesUtil
		 */
		private $optionsPagesUtil;

		/**
		 * AssetsRegister constructor.
		 *
		 * @param OptionsPagesUtil $optionsPagesUtil
		 */
		public function __construct( OptionsPagesUtil $optionsPagesUtil ) {
			$this->optionsPagesUtil = $optionsPagesUtil;
		}

		/**
		 * @return \Closure
		 */
		protected function registerAssetsCallback() {
			$registerScriptCallback = $this->registerScriptCallback();
			$registerStyleCallback  = $this->registerStyleCallback();
			$optionsPagesUtil       = $this->optionsPagesUtil;

			return function () use ( $registerStyleCallback, $registerScriptCallback, $optionsPagesUtil ) {
				$loadAddthisScript = apply_filters( AssetFilterName::loadAddthisScript(), is_singular() );
				$pikartBaseDeps    = array( AssetHandle::jquery() );

				if ( $loadAddthisScript ) {
					$pikartBaseDeps[] = AssetHandle::addthis();
				}

				$registerScriptCallback(
					AssetHandle::pikartBase(),
					PluginPathsUtil::getJsUrl( 'pikart-base.min.js' ),
					$pikartBaseDeps
				);

				$registerStyleCallback(
					AssetHandle::jqueryUi(),
					PluginPathsUtil::getAssetsVendorUrl( 'jquery-ui/themes/base/jquery-ui.min.css' )
				);

				$registerStyleCallback(
					AssetHandle::adminShortcodesStyle(),
					PluginPathsUtil::getCssUrl( 'admin/shortcodes.css' ),
					array( AssetHandle::jqueryUi() )
				);

				$registerStyleCallback(
					AssetHandle::adminShortcodesRtlStyle(),
					PluginPathsUtil::getCssUrl( 'admin/shortcodes-rtl.css' ),
					array( AssetHandle::adminShortcodesStyle() )
				);

				$registerScriptCallback(
					AssetHandle::shortcodes(),
					PluginPathsUtil::getJsUrl( 'shortcodes.js' ),
					array( AssetHandle::jquery() ),
					true
				);

				$registerScriptCallback(
					AssetHandle::pikartBaseCustom(),
					PluginPathsUtil::getJsUrl( 'pikart-base-custom.js' ),
					$pikartBaseDeps,
					true
				);

				$registerScriptCallback(
					AssetHandle::addthis(),
					'//s7.addthis.com/js/300/addthis_widget.js#async=1',
					array(),
					false,
					true
				);

				$registerStyleCallback(
					AssetHandle::fontAwesome(),
					PluginPathsUtil::getAssetsVendorUrl( 'font-awesome/css/font-awesome.min.css' )
				//'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
				);

				$registerScriptCallback(
					AssetHandle::limitSlider(),
					PluginPathsUtil::getAssetsVendorUrl( 'limitslider/jquery.limitslider.js' ),
					array( AssetHandle::jquery(), AssetHandle::jqueryUiSlider() )
				);

				$registerScriptCallback(
					AssetHandle::multipleSelect(),
					PluginPathsUtil::getAssetsVendorUrl( 'multiple-select/multiple-select.js' ),
					array( AssetHandle::jquery() )
				);

				$registerStyleCallback(
					AssetHandle::multipleSelect(),
					PluginPathsUtil::getAssetsVendorUrl( 'multiple-select/multiple-select.css' )
				);

				$registerScriptCallback( AssetHandle::postLikes(),
					PluginPathsUtil::getJsUrl( 'post-likes.js' ),
					array( AssetHandle::jquery() ),
					true
				);

				$registerScriptCallback( AssetHandle::adminCustomSidebars(),
					PluginPathsUtil::getJsUrl( 'admin/custom-sidebars.js' ),
					array( AssetHandle::jquery() )
				);

				$registerScriptCallback( AssetHandle::adminNavigationMenus(),
					PluginPathsUtil::getJsUrl( 'admin/navigation-menus.js' ),
					array( AssetHandle::jquery() )
				);

				$registerStyleCallback( AssetHandle::adminNavigationMenusStyle(),
					PluginPathsUtil::getCssUrl( 'admin/navigation-menus.css' )
				);

				$registerScriptCallback( AssetHandle::adminWidgets(),
					PluginPathsUtil::getJsUrl( 'admin/widgets.js' ),
					array( AssetHandle::jquery() )
				);

				$registerStyleCallback( AssetHandle::adminWidgetsStyle(),
					PluginPathsUtil::getCssUrl( 'admin/widgets.css' )
				);

				$registerStyleCallback(
					AssetHandle::adminCustomSidebarsStyle(),
					PluginPathsUtil::getCssUrl( 'admin/custom-sidebars.css' )
				);

				$registerStyleCallback(
					AssetHandle::adminCustomSidebarsRtlStyle(),
					PluginPathsUtil::getCssUrl( 'admin/custom-sidebars-rtl.css' ),
					array( AssetHandle::adminCustomSidebarsStyle() )
				);

				$registerStyleCallback(
					AssetHandle::adminMediaCustomFieldsStyle(),
					PluginPathsUtil::getCssUrl( 'admin/media-custom-fields.css' ),
					array( AssetHandle::jqueryUi() )
				);

				$registerStyleCallback(
					AssetHandle::adminMediaCustomFieldsRtlStyle(),
					PluginPathsUtil::getCssUrl( 'admin/media-custom-fields-rtl.css' ),
					array( AssetHandle::adminMediaCustomFieldsStyle() )
				);

				$gmapApiKey = $optionsPagesUtil->getPikartBaseOption( PageOption::GOOGLE_MAPS_API_KEY );
				$gmapUrlKey = $gmapApiKey ? '&key=' . $gmapApiKey : '';

				$registerScriptCallback(
					AssetHandle::gmapApi(),
					'//maps.googleapis.com/maps/api/js?callback=initGMap' . $gmapUrlKey,
					array( AssetHandle::shortcodes() ),
					false,
					true
				);

				$registerScriptCallback(
					AssetHandle::twitterWidgets(),
					'//platform.twitter.com/widgets.js',
					array(),
					false,
					true
				);

				$registerScriptCallback(
					AssetHandle::adminBlockCoreGallery(),
					PluginPathsUtil::getJsUrl( 'admin/blocks/core-gallery.js' ),
					array( 'wp-element', 'wp-components', 'wp-editor', 'wp-i18n' )
				);
			};
		}

		/**
		 * @inheritdoc
		 */
		protected function getAssetVersion() {
			return PIKART_BASE_VERSION;
		}
	}
}