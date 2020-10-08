<?php

use Pikart\Nels\DependencyInjection\Service;

if ( ! Service::themeOptionsUtil()->postHasElement( 'tags' ) || ! has_tag() ) :
	return;
endif;
?>

<div class="entry-taxonomies">
	<?php Service::util()->partial( 'single/tags' ); ?>
</div>