<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$relatedPostsNbColumns = Service::themeOptionsUtil()->getIntOption( ThemeOption::RELATED_POSTS_COLUMNS_NUMBER );
$relatedPosts          = Service::postRepository()->getRelatedItems( get_the_ID(), $relatedPostsNbColumns );

if ( count( $relatedPosts ) < 1 ):
	return;
endif;

$relatedPostsDisplay = Service::themeOptionsUtil()->getOption( ThemeOption::RELATED_POSTS_DISPLAY );
$columnsSpacing      = Service::themeOptionsUtil()->getOption( ThemeOption::RELATED_POSTS_COLUMNS_SPACING );

$archiveItemsCssClasses = Service::templatesUtil()->getArchiveItemsCssClasses(
	$relatedPostsNbColumns,
	$columnsSpacing
);

$nbComments = get_comments_number();
?>

<div class="entry-footer__item related-items related-items--posts">
	<div class="related-items__wrapper">
		<h3 class="related-items__title entry-footer__title">
			<?php esc_html_e( 'Related posts', 'nels' ) ?>
		</h3>

		<ul class="related-items__list <?php echo esc_attr( $archiveItemsCssClasses ) ?>">

			<?php foreach ( $relatedPosts as $relPost ): ?>

				<li class="card card--masonry card--<?php echo esc_attr( $relatedPostsDisplay ) ?> column">
					<div class="card-body">

						<?php if ( has_post_thumbnail( $relPost ) ) : ?>
							<div class="card-header header-standard">
								<a class="card-thumbnail" href="<?php the_permalink( $relPost ) ?>">
									<?php if ( Service::templatesUtil()->isTransparencyAllowed( $relatedPostsDisplay ) ) : ?>
										<div class="color-overlay">
											<div class="color-overlay-inner"></div>
										</div>
									<?php endif; ?>

									<?php echo get_the_post_thumbnail( $relPost ) ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="card-content">
							<a class="card-branding" href="<?php the_permalink( $relPost ) ?>">

								<h4 class="branding__title">
									<?php echo esc_html( get_the_title( $relPost ) ) ?>
								</h4>

								<div class="branding__meta">
									<?php if ( has_category( '', $relPost ) ): ?>
										<span class="branding__meta__item branding__meta__taxonomies">
											<i class="icon-tag"></i>
											<span><?php echo esc_html(
												Service::templatesUtil()->joinCategoryNames( $relPost->ID ) ); ?></span>
										</span>
									<?php endif; ?>

									<div class="branding__meta__item">
										<i class="icon-bubble"></i>
										<span><?php echo esc_html ( $nbComments ); ?></span>
									</div>
								</div>
							</a>

							<div class="card-info">
								<span class="card-info__item">
									<span class="date"><?php echo esc_html( get_the_date( '', $relPost ) ); ?></span>
								</span>
								<span class="card-info__item">
									<span class="card-button">
										<a class="button" href="<?php the_permalink( $relPost ) ?>">
											<i class="icon-calendar"></i>
											<i class="icon-action-redo"></i>
											<span><?php echo esc_html__( 'Read more', 'nels' ); ?></span>
										</a>
									</span>
								</span>
							</div>
						</div>

					</div>
				</li>

			<?php endforeach; ?>

		</ul>
	</div>
</div>