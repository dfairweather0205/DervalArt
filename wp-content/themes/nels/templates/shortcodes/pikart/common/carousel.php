<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var \Pikart\Nels\Post\Options\Type\AlbumOptions $options
 * @var array $data
 */

use Pikart\Nels\DependencyInjection\Service;

$carouselSlidesSpacing = max( 0, (int) $data['masonry_columns_spacing'] );

$dataAnimationDelay  = 1000 * Service::util()->getValidNumberInRange( $data['animation_delay'], 0, 3 );
$hasAnimation        = $data['animation'] !== 'none';
$containerCssClasses = trim( $data['container_css_classes'] . $this->textIfValTrue( ' animated not-visible', $hasAnimation ) );

$articleCssClasses = sprintf( 'card card--carousel card--%s card-skin--%s',
	$data['masonry_display'], $data['text_color_skin'] );
?>

<div class="<?php echo esc_attr( $containerCssClasses ) ?>" data-index="<?php echo esc_attr( $this->getIndex() ) ?>"
	<?php
	if ( $hasAnimation && ! empty ( $data['animation'] ) ) :
		printf( ' data-animation="%s"', esc_attr( $data['animation'] ) );
	endif;

	if ( $hasAnimation && ! empty ( $dataAnimationDelay ) ) :
		printf( ' data-animation-delay="%s"', esc_attr( $dataAnimationDelay ) );
	endif; ?> >

	<?php if ( count( $data['items'] ) > 0 ) :

		$data['shortcode']->beforeLoop(); ?>

		<div class="archive-items owl-carousel"
			 data-nb-slides="<?php echo esc_attr( (int) $data['masonry_nb_columns'] ) ?>"
			 data-slides-spacing="<?php echo esc_attr( $carouselSlidesSpacing ) ?>"
			 data-slides-autoplay="<?php echo esc_attr( $data['carousel_autoplay'] ) ?>"
			 data-slides-autoplay-speed="<?php echo esc_attr( (int) $data['carousel_autoplay_speed'] ) ?>">

			<?php foreach ( $data['items'] as $itemId ) :
				$data['shortcode']->beforeItem( $itemId );

				$data['item'] = $itemId;
				$options      = $data['options'][ $itemId ]; ?>

				<article class="<?php echo esc_attr( $articleCssClasses ) ?>">
					<div class="card-body">
						<?php $this->partial( $data['shortcode_name'] . '/featured-image/container', $data );
						$this->partial( $data['shortcode_name'] . '/header-branding', $data ); ?>
					</div>
				</article>

				<?php
				$data['shortcode']->afterItem();
			endforeach; ?>

		</div>

		<?php
		$data['shortcode']->afterLoop();
	endif; ?>
</div>
