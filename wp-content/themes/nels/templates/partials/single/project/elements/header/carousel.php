<?php

use Pikart\Nels\DependencyInjection\Service;

/* @var \Pikart\Nels\Post\Options\Type\ProjectOptions $projectOptions */

$heroHeader = $projectOptions->getHeroHeader();

if ( count( $projectOptions->getImages() ) < 1 && empty( $heroHeader ) ) :
	return;
endif; ?>

<div class="entry-header__item entry-thumbnail hero-header">

	<?php if ( count( $projectOptions->getImages() ) > 0 ) : ?>

		<div class="owl-carousel"
			 data-nb-slides="<?php echo esc_attr( $projectOptions->getCarouselNbSlides() ) ?>"
			 data-slides-spacing="<?php echo esc_attr( $projectOptions->getCarouselSlidesSpacing() ) ?>">

			<?php foreach ( $projectOptions->getImages() as $imageId ):
				$imageUrl = wp_get_attachment_image_url( $imageId, 'full' );
				$imageAltText = get_post_meta( $imageId, '_wp_attachment_image_alt', true ); ?>

				<img src="<?php echo esc_url( $imageUrl ) ?>" alt="<?php echo esc_attr( $imageAltText ) ?>"/>
			<?php endforeach; ?>

		</div>

	<?php endif;

	if ( ! empty( $heroHeader ) ) :
		echo Service::templatesUtil()->filterContent( $heroHeader );
	endif; ?>

</div>
