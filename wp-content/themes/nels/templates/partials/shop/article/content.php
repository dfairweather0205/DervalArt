<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$shopDisplay = Service::themeOptionsUtil()->getOption( ThemeOption::SHOP_DISPLAY );
?>

<div class="card-header header-standard">

	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>

	<a class="card-thumbnail" href="<?php the_permalink(); ?>">
		<?php if ( Service::templatesUtil()->isTransparencyAllowed( $shopDisplay ) ): ?>
			<div class="color-overlay">
				<div class="color-overlay-inner"></div>
			</div>
		<?php endif;

		Service::util()->partial( 'shop/article/elements/ribbons' );

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
	</a>

	<?php Service::util()->partial( 'shop/article/elements/card-icons' ); ?>

</div>

<?php Service::util()->partial( 'shop/article/elements/content-card' );