<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$themeOptionsUtil  = Service::themeOptionsUtil();
$accountPageId     = ShopUtil::getMyAccountPageId();

if ( ! ShopUtil::isShopActivated() || ! $themeOptionsUtil->headerHasShopIcon( 'my_account' ) || ! $accountPageId ) :
	return;
endif;
?>

<a class="mobile-menu-my-account" href="<?php the_permalink( $accountPageId ) ?>">
	<span><?php esc_html_e( 'My account', 'nels' ); ?></span>
</a>