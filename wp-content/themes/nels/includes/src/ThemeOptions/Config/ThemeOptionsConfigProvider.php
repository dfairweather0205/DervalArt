<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsConfigHelper;

if ( ! class_exists( __NAMESPACE__ . '\ThemeOptionsConfigProvider' ) ) {

	/**
	 * Class ThemeOptionsConfigProvider
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ThemeOptionsConfigProvider {

		/**
		 * @var LayoutConfig
		 */
		private $layoutConfig;

		/**
		 * @var ColorsConfig
		 */
		private $colorsConfig;

		/**
		 * @var TypographyConfig
		 */
		private $typographyConfig;

		/**
		 * @var ThemeOptionsConfigHelper
		 */
		private $configHelper;

		/**
		 * @var MiscConfig
		 */
		private $miscConfig;

		/**
		 * @var ContentGeneralConfig
		 */
		private $contentGeneralConfig;

		/**
		 * @var SinglePostConfig
		 */
		private $singlePostConfig;

		/**
		 * @var SingleProjectConfig
		 */
		private $singleProjectConfig;

		/**
		 * @var SinglePageConfig
		 */
		private $singlePageConfig;

		/**
		 * @var FeaturedBrandingConfig
		 */
		private $featuredBrandingConfig;

		/**
		 * @var SidebarConfig
		 */
		private $sidebarConfig;

		/**
		 * @var ErrorPageConfig
		 */
		private $errorPageConfig;

		/**
		 * @var HeaderLayoutConfig
		 */
		private $headerLayoutConfig;

		/**
		 * @var HeaderMenuConfig
		 */
		private $headerMenuConfig;

		/**
		 * @var HeaderSearchAreaConfig
		 */
		private $headerSearchAreaConfig;

		/**
		 * @var HeaderSidebarConfig
		 */
		private $headerSidebarConfig;

		/**
		 * @var HeaderAboveAreaConfig
		 */
		private $headerAboveAreaConfig;

		/**
		 * @var HeaderMobileMenuConfig
		 */
		private $headerMobileMenuConfig;

		/**
		 * @var FooterSidebarConfig
		 */
		private $footerSidebarConfig;

		/**
		 * @var FooterBelowAreaConfig
		 */
		private $footerBelowAreaConfig;

		/**
		 * @var SiteIdentityConfig
		 */
		private $siteIdentityConfig;

		/**
		 * @var ShopHeaderConfig
		 */
		private $shopHeaderConfig;

		/**
		 * @var ShopProductConfig
		 */
		private $shopProductConfig;

		/**
		 * @var $shopRibbonsConfig
		 */
		private $shopRibbonsConfig;

		/**
		 * @var ShopProductCatalogConfig
		 */
		private $shopProductCatalogConfig;

		/**
		 * @var WpOptionsConfig
		 */
		private $wpOptionsConfig;

		/**
		 * ThemeOptionsConfigProvider constructor.
		 *
		 * @param LayoutConfig $layoutConfig
		 * @param ColorsConfig $colorsConfig
		 * @param TypographyConfig $typographyConfig
		 * @param MiscConfig $miscConfig
		 * @param ContentGeneralConfig $contentGeneralConfig
		 * @param SinglePostConfig $singlePostConfig
		 * @param SingleProjectConfig $singleProjectConfig
		 * @param SinglePageConfig $singlePageConfig
		 * @param FeaturedBrandingConfig $featuredBrandingConfig
		 * @param SidebarConfig $sidebarConfig
		 * @param ErrorPageConfig $errorPageConfig
		 * @param ShopHeaderConfig $shopHeaderConfig
		 * @param ShopProductConfig $shopProductConfig
		 * @param shopRibbonsConfig $shopRibbonsConfig
		 * @param HeaderLayoutConfig $headerLayoutConfig
		 * @param HeaderMenuConfig $headerMenuConfig
		 * @param HeaderSearchAreaConfig $headerSearchAreaConfig
		 * @param HeaderSidebarConfig $headerSidebarConfig
		 * @param HeaderAboveAreaConfig $headerAboveAreaConfig
		 * @param HeaderMobileMenuConfig $headerMobileMenuConfig
		 * @param FooterSidebarConfig $footerSidebarConfig
		 * @param FooterBelowAreaConfig $footerBelowAreaConfig
		 * @param SiteIdentityConfig $siteIdentityConfig
		 * @param ShopProductCatalogConfig $shopProductCatalogConfig
		 * @param WpOptionsConfig $wpOptionsConfig
		 */
		public function __construct(
			LayoutConfig $layoutConfig,
			ColorsConfig $colorsConfig,
			TypographyConfig $typographyConfig,
			MiscConfig $miscConfig,
			ContentGeneralConfig $contentGeneralConfig,
			SinglePostConfig $singlePostConfig,
			SingleProjectConfig $singleProjectConfig,
			SinglePageConfig $singlePageConfig,
			FeaturedBrandingConfig $featuredBrandingConfig,
			SidebarConfig $sidebarConfig,
			ErrorPageConfig $errorPageConfig,
			ShopHeaderConfig $shopHeaderConfig,
			ShopProductConfig $shopProductConfig,
			ShopRibbonsConfig $shopRibbonsConfig,
			HeaderLayoutConfig $headerLayoutConfig,
			HeaderMenuConfig $headerMenuConfig,
			HeaderSearchAreaConfig $headerSearchAreaConfig,
			HeaderSidebarConfig $headerSidebarConfig,
			HeaderAboveAreaConfig $headerAboveAreaConfig,
			HeaderMobileMenuConfig $headerMobileMenuConfig,
			FooterSidebarConfig $footerSidebarConfig,
			FooterBelowAreaConfig $footerBelowAreaConfig,
			SiteIdentityConfig $siteIdentityConfig,
			ShopProductCatalogConfig $shopProductCatalogConfig,
			WpOptionsConfig $wpOptionsConfig
		) {
			$this->layoutConfig             = $layoutConfig;
			$this->colorsConfig             = $colorsConfig;
			$this->typographyConfig         = $typographyConfig;
			$this->miscConfig               = $miscConfig;
			$this->contentGeneralConfig     = $contentGeneralConfig;
			$this->singlePostConfig         = $singlePostConfig;
			$this->singleProjectConfig      = $singleProjectConfig;
			$this->singlePageConfig         = $singlePageConfig;
			$this->featuredBrandingConfig   = $featuredBrandingConfig;
			$this->sidebarConfig            = $sidebarConfig;
			$this->errorPageConfig          = $errorPageConfig;
			$this->shopHeaderConfig         = $shopHeaderConfig;
			$this->shopProductConfig        = $shopProductConfig;
			$this->shopRibbonsConfig        = $shopRibbonsConfig;
			$this->headerLayoutConfig       = $headerLayoutConfig;
			$this->headerMenuConfig         = $headerMenuConfig;
			$this->headerSearchAreaConfig   = $headerSearchAreaConfig;
			$this->headerSidebarConfig      = $headerSidebarConfig;
			$this->headerAboveAreaConfig    = $headerAboveAreaConfig;
			$this->headerMobileMenuConfig   = $headerMobileMenuConfig;
			$this->footerSidebarConfig      = $footerSidebarConfig;
			$this->footerBelowAreaConfig    = $footerBelowAreaConfig;
			$this->siteIdentityConfig       = $siteIdentityConfig;
			$this->shopProductCatalogConfig = $shopProductCatalogConfig;
			$this->wpOptionsConfig          = $wpOptionsConfig;
		}

		/**
		 * @return LayoutConfig
		 */
		public function getLayoutConfig() {
			return $this->layoutConfig;
		}

		/**
		 * @return ColorsConfig
		 */
		public function getColorsConfig() {
			return $this->colorsConfig;
		}

		/**
		 * @return TypographyConfig
		 */
		public function getTypographyConfig() {
			return $this->typographyConfig;
		}

		/**
		 * @return ThemeOptionsConfigHelper
		 */
		public function getConfigHelper() {
			return $this->configHelper;
		}

		/**
		 * @return MiscConfig
		 */
		public function getMiscConfig() {
			return $this->miscConfig;
		}

		/**
		 * @return ContentGeneralConfig
		 */
		public function getContentGeneralConfig() {
			return $this->contentGeneralConfig;
		}

		/**
		 * @return SinglePostConfig
		 */
		public function getSinglePostConfig() {
			return $this->singlePostConfig;
		}

		/**
		 * @return SingleProjectConfig
		 */
		public function getSingleProjectConfig() {
			return $this->singleProjectConfig;
		}

		/**
		 * @return SinglePageConfig
		 */
		public function getSinglePageConfig() {
			return $this->singlePageConfig;
		}

		/**
		 * @return FeaturedBrandingConfig
		 */
		public function getFeaturedBrandingConfig() {
			return $this->featuredBrandingConfig;
		}

		/**
		 * @return SidebarConfig
		 */
		public function getSidebarConfig() {
			return $this->sidebarConfig;
		}

		/**
		 * @return ErrorPageConfig
		 */
		public function getErrorPageConfig() {
			return $this->errorPageConfig;
		}

		/**
		 * @return ShopProductConfig
		 */
		public function getShopProductConfig() {
			return $this->shopProductConfig;
		}

		/**
		 * @return ShopHeaderConfig
		 */
		public function getShopHeaderConfig() {
			return $this->shopHeaderConfig;
		}

		/**
		 * @return ShopRibbonsConfig
		 */
		public function getShopRibbonsConfig() {
			return $this->shopRibbonsConfig;
		}

		/**
		 * @return HeaderLayoutConfig
		 */
		public function getHeaderLayoutConfig() {
			return $this->headerLayoutConfig;
		}

		/**
		 * @return HeaderMenuConfig
		 */
		public function getHeaderMenuConfig() {
			return $this->headerMenuConfig;
		}

		/**
		 * @return HeaderSearchAreaConfig
		 */
		public function getHeaderSearchAreaConfig() {
			return $this->headerSearchAreaConfig;
		}

		/**
		 * @return HeaderSidebarConfig
		 */
		public function getHeaderSidebarConfig() {
			return $this->headerSidebarConfig;
		}

		/**
		 * @return HeaderAboveAreaConfig
		 */
		public function getHeaderAboveAreaConfig() {
			return $this->headerAboveAreaConfig;
		}

		/**
		 * @return HeaderMobileMenuConfig
		 */
		public function getHeaderMobileMenuConfig() {
			return $this->headerMobileMenuConfig;
		}

		/**
		 * @return FooterSidebarConfig
		 */
		public function getFooterSidebarConfig() {
			return $this->footerSidebarConfig;
		}

		/**
		 * @return FooterBelowAreaConfig
		 */
		public function getFooterBelowAreaConfig() {
			return $this->footerBelowAreaConfig;
		}

		/**
		 * @return SiteIdentityConfig
		 */
		public function getSiteIdentityConfig() {
			return $this->siteIdentityConfig;
		}

		/**
		 * @return ShopProductCatalogConfig
		 */
		public function getShopProductCatalogConfig() {
			return $this->shopProductCatalogConfig;
		}

		/**
		 * @return WpOptionsConfig
		 */
		public function getWpOptionsConfig() {
			return $this->wpOptionsConfig;
		}
	}
}