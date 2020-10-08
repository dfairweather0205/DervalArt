<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\ShopProductConfig' ) ) {

	/**
	 * Class ShopProductConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class ShopProductConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$spacingRightContentProperty = sprintf( 'border-right-width: %spx', self::DELIMITER );
			$spacingLeftContentProperty  = sprintf( 'border-left-width: %spx', self::DELIMITER );

			return $this->controlConfigBuilder
				->noInput( 'shop_product_spacing_title' )
				->label( esc_html__( 'Spacing', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::PRODUCT_COMPRESS_PRODUCT_CONTENT_LEFT )
				->defaultVal( 0 )
				->description( esc_html__( '_left (pixels)', 'nels' ) )
				->css( array(
					$spacingLeftContentProperty => array(
						'.site-main--product .entry-content',
						'.site-main--product .details-position--top .entry-details',
						'.site-main--product .details-position--bottom .entry-details',
						'.site-main--product .entry-taxonomies',
						'.site-main--product .entry-social-area',
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::PRODUCT_COMPRESS_PRODUCT_CONTENT_RIGHT )
				->defaultVal( 0 )
				->description( esc_html__( '_right (pixels)', 'nels' ) )
				->css( array(
					$spacingRightContentProperty => array(
						'.site-main--product .entry-content',
						'.site-main--product .details-position--top .entry-details',
						'.site-main--product .details-position--bottom .entry-details',
						'.site-main--product .entry-taxonomies',
						'.site-main--product .entry-social-area',
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkboxMultiple( ThemeOption::SHOP_ELEMENTS_VISIBILITY )
				->label( esc_html__( 'Visibility', 'nels' ) )
				->defaultVal( array(
					'related_products',
					'navigation',
				) )
				->choices( array(
					'related_products' => esc_html__( '_Related Products', 'nels' ),
					'navigation'       => esc_html__( '_Navigation', 'nels' ),
				) )
				->selectiveRefresh( '.site-main--product .entry-footer', 'single/product/elements/footer' )
				->build();
		}
	}
}