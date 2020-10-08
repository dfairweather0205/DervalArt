<?php

namespace Pikart\WpBase\NavigationMenus;

use Pikart\WpCore\Common\DataSanitizer;
use Pikart\WpCore\NavigationMenus\NavigationMenusFilterName;
use WP_Post;
use WP_Term;

if ( ! class_exists( __NAMESPACE__ . '\\NavigationMenusHelper' ) ) {

	/**
	 * Class NavigationMenusHelper
	 * @package Pikart\WpBase\Admin\NavigationMenus
	 *
	 * @since 1.1.0
	 */
	class NavigationMenusHelper {

		const WIDE_MENU = NavigationMenusOption::WIDE_MENU;
		const NB_COLUMNS = NavigationMenusOption::NB_COLUMNS;

		/**
		 * @var DataSanitizer
		 */
		private $dataSanitizer;

		/**
		 * @var NavigationMenusUtil
		 */
		private $navigationMenusUtil;

		/**
		 * @var array
		 */
		private $menuItemsConfig = array();

		/**
		 * @var array
		 */
		private $menuItems = array();

		/**
		 * NavigationMenusFacade constructor.
		 *
		 * @param DataSanitizer $dataSanitizer
		 * @param NavigationMenusUtil $navigationMenusUtil
		 */
		public function __construct( DataSanitizer $dataSanitizer, NavigationMenusUtil $navigationMenusUtil ) {
			$this->dataSanitizer       = $dataSanitizer;
			$this->navigationMenusUtil = $navigationMenusUtil;
		}

		/**
		 * @param array $classes
		 * @param object $item
		 * @param object $args
		 * @param int $depth
		 *
		 * @return array
		 */
		public function setupMenuItemCssClasses( $classes, $item, $args, $depth = - 1 ) {
			$navigationMenusUtil = $this->navigationMenusUtil;

			if ( $depth !== 0 || ! apply_filters( NavigationMenusFilterName::wideMenuEnabled(), true, $args )
			     || ! $navigationMenusUtil->getMenuItemOption( $item->ID, self::WIDE_MENU ) ) {
				return $classes;
			}

			$nbColumns = (int) $navigationMenusUtil
				->getMenuItemOption( $item->ID, self::NB_COLUMNS );

			if ( $nbColumns > 0 ) {
				$classes[] = 'menu-wide';
				$classes[] = 'menu-wide--columns-' . esc_attr( $nbColumns );
			}

			return $classes;
		}

		/**
		 * @param string $output
		 * @param object $item
		 * @param int $depth
		 * @param object $args
		 *
		 * @return string
		 */
		public function setupCustomWidgetAreaGeneration( $output, $item, $depth, $args ) {
			if ( ! apply_filters( NavigationMenusFilterName::wideMenuEnabled(), true, $args ) ) {
				return $output;
			}

			$menuItemParentId = $item->menu_item_parent;
			$menuItemConfig   = array();

			if ( $menuItemParentId && isset( $this->menuItemsConfig[ $menuItemParentId ] ) ) {
				$menuItemConfig = $this->menuItemsConfig[ $menuItemParentId ];
			} else {
				$wideMenuItemId = $this->getTopMenuItemId( $item, $depth, $args->menu );

				$menuItemConfig[ self::WIDE_MENU ]  =
					$this->navigationMenusUtil->getMenuItemOption( $wideMenuItemId, self::WIDE_MENU );
				$menuItemConfig[ self::NB_COLUMNS ] =
					(int) $this->navigationMenusUtil->getMenuItemOption( $wideMenuItemId, self::NB_COLUMNS );
			}

			$menuItemConfig['depth']            = $depth;
			$this->menuItemsConfig[ $item->ID ] = $menuItemConfig;

			if ( $depth < 1 ) {
				return $output;
			}

			if ( ! $menuItemConfig[ self::WIDE_MENU ]
			     || $menuItemConfig[ self::NB_COLUMNS ] < 1 ) {
				return $output;
			}

			$sidebar = $this->navigationMenusUtil->getMenuItemOption(
				$item->ID, NavigationMenusOption::CUSTOM_WIDGET_AREA );

			if ( $sidebar && is_registered_sidebar( $sidebar ) && is_active_sidebar( $sidebar ) ) {
				ob_start();
				dynamic_sidebar( $sidebar );
				$output .= ob_get_clean();
			}

			return $output;
		}

		/**
		 * @param string $menuId
		 * @param string $menuItemDbId
		 * @param array $args
		 */
		public function updateNavigationMenuItemOptions( $menuId, $menuItemDbId, $args ) {
			foreach ( NavigationMenusOption::getOptions() as $option ) {
				$fieldName = 'menu-item-' . str_replace( '_', '-', $option );
				$values    = isset( $_POST[ $fieldName ] ) ? $_POST[ $fieldName ] : array();
				$value     = isset( $values[ $menuItemDbId ] ) ? $values[ $menuItemDbId ] : '';

				$this->navigationMenusUtil->updateMenuItemOption(
					$menuItemDbId, $option, $this->dataSanitizer->sanitize( $value ) );
			}
		}

		/**
		 * @param object $menuItem
		 *
		 * @return object
		 */
		public function setupNavigationMenuItemOptions( $menuItem ) {
			foreach ( NavigationMenusOption::getOptions() as $option ) {
				$menuItem->{$option} = $this->navigationMenusUtil->getMenuItemOption( $menuItem->ID, $option );
			}

			return $menuItem;
		}

		/**
		 * @param string $title
		 * @param WP_Post $item
		 * @param object $args
		 * @param int $depth
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		public function applyAlternativeLabelsOptions( $title, $item, $args, $depth ) {
			static $originalLinkAfter = '';

			$originalLinkAfter = $args->link_after;

			if ( ! apply_filters( NavigationMenusFilterName::alternativeLabelsEnabled(), true, $args ) ) {
				return $title;
			}

			$util  = $this->navigationMenusUtil;
			$label = $util->getMenuItemOption( $item->ID, NavigationMenusOption::ALTERNATIVE_LABEL );

			if ( empty( $label ) ) {
				return $title;
			}

			$attributesToOptionsList = array(
				'color'            => NavigationMenusOption::ALTERNATIVE_LABEL_COLOR,
				'background-color' => NavigationMenusOption::ALTERNATIVE_LABEL_BACKGROUND_COLOR,
				'border-color'     => NavigationMenusOption::ALTERNATIVE_LABEL_BACKGROUND_COLOR
			);

			$styleAttributes = array();

			foreach ( $attributesToOptionsList as $attribute => $option ) {
				$value = $util->getMenuItemOption( $item->ID, $option );

				if ( ! empty( $value ) ) {
					$styleAttributes[] = sprintf( '%s: %s', esc_attr( $attribute ), esc_attr( $value ) );
				}
			}

			$labelStyle = empty( $styleAttributes ) ? '' : sprintf( 'style="%s"', implode( ';', $styleAttributes ) );
			$labelHtml  = sprintf( '<span class="menu-item-alt-label" %s>%s</span>', $labelStyle, esc_html( $label ) );

			$args->link_after .= $labelHtml;

			add_filter( 'walker_nav_menu_start_el', function ( $output, $item, $depth, $args ) use (
				&$originalLinkAfter
			) {
				// restore original link_after value
				$args->link_after = $originalLinkAfter;

				return $output;
			}, 1, 4 );

			return $title;
		}

		/**
		 * @param object $item
		 * @param int $depth
		 * @param WP_Term $menu
		 *
		 * @return int
		 */
		private function getTopMenuItemId( $item, $depth, $menu ) {
			if ( $depth === 0 ) {
				return $item->ID;
			} elseif ( $depth === 1 ) {
				return $item->menu_item_parent;
			}

			if ( empty( $this->menuItems ) ) {
				$menuItems = wp_get_nav_menu_items( $menu );

				foreach ( $menuItems as $menuItem ) {
					$this->menuItems[ $menuItem->ID ] = $menuItem;
				}
			}

			$menuItemParentId = $item->menu_item_parent;

			while ( $menuItemParentId ) {
				$menuItemParentId = $this->menuItems[ $menuItemParentId ]->menu_item_parent;
			}

			return $menuItemParentId;
		}
	}
}
