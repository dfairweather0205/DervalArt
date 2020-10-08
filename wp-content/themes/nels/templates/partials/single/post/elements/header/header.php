<?php

use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadStandardOptions( get_the_ID() );
set_query_var( 'postOptions', $options );

if ( $options->isFeaturedImage() && has_post_thumbnail() ) : ?>

	<div class="entry-header__item entry-thumbnail">
		<div class="featured-image">
			<?php the_post_thumbnail(); ?>
		</div>
	</div>

<?php endif;