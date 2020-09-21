<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\ShopRibbonsConfig' ) ) {

	/**
	 * Class ShopRibbonsConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ShopRibbonsConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			return $this->controlConfigBuilder
				->noInput( 'shop_ribbons_hot' )
				->label( esc_html__( 'Hot', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_RIBBONS_HOT_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_RIBBONS_HOT_BACKGROUND_COLOR )
				->defaultVal( '#fe6c61' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.woocommerce .woocommerce.ribbons .featured'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_RIBBONS_HOT_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_color', 'nels' ) )
				->css( array(
					'color' => array(
						'.woocommerce .woocommerce.ribbons .featured'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'shop_ribbons_sale' )
				->label( esc_html__( 'Sale', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_RIBBONS_SALE_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_RIBBONS_SALE_BACKGROUND_COLOR )
				->defaultVal( '#84a1d1' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.woocommerce .woocommerce.ribbons .on-sale'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_RIBBONS_SALE_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_color', 'nels' ) )
				->css( array(
					'color' => array(
						'.woocommerce .woocommerce.ribbons .on-sale'
					)
				) )
				->noInput( 'shop_ribbons_new' )
				->label( esc_html__( 'New', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_RIBBONS_NEW_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SHOP_RIBBONS_NEW_LAST_DAYS )
				->defaultVal( 3 )
				->description( esc_html__( '_for products added less then number of days', 'nels' ) )
				->inputAttributes( array(
					'min'  => 0,
					'step' => 1
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_RIBBONS_NEW_BACKGROUND_COLOR )
				->defaultVal( '#ff9a9e' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.woocommerce .woocommerce.ribbons .new'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_RIBBONS_NEW_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_color', 'nels' ) )
				->css( array(
					'color' => array(
						'.woocommerce .woocommerce.ribbons .new'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'shop_ribbons_out_of_stock' )
				->label( esc_html__( 'Out of Stock', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SHOP_RIBBONS_OUT_OF_STOCK_ENABLED )
				->defaultVal( 1 )
				->label( esc_html__( 'Enabled', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_RIBBONS_OUT_OF_STOCK_BACKGROUND_COLOR )
				->defaultVal( '#4d4d4d' )
				->description( esc_html__( '_background', 'nels' ) )
				->css( array(
					'background-color' => array(
						'.woocommerce .woocommerce.ribbons .out-of-stock'
					)
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->color( ThemeOption::SHOP_RIBBONS_OUT_OF_STOCK_COLOR )
				->defaultVal( '#ffffff' )
				->description( esc_html__( '_color', 'nels' ) )
				->css( array(
					'color' => array(
						'.woocommerce .woocommerce.ribbons .out-of-stock'
					)
				) )
				->build();
		}
	}
}