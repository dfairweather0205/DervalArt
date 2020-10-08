<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\WpThemeCore\Shop\ShopUtil;

$product               = ShopUtil::getGlobalProduct();
$addProductIconClass   = 'icon-shuffle';
$addedProductIconClass = 'icon-shuffle';
$compareListHasProduct = PikartBaseUtil::compareListHasProduct( $product->get_id() );
$iconClass             = $compareListHasProduct ? $addedProductIconClass : $addProductIconClass;
$iconTitle             = $compareListHasProduct
	? esc_html__( 'View Compare', 'nels' ) : esc_html__( 'Compare', 'nels' );
?>

<a class="<?php echo esc_attr( Service::templatesUtil()->getShopCardIconCssClasses( 'products-compare-button' ) ) ?>"
   href="#" title="<?php echo esc_attr( $iconTitle ) ?>"
   data-product-id="<?php echo esc_attr( $product->get_id() ) ?>" data-tooltip>
	<i class="<?php echo esc_attr( $iconClass ) ?>" data-spinner-icon-class="fa-spinner fa-spin"
	   data-add-product-icon-class="<?php echo esc_attr( $addProductIconClass ) ?>"
	   data-added-product-icon-class="<?php echo esc_attr( $addedProductIconClass ) ?>"></i>
</a>