<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\HeaderMenuConfig' ) ) {

	/**
	 * Class HeaderMenuConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class HeaderMenuConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$fontSizeProperty      = sprintf( 'font-size: %spx', self::DELIMITER );
			$fontWeightProperty    = sprintf( 'font-weight: %s', self::DELIMITER );
			$letterSpacingProperty = sprintf( 'letter-spacing: %spx', self::DELIMITER );
			$verticalSpacing       = sprintf( 'padding-top: %1$spx; padding-bottom: %1$spx', self::DELIMITER );

			return $this->controlConfigBuilder
				->noInput( 'header_main_menu_title' )
				->label( esc_html__( 'Main menu', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_HEADER_NAVIGATION_VERTICAL_SPACING )
				->defaultVal( 24 )
				->description( esc_html__( '_top & bottom spacing', 'nels' ) )
				->css( array(
					$verticalSpacing => array(
						'.site-header__main #primary-menu > .menu-item',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_LOGO_SIDE_MENU_POSITION )
				->defaultVal( 'right' )
				->description( esc_html__( '_position (valid for Logo Side)', 'nels' ) )
				->choices( array(
					'left'   => esc_html__( 'Left', 'nels' ),
					'center' => esc_html__( 'Center', 'nels' ),
					'right'  => esc_html__( 'Right', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_HEADER_NAVIGATION_FONT_SIZE )
				->defaultVal( 13 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'.site-header__main #primary-menu > .menu-item > a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SITE_HEADER_NAVIGATION_FONT_WEIGHT )
				->defaultVal( 500 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					$fontWeightProperty => array(
						'.site-header__main #primary-menu > .menu-item > a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_HEADER_NAVIGATION_LETTER_SPACING )
				->defaultVal( 0 )
				->description( esc_html__( '_letter-spacing (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => - 5,
					'max'  => 5,
					'step' => 0.1
				) )
				->css( array(
					$letterSpacingProperty => array(
						'.site-header__main #primary-menu > .menu-item > a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_submenus_title' )
				->label( esc_html__( 'Submenus', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_SUBMENU_BACKGROUND_COLOR )
				->defaultVal( '#252525' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.site-header__main #primary-menu .submenu'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_SUBMENU_COLOR_SKIN )
				->defaultVal( 'light' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_HEADER_NAVIGATION_SUBMENU_FONT_SIZE )
				->defaultVal( 13 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'.site-header__main #primary-menu .submenu .menu-item > a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SITE_HEADER_NAVIGATION_SUBMENU_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					$fontWeightProperty => array(
						'.site-header__main #primary-menu .submenu .menu-item > a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_HEADER_NAVIGATION_SUBMENU_LETTER_SPACING )
				->defaultVal( 0 )
				->description( esc_html__( '_letter-spacing (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => - 5,
					'max'  => 5,
					'step' => 0.1
				) )
				->css( array(
					$letterSpacingProperty => array(
						'.site-header__main #primary-menu .submenu .menu-item > a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_social_menu_title' )
				->label( esc_html__( 'Social menu', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_HEADER_NAVIGATION_SOCIAL_FONT_SIZE )
				->defaultVal( 18 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'.site-header__main #social-primary-menu > li > a'
					),
				) )
				->build();
		}

		/**
		 * @return array
		 */
		private function getFontWeightList() {
			return array(
				100 => '100 Thin',
				200 => '200 Extra Light',
				300 => '300 Light',
				400 => '400 Normal',
				500 => '500 Medium',
				600 => '600 Semi Bold',
				700 => '700 Bold',
				800 => '800 Extra Bold',
				900 => '900 Black',
			);
		}
	}
}