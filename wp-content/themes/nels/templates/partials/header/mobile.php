<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Misc\PikartBaseUtil;
use Pikart\Nels\Site\NavigationMenu;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil = Service::themeOptionsUtil();

$itemsWrap = '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion">%3$s</ul>';
$colorSkin = sprintf( 'mobile-menu--skin-%s', $themeOptionsUtil->getOption( ThemeOption::HEADER_MOBILE_MENU_COLOR_SKIN ) );

$headerSearchAreaText = Service::themeOptionsUtil()->getOption( ThemeOption::HEADER_SEARCH_AREA_TEXT );
?>

<div class="mobile-navigation <?php echo esc_attr( $colorSkin ) ?>">

	<form class="mobile-search-form" action='<?php echo esc_url( home_url( '/' ) ); ?>' method='get' role='search'>
		<div class="search-form__field">
			<input type="search" name="s" class="search-form__input" value="<?php the_search_query() ?>"
				   autocomplete="off" placeholder="<?php echo esc_attr( $headerSearchAreaText ) ?>"/>

			<button class="search-form__button"></button>

			<?php if ( Service::themeOptionsUtil()->isHeaderProductSearchModeEnabled() ) : ?>
				<input type="hidden" name="post_type" value="product" />
			<?php endif; ?>
		</div>
	</form>

	<nav id="site-navigation-mobile" class="navigation navigation--main navigation--main--mobile" role="navigation">
		<?php wp_nav_menu( array(
			'theme_location' => NavigationMenu::PRIMARY,
			'menu_class'     => 'menu primary-menu mobile-menu accordion',
			'menu_id'        => 'primary-menu-mobile',
			'container'      => '',
			'items_wrap'     => $itemsWrap,
			'link_before'    => '<span class="menu-item__span">',
			'link_after'     => '</span>',
			'fallback_cb'    => false,
		) ); ?>
	</nav>

	<?php
	PikartBaseUtil::wishlistPartial( 'header/shop-icons/wishlist-mobile' );
	PikartBaseUtil::productsComparePartial( 'header/shop-icons/products-compare-mobile' );
	Service::util()->partial( 'header/shop-icons/account-mobile' ); ?>

	<?php if ( has_nav_menu( NavigationMenu::SOCIAL_PRIMARY ) ) : ?>
		<nav id="social-nav-primary-mobile" class="navigation navigation--social" role="navigation"
			 aria-label="<?php esc_attr_e( 'Social', 'nels' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => NavigationMenu::SOCIAL_PRIMARY,
				'menu_class'     => 'menu social-menu',
				'menu_id'        => 'social-primary-menu-mobile',
				'container'      => '',
				'link_before'    => '<span class="screen-reader-text">',
				'link_after'     => '</span>',
				'depth'          => 1,
			) );
			?>
		</nav>
	<?php endif; ?>

</div>