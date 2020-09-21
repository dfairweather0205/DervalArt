<?php

namespace Pikart\Nels\Post\Options\Type;

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Site\SidebarId;
use Pikart\WpThemeCore\Post\Options\Type\GenericPostOptions;
use Pikart\WpThemeCore\Shortcode\ShortcodeConfig;

if ( ! class_exists( __NAMESPACE__ . '\\CommonPostOptions' ) ) {

	/**
	 * Class CommonPostOptions
	 * @package Pikart\Nels\Post\Options
	 */
	class CommonPostOptions extends GenericPostOptions {

		const SITE_WIDTH = 'site_width';
		const FULL_WIDTH = 'full_width';
		const SITE_HEADER_TRANSPARENCY = 'site_header_transparency';
		const SITE_HEADER_ABOVE_AREA = 'site_header_above_area';
		const FEATURED_BRANDING = 'featured_branding';
		const BRANDING_ENABLED = 'branding_enabled';
		const BREADCRUMBS = 'breadcrumbs';
		const TITLE_AREA = 'title_area';
		const SITE_CONTENT_SIDEBAR = 'site_content_sidebar';
		const CUSTOM_SIDEBAR = 'custom_sidebar';
		const SITE_CONTENT_BACKGROUND = 'site_content_background';
		const SITE_FOOTER_SIDEBAR = 'site_footer_sidebar';
		const SITE_FOOTER_BELOW_AREA = 'site_footer_below_area';
		const META_DESCRIPTION = 'meta_description';
		const MASONRY_LARGE_SIZE = 'masonry_large_size';
		const MASONRY_SPACING = 'masonry_spacing';
		const MASONRY_TITLE_FONT_SIZE = 'masonry_title_font_size';

		// read only options
		const NB_LIKES = 'nb_likes';
		const FONT_FAMILY_LIST = ShortcodeConfig::FONT_FAMILY_LIST_POST_OPTION;

		/**
		 * @return int
		 */
		public function getSiteWidth() {
			return $this->getIntOption( self::SITE_WIDTH );
		}

		/**
		 * @return bool
		 */
		public function isFullWidth() {
			return $this->getBoolOption( self::FULL_WIDTH );
		}

		/**
		 * @return bool
		 */
		public function isSiteHeaderTransparency() {
			return $this->getBoolOption( self::SITE_HEADER_TRANSPARENCY );
		}

		/**
		 * @return bool
		 */
		public function getAboveArea() {
			return $this->getBoolOption( self::SITE_HEADER_ABOVE_AREA );
		}

		/**
		 * @return bool
		 */
		public function isFeaturedBranding() {
			return $this->getBoolOption( self::FEATURED_BRANDING );
		}

		/**
		 * @return bool
		 */
		public function isBrandingEnabled() {
			return $this->getBoolOption( self::BRANDING_ENABLED );
		}

		/**
		 * @return bool
		 */
		public function isBreadcrumbsEnabled() {
			return $this->getBoolOption( self::BREADCRUMBS );
		}

		/**
		 * @return string
		 */
		public function getTitleArea() {
			return $this->getOption( self::TITLE_AREA );
		}

		/**
		 * @return bool
		 */
		public function isSiteContentSidebar() {
			return $this->getBoolOption( self::SITE_CONTENT_SIDEBAR ) && is_active_sidebar( SidebarId::content() );
		}

		/**
		 * @return string
		 */
		public function getCustomSidebar() {
			return $this->getOption( self::CUSTOM_SIDEBAR );
		}

		/**
		 * @return bool
		 */
		public function getSiteContentBackground() {
			return $this->getOption( self::SITE_CONTENT_BACKGROUND );
		}

		/**
		 * @return bool
		 */
		public function getSiteFooterSidebar() {
			return $this->getBoolOption( self::SITE_FOOTER_SIDEBAR )
			       && Service::themeOptionsUtil()->footerSidebarHasWidgets();
		}

		/**
		 * @return bool
		 */
		public function getSiteFooterBelowArea() {
			return $this->getBoolOption( self::SITE_FOOTER_BELOW_AREA );
		}

		/**
		 * @return string
		 */
		public function getMetaDescription() {
			return $this->getOption( self::META_DESCRIPTION );
		}

		/**
		 * @return bool
		 */
		public function isMasonryLargeSize() {
			return $this->getBoolOption( self::MASONRY_LARGE_SIZE );
		}

		/**
		 * @return string
		 */
		public function getMasonrySpacing() {
			return $this->getOption( self::MASONRY_SPACING );
		}

		/**
		 * @return int
		 */
		public function getMasonryTitleFontSize() {
			return $this->getIntOption( self::MASONRY_TITLE_FONT_SIZE );
		}

		/**
		 * @return int
		 */
		public function getNbLikes() {
			return $this->getIntOption( self::NB_LIKES );
		}

		/**
		 * @return array
		 */
		public function getFontFamilyList() {
			return $this->getArrayOption( self::FONT_FAMILY_LIST );
		}
	}
}