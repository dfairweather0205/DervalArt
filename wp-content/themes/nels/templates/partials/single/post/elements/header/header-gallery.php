<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Admin\Media\CustomGalleryMeta;

$options = Service::postOptionsLoader()->loadGalleryOptions( get_the_ID() );
set_query_var( 'postOptions', $options );

if ( ! $options->isFeaturedGallery() || count( $options->getImages() ) < 1 ) :
	return;
endif; ?>

<div class="entry-header__item entry-thumbnail owl-carousel">
	<?php foreach ( $options->getImages() as $imageId ):
		$imageUrl = wp_get_attachment_image_url( $imageId, 'full' );
		$imageAltText = get_post_meta( $imageId, '_wp_attachment_image_alt', true );
		$videoUrl = Service::attachmentsUtil()->getMetaField( $imageId, CustomGalleryMeta::VIDEO_URL );

		if( empty( $videoUrl ) ) : ?>
			<img src="<?php echo esc_url( $imageUrl ) ?>" alt="<?php echo esc_attr( $imageAltText ) ?>"/>
		<?php else : ?>
			<div class="item-video">
				<a class="owl-video" href="<?php echo esc_url( $videoUrl ) ?>"></a>
				<img src="<?php echo esc_url( $imageUrl ) ?>" alt="<?php echo esc_attr( $imageAltText ) ?>"/>
			</div>
		<?php endif;
	endforeach; ?>
</div>