<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Admin\Media\CustomGalleryMeta;

/* @var \Pikart\Nels\Blog\Options\BlogOptions $blogOptions */

$options = Service::postOptionsLoader()->loadGalleryOptions( get_the_ID() );
set_query_var( 'postOptions', $options );
set_query_var( 'displayExcerpt', $options->isPostExcerptEnabled() );

if ( count( $options->getImages() ) > 0 ) : ?>

	<div class="card-header header-gallery">

			<a href="<?php the_permalink(); ?>">
				<?php Service::util()->partial( 'blog/article/elements/header-overlay' ); ?>
			</a>

			<div class="card-thumbnail owl-carousel">
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

	</div>

<?php endif;

Service::util()->partial( 'blog/article/elements/content-card' );