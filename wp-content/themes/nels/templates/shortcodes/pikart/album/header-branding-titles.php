<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var \Pikart\Nels\Post\Options\Type\AlbumOptions $options
 * @var array $data
 */

$item    = $data['item'];
$options = $data['options'][ $item ];

$albumTitle    = $options->getTitle();
$albumSubtitle = $options->getSubtitle();

if ( ! empty( $albumTitle ) ) : ?>
	<h4 class="branding__title"
		<?php echo( sprintf( 'style="font-size: %dpx;"', esc_attr( $options->getMasonryTitleFontSize() ) ) ) ?> >
		<?php echo wp_kses_post( $albumTitle ) ?>
	</h4>
<?php endif;

if ( ! empty( $albumSubtitle ) ) : ?>
	<div class="branding__meta">
		<div class="branding__meta__item">
			<?php echo wp_kses_post( $albumSubtitle ); ?>
		</div>
	</div>
<?php endif;


