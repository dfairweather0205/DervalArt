<?php
/**
 * @since 1.3.0
 */
?>

<p class="cart-empty">
	<?php esc_html_e( 'Your wishlist is currently empty.', 'pikart-base' ); ?>
</p>

<?php if ( wc_get_page_id( 'shop' ) < 1 ):
	return;
endif;

$shopUrl = apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ); ?>

<p class="return-to-shop">
	<a class="button wc-backward" href="<?php echo esc_url( $shopUrl ); ?>">
		<?php esc_html_e( 'Return to shop', 'pikart-base' ) ?>
	</a>
</p>
