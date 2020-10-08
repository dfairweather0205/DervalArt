<?php

use Pikart\WpThemeCore\Post\Type\PostTypeSlug;
use Pikart\WpThemeCore\Shop\ShopUtil;

$product = ShopUtil::getGlobalProduct();
$sku     = $product->get_sku() ? $product->get_sku() : esc_html__( 'N/A', 'nels' );

$hasCategories     = has_term( '', PostTypeSlug::PRODUCT_CATEGORY );
$productCategories = get_the_terms( $product->get_id(), PostTypeSlug::PRODUCT_CATEGORY );
$nbCategories      = is_array( $productCategories ) ? count( $productCategories ) : 0;
?>

<div class="sku_wrapper">
	<span><?php esc_html_e( 'SKU Number:', 'nels' ); ?></span>
	<a href="#" class="sku">
		<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) :
			echo esc_html( $sku );
		else :
			esc_html_e( 'N/A', 'nels' );
		endif; ?>
	</a>
</div>

<?php if ( $hasCategories ): ?>

	<div class="product-categories">
		<span><?php echo esc_html( _n( 'Category:', 'Categories:', $nbCategories, 'nels' ) ); ?></span>
		<?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?>
	</div>

<?php endif; ?>