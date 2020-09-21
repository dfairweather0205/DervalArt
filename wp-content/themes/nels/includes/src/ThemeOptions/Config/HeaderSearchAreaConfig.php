<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\HeaderSearchAreaConfig' ) ) {

	/**
	 * Class HeaderSearchAreaConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class HeaderSearchAreaConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$fontSizeProperty = sprintf( 'font-size: %spx', self::DELIMITER );

			return $this->controlConfigBuilder
				->checkbox( ThemeOption::HEADER_SEARCH_AREA_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				->description( esc_html__( '_enable Search Area for Site Header', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_search_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::HEADER_SEARCH_AREA_BACKGROUND_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.site-search-area'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_SEARCH_AREA_COLOR_SKIN )
				->defaultVal( 'dark' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->transportTypePostMessage()
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'header_search_behaviour_title' )
				->label( esc_html__( 'Behaviour', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::HEADER_SEARCH_AREA_TYPE )
				->defaultVal( 'fullscreen' )
				->description( esc_html__( '_type', 'nels' ) )
				->choices( array(
					'above'      => esc_html__( 'Covering header', 'nels' ),
					'fullscreen' => esc_html__( 'Fullscreen', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->text( ThemeOption::HEADER_SEARCH_AREA_TEXT )
				->label( esc_html__( 'Text field', 'nels' ) )
				->defaultVal( esc_html__( 'Enter your keywords', 'nels' ) )
				->description( esc_html__( '_type the search field "label" text', 'nels' ) )
				->placeholder( esc_html__( 'Search Label Text', 'nels' ) )
				->transportTypePostMessage()
				->htmlAttributes( array(
					'placeholder' => array( '.search-form__input' )
				) )
				->build();
		}
	}
}