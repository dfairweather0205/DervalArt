<?php
use Pikart\Nels\DependencyInjection\Service;

$productOptions = Service::postOptionsLoader()->loadProductOptions( get_the_ID() );

$contentInnerClasses = Service::templatesUtil()->getContentCssClass( $productOptions->isSiteContentSidebar() );
$contentInnerStyle   = Service::templatesUtil()->getContentFloat( $productOptions->isSiteContentSidebar() );

$isProductHeaderFullWidth = $productOptions->getProductHeaderFullWidth() ? ' is-full-width' : '';

$siteWidth   = sprintf( 'max-width: %spx', $productOptions->getSiteWidth() );
$isFullWidth = $productOptions->isFullWidth() ? 'is-full-width' : '';
?>

<header class="entry-header header-product <?php echo esc_attr( $isProductHeaderFullWidth ) ?>">
	<?php
	Service::util()->partial( 'single/product/elements/header' );
	Service::util()->partial( 'single/product/elements/details' ); ?>
</header>

<div class="entry-content <?php echo esc_attr( $isFullWidth ) ?>" style="<?php echo esc_attr( $siteWidth ) ?>">
	<div class="entry-content__item entry-content-area <?php echo esc_attr( $contentInnerClasses ) ?>"
	     style="<?php echo esc_attr( $contentInnerStyle ) ?>">
		<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );

		woocommerce_template_single_meta(); ?>
	</div>

	<?php if ( $productOptions->isSiteContentSidebar() ):
		Service::util()->partial( 'main-sidebar' );
	endif; ?>
</div>

<footer class="entry-footer">
	<?php Service::util()->partial( 'single/product/elements/footer' ); ?>
</footer>