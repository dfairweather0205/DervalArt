<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Misc\PikartBaseUtil;

$wishlistContent = Service::templatesUtil()->wrapContent(
	'<span class="woocommerce-product-details__tools__wishlist">%s</span>',
	PikartBaseUtil::getWishlistPartialContent( 'single/product/elements/wishlist-area' )
);

$productsCompareContent = Service::templatesUtil()->wrapContent(
	'<span class="woocommerce-product-details__tools__compare">%s</span>',
	PikartBaseUtil::getProductsComparePartialContent( 'single/product/elements/products-compare-area' )
);

if ( ! $wishlistContent && ! $productsCompareContent ):
	return;
endif;

echo <<<HTML
<div class="woocommerce-product-details__tools">$wishlistContent $productsCompareContent</div>
HTML;
