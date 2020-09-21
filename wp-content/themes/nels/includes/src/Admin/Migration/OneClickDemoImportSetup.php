<?php

namespace Pikart\Nels\Admin\Migration;

use Pikart\WpThemeCore\Admin\Migration\MigrationConfig;
use Pikart\WpThemeCore\Common\ThemePathsUtil;

if ( ! class_exists( __NAMESPACE__ . '\OneClickDemoImportSetup' ) ) {

	/**
	 * Class OneClickDemoImportSetup
	 * @package Pikart\Nels\Admin\Migration
	 *
	 * @since 1.0.2
	 */
	class OneClickDemoImportSetup {

		const DEMO_NAME_PATTERN = '%s Demo %s';
		const DEMO_PATH_PATTERN = 'demos/demo-%s/';
		const DEMO_COVERS_PATH_PATTERN = 'assets/images/nels/demo-covers/cover-%s.jpg';
		const DEMO_XML_FILE_PATTERN = 'demo-%s.xml';
		const DEMO_WIDGETS_FILE_PATTERN = 'widgets-%s.wie';
		const DEMO_THEME_OPTIONS_FILE_PATTERN = 'theme-options-%s.dat';
		const DEMO_PIKART_BASE_OPTIONS_FILE_PATTERN = 'pikart-base-options-%s.dat';

		/**
		 * @return array
		 */
		public function getDemoFilesConfig() {
			$demos = array(
				'main',
				'furniture',
				'interior',
				'fashion',
				'sportswear',
				'winery',
				'footwear',
				'minimalist',
				'lookbook',
				'modern-furniture',
				'clothing',
				'main-RTL'
			);

			$demosConfig = array();

			foreach ( $demos as $index => $demo ) {
				$demoNb         = str_pad( $index + 1, 2, "0", STR_PAD_LEFT );
				$demoPath       = ThemePathsUtil::getResourcesDir( sprintf( self::DEMO_PATH_PATTERN, $demoNb ) );
				$xmlFile        = sprintf( self::DEMO_XML_FILE_PATTERN, $demoNb );
				$widgetFile     = sprintf( self::DEMO_WIDGETS_FILE_PATTERN, $demoNb );
				$customizerFile = sprintf( self::DEMO_THEME_OPTIONS_FILE_PATTERN, $demoNb );
				$coverFile      = sprintf( self::DEMO_COVERS_PATH_PATTERN, $demoNb );
				$pikartBaseFile = sprintf( self::DEMO_PIKART_BASE_OPTIONS_FILE_PATTERN, $demoNb );
				$demoName       = sprintf( self::DEMO_NAME_PATTERN,
					ucwords( str_replace( '-', ' ', $demo ) ), $demoNb );


				$demosConfig[] = array(
					'import_file_name'                               => $demoName,
					'local_import_file'                              => $demoPath . $xmlFile,
					'local_import_widget_file'                       => $demoPath . $widgetFile,
					'local_import_customizer_file'                   => $demoPath . $customizerFile,
					MigrationConfig::PIKART_BASE_OPTIONS_IMPORT_FILE => $demoPath . $pikartBaseFile,
					'import_preview_image_url'                       => PIKARTHOUSE_URL . $coverFile,
					'import_notice'                                  => esc_html__( 'Be sure to have activated all the required and recommended plugins. After you import this demo, you will have to setup Sliders and Contact Forms separately.', 'nels' ),
					'preview_url'                                    => sprintf( '%s%s/', PIKART_NELS_URL, $demo )
				);
			}

			return $demosConfig;
		}

		public function updateNavigationMenuLocations() {
			$menuSlugs     = array_keys( get_registered_nav_menus() );
			$menuLocations = array();

			foreach ( $menuSlugs as $slug ) {
				$menu = wp_get_nav_menu_object( str_replace( '_', '-', $slug ) );

				if ( $menu ) {
					$menuLocations[ $slug ] = $menu->term_id;
				}
			}

			set_theme_mod( 'nav_menu_locations', $menuLocations );
		}

		public function updatePageOptions() {
			update_option( 'show_on_front', 'page' );

			$optionIdToPageSlug = array(
				'page_on_front'                 => 'home',
				'page_for_posts'                => 'blog',
				'woocommerce_shop_page_id'      => 'shop',
				'woocommerce_cart_page_id'      => 'cart',
				'woocommerce_checkout_page_id'  => 'checkout',
				'woocommerce_myaccount_page_id' => 'my-account',
				'woocommerce_terms_page_id'     => 'terms',
				'wp_page_for_privacy_policy'    => 'privacy-policy'
			);

			foreach ( $optionIdToPageSlug as $optionId => $pageSlug ) {
				$page = get_page_by_path( $pageSlug );

				if ( ! $page && $pageSlug === 'home' ) {
					$page = get_page_by_path( 'shop' );
				}

				if ( $page ) {
					update_option( $optionId, $page->ID );
				}
			}
		}
	}
}