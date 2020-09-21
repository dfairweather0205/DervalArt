<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$commonOptions = Service::postOptionsLoader()->loadCommonPostOptions( ShopUtil::getShopPageId() );

$isFeaturedBrandingEnabled = ShopUtil::isShop() ? $commonOptions->isFeaturedBranding()
	: Service::themeOptionsUtil()->isFeaturedBrandingEnabled();

$siteMainCssClasses = ShopUtil::isShop()
	? 'site-main--single site-main--page site-main--shop' : 'site-main--archive';

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

if ( $isFeaturedBrandingEnabled ) :
	Service::util()->partial( 'header-area' );
endif; ?>

	<div id="content-area" class="content-area">
		<main class="site-main <?php echo esc_attr( $siteMainCssClasses ) ?>" role="main">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php Service::util()->partial( 'shop/shop' ); ?>
			</article>

		</main>
	</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );