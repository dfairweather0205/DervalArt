<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || false === wc_get_loop_product_visibility( $product->get_id() ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="swiper-slide">
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	// do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	// do_action( 'woocommerce_shop_loop_item_title' );
	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	// do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	// do_action( 'woocommerce_after_shop_loop_item_custom' );
	global $product;
	global $i;
	global $total_product, $enquiry;
	$product_id = get_the_ID();
	$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
	$description = !empty(get_the_content()) ? get_the_content() : get_the_excerpt();
	$i = $i < 10 ? '0'.$i : $i;
	?>
	<div class="carousel-item-image products">
		<a href="" class="image-zoom"><img src="<?php echo get_template_directory_uri() .'/images/plus.svg'; ?>" alt=""></a>
		<a href="<?php echo esc_url( $link ); ?>" class="img-thumb">
			<?php echo woocommerce_get_product_thumbnail('shop_single'); ?>
		</a>
		<div class="carousel-item-info product_by_term">
			<div class="carousel-cat-links">
				<ul>
					<li class="portfolio-enquiry">
						<?php if($enquiry == 'no'): ?>
							<?php
								$product_price = $product->get_price();
								if(!empty($product_price)):
							?>
							<a class="enquiry-btn redirect" href="<?php echo home_url("/?add-to-cart=$product_id"); ?>">Add To Cart</a>
								<?php endif; ?>
						<?php else: ?>
							<a class="enquiry-btn" href="">ENQUIRY</a>
						<?php endif; ?>
					</li>
					<li class="portfolio-category">
						<a href="<?php echo esc_url( $link ); ?>" title="Click here to visit the product page."><?php echo get_the_title(); ?></a>
					</li>
					<li class="portfolio-description">
						<p><?php //echo $description; ?></p>
					</li>
				</ul>
			</div>
		</div>
		<p class="post-num"><span><?php echo $i; ?></span><span class="total-num"><?php echo $total_product; ?></span></p>
	</div>
</div>