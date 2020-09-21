<?php

use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! ShopUtil::isShopActivated() ) :
	return;
endif; ?>

<?php if ( WC()->cart->is_empty() ) : ?>

	<div class="cart-popup__widget__empty">
		<p class="popup-cart-empty">
			<?php echo wp_kses_post( apply_filters( 'wc_empty_cart_message', esc_html__( 'Your cart is currently empty.', 'nels' ) ) ) ?>
		</p>
		<p class="return-to-shop">
			<a class="button wc-backward"
			   href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<?php esc_html_e( 'Return to shop', 'nels' ) ?>
			</a>
		</p>
	</div>

<?php else :

	woocommerce_mini_cart();

endif;