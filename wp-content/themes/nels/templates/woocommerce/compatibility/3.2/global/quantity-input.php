<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

use Pikart\Nels\DependencyInjection\Service;

if ( ! isset( $classes ) ) {
	$classes = 'input-text qty text';
}

set_query_var('input_id', $input_id);
set_query_var('classes', $classes);
set_query_var('input_name', $input_name);
set_query_var('input_value', $input_value);
set_query_var('max_value', $max_value);
set_query_var('min_value', $min_value);
set_query_var('step', $step);
set_query_var('pattern', $pattern);
set_query_var('inputmode', $inputmode);

Service::util()->partial( 'woocommerce/global/quantity-input' );
