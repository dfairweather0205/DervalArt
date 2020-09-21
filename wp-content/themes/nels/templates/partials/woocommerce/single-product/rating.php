<?php

use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! ShopTemplateHelper::wcReviewRatingsEnabled() ) :
	return;
endif;

$product       = ShopUtil::getGlobalProduct();
$ratingCount   = $product->get_rating_count();
$averageRating = $product->get_average_rating();

if ( $ratingCount <= 0 ) :
	return;
endif; ?>

<div class="woocommerce-product-rating">
	<?php echo wc_get_rating_html( $averageRating, $ratingCount ); // WPCS: XSS ok. ?>
</div>
