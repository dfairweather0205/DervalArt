<?php

use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\WpThemeCore\Shop\ShopUtil;

$product               = ShopUtil::getGlobalProduct();
$addProductIconClass   = 'fa-random';
$addedProductIconClass = 'fa-list';
$iconClass             = PikartBaseUtil::compareListHasProduct( $product->get_id() )
	? $addedProductIconClass : $addProductIconClass;
?>

<a class="products-compare-button" href="#"
   data-product-id="<?php echo esc_attr( $product->get_id() ) ?>">
	<span class="products-compare-button__icons">
		<i class="fa <?php echo esc_attr( $iconClass ) ?>" data-spinner-icon-class="fa-spinner fa-spin"
		   data-add-product-icon-class="<?php echo esc_attr( $addProductIconClass ) ?>"
		   data-added-product-icon-class="<?php echo esc_attr( $addedProductIconClass ) ?>"></i>
	</span>
	<span class="products-compare-button__text"><?php esc_html_e( 'Compare Products', 'nels' ); ?></span>
</a>