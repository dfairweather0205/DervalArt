<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\WpThemeCore\Shop\ShopUtil;

/**
 * @global string $wishlistPageUrl
 */
isset( $wishlistPageUrl ) || $wishlistPageUrl = '';

$product               = ShopUtil::getGlobalProduct();
$addProductIconClass   = 'icon-heart';
$addedProductIconClass = 'icon-action-redo';

$wishlistHasProduct = PikartBaseUtil::wishlistHasProduct( $product->get_id() );
$iconClass          = $wishlistHasProduct ? $addedProductIconClass : $addProductIconClass;
$iconTitle          = $wishlistHasProduct
	? esc_html__( 'Browse Wishlist', 'nels' ) : esc_html__( 'Add to Wishlist', 'nels' );
?>

<a class="<?php echo esc_attr( Service::templatesUtil()->getShopCardIconCssClasses( 'wishlist-button' ) ) ?>"
   href="<?php echo esc_url( $wishlistPageUrl ) ?>" title="<?php echo esc_attr( $iconTitle ) ?>"
   data-product-id="<?php echo esc_attr( $product->get_id() ) ?>" data-tooltip>
	<i class="<?php echo esc_attr( $iconClass ) ?>" data-spinner-icon-class="fa-spinner fa-spin"
	   data-add-product-icon-class="<?php echo esc_attr( $addProductIconClass ) ?>"
	   data-added-product-icon-class="<?php echo esc_attr( $addedProductIconClass ) ?>"></i>
</a>