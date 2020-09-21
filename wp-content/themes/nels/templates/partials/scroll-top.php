<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

if ( Service::themeOptionsUtil()->getBoolOption( ThemeOption::SCROLL_TOP_BUTTON ) ) : ?>

	<a class="scroll-top-button">
		<span class="scroll-top-button__wrapper">
			<svg class="scroll-top-button__svg" width="18px" height="13px" viewBox="0 0 18 13">
				<polyline class="scroll-top-button__arrow-up" points="1.3,6.8 9.1,1.3 16.9,6.8 "/>
				<polyline class="scroll-top-button__arrow-down" points="1.3,12 9.1,6.4 16.9,12 "/>
			</svg>
		</span>
	</a>

<?php endif;