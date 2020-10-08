<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! Service::themeOptionsUtil()->isMyAccountPopupEnabled() ) :
	return;
endif;

$isUserLoggedIn    = is_user_logged_in();
$accountPopupClass = $isUserLoggedIn ? 'logged-in' : 'logged-out';
$userTemplate      = $isUserLoggedIn ? 'navigation' : 'form-login';
$accountPageId     = ShopUtil::getMyAccountPageId();

// Hide wc notices inside account popup
ShopTemplateHelper::backupAndClearWcNotices();
?>

<div class="account-icon-popup woocommerce <?php echo esc_attr( $accountPopupClass ) ?>">
	<div class="account-icon-popup-wrapper">
		<?php if ( ! $isUserLoggedIn ) : ?>

			<div class="account-icon-popup__create-link">
				<a href="<?php the_permalink( $accountPageId ) ?>">
					<?php esc_html_e( 'Create an Account', 'nels' ); ?>
				</a>
			</div>

		<?php endif;

		wc_get_template( sprintf( 'myaccount/%s.php', $userTemplate ) ); ?>
	</div>
</div>

<?php
//restore wc notices to be displayed later
ShopTemplateHelper::restoreWcNoticesFromBackup();