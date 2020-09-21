<?php
/**
 * @var \Pikart\WpBase\Widget\Type\RecentProjectsWidget $this
 * @var array $data
 *
 * @since 1.6.2
 */

?>
<ul class="widget_recent_entries__list">
	<?php foreach ( $data['projects'] as $project ) : ?>
		<?php
		$projectId     = esc_attr( $project->ID );
		$title         = get_the_title( $projectId );
		$categoryNames = implode( ', ', $this->projectRepository->getCategoriesByItemId( $projectId ) );

		if ( ! $title ) :
			continue;
		endif; ?>

		<li class="list__recent-entry">
			<a class="recent-entry__link" href="<?php the_permalink( $projectId ); ?>">

				<?php if ( has_post_thumbnail( $projectId ) ) : ?>
					<div class="recent-entry__image">
						<?php echo get_the_post_thumbnail( $projectId, 'thumbnail' ); ?>
					</div>
				<?php endif; ?>

				<div class="recent-entry__branding">

					<h3 class="branding__title">
						<?php echo esc_html( $title ) ?>
					</h3>

					<div class="branding__meta">
						<span class="branding__meta__item branding__meta__taxonomies">
							<?php echo esc_html( $categoryNames ) ?>
						</span>
					</div>

				</div>

			</a>
		</li>

	<?php endforeach; ?>
</ul>