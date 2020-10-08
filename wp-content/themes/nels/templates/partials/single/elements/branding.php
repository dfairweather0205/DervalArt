<?php

use Pikart\Nels\DependencyInjection\Service;

$commonOptions = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );

if ( ! $commonOptions->isBrandingEnabled() ) :
	return;
endif;

$itemTitle          = $commonOptions->getTitleArea();
$cssClasses         = empty( $itemTitle ) ? '' : 'reset-font-weight';
$partialElementType = Service::templatesUtil()->getPartialElementType();
?>

<div class="entry-branding">
	<div class="default-branding">

		<?php Service::templatesUtil()->generateBreadcrumbs(); ?>

		<h1 class="branding__title <?php echo esc_attr( $cssClasses ) ?>">
			<?php echo( empty( $itemTitle ) ? esc_html( get_the_title() ) : wp_kses_post( $itemTitle ) ) ?>
		</h1>

		<?php Service::util()->partial( 'single/' . $partialElementType . '/elements/branding-meta' ); ?>

	</div>
</div>
