<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\FooterSidebarConfig' ) ) {

	/**
	 * Class FooterSidebarConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class FooterSidebarConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$verticalSpacing   = sprintf( 'border-top-width: %1$spx; border-bottom-width: %1$spx', self::DELIMITER );
			$horizontalSpacing = sprintf( 'border-right-width: %1$spx; border-left-width: %1$spx', self::DELIMITER );
			$borderTopWidth    = sprintf( 'border-top-width: %spx;', self::DELIMITER );
			$util              = $this->util;

			return $this->controlConfigBuilder
				->checkbox( ThemeOption::FOOTER_SIDEBAR_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				->description( esc_html__( '_for displaying Widgets', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_sidebar_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::FOOTER_SIDEBAR_BACKGROUND )
				->defaultVal( '#262930' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.sidebar--site-footer .color-overlay'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_SIDEBAR_BACKGROUND_TRANSPARENCY )
				->defaultVal( 0 )
				->description( esc_html__( '_background transparency (%)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
					'max' => 100,
				) )
				->cssCallback( function ( $option ) use ( $util ) {
					$transparencyProperty = 'opacity: ' . $util->transparencyToOpacity( $option );

					return array(
						$transparencyProperty => array(
							'.sidebar--site-footer .color-overlay'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::FOOTER_SIDEBAR_COLOR_SKIN )
				->defaultVal( 'light' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				->selectiveRefresh( '.sidebar--site-footer', 'footer/sidebar', true )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_sidebar_spacing_title' )
				->label( esc_html__( 'Spacing (pixels)', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_SIDEBAR_SPACING_VERTICAL )
				->defaultVal( 0 )
				->description( esc_html__( '_top & bottom', 'nels' ) )
				->css( array(
					$verticalSpacing => array(
						'.sidebar--site-footer__wrapper',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_SIDEBAR_SPACING_HORIZONTAL )
				->defaultVal( 0 )
				->description( esc_html__( '_left & right', 'nels' ) )
				->css( array(
					$horizontalSpacing => array(
						'.sidebar--site-footer__wrapper',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_sidebar_border_top_title' )
				->label( esc_html__( 'Border top', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::FOOTER_SIDEBAR_BORDER_TOP_COLOR )
				->defaultVal( '#e1e1e1' )
				->description( esc_html__( '_color', 'nels' ) )
				->css( array(
					'border-top-color' => array(
						'.sidebar--site-footer'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FOOTER_SIDEBAR_BORDER_TOP_WIDTH )
				->defaultVal( 0 )
				->description( esc_html__( '_width (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->css( array(
					$borderTopWidth => array(
						'.sidebar--site-footer'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->image( ThemeOption::FOOTER_SIDEBAR_BACKGROUND_IMAGE )
				->label( esc_html__( 'Background Image', 'nels' ) )
				->selectiveRefresh( '.featured-branding__background', 'featured-branding/background' )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'footer_sidebar_columns_title' )
				->label( esc_html__( 'Columns', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::FOOTER_SIDEBAR_NB_COLUMNS )
				->defaultVal( 4 )
				->description( esc_html__( '_number', 'nels' ) )
				->selectiveRefresh( '.sidebar--site-footer-inner', 'footer/dynamic-sidebars' )
				->choices( array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
				) )
				->build();
		}
	}
}