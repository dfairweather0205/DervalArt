<?php
/* @var \Pikart\Nels\Post\Options\Type\ProjectOptions $projectOptions */

use Pikart\Nels\DependencyInjection\Service;

if ( $projectOptions->getProjectDescription() ) : ?>

	<div class="entry-description">
		<?php echo Service::templatesUtil()->filterContent( $projectOptions->getProjectDescription() ) ?>
	</div>

<?php endif;
