<?php

use Pikart\Nels\DependencyInjection\Service;

/* @var \Pikart\Nels\Blog\Options\BlogOptions $blogOptions */

$options = Service::postOptionsLoader()->loadStandardOptions( get_the_ID() );
set_query_var( 'postOptions', $options );
set_query_var( 'displayExcerpt', $options->isPostExcerptEnabled() );

if ( has_post_thumbnail() ) : ?>

	<div class="card-header header-standard">

		<a class="card-thumbnail" href="<?php the_permalink() ?>">
			<?php
			Service::util()->partial( 'blog/article/elements/header-overlay' );
			the_post_thumbnail( 'post-thumbnail' ); ?>
		</a>

	</div>

<?php endif;

Service::util()->partial( 'blog/article/elements/content-card' );