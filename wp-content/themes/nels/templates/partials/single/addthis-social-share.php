<?php

use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;
use Pikart\WpThemeCore\Shop\ShopUtil;

$socialServices = PikartBaseUtil::getSocialServices();

isset( $pikartSocialShareItem ) || $pikartSocialShareItem = ShopUtil::isShop() ? PostTypeSlug::PAGE : get_post_type();

if ( ! PikartBaseUtil::isSocialShareVisible( $pikartSocialShareItem ) || empty( $socialServices ) ) :
	return;
endif;

$itemId = ShopUtil::isShop() ? ShopUtil::getShopPageId() : get_the_ID(); ?>

<div class="social-share">
	<div class="social-share__wrapper">

		<span class="social__button">
			<?php esc_html_e( 'Share:', 'nels' ); ?>
		</span>

		<div class="social__list addthis-toolbox addthis_toolbox"
			 addthis:url="<?php the_permalink( $itemId ) ?>"
			 addthis:title="<?php echo esc_attr( get_the_title( $itemId ) ) ?>">

			<?php foreach ( $socialServices as $service ): ?>
				<a class="addthis_button_<?php echo esc_attr( $service ) ?>"></a>
			<?php endforeach; ?>

		</div>

	</div>
</div>