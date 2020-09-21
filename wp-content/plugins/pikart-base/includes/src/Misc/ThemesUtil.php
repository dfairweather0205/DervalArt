<?php

namespace Pikart\WpBase\Misc;

use Pikart\WpBase\OptionsPages\OptionsPage;
use Pikart\WpBase\OptionsPages\PageOption;
use Pikart\WpCore\Admin\Media\MediaFilter;
use Pikart\WpCore\Common\AssetFilterName;
use Pikart\WpCore\Elementor\ElementorFilterName;
use Pikart\WpCore\NavigationMenus\NavigationMenusFilterName;
use Pikart\WpCore\OptionsPages\OptionsPagesFilterName;
use Pikart\WpCore\Post\PostFilterName;
use Pikart\WpCore\Post\Type\PostTypeSlug;
use Pikart\WpCore\Shop\ShopFilterName;
use Pikart\WpCore\Shortcode\ShortcodeFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\ThemesUtil ' ) ) {

	/**
	 * Class OptionsMenuPageRegister
	 * @package Pikart\WpBase\OptionsPages
	 *
	 * @since 1.6.1
	 */
	class ThemesUtil {

		public static function deactivateNavigationMenuAlternativeLabels() {
			self::addReturnFalseFilter( NavigationMenusFilterName::alternativeLabelsEnabled() );
		}

		public static function disableAlbumPostType() {
			self::addReturnFalseFilter( PostFilterName::postTypeEnabled( PostTypeSlug::ALBUM ) );
		}

		public static function allowElementor() {
			add_filter( ElementorFilterName::pikartBaseElementorAllowed(), '__return_true' );
		}

		public static function disableWishlist() {
			self::addReturnFalseFilter( ShopFilterName::wishlistAllowed() );
		}

		public static function disableProductsCompare() {
			self::addReturnFalseFilter( ShopFilterName::productsCompareAllowed() );
		}

		public static function disablePikartBaseSocialServicesSection() {
			self::addReturnFalseFilter( OptionsPagesFilterName::sectionEnabled(
				OptionsPage::PIKART_BASE, 'social_services' ) );
		}

		public static function disablePikartBaseGoogleMapsPinImage() {
			self::addReturnFalseFilter( OptionsPagesFilterName::settingEnabled(
				OptionsPage::PIKART_BASE, PageOption::GOOGLE_MAPS_PIN_IMAGE ) );
		}

		public static function disablePikartBaseGoogleMapsApiKey() {
			self::addReturnFalseFilter( OptionsPagesFilterName::settingEnabled(
				OptionsPage::PIKART_BASE, PageOption::GOOGLE_MAPS_API_KEY ) );
		}

		public static function disableWpBaseGalleryCustomizer() {
			self::addReturnFalseFilter( MediaFilter::wpBaseGalleryCustomizerEnabled() );
		}

		public static function disableAddthis() {
			self::addReturnFalseFilter( AssetFilterName::loadAddthisScript() );
		}

		/**
		 * @since 1.7.0
		 */
		public static function disablePikartShortcodes() {
			self::addReturnFalseFilter( ShortcodeFilterName::shortcodesEnabled() );
		}

		/**
		 * @since 1.7.0
		 */
		public static function disableNavigationMenusWideMenu() {
			self::addReturnFalseFilter( NavigationMenusFilterName::wideMenuEnabled() );
		}

		/**
		 * @since 1.7.0
		 */
		public static function enableCustomSocialProfiles() {
			self::addReturnTrueFilter( OptionsPagesFilterName::sectionEnabled(
				OptionsPage::PIKART_BASE, 'custom_social_profiles' ) );
		}

		/**
		 * @param string $filterName
		 */
		private static function addReturnFalseFilter( $filterName ) {
			add_filter( $filterName, '__return_false' );
		}

		/**
		 * @param string $filterName
		 *
		 * @since 1.7.0
		 */
		private static function addReturnTrueFilter( $filterName ) {
			add_filter( $filterName, '__return_true' );
		}
	}
}