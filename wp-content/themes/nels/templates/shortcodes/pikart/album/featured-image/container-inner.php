<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var \Pikart\Nels\Post\Options\Type\AlbumOptions $options
 * @var array $data
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Post\Options\Type\AlbumOptions;
use Pikart\WpThemeCore\Common\ThemePathsUtil;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

$item    = $data['item'];
$options = $data['options'][ $item ];

$thumbnailUrl = has_post_thumbnail( $item )
	? get_the_post_thumbnail_url( $item, 'post-thumbnail' ) : ThemePathsUtil::getImagesUrl( 'blank.gif' );

$uploadedLink   = $options->getVideoUploadedLink();
$videoSource    = $options->getVideoSource();
$autoplayText   = $options->getVideoAutoplay() ? 'autoplay muted' : '';
$autoplayStatus = $options->getVideoAutoplay() ? 'on' : 'off';

/**
 * @param AlbumOptions $options
 */
$printLinkStart = function ( $options ) {
	$albumLink = $options->getButtonLink();

	if ( empty( $albumLink ) ) {
		echo '<div class="card-thumbnail">';

		return;
	}

	$newTab = $options->getNewTab();

	printf( '<a class="card-thumbnail" href="%s" %s >',
		esc_url( $albumLink ), empty ( $newTab ) ? '' : 'target="_blank"' );
};

/**
 * @param AlbumOptions $options
 */
$printLinkEnd = function ( $options ) {
	$albumLink = $options->getButtonLink();

	print( empty ( $albumLink ) ? '</div>' : '</a>' );
};

$isTransparencyAllowed = Service::templatesUtil()->isTransparencyAllowed( $data['masonry_display'] );

if ( get_post_format( $item ) === PostFormatSlug::VIDEO ) :

	if ( $isTransparencyAllowed ) :

		$printLinkStart( $options );
		$this->partial( 'common/header-overlay', $data );
		$printLinkEnd( $options );

	endif; ?>

	<div class="card-thumbnail fluid-video">
		<?php if ( $options->isVideoTypeOnlineService() ) :

			if ( ! empty( $videoSource ) && ! Util::isUrl( $videoSource ) ) :
				echo Service::dataSanitizer()->wpKsesWithIframe( $videoSource );
			elseif ( ! empty( $videoSource ) && Util::isUrl( $videoSource ) ) :
				echo wp_oembed_get( esc_url( $videoSource ) );
			endif;

		elseif ( $options->isVideoTypeSelfHosted() ) : ?>

			<video class="featured-video" src="<?php echo esc_url( $uploadedLink ) ?>"
				   poster="<?php echo esc_url( $thumbnailUrl ) ?>" <?php echo esc_attr( $autoplayText ) ?> loop controls
				   data-autoplay="<?php echo esc_attr( $autoplayStatus ) ?>">
			</video>
			<div class="video-play-button"></div>

		<?php endif; ?>
	</div>

<?php else :

	$printLinkStart( $options );

	if ( $isTransparencyAllowed ) :
		$this->partial( 'common/header-overlay', $data );
	endif;

	echo get_the_post_thumbnail( $item, 'post-thumbnail' );
	$printLinkEnd( $options );

endif;