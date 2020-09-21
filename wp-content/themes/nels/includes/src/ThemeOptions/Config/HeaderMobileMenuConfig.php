<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\HeaderMobileMenuConfig' ) ) {

	/**
	 * Class HeaderMobileMenuConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class HeaderMobileMenuConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			return $this->controlConfigBuilder
				->noInput( 'header_mobile_menu_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_MOBILE_MENU_BACKGROUND_COLOR )
				->defaultVal( '#252525' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.mobile-navigation'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_MOBILE_MENU_COLOR_SKIN )
				->defaultVal( 'light' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				->build();
		}
	}
}