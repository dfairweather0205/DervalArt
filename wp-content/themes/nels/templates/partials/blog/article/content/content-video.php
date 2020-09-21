<?php

use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadVideoOptions( get_the_ID() );

set_query_var( 'postOptions', $options );
set_query_var( 'displayExcerpt', $options->isPostExcerptEnabled() );

$videoLink      = $options->getVideoUploadedLink();
$thumbnailUrl   = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
$autoplayText   = $options->getVideoAutoplay() ? 'autoplay muted' : '';
$autoplayStatus = $options->getVideoAutoplay() ? 'on' : 'off';

if ( $options->isVideoTypeOnlineService() || $options->isVideoTypeSelfHosted() ) : ?>

	<div class="card-header header-video">

		<a href="<?php the_permalink(); ?>">
			<?php Service::util()->partial( 'blog/article/elements/header-overlay' ); ?>
		</a>

		<div class="card-thumbnail fluid-video">
			<?php if ( $options->isVideoTypeOnlineService() ) :

				if ( $options->hasEmbedded() ) :
					echo Service::dataSanitizer()->wpKsesWithIframe( $options->getSource() );
				elseif ( $options->hasUrl() ) :
					echo wp_oembed_get( esc_url( $options->getSource() ) );
				endif;

			elseif ( $options->isVideoTypeSelfHosted() ) : ?>

				<video class="featured-video" src="<?php echo esc_url( $videoLink ) ?>"
				       poster="<?php echo esc_url( $thumbnailUrl ) ?>" <?php echo esc_attr( $autoplayText ) ?>
					   loop controls data-autoplay="<?php echo esc_attr( $autoplayStatus ) ?>">
				</video>
				<div class="video-play-button"></div>

			<?php endif; ?>
		</div>

	</div>

<?php endif;

Service::util()->partial( 'blog/article/elements/content-card' );
