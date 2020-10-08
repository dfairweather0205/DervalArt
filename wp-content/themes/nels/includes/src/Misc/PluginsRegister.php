<?php

namespace Pikart\Nels\Misc;

use Pikart\WpThemeCore\Common\ThemePathsUtil;
use Pikart\WpThemeCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\\PluginsRegister' ) ) {

	/**
	 * Class PluginsRegister
	 * @package Pikart\Nels\Misc
	 */
	class PluginsRegister {

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * PluginsRegister constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
		}

		/**
		 * Register all required/recommended plugins
		 */
		public function register() {
			$util = $this->util;

			add_action( 'tgmpa_register', function () use ( $util ) {
				$pikartBaseConfig = array(
					'name'     => 'Pikart Base',
					'slug'     => PIKART_BASE_SLUG,
					'required' => true,
					'version'  => '1.7.1',
				);

				$pikartBaseConfig['source'] = $util->generateArtifactDownloadUrl(
					$pikartBaseConfig['slug'], $pikartBaseConfig['version']
				);

				$plugins = array(
					array(
						'name'     => 'WPForms Lite',
						'slug'     => 'wpforms-lite',
						'required' => false,
					),
					array(
						'name'     => 'WooCommerce',
						'slug'     => 'woocommerce',
						'required' => false,
					),
					array(
						'name'     => 'WPBakery Visual Composer',
						'slug'     => 'js_composer',
						'required' => false,
						'version'  => '6.2',
						'source'   => ThemePathsUtil::getPluginsDir( 'js_composer.zip' ),
					),
					array(
						'name'     => 'Slider Revolution',
						'slug'     => 'revslider',
						'required' => false,
						'version'  => '6.2.17',
						'source'   => ThemePathsUtil::getPluginsDir( 'revslider.zip' ),
					),
					array(
						'name'     => 'One Click Demo Import',
						'slug'     => 'one-click-demo-import',
						'required' => false,
					),
					$pikartBaseConfig,
				);

				tgmpa( $plugins );
			} );
		}
	}
}
