<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer  $this
 * @var \Pikart\Nels\Post\Options\Type\AlbumOptions $options
 * @var array                                       $data
 */

use Pikart\WpThemeCore\Post\Type\Format\PostFormatSlug;

$item    = $data['item'];
$options = $data['options'][ $item ];

$isImageFormat = get_post_format( $item ) === PostFormatSlug::IMAGE;
$isVideoFormat = get_post_format( $item ) === PostFormatSlug::VIDEO;

$hasImage  = $isImageFormat && has_post_thumbnail( $item );
$hasVideo  = $isVideoFormat && ( $options->isVideoTypeOnlineService() || $options->isVideoTypeSelfHosted() );

if ( ! $hasImage && ! $hasVideo ) :
	return;
endif; ?>

<div class="card-header header-<?php echo esc_attr( get_post_format( $data['item'] ) ) ?>">
	<?php $this->partial( 'album/featured-image/container-inner', $data ); ?>
</div>
