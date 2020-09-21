<?php

use Pikart\Nels\Site\NavigationMenu;

if ( has_nav_menu( NavigationMenu::SOCIAL_PRIMARY ) ) : ?>

	<div class="social-icons">
		<nav id="social-nav-primary" class="navigation navigation--social" role="navigation"
		     aria-label="<?php esc_attr_e( 'Social', 'nels' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => NavigationMenu::SOCIAL_PRIMARY,
				'menu_class'     => 'menu menu-horizontal social-menu',
				'menu_id'        => 'social-primary-menu',
				'container'      => '',
				'link_before'    => '<span class="screen-reader-text">',
				'link_after'     => '</span>',
				'depth'          => 1,
			) );
			?>
		</nav>
	</div>

<?php endif;