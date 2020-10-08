<?php
use Pikart\Nels\DependencyInjection\Service;

if ( has_post_thumbnail() ) : ?>

	<div class="card-header header-image">
		<a class="card-thumbnail" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'post-thumbnail' ); ?>
		</a>
	</div>

<?php else :
	Service::util()->partial( 'blog/article/elements/content-card' );
endif;