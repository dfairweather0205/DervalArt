<?php

use Pikart\Nels\DependencyInjection\Service;

if ( ! Service::themeOptionsUtil()->isHeaderSearchAreaEnabled() ):
	return;
endif;
?>

<div class="search-icon">
	<a class="search-button-icon" href="#">
		<i class="icon-magnifier"></i>
	</a>
</div>