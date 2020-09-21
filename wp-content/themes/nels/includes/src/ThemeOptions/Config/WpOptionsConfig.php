<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsCssFilter;
use Pikart\WpThemeCore\ThemeOptions\WpOption;

if ( ! class_exists( __NAMESPACE__ . '\WpOptionsConfig' ) ) {

	/**
	 * Class WpOptionsConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class WpOptionsConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			return $this->controlConfigBuilder
				->builtInControl( WpOption::BLOG_NAME )
				->cssItem( '.site-title' )
				// -------------------------------------------------------------------------------------------------- \\
				->builtInControl( WpOption::BLOG_DESCRIPTION )
				// -------------------------------------------------------------------------------------------------- \\
				->builtInControl( WpOption::HEADER_TEXT_COLOR )
				->defaultVal( get_theme_support( 'custom-header', 'default-text-color' ) )
				->cssFilter( ThemeOptionsCssFilter::COLOR )
				->css( array(
					'background-color' => array(
						'.featured-branding .branding__meta__item:before',
					),
					'color' => array(
						'.featured-branding .branding__title',
						'.featured-branding .branding__meta__item',
						'.featured-branding .branding__meta__item a',
						'.featured-branding .nav--breadcrumbs .breadcrumbs li > *',
						'.featured-branding .nav--breadcrumbs .breadcrumbs li:before',
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->builtInControl( WpOption::WP_BACKGROUND_COLOR )
				->defaultVal( get_theme_support( 'custom-background', 'default-color' ) )
				->cssFilter( ThemeOptionsCssFilter::COLOR )
				->build();
		}

	}
}