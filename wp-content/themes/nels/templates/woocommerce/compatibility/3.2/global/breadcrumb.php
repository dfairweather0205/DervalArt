<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.3.0
 * @see           woocommerce_breadcrumb()
 *
 * @var $breadcrumb
 * @var $wrap_before
 * @var $before
 * @var $after
 * @var $wrap_after
 */

use Pikart\Nels\DependencyInjection\Service;

set_query_var('breadcrumb', $breadcrumb);
set_query_var('wrap_before', $wrap_before);
set_query_var('wrap_after', $wrap_after);
set_query_var('before', $before);
set_query_var('after', $after);

Service::util()->partial( 'woocommerce/global/breadcrumb' );