<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

if ( Service::themeOptionsUtil()->getOption( ThemeOption::SITE_LOADING_ANIMATION ) === 'none' ) :
	return;
endif;
?>

<div class="site-loader-bg">
	<?php
	$loadingAnimation = Service::themeOptionsUtil()->getOption( ThemeOption::SITE_LOADING_ANIMATION );
	Service::util()->partial( 'loader/' . $loadingAnimation ) ?>
</div>