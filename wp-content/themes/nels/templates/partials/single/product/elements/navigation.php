<?php
use Pikart\WpThemeCore\Shop\ShopUtil;

set_query_var( 'singleNavigationAttributes', array(
	'previousPostText' => esc_html__( 'Previous product', 'nels' ),
	'nextPostText'     => esc_html__( 'Next product', 'nels' ),
	'allItemsText'     => esc_html__( 'Shop', 'nels' ),
	'allItemsLink'     => esc_url( get_permalink( ShopUtil::getShopPageId() ) ),
) );