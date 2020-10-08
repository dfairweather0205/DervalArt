<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$product       = ShopUtil::getGlobalProduct();
$commonOptions = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );
$itemTitle     = $commonOptions->getTitleArea();
$cssClasses    = empty( $itemTitle ) ? '' : 'reset-font-weight';

$productOptions  = Service::postOptionsLoader()->loadProductOptions( get_the_ID() );
$detailsPosition = $productOptions->getProductDetailsPosition();
$detailsIsSticky = $productOptions->getProductDetailsSticky()
                   && ( $detailsPosition === 'right' || $detailsPosition === 'left' ) ? 'entry-details--sticky' : ''; ?>

<div class="entry-header__item entry-details <?php echo esc_attr( $detailsIsSticky ) ?>">
	<div class="entry-details__wrapper">
		<?php if ( ! $productOptions->isFeaturedBranding() && $commonOptions->isBrandingEnabled() ) : ?>
			<div class="entry-branding">
				<div class="default-branding">

					<?php Service::templatesUtil()->generateBreadcrumbs(); ?>

					<h1 class="branding__title <?php echo esc_attr( $cssClasses ) ?>">
						<?php echo( empty( $itemTitle ) ? esc_html( get_the_title() ) : wp_kses_post( $itemTitle ) ) ?>
					</h1>

				</div>
			</div>
		<?php endif;

		/**
		 * woocommerce_before_single_product hook.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 */
		do_action( 'woocommerce_before_single_product' );

		/**
		 * woocommerce_single_product_summary hook.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );

		Service::util()->partial( 'single/product/elements/details-tools' ); ?>

		<div class="woocommerce-product-details__metadata product_meta">
			<?php Service::util()->partial( 'single/product/elements/details-metadata' ); ?>
		</div>
	</div>

	<?php if ( $productOptions->getProductGalleryEnable() ) : ?>
		<div class="zoomImg-wrapper"></div>
	<?php endif; ?>
</div>