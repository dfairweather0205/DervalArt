<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\TypographyConfig' ) ) {

	/**
	 * Class TypographyConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class TypographyConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$fontSizeProperty = sprintf( 'font-size: %spx', self::DELIMITER );

			return $this->configHelper
				->buildAddGoogleFontConfig( $this->controlConfigBuilder )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_headings_font' )
				->label( esc_html__( 'Headings', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->fontFamily( ThemeOption::SITE_HEADINGS_FONT_FAMILY )
				->defaultVal( 'Poppins:300,400,500,600,700' )
				->description( esc_html__( '_font-family', 'nels' ) )
				->css( array(
					'font-family' => array(
						'h1',
						'h2',
						'h3',
						'h4',
						'h5',
						'h6',
						'.sidebar--site-header__title',
						'.author__title',
						'.taxonomies-tags span',
						'.social__button',
						'.likes-area__number',
						'.comment__content__reply',
						'.nav__prev__post-title',
						'.nav__next__post-title',
						'.site-search-area',
						'.custom-fields__item__title',
						'.attachment__title',
						'.progressbar__branding__number',
						'.tabs__title',
						'.mfp-pikart .mfp-top-bar .mfp-title',
						'.mfp-pikart .mfp-counter',
						'.cart-popup__title',
						'.woocommerce.widget_shopping_cart .product_list_widget li a',
						'.products-compare-popup tbody tr:nth-child(2) td:not(:first-child)',
						'.products-compare-popup th',
						'.products-compare-popup tr td:first-child',
						'.shop_table th',
						'.shop_table .product-name',
						'.cart-popup__widget .woocommerce-mini-cart__total strong',
						'.woocommerce-MyAccount-navigation-link',
						'.woocommerce div.woocommerce-MyAccount-content legend',
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_h1' )
				->label( esc_html__( 'H1', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::H1_FONT_SIZE )
				->defaultVal( 56 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'h1'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::H1_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					'font-weight' => array(
						'h1'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_h2' )
				->label( esc_html__( 'H2', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::H2_FONT_SIZE )
				->defaultVal( 42 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'h2'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::H2_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					'font-weight' => array(
						'h2'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_h3' )
				->label( esc_html__( 'H3', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::H3_FONT_SIZE )
				->defaultVal( 32 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'h3'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::H3_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					'font-weight' => array(
						'h3'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_h4' )
				->label( esc_html__( 'H4', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::H4_FONT_SIZE )
				->defaultVal( 24 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'h4'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::H4_FONT_WEIGHT )
				->defaultVal( 400 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					'font-weight' => array(
						'h4'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_h5' )
				->label( esc_html__( 'H5', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::H5_FONT_SIZE )
				->defaultVal( 18 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'h5'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::H5_FONT_WEIGHT )
				->defaultVal( 500 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					'font-weight' => array(
						'h5'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_h6' )
				->label( esc_html__( 'H6', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::H6_FONT_SIZE )
				->defaultVal( 14 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'h6'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::H6_FONT_WEIGHT )
				->defaultVal( 600 )
				->description( esc_html__( '_font-weight', 'nels' ) )
				->choices( $this->getFontWeightList() )
				->css( array(
					'font-weight' => array(
						'h6'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_text_font' )
				->label( esc_html__( 'Body text', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->fontFamily( ThemeOption::SITE_TEXT_FONT_FAMILY )
				->defaultVal( 'Lato:300,300i,400,400i,700,700i' )
				->description( esc_html__( '_font-family', 'nels' ) )
				->css( array(
					'font-family' => array(
						'body',
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_TEXT_FONT_SIZE )
				->defaultVal( 16 )
				->description( esc_html__( '_font-size (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 96,
					'step' => 1
				) )
				->css( array(
					$fontSizeProperty => array(
						'body'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SITE_TEXT_FONT_LINE_HEIGHT )
				->defaultVal( 1.7 )
				->description( esc_html__( '_line-height', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'max'  => 3,
					'step' => 0.01
				) )
				->css( array(
					'line-height' => array(
						'body'
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'general_typography_site-header-navigation_font' )
				->label( esc_html__( 'Site Header navigation', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->fontFamily( ThemeOption::SITE_HEADER_NAVIGATION_FONT )
				->defaultVal( 'Poppins:300,400,500,600,700' )
				->description( esc_html__( '_font-family', 'nels' ) )
				->css( array(
					'font-family' => array(
						'.site-header',
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'site_hover_style_title' )
				->label( esc_html__( 'Hover style', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SITE_HOVER_STYLE )
				->defaultVal( 'default' )
				->description( esc_html__( '_type', 'nels' ) )
				->choices( array(
					'default' => esc_html__( 'Default', 'nels' ),
					'ball'    => esc_html__( 'Ball', 'nels' ),
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