<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! ShopUtil::isShopActivated() ) :
	return;
endif;

$commonOptions = Service::postOptionsLoader()->loadCommonPostOptions( ShopUtil::getShopPageId() );

$isSidebarEnabled = ShopUtil::isShop() ? $commonOptions->isSiteContentSidebar()
	: Service::themeOptionsUtil()->isArchiveSidebarEnabled();

$contentInnerClasses = Service::templatesUtil()->getContentCssClass( $isSidebarEnabled );
$contentInnerStyle   = Service::templatesUtil()->getContentFloat( $isSidebarEnabled );

$siteWidth   = sprintf( 'max-width: %spx', $commonOptions->getSiteWidth() );
$isFullWidth = $commonOptions->isFullWidth() ? 'is-full-width' : '';
?>

<div class="entry-content <?php echo esc_attr( $isFullWidth ) ?>" style="<?php echo esc_attr( $siteWidth ) ?>">
	<div class="entry-content__item entry-content-area <?php echo esc_attr( $contentInnerClasses ) ?>"
	     style="<?php echo esc_attr( $contentInnerStyle ) ?>">

		<?php
		/**
		 * woocommerce_archive_description hook.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
		?>

		<?php Service::util()->partial( 'shop/elements/archive-list' ); ?>

	</div>

	<?php if ( $isSidebarEnabled ):
		Service::util()->partial( 'main-sidebar' );

		/**
		 * Hook: woocommerce_sidebar.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	endif; ?>
</div>