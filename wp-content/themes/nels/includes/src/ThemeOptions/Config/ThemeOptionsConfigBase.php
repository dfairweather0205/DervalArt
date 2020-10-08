<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\WpThemeCore\Shop\ShopUtil;
use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ControlConfigBuilder;
use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\PanelConfigBuilder;
use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\SectionConfigBuilder;
use Pikart\WpThemeCore\ThemeOptions\ConfigBuilder\ThemeOptionsConfigBuilder;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsConfigHelper;
use Pikart\WpThemeCore\ThemeOptions\WpDefaultSection;

if ( ! class_exists( __NAMESPACE__ . '\ThemeOptionsConfigBase' ) ) {

	/**
	 * Class ThemeOptionsConfigBase
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ThemeOptionsConfigBase {

		/**
		 * @var ThemeOptionsConfigBuilder
		 */
		private $configBuilder;

		/**
		 * @var ThemeOptionsConfigHelper
		 */
		private $configHelper;

		/**
		 * @var ControlConfigBuilder
		 */
		private $controlConfigBuilder;

		/**
		 * @var ThemeOptionsConfigProvider
		 */
		private $configProvider;

		/**
		 * ThemeOptionsConfig constructor.
		 *
		 * @param ThemeOptionsConfigBuilder $configBuilder
		 * @param ThemeOptionsConfigHelper $configHelper
		 * @param ThemeOptionsConfigProvider $configProvider
		 */
		public function __construct(
			ThemeOptionsConfigBuilder $configBuilder,
			ThemeOptionsConfigHelper $configHelper,
			ThemeOptionsConfigProvider $configProvider
		) {
			$this->configBuilder        = $configBuilder;
			$this->controlConfigBuilder = $this->configBuilder->getControlBuilder();
			$this->configProvider       = $configProvider;
			$this->configHelper         = $configHelper;
		}


		/**
		 * @inheritdoc
		 */
		public function buildThemeOptions() {
			return $this->configBuilder
				->customOptions( $this->getPanels()->build(), $this->getSections()->build() )
				->wpOptions( $this->configProvider->getWpOptionsConfig()->getConfig() )
				->buildThemeOptions();
		}

		/**
		 * @return PanelConfigBuilder
		 */
		private function getPanels() {
			return $this->configBuilder
				->panel( 'general' )
				->title( esc_html__( 'General', 'nels' ) )
				->sections( $this->getGeneralPanelSections()->build() )
				// -------------------------------------------------------------------------------------------------- \\
				->panel( 'header' )
				->title( esc_html__( 'Header', 'nels' ) )
				->sections( $this->getHeaderPanelSections()->build() )
				// -------------------------------------------------------------------------------------------------- \\
				->panel( 'content' )
				->title( esc_html__( 'Content', 'nels' ) )
				->sections( $this->getContentPanelSections()->build() )
				// -------------------------------------------------------------------------------------------------- \\
				->panel( 'footer' )
				->title( esc_html__( 'Footer', 'nels' ) )
				->sections( $this->getFooterPanelSections()->build() )
				->panel( 'woocommerce' )
				->priority( 200 )
				->builtIn( ShopUtil::shopHasCustomizerOptions() )
				->enabled( ShopUtil::isShopActivated() )
				->title( esc_html__( 'WooCommerce', 'nels' ) )
				->sections( $this->getWooCommerceSections()->build() );
		}

		/**
		 * @return SectionConfigBuilder
		 */
		private function getSections() {
			return $this->configBuilder
				->section( 'general_layout' )
				->title( esc_html__( 'Layout', 'nels' ) )
				->priority( 1 )
				->controls( $this->configProvider->getLayoutConfig()->getConfig() )
				->section( WpDefaultSection::TITLE_TAGLINE )
				->builtIn( true )
				->controls( $this->configProvider->getSiteIdentityConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( WpDefaultSection::COLORS )
				->builtIn( true )
				->title( esc_html__( 'Colors', 'nels' ) )
				->controls( $this->configProvider->getColorsConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( WpDefaultSection::WP_HEADER_IMAGE )
				->builtIn( true )
				->title( esc_html__( 'Featured Branding', 'nels' ) )
				->controls( $this->configProvider->getFeaturedBrandingConfig()->getConfig() );
		}

		/**
		 * @return SectionConfigBuilder
		 */
		private function getWooCommerceSections() {
			$this->configBuilder
				->section( 'woocommerce_product_catalog' )
				->builtIn( ShopUtil::shopHasCustomizerOptions() )
				->enabled( ShopUtil::isShopActivated() )
				->title( esc_html__( 'Product Catalog', 'nels' ) )
				->controls( $this->configProvider->getShopProductCatalogConfig()->getConfig() )
				->section( 'shop_product' )
				->title( esc_html__( 'Product', 'nels' ) )
				->controls( $this->configProvider->getShopProductConfig()->getConfig() )
				->section( 'shop_header' )
				->title( esc_html__( 'Header', 'nels' ) )
				->controls( $this->configProvider->getShopHeaderConfig()->getConfig() )
				->section( 'shop_ribbons' )
				->title( esc_html__( 'Ribbons', 'nels' ) )
				->controls( $this->configProvider->getShopRibbonsConfig()->getConfig() );

			return $this->configBuilder->getSectionBuilder();
		}

		/**
		 * @return SectionConfigBuilder
		 */
		private function getGeneralPanelSections() {
			return $this->configBuilder
				->section( 'typography' )
				->title( esc_html__( 'Typography', 'nels' ) )
				->controls( $this->configProvider->getTypographyConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'custom_code' )
				->title( esc_html__( 'Custom code', 'nels' ) )
				->controls( $this->configHelper->buildCustomJsConfig( $this->controlConfigBuilder )->build() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'miscellaneous' )
				->title( esc_html__( 'Miscellaneous', 'nels' ) )
				->controls( $this->configProvider->getMiscConfig()->getConfig() );
		}

		/**
		 * @return SectionConfigBuilder
		 */
		private function getContentPanelSections() {
			$this->configBuilder
				->section( 'general_options_content' )
				->title( esc_html__( 'General', 'nels' ) )
				->controls( $this->configProvider->getContentGeneralConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'single_post' )
				->title( esc_html__( 'Post', 'nels' ) )
				->controls( $this->configProvider->getSinglePostConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'single_project' )
				->enabled( PIKART_BASE_ENABLED )
				->title( esc_html__( 'Project', 'nels' ) )
				->controls( $this->configProvider->getSingleProjectConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'page' )
				->title( esc_html__( 'Page', 'nels' ) )
				->controls( $this->configProvider->getSinglePageConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'sidebar' )
				->title( esc_html__( 'Sidebar', 'nels' ) )
				->controls( $this->configProvider->getSidebarConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( '404_error_page' )
				->title( esc_html__( '404 Error Page', 'nels' ) )
				->controls( $this->configProvider->getErrorPageConfig()->getConfig() );

			return $this->configBuilder->getSectionBuilder();
		}

		/**
		 * @return SectionConfigBuilder
		 */
		private function getHeaderPanelSections() {
			return $this->configBuilder
				->section( 'header_layout' )
				->title( esc_html__( 'Layout', 'nels' ) )
				->controls( $this->configProvider->getHeaderLayoutConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'header_menu' )
				->title( esc_html__( 'Menu', 'nels' ) )
				->controls( $this->configProvider->getHeaderMenuConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'header_search_area' )
				->title( esc_html__( 'Search Area', 'nels' ) )
				->controls( $this->configProvider->getHeaderSearchAreaConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'header_sidebar' )
				->title( esc_html__( 'Sidebar', 'nels' ) )
				->controls( $this->configProvider->getHeaderSidebarConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'header_above_area' )
				->title( esc_html__( 'Above Area', 'nels' ) )
				->controls( $this->configProvider->getHeaderAboveAreaConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'header_mobile_menu' )
				->title( esc_html__( 'Mobile Menu', 'nels' ) )
				->controls( $this->configProvider->getHeaderMobileMenuConfig()->getConfig() );
		}


		/**
		 * @return SectionConfigBuilder
		 */
		private function getFooterPanelSections() {
			return $this->configBuilder
				->section( 'footer_sidebar' )
				->title( esc_html__( 'Sidebar', 'nels' ) )
				->controls( $this->configProvider->getFooterSidebarConfig()->getConfig() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'footer_below_area' )
				->title( esc_html__( 'Below Area', 'nels' ) )
				->controls( $this->configProvider->getFooterBelowAreaConfig()->getConfig() );
		}
	}
}