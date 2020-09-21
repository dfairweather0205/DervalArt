<?php
use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadAudioOptions( get_the_ID() );
set_query_var( 'postOptions', $options );

if ( ! $options->isFeaturedAudio() || ! $options->hasSource() ) :
	return;
endif; ?>

<div class="entry-header__item entry-thumbnail">

	<?php if ( $options->hasEmbedded() ) :
		echo Service::dataSanitizer()->wpKsesWithIframe( $options->getSource() );
	elseif ( $options->hasUrl() ) :
		echo wp_oembed_get( esc_url( $options->getSource() ) );
	endif; ?>

</div>