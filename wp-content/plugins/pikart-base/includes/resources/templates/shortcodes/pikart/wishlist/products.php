<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 *
 * @since 1.3.0
 */

$wishlist = $data['wishlist'];
?>

<div class="woocommerce-cart-form">
	<table class="shop_table shop_table_responsive wishlist_table" cellspacing="0">
		<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php esc_html_e( 'Product', 'pikart-base' ); ?></th>
			<th class="product-price"><?php esc_html_e( 'Price', 'pikart-base' ); ?></th>
			<th class="product-stock-status"><?php esc_html_e( 'Stock status', 'pikart-base' ); ?></th>
			<th class="product-add-to-cart"></th>
		</tr>
		</thead>
		<tbody>

		<?php
		/* @var WC_Product $product */
		foreach ( $wishlist as $productId => $product ):
			$GLOBALS['product'] = $product;
			$productIsVisible = $product->is_visible();
			$productLink = $product->get_permalink();
			?>

			<tr class="woocommerce-cart-form__cart-item cart_item">
				<td class="product-remove">
					<a href="#" class="remove wishlist-button-remove"
					   data-product-id="<?php echo esc_attr( $productId ) ?>">&times;</a>
				</td>

				<td class="product-thumbnail">
					<?php if ( $productIsVisible ): ?>
						<a href="<?php echo esc_url( $productLink ) ?>"><?php print( $product->get_image() ) ?></a>
					<?php else:
						print( $product->get_image() );
					endif;
					?>
				</td>

				<td class="product-name">
					<?php
					if ( $productIsVisible ):?>
						<a href="<?php echo esc_url( $productLink ) ?>">
							<?php echo esc_html( $product->get_title() ) ?>
						</a>
					<?php else:
						echo esc_html( $product->get_name() ) . '&nbsp;';
					endif;
					?>
				</td>

				<td class="product-price">
					<?php print( $product->get_price_html() ) ?>
				</td>

				<td class="product-stock-status">
					<?php $product->is_in_stock()
						? esc_html_e( 'In Stock', 'pikart-base' ) : esc_html_e( 'Out of Stock', 'pikart-base' ); ?>
				</td>

				<td class="product-add-to-cart">
					<?php woocommerce_template_loop_add_to_cart(); ?>
				</td>

			</tr>

		<?php endforeach; ?>

		</tbody>
	</table>
</div>
