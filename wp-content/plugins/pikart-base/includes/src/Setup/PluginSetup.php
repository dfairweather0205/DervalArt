<?php

namespace Pikart\WpBase\Setup;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpCore\Admin\MetaBoxes\MetaBoxConfig;
use Pikart\WpCore\Common\AssetFilterName;
use Pikart\WpCore\Common\Util;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfig as ThemeMetaBoxConfig;

if ( ! class_exists( __NAMESPACE__ . '\PluginSetup' ) ) {

	/**
	 * Class PluginSetup
	 * @package Pikart\WpBase\Setup
	 */
	class PluginSetup {

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * PluginSetup constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
		}

		public function setup() {
			$this->enqueueAssets();
			$this->loadPluginTextDomain();
			$this->initGoogleAnalytics();
			$this->initMetaBoxesConfig();
		}

		private function enqueueAssets() {
			add_action( 'wp_enqueue_scripts', function () {
				wp_enqueue_script( AssetHandle::pikartBaseCustom() );

				if ( apply_filters( AssetFilterName::loadAddthisScript(), is_singular() ) ) {
					wp_enqueue_script( AssetHandle::addthis() );
				}
			} );
		}

		private function loadPluginTextDomain() {
			add_action( 'plugins_loaded', function () {
				load_plugin_textdomain(
					PIKART_BASE_SLUG,
					false,
					dirname( PIKART_PLUGIN_BASE_NAME ) . '/languages/'
				);
			} );
		}

		private function initGoogleAnalytics() {
			$util = $this->util;

			add_action( 'wp_footer', function () use ( $util ) {
				$util->pikartBasePartial( 'google-analytics-tracking' );
			} );
		}

		/**
		 * @since 1.4.0
		 */
		private function initMetaBoxesConfig() {
			add_action( 'init', function () {
				$metaBoxAddMethodName   = 'add_meta_box';
				$metaBoxesAddFilterName = 'add_meta_boxes';

				MetaBoxConfig::setMetaBoxAddMethod( $metaBoxAddMethodName );
				MetaBoxConfig::setMetaBoxesAddFilter( $metaBoxesAddFilterName );

				if ( class_exists( '\Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfig' ) ) {
					ThemeMetaBoxConfig::setMetaBoxAddMethod( $metaBoxAddMethodName );
					ThemeMetaBoxConfig::setMetaBoxesAddFilter( $metaBoxesAddFilterName );
				}
			} );
		}
	}
}