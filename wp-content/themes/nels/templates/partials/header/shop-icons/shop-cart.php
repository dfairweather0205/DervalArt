<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$themeOptionsUtil = Service::themeOptionsUtil();

if ( ! ShopUtil::isShopActivated() || ! $themeOptionsUtil->headerHasShopIcon( 'cart' ) ) :
	return;
endif;

$cartIconUrl = $themeOptionsUtil->isShopCartIconLinkCartPopup() ? '#' : wc_get_cart_url();
?>

<div class="shop-cart-icon">
	<a href="<?php echo esc_url( $cartIconUrl ) ?>" title="<?php esc_attr_e( 'Cart', 'nels' ); ?>">
		<i class="icon-handbag"></i>
		<span class="shop-cart-icon__items">
			<span class="shop-cart-icon__background"></span>
			<span class="shop-cart-icon__items-number">
				<?php echo esc_html( WC()->cart->get_cart_contents_count() ) ?>
			</span>
		</span>

	</a>
</div>