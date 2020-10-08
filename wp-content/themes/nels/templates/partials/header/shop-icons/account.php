<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Shop\ShopUtil;

$themeOptionsUtil = Service::themeOptionsUtil();
$accountPageId    = ShopUtil::getMyAccountPageId();

if ( ! ShopUtil::isShopActivated() || ! $themeOptionsUtil->headerHasShopIcon( 'my_account' ) || ! $accountPageId
     || is_account_page() ) :
	return;
endif;
?>

<div class="my-account-icon">

	<a class="account-icon" href="<?php the_permalink( $accountPageId ) ?>"
	   title="<?php esc_attr_e( 'Account', 'nels' ); ?>">
		<i class="icon-user"></i>
	</a>

	<?php Service::util()->partial( 'header/popups/my-account-popup' ) ?>

</div>