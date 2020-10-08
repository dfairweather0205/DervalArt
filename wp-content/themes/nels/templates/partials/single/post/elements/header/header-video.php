<?php

use Pikart\Nels\DependencyInjection\Service;

$options   = Service::postOptionsLoader()->loadVideoOptions( get_the_ID() );
$videoLink = $options->getVideoUploadedLink();

set_query_var( 'postOptions', $options );

$isFeaturedVideo = $options->isFeaturedVideo();
$isServiceOnline = $options->isVideoTypeOnlineService();
$isSelfHosted    = $options->isVideoTypeSelfHosted();

if ( ! $isFeaturedVideo || ( ! $isServiceOnline && ! $isSelfHosted ) ) :
	return;
endif;

$videoLink      = $options->getVideoUploadedLink();
$thumbnailUrl   = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
$autoplayText   = $options->getVideoAutoplay() ? 'autoplay muted' : '';
$autoplayStatus = $options->getVideoAutoplay() ? 'on' : 'off';

?>

<div class="entry-header__item entry-thumbnail fluid-video">
	<?php if ( $isServiceOnline ) :

		if ( $options->hasEmbedded() ) :
			echo Service::dataSanitizer()->wpKsesWithIframe( $options->getSource() );
		elseif ( $options->hasUrl() ) :
			echo wp_oembed_get( esc_url( $options->getSource() ) );
		endif;

	elseif ( $isSelfHosted ) : ?>

		<video class="featured-video" src="<?php echo esc_url( $videoLink ) ?>"
			   poster="<?php echo esc_url( $thumbnailUrl ) ?>" <?php echo esc_attr( $autoplayText ) ?> loop controls
			   data-autoplay="<?php echo esc_attr( $autoplayStatus ) ?>">
		</video>
		<div class="video-play-button"></div>

	<?php endif; ?>
</div>