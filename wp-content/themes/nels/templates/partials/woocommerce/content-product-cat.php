<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$shopDisplay = Service::themeOptionsUtil()->getOption( ThemeOption::SHOP_DISPLAY );
?>

<li <?php wc_product_cat_class( '', $category ); ?>>
	<div class="card-body">

		<?php
		/**
		 * woocommerce_before_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_open - 10
		 */
		do_action( 'woocommerce_before_subcategory', $category ); ?>

		<div class="card-header header-standard">
			<a class="card-thumbnail" href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) )?>">
				<?php if ( Service::templatesUtil()->isTransparencyAllowed( $shopDisplay ) ): ?>
					<div class="color-overlay">
						<div class="color-overlay-inner"></div>
					</div>
				<?php endif;

				/**
				 * woocommerce_before_subcategory_title hook.
				 *
				 * @hooked woocommerce_subcategory_thumbnail - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category ); ?>
			</a>
		</div>

		<div class="card-content">
			<a class="card-branding" href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) )?>">
				<h4 class="branding__title">
					<?php
					/**
					 * woocommerce_shop_loop_subcategory_title hook.
					 *
					 * @hooked woocommerce_template_loop_category_title - 10
					 */
					do_action( 'woocommerce_shop_loop_subcategory_title', $category ); ?>
				</h4>
				<div class="branding__meta">
					<div class="branding__meta__item woocommerce-loop-category__items">
						<?php printf( esc_html( _n( '%s product', '%s products',
							(int) $category->count, 'nels' ) ), (int) $category->count ) ?>
					</div>
				</div>
			</a>
		</div>

		<?php
		/**
		 * woocommerce_after_subcategory_title hook.
		 */
		do_action( 'woocommerce_after_subcategory_title', $category );

		/**
		 * woocommerce_after_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_close - 10
		 */
		do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
</li>
