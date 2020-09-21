<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$output = Service::util()->captureOutput( function () {
	$product = ShopUtil::getGlobalProduct();

	do_action( 'woocommerce_product_meta_start' );

	echo wc_get_product_tag_list( $product->get_id(), '',
		sprintf( '<div class="entry-footer__item entry-taxonomies"><div class="taxonomies-tags"><span>%s</span>',
			esc_html__( 'Product Tags:', 'nels' ) ), '</div></div>' );

	Service::util()->partial( 'single/elements/social-area' );

	do_action( 'woocommerce_product_meta_end' );
} );

if ( empty( $output ) ) :
	return;
endif;

echo <<<HTML
<div class="entry-meta">
	<div class="entry-meta__wrapper">
		$output
	</div>
</div>
HTML;
