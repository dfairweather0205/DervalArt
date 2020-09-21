<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<div class="entry-footer__item related-items related-items--products">
		<div class="related-items__wrapper">
			<section class="related products">

				<?php
				$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'nels' ) );

				if ( $heading ) : ?>
					<h3 class="related-items__title entry-footer__title">
						<?php esc_html_e( $heading ); ?>
					</h3>
				<?php endif; ?>

				<?php woocommerce_product_loop_start(); ?>

					<?php foreach ( $related_products as $related_product ) : ?>

						<?php
						    $post_object = get_post( $related_product->get_id() );

							setup_postdata( $GLOBALS['post'] =& $post_object );

							wc_get_template_part( 'content', 'product' ); ?>

					<?php endforeach; ?>

				<?php woocommerce_product_loop_end(); ?>

			</section>
		</div>
	</div>

<?php endif;

wp_reset_postdata();
