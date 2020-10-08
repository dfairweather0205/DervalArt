<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$output = Service::util()->getPartialContent( 'single/elements/social-area' );

if ( ! ShopUtil::isShop() || empty( $output ) ) :
	return;
endif;

$commonOptions = Service::postOptionsLoader()->loadCommonPostOptions( ShopUtil::getShopPageId() );
$siteWidth     = sprintf( 'max-width: %spx', esc_attr( $commonOptions->getSiteWidth() ) );

echo <<<HTML
<div class="entry-footer__item entry-meta" style="$siteWidth">
	<div class="entry-meta__wrapper">
		$output
	</div>
</div>
HTML;
