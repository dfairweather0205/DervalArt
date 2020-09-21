<?php

namespace Pikart\WpBase\Setup;

use Pikart\WpBase\Admin\Media\WpGallery\WpGalleryCustomizer;
use Pikart\WpBase\Admin\Migration\MigrationSetup;
use Pikart\WpBase\Admin\Sidebars\CustomSidebarFacade;
use Pikart\WpBase\Common\AssetsRegister;
use Pikart\WpBase\Elementor\ElementorInitializer;
use Pikart\WpBase\NavigationMenus\NavigationMenusFacade;
use Pikart\WpBase\OptionsPages\OptionsPagesGenerator;
use Pikart\WpBase\Post\PostLikesFacade;
use Pikart\WpBase\Post\PostTypeFacade;
use Pikart\WpBase\Shop\ProductsCompare\ProductsCompareFacade;
use Pikart\WpBase\Shop\Wishlist\WishlistFacade;
use Pikart\WpBase\Shortcode\ShortcodesInitializer;
use Pikart\WpBase\Widget\WidgetsRegister;
use Pikart\WpCore\ThemeOptions\GoogleFontsHelper;

if ( ! class_exists( __NAMESPACE__ . '\Bootstrap' ) ) {

	/**
	 * Class Bootstrap
	 * @package Pikart\WpBase\Setup
	 */
	class Bootstrap {

		/**
		 * @var ShortcodesInitializer
		 */
		private $shortcodesInitializer;

		/**
		 * @var PluginSetup
		 */
		private $pluginSetup;

		/**
		 * @var AssetsRegister
		 */
		private $assetsRegister;

		/**
		 * @var PostTypeFacade
		 */
		private $postTypeFacade;

		/**
		 * @var PostLikesFacade
		 */
		private $postLikesFacade;

		/**
		 * @var CustomSidebarFacade
		 */
		private $customSidebarFacade;

		/**
		 * @var WpGalleryCustomizer
		 */
		private $wpGalleryCustomizer;

		/**
		 * @var GoogleFontsHelper
		 */
		private $googleFontsHelper;

		/**
		 * @var OptionsPagesGenerator
		 */
		private $pluginOptionsFacade;

		/**
		 * @var NavigationMenusFacade
		 *
		 * @since 1.1.0
		 */
		private $navigationMenusFacade;

		/**
		 * @var WidgetsRegister
		 *
		 * @since 1.1.0
		 */
		private $widgetsRegister;

		/**
		 * @var WishlistFacade
		 *
		 * @since 1.3.0
		 */
		private $wishlistFacade;

		/**
		 * @var ProductsCompareFacade
		 *
		 * @since 1.3.0
		 */
		private $productsCompareFacade;

		/**
		 * @var MigrationSetup
		 *
		 * @since 1.5.3
		 */
		private $migrationSetup;

		/**
		 * @var ElementorInitializer
		 *
		 * @since 1.6.0
		 */
		private $elementorInitializer;

		/**
		 * Bootstrap constructor.
		 *
		 * @param ShortcodesInitializer $shortcodesInitializer
		 * @param PluginSetup $pluginSetup
		 * @param AssetsRegister $assetsRegister
		 * @param PostTypeFacade $postTypeFacade
		 * @param MigrationSetup $migrationSetup
		 * @param PostLikesFacade $postLikesFacade
		 * @param CustomSidebarFacade $customSidebarFacade
		 * @param WpGalleryCustomizer $wpGalleryCustomizer
		 * @param GoogleFontsHelper $googleFontsHelper
		 * @param OptionsPagesGenerator $pluginOptionsFacade
		 * @param NavigationMenusFacade $navigationMenusFacade
		 * @param WidgetsRegister $widgetsRegister
		 * @param WishlistFacade $wishlistFacade
		 * @param ProductsCompareFacade $productsCompareFacade
		 * @param ElementorInitializer $elementorInitializer
		 */
		public function __construct(
			ShortcodesInitializer $shortcodesInitializer,
			PluginSetup $pluginSetup,
			AssetsRegister $assetsRegister,
			PostTypeFacade $postTypeFacade,
			MigrationSetup $migrationSetup,
			PostLikesFacade $postLikesFacade,
			CustomSidebarFacade $customSidebarFacade,
			WpGalleryCustomizer $wpGalleryCustomizer,
			GoogleFontsHelper $googleFontsHelper,
			OptionsPagesGenerator $pluginOptionsFacade,
			NavigationMenusFacade $navigationMenusFacade,
			WidgetsRegister $widgetsRegister,
			WishlistFacade $wishlistFacade,
			ProductsCompareFacade $productsCompareFacade,
			ElementorInitializer $elementorInitializer
		) {
			$this->shortcodesInitializer = $shortcodesInitializer;
			$this->pluginSetup           = $pluginSetup;
			$this->assetsRegister        = $assetsRegister;
			$this->postTypeFacade        = $postTypeFacade;
			$this->postLikesFacade       = $postLikesFacade;
			$this->customSidebarFacade   = $customSidebarFacade;
			$this->wpGalleryCustomizer   = $wpGalleryCustomizer;
			$this->googleFontsHelper     = $googleFontsHelper;
			$this->pluginOptionsFacade   = $pluginOptionsFacade;
			$this->navigationMenusFacade = $navigationMenusFacade;
			$this->widgetsRegister       = $widgetsRegister;
			$this->wishlistFacade        = $wishlistFacade;
			$this->productsCompareFacade = $productsCompareFacade;
			$this->migrationSetup        = $migrationSetup;
			$this->elementorInitializer  = $elementorInitializer;
		}

		public function run() {
			$this->pluginSetup->setup();
			$this->shortcodesInitializer->initialize();
			$this->assetsRegister->register();
			$this->initPostTypes();
			$this->postLikesFacade->setupPostLikes();
			$this->customSidebarFacade->manageCustomSidebars();
			$this->wpGalleryCustomizer->customize();
			$this->googleFontsHelper->enqueueGoogleFonts();
			$this->pluginOptionsFacade->run();
			$this->navigationMenusFacade->manageNavigationMenus();
			$this->widgetsRegister->register();
			$this->wishlistFacade->manageWishlist();
			$this->productsCompareFacade->manageProductsCompare();
			$this->migrationSetup->run();
			$this->elementorInitializer->initialize();
		}

		private function initPostTypes() {
			$this->postTypeFacade->initProject();
			$this->postTypeFacade->initPost();
			$this->postTypeFacade->initPage();
			$this->postTypeFacade->initAlbum();
			$this->postTypeFacade->initProduct();
		}
	}
}