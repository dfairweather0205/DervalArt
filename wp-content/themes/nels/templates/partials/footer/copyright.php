<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

?>

<div class="copyright">
	<?php echo wp_kses_post( Service::themeOptionsUtil()->getOption( ThemeOption::FOOTER_BELOW_COPYRIGHT ) ) ?>
</div>