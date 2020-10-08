<?php use Pikart\Nels\Site\NavigationMenu;

if ( has_nav_menu( NavigationMenu::FOOTER_MENU ) ) : ?>

	<nav id="footer-navigation" class="navigation navigation--footer" role="navigation">
		<?php wp_nav_menu( array(
			'theme_location' => NavigationMenu::FOOTER_MENU,
			'menu_class'     => 'menu menu-horizontal',
			'menu_id'        => 'footer-menu',
			'container'      => '',
			'link_before'    => '<span class="menu-item__span">',
			'link_after'     => '</span>',
			'depth'          => 1,
		) ); ?>
	</nav>

<?php endif;