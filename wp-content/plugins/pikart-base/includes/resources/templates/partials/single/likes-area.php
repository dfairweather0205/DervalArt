<?php

use Pikart\WpBase\DependencyInjection\Service;
use Pikart\WpCore\Post\PostFilterName;
use Pikart\WpCore\Post\Type\PostTypeSlug;
use Pikart\WpCore\Shop\ShopUtil;

isset( $pikartLikesAreaItem ) || $pikartLikesAreaItem = ShopUtil::isShop() ? PostTypeSlug::PAGE : get_post_type();

if ( ! Service::optionsPagesUtil()->isLikesAreaVisible( $pikartLikesAreaItem ) ) :
	return;
endif;

$postLikesFacade    = Service::postLikesFacade();
$postLikedIconClass = 'fa-heart';
$likePostIconClass  = 'fa-heart-o';
$iconClass          = $postLikesFacade->isPostLiked( get_the_ID() ) ? $postLikedIconClass : $likePostIconClass;
$nbLikes            = $postLikesFacade->getPostNbLikes( get_the_ID() );
$nbLikesText        = apply_filters( PostFilterName::postLikesNumberText(), $nbLikes );
?>

<div class="likes-area">
	<a href="#" class="likes-area__link" data-post-id="<?php the_ID() ?>"
	   data-nb-likes="<?php echo esc_attr( $nbLikes ) ?>">
		<span class="likes-area__icons">
				<i class="fa <?php echo esc_attr( $iconClass ) ?>" data-spinner-icon-class="fa-spinner fa-spin"
				   data-like-post-icon-class="<?php echo esc_attr( $likePostIconClass ) ?>"
				   data-post-liked-icon-class="<?php echo esc_attr( $postLikedIconClass ) ?>"></i>
		</span>
		<span class="likes-area__number"><?php echo esc_html( $nbLikesText ) ?></span>
	</a>
</div>