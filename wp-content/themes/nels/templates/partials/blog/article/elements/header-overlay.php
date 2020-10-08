<?php

use Pikart\Nels\DependencyInjection\Service;

/* @var \Pikart\Nels\Blog\Options\BlogOptions $blogOptions */
isset( $blogOptions ) || $blogOptions = Service::blogOptionsLoader()->load();

$isBlogTemplate           = Service::templatesUtil()->isBlogTemplate();
$overlayColorTransparency = Service::util()->getValidNumberInRange( $blogOptions->getOverlayTransparency(), 0, 100 );
$innerStyle               = $isBlogTemplate
	? sprintf( 'opacity: %s;', Service::util()->transparencyToOpacity( $overlayColorTransparency ) ) : '';

if ( Service::templatesUtil()->isTransparencyAllowed( $blogOptions->getBlogDisplay() ) || ! $isBlogTemplate ) : ?>

	<div class="color-overlay">
		<div class="color-overlay-inner" style="<?php echo esc_attr( $innerStyle ) ?>"></div>
	</div>

<?php endif; ?>