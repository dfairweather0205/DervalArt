<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\WpThemeCore\Shop\ShopUtil;

$product       = ShopUtil::getGlobalProduct();
$commonOptions = Service::postOptionsLoader()->loadCommonPostOptions( $product->get_id() );

$itemTitle  = $commonOptions->getTitleArea();
$cssClasses = empty( $itemTitle ) ? '' : 'reset-font-weight'; ?>

<div class="quick-view-popup woocommerce">
	<div class="site-main--product">
		<div id="product-<?php echo esc_attr( $product->get_id() ) ?>" <?php post_class() ?>>

			<div class="quick-view-popup-columns small-up-1 medium-up-1 large-up-2">

				<div class="column">
					<div class="entry-thumbnail hero-header">
						<div class="product-images-gallery">
							<figure class="woocommerce-product-gallery__wrapper quick-view-owl-carousel owl-carousel">
								<?php ShopTemplateHelper::showProductImages( true ); ?>
							</figure>
						</div>
					</div>
				</div>

				<div class="column">
					<div class="entry-details">
						<div class="entry-details__wrapper">

							<div class="quick-view-popup-branding">
								<h3 class="branding__title <?php echo esc_attr( $cssClasses ) ?>">
									<a href="<?php the_permalink(); ?>">
										<?php echo( empty( $itemTitle ) ? esc_html( get_the_title() ) : wp_kses_post( $itemTitle ) ) ?>
									</a>
								</h3>
							</div>

							<?php

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
							do_action( 'woocommerce_single_product_summary' ); ?>

							<div class="woocommerce-product-details__tools">
								<span class="woocommerce-product-details__tools__wishlist">
									<?php PikartBaseUtil::wishlistPartial( 'single/product/elements/wishlist-area' ) ?>
								</span>
							</div>

							<div class="woocommerce-product-details__metadata product_meta">
								<?php Service::util()->partial( 'single/product/elements/details-metadata' ); ?>

								<div class="woocommerce-product-details__social">
									<?php Service::util()->pikartBasePartial( 'single/addthis-social-share' ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
