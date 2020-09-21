<?php

use Pikart\Nels\Site\NavigationMenu;

if ( has_nav_menu( NavigationMenu::SOCIAL_FOOTER_BELOW ) ) : ?>

	<nav id="social-nav-footer-below" class="navigation navigation--social" role="navigation"
	     aria-label="<?php esc_attr_e( 'Social', 'nels' ); ?>">
		<?php
		wp_nav_menu( array(
			'theme_location' => NavigationMenu::SOCIAL_FOOTER_BELOW,
			'menu_class'     => 'menu menu-horizontal social-menu',
			'menu_id'        => 'social-footer-below-menu',
			'container'      => '',
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>',
			'depth'          => 1,
		) );
		?>
	</nav>

<?php endif;