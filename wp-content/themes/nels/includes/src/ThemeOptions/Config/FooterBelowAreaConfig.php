<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\FooterBelowAreaConfig' ) ) {

	/**
	 * Class FooterBelowAreaConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class FooterBelowAreaConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$verticalSpacing      = sprintf( 'border-top-width: %1$spx; border-bottom-width: %1$spx', self::DELIMITER );
			$horizontalSpacing    = sprintf( 'border-right-width: %1$spx; border-left-width: %1$spx', self::DELIMITER );
			$borderTopWidth       = sprintf( 'border-top-width: %spx;', self::DELIMITER );
			$copyrightText        = esc_html__( 'All rights reserved', 'nels' );
			$copyrightDefaultVal  = sprintf( '&copy; %d <a href="%s" target="_blank">%s</a>. %s',
				date( 'Y' ), $this->themeUtil->getAuthorUri(), $this->themeUtil->getAuthor(), $copyrightText );
			$copyrightPlaceholder = sprintf( '&copy; %d %s. %s', date( 'Y' ),
				$this->themeUtil->getAuthor(), $copyrightText );
			$fontSizeProperty      = sprintf( 'font-size: %spx', self::DELIMITER );
			$fontWeightProperty    = sprintf( 'font-weight: %s', self::DELIMITER );
			$letterSpacingProperty = sprintf( 'letter-spacing: %spx', self::DELIMITER );


			return $this->controlConfigBuilder
				->checkbox( ThemeOption::FOOTER_BELOW_AREA_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				->description( esc_html__( '_the area is displayed right below Sidebar', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_below_area_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::FOOTER_BELOW_BACKGROUND )
				->defaultVal( '#252525' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.site-footer__meta'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::FOOTER_BELOW_COLOR_SKIN )
				->defaultVal( 'light' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				->selectiveRefresh( '.site-footer__meta', 'footer/below-area', true )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_below_area_spacing_title' )
				->label( esc_html__( 'Spacing (pixels)', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_BELOW_SPACING_VERTICAL )
				->defaultVal( 18 )
				->description( esc_html__( '_top & bottom', 'nels' ) )
				->css( array(
					$verticalSpacing => array(
						'.site-footer__meta__wrapper',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_BELOW_SPACING_HORIZONTAL )
				->defaultVal( 0 )
				->description( esc_html__( '_left & right', 'nels' ) )
				->css( array(
					$horizontalSpacing => array(
						'.site-footer__meta__wrapper',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_below_area_border_top_title' )
				->label( esc_html__( 'Border top', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::FOOTER_BELOW_BORDER_TOP_COLOR )
				->defaultVal( '#e1e1e1' )
				->description( esc_html__( '_color', 'nels' ) )
				->css( array(
					'border-top-color' => array(
						'.site-footer__meta'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_BELOW_BORDER_TOP_WIDTH )
				->defaultVal( 0 )
				->description( esc_html__( '_width (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->css( array(
					$borderTopWidth => array(
						'.site-footer__meta'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_below_area_copyright_title' )
				->label( esc_html__( 'Copyright Area', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->textArea( ThemeOption::FOOTER_BELOW_COPYRIGHT )
				->defaultVal( $copyrightDefaultVal )
				->placeholder( $copyrightPlaceholder )
				->cssItem( '.site-footer__meta__wrapper .copyright' )
				->htmlAllowed( true )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_BELOW_COPYRIGHT_FONT_SIZE )
				->defaultVal( 14 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'.copyright'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::FOOTER_BELOW_COPYRIGHT_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					$fontWeightProperty => array(
						'.copyright'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_below_area_menu_title' )
				->label( esc_html__( 'Menu', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_BELOW_NAVIGATION_FONT_SIZE )
				->defaultVal( 13 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'#footer-menu > .menu-item > a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::FOOTER_BELOW_NAVIGATION_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					$fontWeightProperty => array(
						'#footer-menu > .menu-item a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_BELOW_NAVIGATION_LETTER_SPACING )
				->defaultVal( 0 )
				->description( esc_html__( '_letter-spacing (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => - 5,
					'max'  => 5,
					'step' => 0.1
				) )
				->css( array(
					$letterSpacingProperty => array(
						'#footer-menu > .menu-item > a'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_below_area_social_menu_title' )
				->label( esc_html__( 'Social menu', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_BELOW_NAVIGATION_SOCIAL_FONT_SIZE )
				->defaultVal( 14 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'#social-footer-below-menu > li > a'
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