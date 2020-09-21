<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\SidebarConfig' ) ) {

	/**
	 * Class SidebarConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class SidebarConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$floatProperty = 'float: ' . self::DELIMITER;

			return $this->controlConfigBuilder
				->checkbox( ThemeOption::CONTENT_SIDEBAR_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				->description( esc_html__( '_for displaying Widgets', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'content_sidebar_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::CONTENT_SIDEBAR_COLOR_SKIN )
				->defaultVal( 'dark' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				->selectiveRefresh( '.sidebar--site-content', 'main-sidebar', true )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'content_sidebar_spacing_title' )
				->label( esc_html__( 'Spacing', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::CONTENT_SIDEBAR_WIDTH )
				->defaultVal( '1/3' )
				->description( esc_html__( '_width', 'nels' ) )
				->choices( array(
					'1/4' => '1/4',
					'1/3' => '1/3',
					'1/2' => '1/2',
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::CONTENT_SIDEBAR_POSITION )
				->defaultVal( 'right' )
				->description( esc_html__( '_position', 'nels' ) )
				->choices( array(
					'left'  => esc_html__( 'Left', 'nels' ),
					'right' => esc_html__( 'Right', 'nels' ),
				) )
				->css( array(
					$floatProperty => array(
						'.sidebar--site-content'
					),
				) )
				->transportTypeRefresh()
				->build();
		}
	}
}