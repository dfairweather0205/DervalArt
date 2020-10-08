<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil     = Service::themeOptionsUtil();
$fullWidthHeaderClass = $themeOptionsUtil->layoutHasElement( 'header' ) ? 'fullwidth' : '';
$siteHeaderType       = $themeOptionsUtil->getOption( ThemeOption::MAIN_NAVIGATION_TYPE );
?>

<div class="site-header__main">
	<div class="site-header__main__wrapper <?php echo esc_attr( $fullWidthHeaderClass ) ?>">

		<?php if ( $siteHeaderType === 'side' ) :

			Service::util()->partial( 'header/branding/branding' );
			Service::util()->partial( 'header/menus/menu-main' );
			Service::util()->partial( 'header/icons' );

		elseif ( $siteHeaderType === 'center' ) :

			Service::util()->partial( 'header/menus/menu-main' );
			Service::util()->partial( 'header/branding/branding' );
			Service::util()->partial( 'header/icons' );

		else :

			Service::util()->partial( 'header/branding/branding' ); ?>
			<div class="site-navigation-and-icons">
				<?php
				Service::util()->partial( 'header/menus/menu-main' );
				Service::util()->partial( 'header/icons' );
				?>
			</div>

		<?php endif; ?>

	</div>
</div>