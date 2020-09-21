<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$isCatalogModeEnabled = Service::themeOptionsUtil()->isShopCatalogModeEnabled();

?>

<div class="card-content">
	<?php
	Service::util()->partial( 'shop/article/elements/header-branding' );

	if ( ! $isCatalogModeEnabled ) : ?>
		<div class="card-info">
			<?php if ( ShopUtil::getGlobalProduct()->get_price_html() ) : ?>
				<span class="card-info__item">
					<?php woocommerce_template_loop_price(); ?>
				</span>
			<?php endif;

			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

			<span class="card-info__item">
				<span class="card-button">
					<?php
					/**
					 * Hook: woocommerce_after_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );
					?>
				</span>
			</span>
		</div>
	<?php endif; ?>
</div>