<?php

use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\WpThemeCore\Shop\ShopUtil;

/**
 * @global string $wishlistPageUrl
 */
isset( $wishlistPageUrl ) || $wishlistPageUrl = '';

$product               = ShopUtil::getGlobalProduct();
$addProductIconClass   = 'fa-heart-o';
$addedProductIconClass = 'fa-heart';

$iconClass = PikartBaseUtil::wishlistHasProduct( $product->get_id() ) ? $addedProductIconClass : $addProductIconClass;
?>

<a class="wishlist-button" href="<?php echo esc_url( $wishlistPageUrl ) ?>"
   data-product-id="<?php echo esc_attr( $product->get_id() ) ?>">
	<span class="wishlist-button__icons">
		<i class="fa <?php echo esc_attr( $iconClass ) ?>" data-spinner-icon-class="fa-spinner fa-spin"
		   data-add-product-icon-class="<?php echo esc_attr( $addProductIconClass ) ?>"
		   data-added-product-icon-class="<?php echo esc_attr( $addedProductIconClass ) ?>"></i>
	</span>
	<span class="wishlist-button__text"><?php esc_html_e( 'Add to Wishlist', 'nels' ); ?></span>
</a>