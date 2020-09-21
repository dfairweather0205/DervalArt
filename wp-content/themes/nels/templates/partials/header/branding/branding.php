<?php

use Pikart\Nels\DependencyInjection\Service;

?>

<div class="site-branding">
	<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"
	   title="<?php echo esc_attr( get_bloginfo( 'name' ) ) ?>" rel="home">

		<?php Service::util()->partial( 'header/branding/branding-logo' ) ?>
	</a>
</div>