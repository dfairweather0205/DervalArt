<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ShopUtil::isShop() ) :
	$commonOptions   = Service::postOptionsLoader()->loadCommonPostOptions( ShopUtil::getShopPageId() );
	$displayBranding = ! $commonOptions->isFeaturedBranding() && $commonOptions->isBrandingEnabled();
else:
	$displayBranding = ! Service::themeOptionsUtil()->isFeaturedBrandingEnabled();
endif;

if ( $displayBranding ) : ?>
	<div class="entry-branding">
		<div class="default-branding">
			<?php
			Service::templatesUtil()->generateBreadcrumbs();
			Service::util()->partial( 'shop/elements/branding' ); ?>
		</div>
	</div>
<?php endif; ?>

<header class="entry-header header-page is-full-width">
	<?php Service::util()->partial( 'single/page/elements/header' ); ?>
</header>

<?php Service::util()->partial( 'shop/elements/content' ) ?>

<footer class="entry-footer">
	<?php Service::util()->partial( 'shop/elements/footer' ); ?>
</footer>