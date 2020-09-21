<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$commonOptions = Service::postOptionsLoader()->loadCommonPostOptions( ShopUtil::getShopPageId() );

$productTitle = $commonOptions->getTitleArea();
$cssClasses   = empty( $productTitle ) ? '' : 'reset-font-weight';

if ( ! $commonOptions->isBrandingEnabled() && ShopUtil::isShop() ) :
	return;
endif;

if ( ShopUtil::isShop() ) :

	if ( apply_filters( 'woocommerce_show_page_title', true ) ) :

		if ( empty( $productTitle ) ) : ?>

			<h1 class="woocommerce-products-header__title page-title branding__title">
				<?php woocommerce_page_title(); ?>
			</h1>

		<?php else : ?>

			<h1 class="branding__title <?php echo esc_attr( $cssClasses ) ?>">
				<?php echo wp_kses_post( $productTitle ) ?>
			</h1>

		<?php endif;

	endif;

else : ?>

	<h1 class="branding__title"><?php echo wp_kses_post( Service::templatesUtil()->getArchiveTitle() ) ?></h1>

<?php endif;
