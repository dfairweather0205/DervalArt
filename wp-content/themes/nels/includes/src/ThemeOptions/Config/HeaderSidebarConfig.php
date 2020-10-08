<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\HeaderSidebarConfig' ) ) {

	/**
	 * Class HeaderSidebarConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class HeaderSidebarConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$widthProperty     = sprintf( 'width: %spx', self::DELIMITER );
			$verticalSpacing   = sprintf( 'padding-top: %1$spx; padding-bottom: %1$spx', self::DELIMITER );
			$horizontalSpacing = sprintf( 'padding-right: %1$spx; padding-left: %1$spx', self::DELIMITER );

			return $this->controlConfigBuilder
				->checkbox( ThemeOption::HEADER_SIDEBAR_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				->description( esc_html__( '_for displaying Widgets', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_top_sidebar_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_SIDEBAR_BACKGROUND )
				->defaultVal( '#252525' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.sidebar--site-header'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_SIDEBAR_COLOR_SKIN )
				->defaultVal( 'light' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_top_sidebar_spacing_title' )
				->label( esc_html__( 'Spacing (pixels)', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_SIDEBAR_WIDTH )
				->defaultVal( 330 )
				->description( esc_html__( '_width', 'nels' ) )
				->css( array(
					$widthProperty => array(
						'.sidebar--site-header'
					),
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_SIDEBAR_SPACING_VERTICAL )
				->defaultVal( 30 )
				->description( esc_html__( '_top & bottom', 'nels' ) )
				->css( array(
					$verticalSpacing => array(
						'.sidebar--site-header__wrapper',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::HEADER_SIDEBAR_SPACING_HORIZONTAL )
				->defaultVal( 30 )
				->description( esc_html__( '_left & right', 'nels' ) )
				->css( array(
					$horizontalSpacing => array(
						'.sidebar--site-header__wrapper',
						'.sidebar--site-header__heading',
					)
				) )
				->transportTypeRefresh()
				// -------------------------------------------------------------------------------------------------- \\
				->text( ThemeOption::HEADER_SIDEBAR_TITLE )
				->label( esc_html__( 'Title', 'nels' ) )
		        ->defaultVal( 'Sidebar Title' )
				->description( esc_html__( '_enter the title for Sidebar', 'nels' ) )
				->placeholder( esc_html__( 'Sidebar Title', 'nels' ) )
				->selectiveRefresh( '.sidebar--site-header', 'header/sidebar/inner-content' )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_sidebar_menu_icon_title' )
				->label( esc_html__( 'Menu icon', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_SIDEBAR_MENU_ICON )
				->defaultVal( 'small' )
				->description( esc_html__( '_size', 'nels' ) )
				->choices( array(
					'small'  => esc_html__( 'Small', 'nels' ),
					'medium' => esc_html__( 'Medium', 'nels' ),
					'large'  => esc_html__( 'Large', 'nels' ),
				) )
				->build();

		}
	}
}