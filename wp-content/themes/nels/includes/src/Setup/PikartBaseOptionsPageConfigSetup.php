<?php

namespace Pikart\Nels\Setup;


use Pikart\WpThemeCore\OptionsPages\OptionsPagesFilterName;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! class_exists( __NAMESPACE__ . '\\PikartBaseOptionsPageConfigSetup' ) ) {

	/**
	 * Class PikartBaseOptionsPageConfigSetup
	 * @package Pikart\Nels\Setup
	 */
	class PikartBaseOptionsPageConfigSetup {

		public function setup() {
			if ( ! PIKART_BASE_ENABLED || ! ShopUtil::isShopActivated() ) {
				return;
			}

			add_filter( OptionsPagesFilterName::settingValueOptions( 'pikart_base', 'social_share_visibility' ),
				function ( $options ) {
					$options[ PostTypeSlug::PRODUCT ] = esc_html__( 'Product', 'nels' );

					return $options;
				}
			);

			add_filter( OptionsPagesFilterName::settingDefaultValue( 'pikart_base', 'social_share_visibility' ),
				function ( $options ) {
					$options[] = PostTypeSlug::PRODUCT;

					return $options;
				}
			);

			add_filter( OptionsPagesFilterName::settingValueOptions( 'pikart_base', 'likes_area_visibility' ),
				function ( $options ) {
					$options[ PostTypeSlug::PRODUCT ] = esc_html__( 'Product', 'nels' );

					return $options;
				}
			);

			add_filter( OptionsPagesFilterName::settingDefaultValue( 'pikart_base', 'likes_area_visibility' ),
				function ( $options ) {
					$options[] = PostTypeSlug::PRODUCT;

					return $options;
				}
			);
		}
	}
}