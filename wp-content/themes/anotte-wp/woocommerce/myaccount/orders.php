<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="page-split-left page-split-left-big">
<?php
do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
<?php echo do_shortcode('[breadcrum name="page"]'); ?>
<h1 class="entry-title big-text">My Orders</h1>
<?php if ( $has_orders ) : ?>
	<?php
	foreach ( $customer_orders->orders as $customer_order ) {
		$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
		$item_count = $order->get_item_count() - $order->get_item_count_refunded();
		$product_items = $order->get_items();
		foreach($product_items as $product) {
			$product_name = $product['name'];
			$product_id = $product['product_id'];
		}
		$product_img = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail',true );
		$product_url = get_permalink( $product_id );
		?>
		<div class="flex">
			<div class="td first-td">
			<a href="<?php echo $product_url; ?>"><img src="<?php echo $product_img[0]; ?>" alt="Product Image"></a>
			</div>
			<div class="td last-td">
				<p class="product-name"><a href="<?php echo $product_url; ?>"><?php echo $product_name; ?></a></p>
				<p>Qty: <?php echo $item_count; ?></p>
				<p>Total: <?php echo $order->get_formatted_order_total(); ?></p>
				<p>Status: <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></p>
				<p>Created by: <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></p>
			</div>
			<a class="preview-show" href=""><img src="<?php echo get_template_directory_uri() .'/images/left.svg'; ?>" alt="Show preview icon"></a>
			<div class="td preview">
			<?php
				$actions = wc_get_account_orders_actions( $order );

				if ( ! empty( $actions ) ) {
					foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
						echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
					}
				}
				?>
			</div>
		</div>
		<?php
	}
	?>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<p class="p-notice"><?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?></p>
		<!-- <a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"> -->
		<a class="woocommerce-Button button" href="<?php echo esc_url( home_url() , wc_get_page_permalink( 'shop' ) ); ?>">
			<?php esc_html_e( 'Browse products', 'woocommerce' ); ?>
		</a>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
</div>
<?php do_shortcode('[right_page]'); ?>