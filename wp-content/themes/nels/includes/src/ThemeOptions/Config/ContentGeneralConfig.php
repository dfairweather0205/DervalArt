<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\ContentGeneralConfig' ) ) {

	/**
	 * Class ContentGeneralConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ContentGeneralConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$util = $this->util;

			$fontSizeProperty      = sprintf( 'font-size: %spx', self::DELIMITER );
			$fontWeightProperty    = sprintf( 'font-weight: %s', self::DELIMITER );
			$letterSpacingProperty = sprintf( 'letter-spacing: %spx', self::DELIMITER );
			$textTransformProperty = sprintf( 'text-transform: %s', self::DELIMITER );

			return $this->controlConfigBuilder
				->checkbox( ThemeOption::CONTENT_SITE_HEADER_TRANSPARENCY )
				->defaultVal( 0 )
				->label( esc_html__( 'Site Header transparency', 'nels' ) )
				->description( esc_html__( '_if enabled, the Site Header is transparent', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::CONTENT_BREADCRUMBS )
				->defaultVal( 1 )
				->label( esc_html__( 'Breadcrumbs', 'nels' ) )
				->description( esc_html__( '_as secondary site navigation', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'Archive_pages_title' )
				->label( esc_html__( 'Archive Pages', 'nels' ) )
				->description( esc_html__( '_Search, Categories, Tags & any archive page', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::ARCHIVE_DISPLAY )
				->defaultVal( 'default' )
				->description( esc_html__( '_display type', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getDisplayTypes() )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::ARCHIVE_SKIN_TRANSPARENCY )
				->defaultVal( 15 )
				->description( esc_html__( '_*hover color transparency (%)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
					'max' => 100,
				) )
				->cssCallback( function ( $option ) use ( $util ) {
					$transparencyProperty = 'opacity: ' . $util->transparencyToOpacity( $option );

					return array(
						$transparencyProperty => array(
							'body.blog .color-overlay-inner',
							'body.archive .color-overlay-inner',
							'body.search .color-overlay-inner',
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::ARCHIVE_COLUMNS_NUMBER )
				->defaultVal( 2 )
				->description( esc_html__( '_columns number', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getItemColumnsNumber() )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::ARCHIVE_COLUMNS_SPACING )
				->defaultVal( 36 )
				->description( esc_html__( '_columns spacing (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->cssCallback( function ( $option ) {
					$paddingsProperty = sprintf( 'padding-right: %1$dpx; padding-bottom: %1$dpx;', $option );
					$marginsProperty  = sprintf( 'margin-right: %dpx;', - $option );

					return array(
						$paddingsProperty => array(
							'.archive-list--main .archive-items .card'
						),
						$marginsProperty  => array(
							'.archive-list--main .archive-items'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'Archive_sidebar' )
				->label( esc_html__( 'Archive Sidebar', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::ARCHIVE_SIDEBAR_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				->description( esc_html__( '_for displaying Widgets on Archive Pages (Search Page, Categories Page etc)', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'Related_items_title' )
				->label( esc_html__( 'Related Items', 'nels' ) )
				->description( esc_html__( '_Related Posts, Projects & Products', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::RELATED_ITEMS_BACKGROUND_COLOR )
				->defaultVal( '#f2f2f2' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.related-items'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'Categories_filter_title' )
				->label( esc_html__( 'Categories filter', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::CATEGORIES_FILTER_FONT_SIZE )
				->defaultVal( 14 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'.archive-filter__item'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::CATEGORIES_FILTER_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					$fontWeightProperty => array(
						'.archive-filter__item'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::CATEGORIES_FILTER_LETTER_SPACING )
				->defaultVal( 0 )
				->description( esc_html__( '_letter-spacing (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => - 5,
					'max'  => 5,
					'step' => 0.1
				) )
				->css( array(
					$letterSpacingProperty => array(
						'.archive-filter__item'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::CATEGORIES_FILTER_TEXT_TRANSFORM )
				->defaultVal( 'none' )
				->description( esc_html__( '_text transform', 'nels' ) )
				->choices( array(
					'none'       => esc_html__( 'None', 'nels' ),
					'capitalize' => esc_html__( 'Capitalize', 'nels' ),
					'uppercase'  => esc_html__( 'Uppercase', 'nels' ),
					'lowercase'  => esc_html__( 'Lowercase', 'nels' ),
				) )
				->css( array(
					$textTransformProperty => array(
						'.archive-filter__item'
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