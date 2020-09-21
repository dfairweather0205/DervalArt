<?php

use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );

$title      = $options->getTitleArea();
$cssClasses = empty( $title ) ? '' : 'reset-font-weight';

$partialElementType = Service::templatesUtil()->getPartialElementType();
?>

	<h1 class="branding__title <?php echo esc_attr( $cssClasses ) ?>">
		<?php echo( empty( $title ) ? esc_html( get_the_title() ) : wp_kses_post( $title ) ) ?>
	</h1>

<?php Service::util()->partial( 'single/' . $partialElementType . '/elements/branding-meta' ); ?>