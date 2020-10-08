<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\LayoutConfig' ) ) {

	/**
	 * Class LayoutConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class LayoutConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			return $this->controlConfigBuilder
				->noInput( 'main_navigation_title' )
				->label( esc_html__( 'Main navigation', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::MAIN_NAVIGATION_TYPE )
				->defaultVal( 'side' )
				->description( esc_html__( '_type', 'nels' ) )
				->choices( array(
					'side'   => esc_html__( 'Logo Side', 'nels' ),
					'center' => esc_html__( 'Logo Center', 'nels' ),
					'top'    => esc_html__( 'Logo Top', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'site_width_title' )
				->label( esc_html__( 'Site width', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_WIDTH )
				->defaultVal( 1050 )
				->description( esc_html__( '_value (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->cssCallback( $this->getSiteWidthCallback() )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'fullwidth_title' )
				->label( esc_html__( 'Full width', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkboxMultiple( ThemeOption::LAYOUT_SITE_ELEMENTS )
				->choices( array(
					'header' => esc_html__( '_Site Header', 'nels' ),
					'footer' => esc_html__( '_Site Footer', 'nels' ),
				) )
				->build();
		}


		/**
		 * @return \Closure
		 */
		private function getSiteWidthCallback() {
			return function ( $option ) {
				$siteWidth = 'max-width: ' . intval( $option ) . 'px; width: 100%;';

				return array(
					$siteWidth => array(
						'.site-header__main__wrapper',
						'.above-area__wrapper',
						'.site-header__shop-tools__wrapper',
						'.site-search-area-inner',
						'.site-footer>*>*',
						'.entry-branding',
						'.entry-header',
						'.entry-content',
						'.entry-author',
						'.entry-meta',
						'.related-items__wrapper',
						'#comments',
						'.nav--single .nav__wrapper',
						'.entry-details',
					)
				);
			};
		}
	}
}