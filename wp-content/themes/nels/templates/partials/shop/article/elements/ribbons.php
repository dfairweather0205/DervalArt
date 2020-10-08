<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\WpThemeCore\Shop\ShopUtil;

$product          = ShopUtil::getGlobalProduct();
$themeOptionsUtil = Service::themeOptionsUtil();

$isOnSale     = $product->is_on_sale() && $themeOptionsUtil->getBoolOption( ThemeOption::SHOP_RIBBONS_SALE_ENABLED );
$isHot        = $product->is_featured() && $themeOptionsUtil->getBoolOption( ThemeOption::SHOP_RIBBONS_HOT_ENABLED );
$isOutOfStock = ! $product->is_in_stock()
                && $themeOptionsUtil->getBoolOption( ThemeOption::SHOP_RIBBONS_OUT_OF_STOCK_ENABLED );
$lastDays     = $themeOptionsUtil->getIntOption( ThemeOption::SHOP_RIBBONS_NEW_LAST_DAYS );
$isNew        = $themeOptionsUtil->getBoolOption( ThemeOption::SHOP_RIBBONS_NEW_ENABLED )
                && ShopUtil::isProductNew( $product, $lastDays );

if ( ! $isOnSale && ! $isHot && ! $isOutOfStock && ! $isNew ) :
	return;
endif;
?>

<span class="ribbons woocommerce">

	<?php if ( $isOnSale ) : ?>
		<span class="on-sale">
			<?php if ( $product->is_type( 'variable' ) || $product->is_type( 'grouped' ) ) :
				esc_html_e( 'Sale', 'nels' );
			else :
				printf( '-%s', esc_html( ShopUtil::getProductSaleReductionInPercentage( $product ) ) );
			endif; ?>
		</span>
	<?php endif;

	if ( $isHot ) : ?>
		<span class="featured"><?php esc_html_e( 'Hot', 'nels' ); ?></span>
	<?php endif;

	if ( $isNew ) : ?>
		<span class="new"><?php esc_html_e( 'New', 'nels' ); ?></span>
	<?php endif;

	if ( $isOutOfStock ) : ?>
		<span class="out-of-stock"><?php esc_html_e( 'Out of stock', 'nels' ); ?></span>
	<?php endif; ?>

</span>