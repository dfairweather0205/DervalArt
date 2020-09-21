<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$product = ShopUtil::getGlobalProduct();

if ( $product && $product->is_visible() ) :
	Service::util()->partial( 'shop/article/article' );
endif;

