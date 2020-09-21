<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */


?>

<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	// do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();
	global $i;
	global $total_product, $enquiry;
	if ( wc_get_loop_prop( 'total' ) ) {
		$i = 1;
		$term = get_queried_object();
		$products_by_term = apply_filters('product_by_category_id',$term->term_id);
		$total_product = count($products_by_term) < 10 ? '0'.count($products_by_term) : count($products_by_term);
		$enquiry =  get_option('equiry_'.$term->term_id);
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
			$i++;
		}
		?>
		<div class="swiper-slide more-product-categoies swiper-slide-next" data-type="product" data-term="<?php echo $term->term_id; ?>">
			<div class="product-slider-load-more">
				<span class="more-product-categoies-posts">LOAD MORE</span>
				<span class="more-product-categoies-loading">LOADING</span>
				<span class="no-more-product-categoies">NO MORE</span>
			</div>
		</div>
	<?php
	}

	woocommerce_product_loop_end();
	?>
	<div class="enquiry-wrap">
		<div>
		<img id="close-enquiry" src="<?php echo get_template_directory_uri() .'/images/close.svg'; ?>" alt="">
		<p class="form-name">Product Enquiry</p>
	<?php
	echo do_shortcode('[contact-form-7 id="607" title="Enquiry form"]');
	?>
	</div>
	</div>
	<div id="img-zoom" class="img-zoom">
		<a id="zoom-close" href="" class=""><img src="<?php echo get_template_directory_uri() .'/images/close-white.svg'; ?>" alt=""></a>
		<span class="zoom">
			<img id="img" class="is-magic wp-post-image"  src="" alt="Product image">
		</span>
		<div class="zoom-el"><img src="" alt=""></div>
	</div>
	<?php
	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	// do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
