<?php

namespace Pikart\WpBase\NavigationMenus;

use Pikart\WpCore\NavigationMenus\NavigationMenusFilterName;
use Walker_Nav_Menu;

if ( ! class_exists( __NAMESPACE__ . '\\CustomWalkerNavMenu' ) ) {

	/**
	 * Class CustomWalkerNavMenu
	 * @package Pikart\WpBase\NavigationMenus
	 *
	 * @since 1.4.0
	 */
	class CustomWalkerNavMenu extends Walker_Nav_Menu {

		/**
		 * @var NavigationMenusUtil
		 */
		private $navigationMenusUtil;

		/**
		 * @var string
		 */
		private $backgroundImageUrl = '';

		/**
		 * CustomWalkerNavMenu constructor.
		 *
		 * @param NavigationMenusUtil $navigationMenusUtil
		 */
		public function __construct( NavigationMenusUtil $navigationMenusUtil ) {
			$this->navigationMenusUtil = $navigationMenusUtil;
		}

		/**
		 * @inheritdoc
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			if ( $depth > 0 || ! apply_filters( NavigationMenusFilterName::wideMenuEnabled(), true, $args )
			     || empty( $this->backgroundImageUrl )
			) {
				parent::start_lvl( $output, $depth, $args );

				return;
			}

			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}

			$indent = str_repeat( $t, $depth );

			$classes    = array( 'sub-menu' );
			$classNames = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$classNames = $classNames ? sprintf( ' class="%s"', esc_attr( $classNames ) ) : '';
			$style      = sprintf( 'style="background-image: url(\'%s\')"', esc_url( $this->backgroundImageUrl ) );
			$output     .= sprintf( '%s%s<ul %s %s>%s', $n, $indent, $classNames, $style, $n );
		}

		/**
		 * @inheritdoc
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			if ( $depth === 0 && apply_filters( NavigationMenusFilterName::wideMenuEnabled(), true, $args ) ) {
				$this->backgroundImageUrl =
					$this->navigationMenusUtil->getMenuItemOption( $item->ID, NavigationMenusOption::WIDE_MENU )
						? $this->navigationMenusUtil->getBackgroundImageUrl( $item->ID ) : '';
			}

			parent::start_el( $output, $item, $depth, $args, $id );
		}
	}
}
