<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( post_password_required() ) :
	Service::util()->partial( 'password-protected' );

	return;
endif;

$product = ShopUtil::getGlobalProduct();
$options = Service::postOptionsLoader()->loadProductOptions( get_the_ID() );
set_query_var( 'productOptions', $options );

$detailsPositionClass = 'details-position details-position--' . $options->getProductDetailsPosition(); ?>

<div id="product-<?php the_ID(); ?>" <?php ShopTemplateHelper::wcProductClass( esc_attr( $detailsPositionClass ), $product->get_id() ); ?>>
	<?php Service::util()->partial( 'single/product/product' ); ?>
</div>