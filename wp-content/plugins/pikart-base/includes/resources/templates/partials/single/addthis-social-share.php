<?php

use Pikart\WpBase\DependencyInjection\Service;
use Pikart\WpCore\Post\Type\PostTypeSlug;
use Pikart\WpCore\Shop\ShopUtil;

$socialServices = Service::optionsPagesUtil()->getSocialServices();

isset( $pikartSocialShareItem ) || $pikartSocialShareItem = ShopUtil::isShop() ? PostTypeSlug::PAGE : get_post_type();

if ( ! Service::optionsPagesUtil()->isSocialShareVisible( $pikartSocialShareItem ) || empty( $socialServices ) ) :
	return;
endif;

$itemId = ShopUtil::isShop() ? ShopUtil::getShopPageId() : get_the_ID();
?>

<div class="social-share">
	<div class="social-share__wrapper">

		<span class="social__button">
			<span class="social__button-inner"><?php esc_html_e( 'Share', 'pikart-base' ); ?></span>
		</span>

		<div class="social__list addthis-toolbox addthis_toolbox"
			 addthis:url="<?php echo esc_url( get_permalink( $itemId ) ) ?>"
			 addthis:title="<?php echo esc_attr( get_the_title( $itemId ) ) ?>">

			<?php foreach ( $socialServices as $service ): ?>
				<a class="addthis_button_<?php echo esc_attr( $service ) ?>"></a>
			<?php endforeach; ?>

		</div>

	</div>
</div>