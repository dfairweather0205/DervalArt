<?php

namespace Pikart\Nels\Site;

use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Admin\Sidebars\SidebarFilterName;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! class_exists( __NAMESPACE__ . '\SidebarCustomizer' ) ) {

	/**
	 * Class SidebarCustomizer
	 * @package Pikart\Nels\Site
	 */
	class SidebarCustomizer {

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * SidebarCustomizer constructor.
		 *
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 */
		public function __construct( ThemeOptionsUtil $themeOptionsUtil ) {
			$this->themeOptionsUtil = $themeOptionsUtil;
		}

		public function customize() {
			$this->registerSidebar( SidebarId::archive(), esc_html__( 'Archive Sidebar', 'nels' ) );
			$this->registerSidebar( SidebarId::header(), esc_html__( 'Header Sidebar', 'nels' ) );
			$this->registerSidebar( SidebarId::content(), esc_html__( 'Inner Content Sidebar', 'nels' ) );
			$this->registerFooterSidebars();
			$this->setupCustomSidebarArguments();
			if ( ShopUtil::isShopActivated() ) {
				$this->registerSidebar( SidebarId::shopFilter(), esc_html__( 'Shop Filter Sidebar', 'nels' ) );
			}

			add_filter( 'sidebars_widgets', function ( $sidebarsWidgets ) {
				foreach ( $sidebarsWidgets as &$widgets ) {
					if ( ! is_array( $widgets ) ) {
						$widgets = array();
					}
				}

				return $sidebarsWidgets;
			} );
		}

		private function registerFooterSidebars() {
			$columnText = esc_html__( 'Footer Sidebar Column %d', 'nels' );
			$nbColumns  = $this->themeOptionsUtil->getFooterSidebarNbColumns();

			//register all footer sidebars, in order for them to be available when customizing the footer sidebar area
			for ( $count = 1; $count <= $nbColumns; $count ++ ) {
				$this->registerSidebar( SidebarId::footer( $count ), sprintf( $columnText, $count ) );
			}
		}

		private function registerSidebar( $id, $name ) {
			$sidebarDefaultArguments = $this->getSidebarDefaultArguments();
			$themeOptionsUtil        = $this->themeOptionsUtil;

			add_action( 'widgets_init', function () use ( $id, $name, $sidebarDefaultArguments, $themeOptionsUtil ) {
				$sidebarDefaultArguments['id']   = $id;
				$sidebarDefaultArguments['name'] = $name;

				$sidebarsToCheck = array(
					SidebarId::header()  => ThemeOption::HEADER_SIDEBAR_ENABLED,
					SidebarId::archive() => ThemeOption::ARCHIVE_SIDEBAR_ENABLED
				);

				//do not register the sidebars if disabled in theme options
				if ( isset ( $sidebarsToCheck[ $id ] )
				     && ! $themeOptionsUtil->getBoolOption( $sidebarsToCheck[ $id ], true ) ) {
					return;
				}


				register_sidebar( $sidebarDefaultArguments );
			} );
		}

		private function setupCustomSidebarArguments() {
			$sidebarDefaultArguments = $this->getSidebarDefaultArguments();

			add_filter( SidebarFilterName::customSidebarArguments(),
				function ( $arguments ) use ( $sidebarDefaultArguments ) {
					return array_merge( $arguments, $sidebarDefaultArguments );
				}
			);
		}

		private function getSidebarDefaultArguments() {
			return array(
				'description'   => esc_html__( 'Add widgets here.', 'nels' ),
				'before_widget' => '<section id="%1$s" class="widget__item %2$s"><div class="widget__item__wrapper">',
				'after_widget'  => '</div></section>',
				'before_title'  => '<h5 class="widget__item__title">',
				'after_title'   => '</h5>',
			);
		}
	}

}