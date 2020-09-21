<?php

use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadAudioOptions( get_the_ID() );

set_query_var( 'postOptions', $options );
set_query_var( 'displayExcerpt', $options->isPostExcerptEnabled() );

if ( $options->hasSource() ) : ?>

	<div class="card-header header-audio">

		<a href="<?php the_permalink(); ?>">
			<?php Service::util()->partial( 'blog/article/elements/header-overlay' ); ?>
		</a>

		<div class="card-thumbnail">
			<?php if ( $options->hasEmbedded() ) :
				echo Service::dataSanitizer()->wpKsesWithIframe( $options->getSource() );
			elseif ( $options->hasUrl() ) :
				echo wp_oembed_get( esc_url( $options->getSource() ) );
			endif; ?>
		</div>

	</div>

<?php endif;

Service::util()->partial( 'blog/article/elements/content-card' );