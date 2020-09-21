<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
echo do_shortcode('[arrow_button][/arrow_button]');
$term = get_queried_object();
$term_data = get_term($term->term_id,'product_cat');
$term_name = $term_data->name;
$term_description = $term_data->description;

?>
<div class="product-slider image-slider-wrapper relative swiper-container ">
<div class = "swiper-wrapper image-slider slider no-product-slider">
<?php echo do_shortcode("[custom_carousel_slide type='text' title='".$term_name."' des='VISUALS' breadcrum='product_by_category']".$term_description."[/custom_carousel_slide]"); ?>