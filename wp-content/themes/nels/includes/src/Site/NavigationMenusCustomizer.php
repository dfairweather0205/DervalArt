<?php

namespace Pikart\Nels\Site;

use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\NavigationMenus\NavigationMenusFilterName;

if ( ! class_exists( __NAMESPACE__ . '\NavigationMenusCustomizer' ) ) {

	/**
	 * Class NavigationMenusCustomizer
	 * @package Pikart\Nels\Site
	 */
	class NavigationMenusCustomizer {

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * NavigationMenusCustomizer constructor.
		 *
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 */
		public function __construct( ThemeOptionsUtil $themeOptionsUtil ) {
			$this->themeOptionsUtil = $themeOptionsUtil;
		}

		public function customize() {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_filter( NavigationMenusFilterName::wideMenuEnabled(), function ( $wideMenuEnabled, $args ) use (
				$themeOptionsUtil
			) {
				$themeLocationAllowed = true;
				$isMobileMenu         = false;

				if ( is_object( $args ) ) {
					if ( property_exists( $args, 'theme_location' ) ) {
						$themeLocationAllowed = in_array(
							$args->theme_location, array( NavigationMenu::PRIMARY ) );
					}

					if ( property_exists( $args, 'menu_class' ) ) {
						$isMobileMenu = stripos( $args->menu_class, 'mobile-menu' ) !== false;
					}
				}

				return PIKART_BASE_ENABLED
				       && $wideMenuEnabled
				       && $themeLocationAllowed
				       && ! $isMobileMenu;
			}, 10, 2 );
		}
	}

}