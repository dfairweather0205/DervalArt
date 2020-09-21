<?php

use Pikart\Nels\DependencyInjection\Service;

if ( ! Service::themeOptionsUtil()->isCartPopupEnabled() ) :
	return;
endif;
?>

<div class="cart-popup">

	<div class="cart-popup__heading">
		<h5 class="cart-popup__title">
			<?php esc_html_e( 'Shopping Cart', 'nels' ); ?>
		</h5>
		<a class="cart-popup__close-button">
			<?php esc_html_e( 'Close', 'nels' ); ?>
		</a>
	</div>

	<div class="cart-popup__widget widget woocommerce widget_shopping_cart">
		<?php Service::util()->partial( 'header/popups/shop-cart-popup-details' ); ?>
	</div>

</div>