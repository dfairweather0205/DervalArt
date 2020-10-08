<?php

namespace Pikart\WpBase\NavigationMenus;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpCore\Admin\Media\MediaFilter;

if ( ! class_exists( __NAMESPACE__ . '\\NavigationMenusFacade' ) ) {

	/**
	 * Class NavigationMenusFacade
	 * @package Pikart\WpBase\Admin\NavigationMenus
	 *
	 * @since 1.1.0
	 */
	class NavigationMenusFacade {

		/**
		 * @var NavigationMenusHelper
		 */
		private $navigationMenusHelper;

		/**
		 * NavigationMenusFacade constructor.
		 *
		 * @param NavigationMenusHelper $navigationMenusHelper
		 */
		public function __construct( NavigationMenusHelper $navigationMenusHelper ) {
			$this->navigationMenusHelper = $navigationMenusHelper;
		}

		public function manageNavigationMenus() {
			add_filter( 'nav_menu_css_class', array( $this->navigationMenusHelper, 'setupMenuItemCssClasses' ), 10, 4 );

			add_filter( 'walker_nav_menu_start_el',
				array( $this->navigationMenusHelper, 'setupCustomWidgetAreaGeneration' ), 10, 4 );

			add_action( 'wp_update_nav_menu_item',
				array( $this->navigationMenusHelper, 'updateNavigationMenuItemOptions' ), 10, 3 );

			add_filter( 'wp_setup_nav_menu_item',
				array( $this->navigationMenusHelper, 'setupNavigationMenuItemOptions' ) );

			add_filter( 'wp_edit_nav_menu_walker', function () {
				return '\Pikart\WpBase\NavigationMenus\CustomWalkerNavMenuEdit';
			} );

			add_action( 'admin_enqueue_scripts', function ( $hook ) {
				if ( $hook !== 'nav-menus.php' ) {
					return;
				}

				wp_enqueue_script( AssetHandle::adminNavigationMenus() );
				wp_enqueue_style( AssetHandle::adminNavigationMenusStyle() );
			} );

			add_filter( MediaFilter::customGalleryImageHooks(), function ( $hooks ) {
				$hooks[] = 'nav-menus.php';

				return $hooks;
			} );

			/**
			 * @since 1.4.0
			 */
			add_filter( 'nav_menu_item_title',
				array( $this->navigationMenusHelper, 'applyAlternativeLabelsOptions' ), 999, 4 );
		}
	}
}
