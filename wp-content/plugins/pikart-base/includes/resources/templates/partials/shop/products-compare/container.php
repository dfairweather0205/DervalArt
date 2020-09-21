<?php

use Pikart\WpBase\DependencyInjection\Service;

if ( ! Service::productsCompareHelper()->isProductsCompareAllowed()
     || ! Service::optionsPagesUtil()->isProductsCompareEnabled() ) :
	return;
endif;
?>

<div class="products-compare-popup woocommerce">

	<h1><?php esc_html_e( 'Compare Products', 'pikart-base' ) ?></h1>
	<?php if ( Service::productsCompareHelper()->getCompareListProductsNumber() ):
		Service::util()->pikartBasePartial( 'shop/products-compare/products' );
	else: ?>
		<span class="products-compare__no-products"><?php esc_html_e( 'No products to compare', 'pikart-base' ); ?></span>
	<?php endif; ?>

</div>