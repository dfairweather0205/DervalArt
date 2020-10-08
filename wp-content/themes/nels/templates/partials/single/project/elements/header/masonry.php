<?php

use Pikart\Nels\DependencyInjection\Service;

/* @var \Pikart\Nels\Post\Options\Type\ProjectOptions $projectOptions */

$heroHeader = $projectOptions->getHeroHeader();

if ( count( $projectOptions->getImages() ) < 1 && empty( $heroHeader ) ) :
	return;
endif;

$columnsSpacing = $projectOptions->getColumnsSpacing();

$galleryItemStyle = sprintf( 'padding-right: %1$dpx; padding-bottom: %1$dpx; ', $columnsSpacing );

$galleryInnerMargins = Service::templatesUtil()->getProjectGalleryInnerMargins( $projectOptions );

$galleryClasses = sprintf( 'gallery gallery-columns-%d %s',
	$projectOptions->getNbColumns(), Service::templatesUtil()->getColumnsSpacingCssClassForMobile( $columnsSpacing ) );
?>

<div class="entry-header__item entry-thumbnail hero-header">

	<?php if ( count( $projectOptions->getImages() ) > 0 ) : ?>

		<div class="<?php echo esc_attr( $galleryClasses ) ?>" style="<?php echo esc_attr( $galleryInnerMargins ) ?>">

			<?php foreach ( $projectOptions->getImages() as $imageId ):
				$imageUrl = wp_get_attachment_image_url( $imageId, 'full' );
				$caption = get_post( $imageId )->post_excerpt;
				$imageAltText = get_post_meta( $imageId, '_wp_attachment_image_alt', true ); ?>

				<figure class="gallery-item" style="<?php echo esc_attr( $galleryItemStyle ) ?>">

					<div class="gallery-icon">
						<a href="<?php echo esc_url( $imageUrl ) ?>">
							<img class="attachment-full size-full" src="<?php echo esc_url( $imageUrl ) ?>"
								 alt="<?php echo esc_attr( $imageAltText ) ?>"/>
						</a>
					</div>

					<?php if ( $caption ) : ?>
						<figcaption class="wp-caption-text gallery-caption">
							<?php echo Service::templatesUtil()->filterContent( $caption ) ?>
						</figcaption>
					<?php endif; ?>

				</figure>

			<?php endforeach; ?>

		</div>

	<?php endif;

	if ( ! empty( $heroHeader ) ) :
		echo Service::templatesUtil()->filterContent( $heroHeader );
	endif; ?>

</div>
