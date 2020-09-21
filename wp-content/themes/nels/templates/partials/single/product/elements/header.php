<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ShopTemplateHelper;

$productOptions  = Service::postOptionsLoader()->loadProductOptions( get_the_ID() );
$productVideoUrl = $productOptions->getProductVideoUrl();

$thumbnailsPositionClass         = 'thumbnails-position--' . $productOptions->getProductThumbnailsPosition();
$thumbnailsVerticalPositionClass = $productOptions->getProductThumbnailsPosition() === 'horizontal' ? 'owl-carousel' : '';

if ( ! $productOptions->getHeroHeader() && ! $productOptions->getProductGalleryEnable() ) :
	return;
endif; ?>

<div class="entry-header__item entry-thumbnail hero-header">

	<?php if ( $productOptions->getProductGalleryEnable() ) : ?>

		<div class="product-gallery">

			<div class="product-gallery__slides <?php echo esc_attr( $thumbnailsPositionClass ) ?>">
				<div class="product-gallery__slides__wrapper">
					<?php Service::util()->partial( 'shop/article/elements/ribbons' ); ?>
					<figure class="woocommerce-product-gallery__wrapper owl-carousel-slides owl-carousel">
						<?php ShopTemplateHelper::showProductImages( true ); ?>
					</figure>
					<div class="product-gallery-buttons">
						<?php if ( ! empty ( $productVideoUrl ) ) : ?>
							<div class="product-video-button">
								<a href="<?php echo esc_url( $productVideoUrl ) ?>" class="product-video-button__link">
									<i class="icon-control-play"></i>
									<span><?php esc_html_e( 'Video', 'nels' ); ?></span>
								</a>
							</div>
						<?php endif; ?>
						<div class="product-popup-button">
							<a href="#" class="product-popup-button__link">
								<i class="icon-size-fullscreen"></i>
								<span><?php esc_html_e( 'Fullscreen', 'nels' ); ?></span>
							</a>
						</div>
					</div>
				</div>

				<?php if ( $productOptions->getProductThumbnailsEnabled() ) : ?>
					<div class="woocommerce-product-gallery__thumbnails owl-carousel-thumbnails
								<?php echo esc_attr( $thumbnailsVerticalPositionClass )?>"
					     data-nb-slides="<?php echo esc_attr( $productOptions->getProductThumbnailsNbSlides() ) ?>"
						 data-navigation="<?php echo esc_attr( $productOptions->getProductThumbnailsNavigation() ) ?>">
						<?php ShopTemplateHelper::showProductImages( false ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

	<?php endif;

	if ( $productOptions->getHeroHeader() ) :
		echo Service::templatesUtil()->filterContent( $productOptions->getHeroHeader() );
	endif;

	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

</div>