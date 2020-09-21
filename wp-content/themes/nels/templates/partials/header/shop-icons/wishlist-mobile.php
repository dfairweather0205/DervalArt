<?php

use Pikart\Nels\DependencyInjection\Service;

if ( ! Service::themeOptionsUtil()->headerHasShopIcon( 'wishlist' ) ) :
	return;
endif;

/**
 * @global string $wishlistPageUrl
 * @global int $wishlistItemsNumber
 */
isset( $wishlistPageUrl ) || $wishlistPageUrl = '';
isset( $wishlistItemsNumber ) || $wishlistItemsNumber = 0;
?>

<a class="mobile-menu-wishlist" href="<?php echo esc_url( $wishlistPageUrl ) ?>">
	<span><?php esc_html_e( 'Wishlist', 'nels' ); ?></span>
	<span class="wishlist__items"
		<?php if ( ! $wishlistItemsNumber ):
			echo ' style="display: none"';
		endif; ?> >
		<span class="wishlist-icon__background"></span>
		<span class="wishlist-icon__items-number">
			<?php echo esc_html( $wishlistItemsNumber ) ?>
		</span>
	</span>
</a>