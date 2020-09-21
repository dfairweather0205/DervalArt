<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Misc\PikartBaseUtil;

$iconItems = array(
	Service::util()->getPartialContent( 'shop/article/elements/quick-view-button' ),
	PikartBaseUtil::getWishlistPartialContent( 'shop/article/elements/wishlist-area' ),
	PikartBaseUtil::getProductsComparePartialContent( 'shop/article/elements/products-compare-area' )
);

$iconItems = array_filter( array_map( function ( $content ) {
	return Service::templatesUtil()->wrapContent( '<div class="card-icons__item">%s</div>', $content );
}, $iconItems ) );


if ( empty( $iconItems ) ):
	return;
endif;

$iconItemsHtml = implode( '', $iconItems );

echo <<<HTML
<div class="card-icons">$iconItemsHtml</div>
HTML;
