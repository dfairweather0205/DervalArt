<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$current_user_id = get_current_user_id();
$user = get_user_by('id', $current_user_id);
$user_data = $user->data;
$user_name = $user_data->display_name;
$user_email = $user_data->user_email;
$billing_address_1 = get_user_meta($current_user_id,'billing_address_1',true);
$billing_address_2 = get_user_meta($current_user_id,'billing_address_1',true);
$shipping_address_1 = get_user_meta($current_user_id,'shipping_address_1',true);
$shipping_address_2 = get_user_meta($current_user_id,'shipping_address_1',true);
$billing_address = !empty($billing_address_1) ? $billing_address_1 : $billing_address_2;
$shipping_address = !empty($shipping_address_1) ? $shipping_address_1 : $shipping_address_2;
?>
<div class="page-split-left">
	<?php echo do_shortcode('[breadcrum name="page"]');  ?>
	<p class="entry-title big-text"><?php echo esc_html_e('Account Details', 'woocommerce'); ?></p>
	<div class="acount-item">
		<p class="no-m-b"><strong><?php echo $user_name; ?></strong></p>
		<p><?php echo $user_email; ?><a class="detail-edit"  href="<?php echo home_url('/my-account/edit-account'); ?>">Edit</a></p>
	</div>	
	<div class="acount-item">
		<p class="no-m-b"><strong>BILLING ADDRESS</strong></p>
		<p><?php echo !empty($billing_address) ? $billing_address : 'Billing address is Empty.'; ?><a class="detail-edit" href="<?php echo home_url('/my-account/edit-address/billing'); ?>">Edit</a></p>
	</div>	
	<div class="acount-item">
		<p class="no-m-b"><strong>SHIPPING ADDRESS</strong></p>
		<p><?php echo !empty($shipping_address) ? $shipping_address : 'Shipping adress is Empty.'; ?><a class="detail-edit" href="<?php echo home_url('/my-account/edit-address/shipping'); ?>">Edit</a></p>
	</div>
</div>
<?php do_shortcode('[right_page right="acount"]'); ?>
<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );
	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
?>