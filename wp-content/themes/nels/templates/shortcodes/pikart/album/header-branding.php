<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var \Pikart\Nels\Post\Options\Type\AlbumOptions $options
 * @var array $data
 */

$item    = $data['item'];
$options = $data['options'][ $item ];

$albumTitle       = $options->getTitle();
$albumSubtitle    = $options->getSubtitle();
$albumDescription = $options->getDescription();
$albumButtonLabel = $options->getButtonLabel();
$albumLink        = $options->getButtonLink();
$newTab           = $options->getNewTab();

$noContent = empty( $albumTitle ) && empty( $albumSubtitle ) && empty( $albumDescription ) && empty( $albumButtonLabel );
$noVideo   = ! $options->getVideoUploadedLink() && ! $options->getVideoSource();

if ( $noContent && $noVideo ) :
	return;
endif;

?>
<div class="card-content">
	<?php

	if ( empty ( $albumLink ) ) :
		echo '<div class="card-branding">';
	else:
		printf( '<a class="card-branding" href="%s" %s >',
			esc_url( $albumLink ), empty ( $newTab ) ? '' : 'target="_blank"' );
	endif;

	$this->partial( 'album/header-branding-titles', $data );

	echo( empty ( $albumLink ) ? '</div>' : '</a>' );

	if ( ! empty( $albumDescription ) ) : ?>
		<div class="card-excerpt">
			<?php echo wp_kses_post( $albumDescription ) ?>
		</div>
	<?php endif;

	if ( ! empty( $albumButtonLabel ) ) : ?>
		<div class="card-info">
			<span class="card-info__item">
				<span class="card-button">
					<a class="button" href="<?php echo( empty ( $albumLink ) ? '#' : esc_url( $albumLink ) ) ?>"
						<?php echo( empty ( $newTab ) ? '' : 'target="_blank"' ) ?> >
						<?php echo esc_html( $albumButtonLabel ) ?>
					</a>
				</span>
			</span>
		</div>
	<?php endif; ?>

</div>
