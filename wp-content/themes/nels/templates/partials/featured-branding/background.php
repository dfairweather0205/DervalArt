<?php

use Pikart\Nels\DependencyInjection\Service;

$backgroundImageUrl = Service::templatesUtil()->getBackgroundImageUrl();

if ( ! empty( $backgroundImageUrl ) ) : ?>
	<div class="background-image"
	     style="background-image: url(<?php echo esc_url( $backgroundImageUrl ) ?>)">
	</div>
<?php endif; ?>

<div class="color-overlay"></div>
