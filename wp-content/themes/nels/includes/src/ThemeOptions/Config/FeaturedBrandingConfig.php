<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\FeaturedBrandingConfig' ) ) {

	/**
	 * Class FeaturedBrandingConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class FeaturedBrandingConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$heightProperty = sprintf( 'height: %svh', self::DELIMITER );
			$util           = $this->util;

			return $this->controlConfigBuilder
				->checkbox( ThemeOption::FEATURED_BRANDING_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				->description( esc_html__( '_it automatically disables default branding', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'featured_brandind_color_style_title' )
				->label( esc_html__( 'Color style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::FEATURED_BRANDING_OVERLAY_COLOR )
				->defaultVal( '#636363' )
				->description( esc_html__( '_overlay color', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.featured-branding .color-overlay'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FEATURED_BRANDING_OVERLAY_TRANSPARENCY )
				->defaultVal( 0 )
				->description( esc_html__( '_overlay transparency (%)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
					'max' => 100,
				) )
				->cssCallback( function ( $option ) use ( $util ) {
					$transparencyProperty = 'opacity: ' . $util->transparencyToOpacity( $option );

					return array(
						$transparencyProperty => array(
							'.featured-branding .color-overlay'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'featured_branding_spacing_title' )
				->label( esc_html__( 'Spacing', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::FEATURED_BRANDING_HEIGHT )
				->defaultVal( 50 )
				->description( esc_html__( '_height (%)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
					'max' => 100,
				) )
				->css( array(
					$heightProperty => array(
						'.featured-branding .featured-branding-inner'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::FEATURED_BRANDING_PARALLAX )
				->defaultVal( 1 )
				->label( esc_html__( 'Parallax', 'nels' ) )
				->description( esc_html__( '_applied to Header Image', 'nels' ) )
				->build();
		}
	}
}