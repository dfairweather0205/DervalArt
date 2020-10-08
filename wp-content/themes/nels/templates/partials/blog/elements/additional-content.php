<?php
use Pikart\Nels\DependencyInjection\Service;

$options = Service::blogOptionsLoader()->load( get_the_ID() );

if ( $options->getAdditionalContent() ): ?>

	<div class="blog-additional-content">
		<?php echo Service::templatesUtil()->filterContent( $options->getAdditionalContent() ) ?>
	</div>

<?php endif;