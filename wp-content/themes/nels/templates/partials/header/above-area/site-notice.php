<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

?>

<div class="site-notice">
	<?php echo wp_kses_post( Service::themeOptionsUtil()->getOption( ThemeOption::HEADER_ABOVE_SITE_NOTICE ) ) ?>
</div>
