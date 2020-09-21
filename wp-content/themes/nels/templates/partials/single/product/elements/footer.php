<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! ShopUtil::getGlobalProduct() ) :
	return;
endif;

$themeOptionsUtil         = Service::themeOptionsUtil();
$relatedProductsColumnsNb = ShopTemplateHelper::wcGetDefaultProductsPerRow();

if ( $themeOptionsUtil->shopHasElement( 'related_products' ) ) :
	woocommerce_related_products( array(
		'posts_per_page' => -1,
		'columns'        => (int) $relatedProductsColumnsNb,
	) );
endif;

if ( $themeOptionsUtil->shopHasElement( 'navigation' ) ) :
	Service::util()->partial( 'single/product/elements/navigation' );
	Service::util()->partial( 'single/navigation' );
endif;

do_action( 'woocommerce_after_single_product' );