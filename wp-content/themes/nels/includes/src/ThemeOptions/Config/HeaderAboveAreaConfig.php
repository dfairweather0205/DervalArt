<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\HeaderAboveAreaConfig' ) ) {

	/**
	 * Class HeaderAboveAreaConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class HeaderAboveAreaConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$verticalSpacing       = sprintf( 'padding-top: %1$spx; padding-bottom: %1$spx', self::DELIMITER );
			$horizontalSpacing     = sprintf( 'border-right-width: %1$spx; border-left-width: %1$spx', self::DELIMITER );
			$borderBottomWidth     = sprintf( 'border-bottom-width: %spx;', self::DELIMITER );
			$siteNoticePlaceholder = esc_html__( 'Free shipping for all the products', 'nels' );
			$fontSizeProperty      = sprintf( 'font-size: %spx', self::DELIMITER );
			$fontWeightProperty    = sprintf( 'font-weight: %s', self::DELIMITER );
			$letterSpacingProperty = sprintf( 'letter-spacing: %spx', self::DELIMITER );


			return $this->controlConfigBuilder
				->checkbox( ThemeOption::HEADER_ABOVE_AREA_ENABLED )
				->defaultVal( 0 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				->description( esc_html__( '_the area is displayed right above Header', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'above_area_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_ABOVE_BACKGROUND )
				->defaultVal( '#2a2a2a' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.above-area'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_ABOVE_COLOR_SKIN )
				->defaultVal( 'light' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				->selectiveRefresh( '.above-area', 'header/above-area/above-area', true )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'above_area_spacing_title' )
				->label( esc_html__( 'Spacing (pixels)', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_ABOVE_SPACING_VERTICAL )
				->defaultVal( 9 )
				->description( esc_html__( '_top & bottom', 'nels' ) )
				->css( array(
					$verticalSpacing => array(
						'.site-notice',
						'#above-area-menu > .menu-item',
						'#social-above-area-menu li',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_ABOVE_SPACING_HORIZONTAL )
				->defaultVal( 0 )
				->description( esc_html__( '_left & right', 'nels' ) )
				->css( array(
					$horizontalSpacing => array(
						'.above-area__wrapper',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'above_area_border_bottom_title' )
				->label( esc_html__( 'Border bottom', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_ABOVE_BORDER_BOTTOM_COLOR )
				->defaultVal( '#e1e1e1' )
				->description( esc_html__( '_color', 'nels' ) )
				->css( array(
					'border-bottom-color' => array(
						'.above-area'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_ABOVE_BORDER_TOP_WIDTH )
				->defaultVal( 0 )
				->description( esc_html__( '_width (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->css( array(
					$borderBottomWidth => array(
						'.above-area'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'above_area_site_notice_title' )
				->label( esc_html__( 'Site Notice', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->textArea( ThemeOption::HEADER_ABOVE_SITE_NOTICE )
				->cssItem( '.site-notice' )
				->defaultVal( $siteNoticePlaceholder )
				->placeholder( $siteNoticePlaceholder )
				->htmlAllowed( true )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_ABOVE_SITE_NOTICE_FONT_SIZE )
				->defaultVal( 12 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'.site-notice'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_ABOVE_SITE_NOTICE_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					$fontWeightProperty => array(
						'.site-notice'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'above_area_menu_title' )
				->label( esc_html__( 'Menu', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_ABOVE_NAVIGATION_FONT_SIZE )
				->defaultVal( 13 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'#above-area-menu .menu-item a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_ABOVE_NAVIGATION_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					$fontWeightProperty => array(
						'#above-area-menu .menu-item a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_ABOVE_NAVIGATION_LETTER_SPACING )
				->defaultVal( 0 )
				->description( esc_html__( '_letter-spacing (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => - 5,
					'max'  => 5,
					'step' => 0.1
				) )
				->css( array(
					$letterSpacingProperty => array(
						'#above-area-menu .menu-item a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'above_area_social_menu_title' )
				->label( esc_html__( 'Social menu', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_ABOVE_NAVIGATION_SOCIAL_FONT_SIZE )
				->defaultVal( 14 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'#social-above-area-menu > li > a'
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