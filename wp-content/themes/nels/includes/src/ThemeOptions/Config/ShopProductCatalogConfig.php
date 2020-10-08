<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\ShopProductCatalogConfig' ) ) {

	/**
	 * Class ShopProductCatalogConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ShopProductCatalogConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$util = $this->util;

			return $this->controlConfigBuilder
				->noInput( 'shop_display_title' )
				->label( esc_html__( 'Display options', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SHOP_DISPLAY )
				->defaultVal( 'default' )
				->description( esc_html__( '_display type', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getDisplayTypes() )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SHOP_SKIN_TRANSPARENCY )
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
							'.woocommerce.archive-items .card .color-overlay-inner'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SHOP_COLUMNS_SPACING )
				->defaultVal( 30 )
				->description( esc_html__( '_columns spacing (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->cssCallback( function ( $option ) {
					$paddingsProperty = sprintf( 'padding-right: %1$dpx; padding-bottom: %1$dpx;', $option );
					$marginsProperty  = sprintf( 'margin-right: %dpx;', - $option );

					return array(
						$paddingsProperty => array(
							'.woocommerce.archive-items .card'
						),
						$marginsProperty  => array(
							'ul.woocommerce.archive-items'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'shop_filter_title' )
				->label( esc_html__( 'Filter', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SHOP_FILTER_NB_COLUMNS )
				->defaultVal( 4 )
				->description( esc_html__( '_columns', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getItemColumnsNumber() )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'shop_cross_sells_products_title' )
				->label( esc_html__( 'Cross-sells Products', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_CROSS_SELLS_PRODUCTS_AUTOPLAY )
				->defaultVal( 0 )
				->label( esc_html__( 'Autoplay', 'nels' ) )
				->description( esc_html__( '_if enabled, slider plays automatically', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SHOP_CROSS_SELLS_PRODUCTS_NB_COLUMNS )
				->defaultVal( 2 )
				->description( esc_html__( '_columns number', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getItemColumnsNumber() )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'shop_upsells_products_title' )
				->label( esc_html__( 'Upsells Products', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_UPSELLS_PRODUCTS_AUTOPLAY )
				->defaultVal( 0 )
				->label( esc_html__( 'Autoplay', 'nels' ) )
				->description( esc_html__( '_if enabled, slider plays automatically', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SHOP_UPSELLS_PRODUCTS_NB_COLUMNS )
				->defaultVal( 4 )
				->description( esc_html__( '_columns number', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getItemColumnsNumber() )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'shop_related_products_title' )
				->label( esc_html__( 'Related Products', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_RELATED_PRODUCTS_AUTOPLAY )
				->defaultVal( 0 )
				->label( esc_html__( 'Autoplay', 'nels' ) )
				->description( esc_html__( '_if enabled, slider plays automatically', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SHOP_RELATED_PRODUCTS_NB_COLUMNS )
				->defaultVal( 2 )
				->description( esc_html__( '_columns number', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getItemColumnsNumber() )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_CATALOG_MODE_ENABLED )
				->defaultVal( 0 )
				->label( esc_html__( 'Catalog Mode', 'nels' ) )
				->description( esc_html__( '_if enabled, it globally hides the price and Add to Cart button on Product Cards and Pages', 'nels' ) )
				->build();
		}
	}
}