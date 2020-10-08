<?php

use Pikart\Nels\Site\NavigationMenu;

if ( has_nav_menu( NavigationMenu::SOCIAL_HEADER_ABOVE ) ) : ?>

	<nav id="social-nav-above-area" class="navigation navigation--social" role="navigation"
	     aria-label="<?php esc_attr_e( 'Social', 'nels' ); ?>">
		<?php
		wp_nav_menu( array(
			'theme_location' => NavigationMenu::SOCIAL_HEADER_ABOVE,
			'menu_class'     => 'menu menu-horizontal social-menu',
			'menu_id'        => 'social-above-area-menu',
			'container'      => '',
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>',
			'depth'          => 1,
		) );
		?>
	</nav>

<?php endif;