<?php

namespace Pikart\Nels\ThemeOptions;

use Pikart\Nels\Site\SidebarId;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\Shop\ShopUtil;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCoreUtil;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsUtil' ) ) {

	/**
	 * Class ThemeOptionsUtil
	 * @package Pikart\Nels\ThemeOptions
	 */
	class ThemeOptionsUtil {

		/**
		 * @var ThemeOptionsCoreUtil
		 */
		private $themeOptionsCoreUtil;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * ThemeOptionsUtil constructor.
		 *
		 * @param ThemeOptionsCoreUtil $themeOptionsCoreUtil
		 * @param Util $util
		 */
		public function __construct( ThemeOptionsCoreUtil $themeOptionsCoreUtil, Util $util ) {
			$this->themeOptionsCoreUtil = $themeOptionsCoreUtil;
			$this->util                 = $util;
		}

		public function setupPostExcerptLength() {
			$self = $this;

			add_filter( 'excerpt_length', function () use ( $self ) {
				return $self->getIntOption( ThemeOption::BLOG_POST_EXCERPT_WORDS_NB );
			}, 999 );
		}

		/**
		 * @param string $id
		 * @param mixed $defaultValue
		 *
		 * @return array|string
		 */
		public function getOption( $id, $defaultValue = null ) {
			return $this->themeOptionsCoreUtil->getOption( $id, $defaultValue );
		}

		/**
		 * @param string $id
		 * @param mixed $defaultValue
		 *
		 * @return bool
		 */
		public function getBoolOption( $id, $defaultValue = null ) {
			return $this->themeOptionsCoreUtil->getBoolOption( $id, $defaultValue );
		}

		/**
		 * @param string $id
		 * @param mixed $defaultValue
		 *
		 * @return int
		 */
		public function getIntOption( $id, $defaultValue = null ) {
			return $this->themeOptionsCoreUtil->getIntOption( $id, $defaultValue );
		}

		/**
		 * @return int
		 */
		public function getSidebarNbCols() {
			return (int) round( 12 * $this->util->fractionToNumber(
					$this->getOption( ThemeOption::CONTENT_SIDEBAR_WIDTH ) ) );
		}

		/**
		 * @return int
		 */
		public function getMainSiteNbCols() {
			return 12 - $this->getSidebarNbCols();
		}

		/**
		 * @return bool
		 */
		public function isArchiveSidebarEnabled() {
			return $this->getBoolOption( ThemeOption::ARCHIVE_SIDEBAR_ENABLED )
			       && is_active_sidebar( SidebarId::archive() );
		}

		/**
		 * @return bool
		 */
		public function isHeaderSidebarEnabled() {
			return $this->getBoolOption( ThemeOption::HEADER_SIDEBAR_ENABLED )
			       && is_active_sidebar( SidebarId::header() );
		}

		/**
		 * @return bool
		 */
		public function isContentSidebarEnabled() {
			return $this->getBoolOption( ThemeOption::CONTENT_SIDEBAR_ENABLED )
			       && is_active_sidebar( SidebarId::content() );
		}

		/**
		 * @return bool
		 */
		public function isFooterSidebarEnabled() {
			return $this->getBoolOption( ThemeOption::FOOTER_SIDEBAR_ENABLED ) && $this->footerSidebarHasWidgets();
		}

		/**
		 * @return bool
		 */
		public function isFooterBelowAreaEnabled() {
			return $this->getBoolOption( ThemeOption::FOOTER_BELOW_AREA_ENABLED );
		}

		/**
		 * @return bool
		 */
		public function isHeaderSearchAreaEnabled() {
			return $this->getBoolOption( ThemeOption::HEADER_SEARCH_AREA_ENABLED );
		}

		/**
		 * @return bool
		 */
		public function isAboveAreaEnabled() {
			return $this->getBoolOption( ThemeOption::HEADER_ABOVE_AREA_ENABLED );
		}

		/**
		 * @return bool
		 */
		public function isBreadcrumbsEnabled() {
			return $this->getBoolOption( ThemeOption::CONTENT_BREADCRUMBS );
		}

		/**
		 * @return int
		 */
		public function getFooterSidebarNbColumns() {
			return $this->getIntOption( ThemeOption::FOOTER_SIDEBAR_NB_COLUMNS, 4 );
		}

		/**
		 * @param string $element
		 *
		 * @return bool
		 */
		public function layoutHasElement( $element ) {
			return $this->themeOptionsCoreUtil
				->multiValueOptionHasValue( ThemeOption::LAYOUT_SITE_ELEMENTS, $element );
		}

		/**
		 * @param string $element
		 *
		 * @return bool
		 */
		public function postHasElement( $element ) {
			return $this->themeOptionsCoreUtil
				->multiValueOptionHasValue( ThemeOption::SINGLE_POST_ELEMENTS_VISIBILITY, $element );
		}

		/**
		 * @param string $element
		 *
		 * @return bool
		 */
		public function pageHasElement( $element ) {
			return $this->themeOptionsCoreUtil
				->multiValueOptionHasValue( ThemeOption::PAGE_ELEMENTS_VISIBILITY, $element );
		}

		/**
		 * @param string $element
		 *
		 * @return bool
		 */
		public function projectHasElement( $element ) {
			return $this->themeOptionsCoreUtil
				->multiValueOptionHasValue( ThemeOption::SINGLE_PROJECT_ELEMENTS_VISIBILITY, $element );
		}

		/**
		 * @param string $element
		 *
		 * @return bool
		 */
		public function shopHasElement( $element ) {
			return $this->themeOptionsCoreUtil
				->multiValueOptionHasValue( ThemeOption::SHOP_ELEMENTS_VISIBILITY, $element );
		}

		/**
		 * @return bool
		 */
		public function isFeaturedBrandingEnabled() {
			return $this->getBoolOption( ThemeOption::FEATURED_BRANDING_ENABLED );
		}

		/**
		 * @param string $icon
		 *
		 * @return bool
		 */
		public function headerHasShopIcon( $icon ) {
			return $this->themeOptionsCoreUtil
				->multiValueOptionHasValue( ThemeOption::SHOP_HEADER_ICONS_VISIBILITY, $icon );
		}

		/**
		 * @return bool
		 */
		public function isShopCatalogModeEnabled() {
			return $this->getBoolOption( ThemeOption::SHOP_CATALOG_MODE_ENABLED );
		}

		/**
		 * @return bool
		 */
		public function isShopCartIconLinkCartPopup() {
			return $this->getOption( ThemeOption::SHOP_CART_ICON_LINK ) === 'cart_popup';
		}

		/**
		 * @return bool
		 */
		public function isCartPopupEnabled() {
			return ShopUtil::isShopActivated()
			       && ( $this->getOption( ThemeOption::ADD_TO_CART_POPUP )
			            || ( $this->headerHasShopIcon( 'cart' ) && $this->isShopCartIconLinkCartPopup() ) );
		}

		/**
		 * @return bool
		 */
		public function isMyAccountPopupEnabled() {
			return ShopUtil::isShopActivated() && $this->getOption( ThemeOption::SHOP_HEADER_MY_ACCOUNT_POPUP );
		}

		/**
		 * @since 1.0.3
		 *
		 * @return bool
		 */
		public function isHeaderProductSearchModeEnabled() {
			return ShopUtil::isShopActivated() && $this->getOption( ThemeOption::HEADER_PRODUCTS_SEARCH_MODE );
		}

		/**
		 * @param int $logoId
		 * @param string $logoClassSuffix
		 */
		public function printLogoImageHtml( $logoId, $logoClassSuffix ) {
			$attributes = array(
				'rel'   => 'logo',
				'class' => sprintf( 'logo__img logo__img--%s', $logoClassSuffix )
			);

			$imageAlt = get_post_meta( $logoId, '_wp_attachment_image_alt', true );

			if ( empty( $imageAlt ) ) {
				$attributes['alt'] = get_bloginfo( 'name', 'display' );
			}

			echo wp_get_attachment_image( $logoId, 'full', false, $attributes );
		}

		/**
		 * @return bool
		 */
		public function footerSidebarHasWidgets() {
			$nbColumns = $this->getFooterSidebarNbColumns();

			for ( $index = 1; $index <= $nbColumns; $index ++ ) {
				$sidebarId = SidebarId::footer( $index );

				if ( is_active_sidebar( $sidebarId ) ) {
					return true;
				}
			}

			return false;
		}
	}
}