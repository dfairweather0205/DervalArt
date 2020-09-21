<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$relatedProjectsColsNb = Service::themeOptionsUtil()->getIntOption( ThemeOption::RELATED_PROJECTS_COLUMNS_NUMBER );
$relatedProjects       = Service::projectRepository()->getRelatedItems( get_the_ID(), $relatedProjectsColsNb );

if ( count( $relatedProjects ) < 1 ):
	return;
endif;

$relatedProjectsDisplay = Service::themeOptionsUtil()->getOption( ThemeOption::RELATED_PROJECTS_DISPLAY );
$columnsSpacing         = Service::themeOptionsUtil()->getOption( ThemeOption::RELATED_PROJECTS_COLUMNS_SPACING );

$archiveItemsCssClasses = Service::templatesUtil()->getArchiveItemsCssClasses(
	$relatedProjectsColsNb,
	$columnsSpacing
);

$nbComments = get_comments_number();
?>

<div class="entry-footer__item related-items related-items--projects">
	<div class="related-items__wrapper">
		<h3 class="related-items__title entry-footer__title">
			<?php esc_html_e( 'Related projects', 'nels' ) ?>
		</h3>

		<ul class="related-items__list <?php echo esc_attr( $archiveItemsCssClasses ) ?>">

			<?php foreach ( $relatedProjects as $relProject ): ?>

				<li class="card card--masonry card--<?php echo esc_attr( $relatedProjectsDisplay ) ?> column">
					<div class="card-body">

						<?php if ( has_post_thumbnail( $relProject ) ) : ?>
							<div class="card-header header-standard">
								<a class="card-thumbnail" href="<?php the_permalink( $relProject ) ?>">
									<?php if ( Service::templatesUtil()->isTransparencyAllowed( $relatedProjectsDisplay ) ) : ?>
										<div class="color-overlay">
											<div class="color-overlay-inner"></div>
										</div>
									<?php endif; ?>

									<?php echo get_the_post_thumbnail( $relProject ) ?>
								</a>
							</div>
						<?php endif; ?>

						<div class="card-content">
							<a class="card-branding" href="<?php the_permalink( $relProject ) ?>">

								<h4 class="branding__title">
									<?php echo esc_html( get_the_title( $relProject ) ) ?>
								</h4>

								<?php
								$categories = Service::projectRepository()->getCategoriesByItemId( $relProject->ID );

								if ( ! empty( $categories ) ): ?>
									<div class="branding__meta">
										<span class="branding__meta__item branding__meta__taxonomies">
											<i class="icon-tag"></i>
											<span><?php echo esc_html( implode( ', ', $categories ) ); ?></span>
										</span>

										<div class="branding__meta__item">
											<i class="icon-bubble"></i>
											<span><?php echo esc_html( $nbComments ); ?></span>
										</div>
									</div>
								<?php endif; ?>

							</a>
						</div>

					</div>
				</li>

			<?php endforeach; ?>

		</ul>
	</div>
</div>