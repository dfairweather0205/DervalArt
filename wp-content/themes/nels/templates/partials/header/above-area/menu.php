<?php use Pikart\Nels\Site\NavigationMenu;

if ( has_nav_menu( NavigationMenu::ABOVE_MENU ) ) : ?>

	<nav id="above-area-navigation" class="navigation navigation--above-area" role="navigation">
		<?php wp_nav_menu( array(
			'theme_location' => NavigationMenu::ABOVE_MENU,
			'menu_class'     => 'menu menu-horizontal dropdown',
			'menu_id'        => 'above-area-menu',
			'container'      => '',
			'items_wrap'     => '<ul id="%1$s" class="%2$s" data-responsive-menu="dropdown">%3$s</ul>',
			'link_before'    => '<span class="menu-item__span">',
			'link_after'     => '</span>',
		) ); ?>
	</nav>

<?php endif;