<?php

namespace Pikart\Nels\Setup;

use Pikart\Nels\Admin\Migration\MigrationSetup;
use Pikart\Nels\Common\AssetsRegister;
use Pikart\Nels\Misc\PluginsRegister;
use Pikart\Nels\Post\Options\PostOptionsConfigInitializer;
use Pikart\Nels\Shop\ShopSetup;
use Pikart\Nels\Shortcode\ThemeShortcodesInitilizer;
use Pikart\Nels\Site\NavigationMenusCustomizer;
use Pikart\Nels\Site\PostLikesCustomizer;
use Pikart\Nels\Site\SidebarCustomizer;
use Pikart\Nels\Site\SiteCustomizer;
use Pikart\Nels\ThemeOptions\ThemeOptionsGenerator;
use Pikart\Nels\Widgets\WidgetsInitializer;

if ( ! class_exists( __NAMESPACE__ . '\Bootstrap' ) ) {
	/**
	 * Class Bootstrap
	 * @package Pikart\Nels\Setup
	 */
	class Bootstrap {

		/**
		 * @var AssetsRegister
		 */
		private $assetsRegister;

		/**
		 * @var ThemeOptionsGenerator
		 */
		private $themeOptionsGenerator;

		/**
		 * @var ThemeSetup
		 */
		private $themeSetup;

		/**
		 * @var WidgetsInitializer
		 */
		private $widgetsInitializer;

		/**
		 * @var ThemeShortcodesInitilizer
		 */
		private $themeShortcodesInitializer;

		/**
		 * @var SiteCustomizer
		 */
		private $siteCustomizer;

		/**
		 * @var SidebarCustomizer
		 */
		private $sidebarCustomizer;

		/**
		 * @var PluginsRegister
		 */
		private $pluginsRegister;

		/**
		 * @var ShopSetup
		 */
		private $shopSetup;

		/**
		 * @var PostOptionsConfigInitializer
		 */
		private $postOptionsConfigInitializer;

		/**
		 * @var PikartBaseOptionsPageConfigSetup
		 */
		private $pikartBaseOptionsPageConfigSetup;

		/**
		 * @var NavigationMenusCustomizer
		 */
		private $navigationMenusCustomizer;

		/**
		 * @var PostLikesCustomizer
		 */
		private $postLikesCustomizer;

		/**
		 * @var WpBakerySetup
		 */
		private $wpBakerySetup;

		/**
		 * @var MigrationSetup
		 */
		private $migrationSetup;

		/**
		 * Bootstrap constructor.
		 *
		 * @param ThemeSetup $themeSetup
		 * @param AssetsRegister $assetsRegister
		 * @param ThemeShortcodesInitilizer $themeShortcodesInitializer
		 * @param ThemeOptionsGenerator $themeOptionsGenerator
		 * @param WidgetsInitializer $widgetsInitializer
		 * @param SiteCustomizer $siteCustomizer
		 * @param SidebarCustomizer $sidebarCustomizer
		 * @param PluginsRegister $pluginsRegister
		 * @param ShopSetup $shopSetup
		 * @param PostOptionsConfigInitializer $postOptionsConfigInitializer
		 * @param PikartBaseOptionsPageConfigSetup $pikartBaseOptionsPageConfigSetup
		 * @param NavigationMenusCustomizer $navigationMenusCustomizer
		 * @param PostLikesCustomizer $postLikesCustomizer
		 * @param WpBakerySetup $wpBakerySetup
		 * @param MigrationSetup $migrationSetup
		 */
		public function __construct(
			ThemeSetup $themeSetup,
			AssetsRegister $assetsRegister,
			ThemeShortcodesInitilizer $themeShortcodesInitializer,
			ThemeOptionsGenerator $themeOptionsGenerator,
			WidgetsInitializer $widgetsInitializer,
			SiteCustomizer $siteCustomizer,
			SidebarCustomizer $sidebarCustomizer,
			PluginsRegister $pluginsRegister,
			ShopSetup $shopSetup,
			PostOptionsConfigInitializer $postOptionsConfigInitializer,
			PikartBaseOptionsPageConfigSetup $pikartBaseOptionsPageConfigSetup,
			NavigationMenusCustomizer $navigationMenusCustomizer,
			PostLikesCustomizer $postLikesCustomizer,
			WpBakerySetup $wpBakerySetup,
			MigrationSetup $migrationSetup
		) {
			$this->themeSetup                       = $themeSetup;
			$this->assetsRegister                   = $assetsRegister;
			$this->themeShortcodesInitializer       = $themeShortcodesInitializer;
			$this->themeOptionsGenerator            = $themeOptionsGenerator;
			$this->widgetsInitializer               = $widgetsInitializer;
			$this->siteCustomizer                   = $siteCustomizer;
			$this->sidebarCustomizer                = $sidebarCustomizer;
			$this->pluginsRegister                  = $pluginsRegister;
			$this->shopSetup                        = $shopSetup;
			$this->postOptionsConfigInitializer     = $postOptionsConfigInitializer;
			$this->pikartBaseOptionsPageConfigSetup = $pikartBaseOptionsPageConfigSetup;
			$this->navigationMenusCustomizer        = $navigationMenusCustomizer;
			$this->postLikesCustomizer              = $postLikesCustomizer;
			$this->wpBakerySetup                    = $wpBakerySetup;
			$this->migrationSetup = $migrationSetup;
		}

		public function run() {
			$this->themeSetup->run();
			$this->assetsRegister->register();
			$this->themeOptionsGenerator->generate();
			$this->themeShortcodesInitializer->initialize();
			$this->widgetsInitializer->init();
			$this->postOptionsConfigInitializer->initialize();
			$this->siteCustomizer->customize();
			$this->sidebarCustomizer->customize();
			$this->navigationMenusCustomizer->customize();
			$this->postLikesCustomizer->customize();
			$this->pluginsRegister->register();
			$this->shopSetup->run();
			$this->pikartBaseOptionsPageConfigSetup->setup();
			$this->wpBakerySetup->run();
			$this->migrationSetup->run();
		}
	}
}