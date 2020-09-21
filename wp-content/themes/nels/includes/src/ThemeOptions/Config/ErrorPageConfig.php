<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\ErrorPageConfig' ) ) {

	/**
	 * Class ErrorPageConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ErrorPageConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {

			$errorSelector = '#error-404';
			$errorPartial  = '404-content';

			return $this->controlConfigBuilder
				->noInput( 'error_page_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::ERROR_PAGE_COLOR_SKIN )
				->defaultVal( 'light' )
				->description( esc_html__( '_color skin', 'nels' ) )
				->choices( array(
					'light' => esc_html__( 'Light', 'nels' ),
					'dark'  => esc_html__( 'Dark', 'nels' ),
				) )
				->selectiveRefresh( $errorSelector, $errorPartial, true )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'error_page_elements_title' )
				->label( esc_html__( 'Elements', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->text( ThemeOption::ERROR_PAGE_TITLE )
				->defaultVal( 'Error 404' )
				->description( esc_html__( '_title', 'nels' ) )
				->placeholder( esc_html__( 'Error 404', 'nels' ) )
				->selectiveRefresh( $errorSelector, $errorPartial, true )
				// -------------------------------------------------------------------------------------------------- \\
				->text( ThemeOption::ERROR_PAGE_SUBTITLE )
				->description( esc_html__( '_subtitle', 'nels' ) )
				->placeholder( esc_html__( 'Oops, this page can&rsquo;t be found', 'nels' ) )
				->selectiveRefresh( $errorSelector, $errorPartial, true )
				// -------------------------------------------------------------------------------------------------- \\
				->textArea( ThemeOption::ERROR_PAGE_TEXT )
				->description( esc_html__( '_description', 'nels' ) )
				->placeholder(
					esc_html__( 'The link might be corrupted or the page may have been removed', 'nels' ) )
				->selectiveRefresh( $errorSelector, $errorPartial, true )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'error_page_elements_button_title' )
				->label( esc_html__( '_button', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->text( ThemeOption::ERROR_PAGE_BUTTON_LABEL )
				->description( esc_html__( '_label', 'nels' ) )
				->placeholder( esc_html__( 'Button label', 'nels' ) )
				->selectiveRefresh( $errorSelector, $errorPartial, true )
				// -------------------------------------------------------------------------------------------------- \\
				->url( ThemeOption::ERROR_PAGE_BUTTON_LINK )
				->description( esc_html__( '_link', 'nels' ) )
				->placeholder( esc_html__( 'Button link', 'nels' ) )
				->selectiveRefresh( $errorSelector, $errorPartial, true )
				->build();
		}
	}
}