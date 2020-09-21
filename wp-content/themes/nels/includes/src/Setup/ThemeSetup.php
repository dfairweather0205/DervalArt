<?php

namespace Pikart\Nels\Setup;

use Pikart\Nels\Common\AssetHandle;
use Pikart\Nels\Site\NavigationMenu;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Common\CoreAssetHandle;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\ThemeOptions\GoogleFontsHelper;

if ( ! class_exists( __NAMESPACE__ . '\ThemeSetup' ) ) {

	/**
	 * Class ThemeSetup
	 * @package Pikart\Nels\Setup
	 */
	class ThemeSetup {

		const CONTENT_WIDTH = 1000;
		const MAX_SRC_SET_IMAGE_WIDTH = 8192;

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * @var GoogleFontsHelper
		 */
		private $googleFontsHelper;

		/**
		 * ThemeSetup constructor.
		 *
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 * @param Util $util
		 * @param GoogleFontsHelper $googleFontsHelper
		 */
		public function __construct(
			ThemeOptionsUtil $themeOptionsUtil,
			Util $util,
			GoogleFontsHelper $googleFontsHelper
		) {
			$this->themeOptionsUtil  = $themeOptionsUtil;
			$this->util              = $util;
			$this->googleFontsHelper = $googleFontsHelper;
		}

		public function run() {
			$this->setup();
			$this->enqueueScripts();
			$this->googleFontsHelper->enqueueGoogleFonts();
		}

		private function setup() {
			add_action( 'after_setup_theme', function () {
				if ( ! isset( $GLOBALS['content_width'] ) ) {
					$GLOBALS['content_width'] = ThemeSetup::CONTENT_WIDTH;
				}
			}, 0 );

			$addThemeSupportCallback = $this->addThemeSupportCallback();

			add_action( 'after_setup_theme', function () use ( $addThemeSupportCallback ) {

				// Make theme available for translation. Translations can be filed in the /languages/ directory.
				load_theme_textdomain( PIKART_THEME_SLUG, get_template_directory() . '/languages' );

				$addThemeSupportCallback();

				register_nav_menus( array(
					NavigationMenu::PRIMARY             => esc_html__( 'Primary', 'nels' ),
					NavigationMenu::SOCIAL_PRIMARY      => esc_html__( 'Social Primary', 'nels' ),
					NavigationMenu::ABOVE_MENU          => esc_html__( 'Above Menu', 'nels' ),
					NavigationMenu::SOCIAL_HEADER_ABOVE => esc_html__( 'Social Header Above', 'nels' ),
					NavigationMenu::FOOTER_MENU         => esc_html__( 'Footer Menu', 'nels' ),
					NavigationMenu::SOCIAL_FOOTER_BELOW => esc_html__( 'Social Footer Below', 'nels' ),
				) );
			} );

			add_filter( 'max_srcset_image_width', function () {
				return ThemeSetup::MAX_SRC_SET_IMAGE_WIDTH;
			} );
		}

		private function enqueueScripts() {
			add_action( 'wp_enqueue_scripts', function () {

				wp_enqueue_style( AssetHandle::themeStyle() );
				wp_enqueue_script( AssetHandle::customScript() );

				if ( is_rtl() ) {
					wp_enqueue_style( AssetHandle::themeRtlStyle() );
				}

				if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
					wp_enqueue_script( 'comment-reply' );
				}

				wp_enqueue_style( CoreAssetHandle::fontAwesome() );
			} );
		}

		private function addThemeSupportCallback() {
			return function () {

				add_editor_style();
				add_theme_support( 'title-tag' );
				add_theme_support( 'custom-logo' );

				add_theme_support( 'custom-header', array(
					'default-image'          => '',
					'width'                  => 1200,
					'height'                 => 1200,
					'flex-height'            => true,
					'flex-width'             => true,
					'header-text'            => true,
					'default-text-color'     => '#ffffff',
				) );
				add_theme_support( 'custom-background', array(
					'default-color'          => '#ffffff',
					'default-repeat'         => 'no-repeat',
					'default-position-x'     => 'center',
					'default-position-y'     => 'center',
					'default-size'           => 'cover',
					'default-attachment'     => 'fixed',
				) );

				// Add default posts and comments RSS feed links to head.
				add_theme_support( 'automatic-feed-links' );
				add_theme_support( 'post-thumbnails' );

				add_theme_support( 'align-wide' );

				add_theme_support(
					'post-formats',
					array( 'gallery', 'image', 'quote', 'video', 'audio', 'link', 'aside' )
				);

				add_theme_support(
					'html5',
					array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'widgets' )
				);
			};
		}
	}
}