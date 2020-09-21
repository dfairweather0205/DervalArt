<?php
/** @var $recentPostsShowDate */

$title = get_the_title();

if ( empty( $title ) ) :
	$title = get_the_ID();
endif;

?>

<li class="list__recent-entry">
	<a class="recent-entry__link" href="<?php the_permalink(); ?>">

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="recent-entry__image"><?php the_post_thumbnail( 'thumbnail' ); ?></div>
		<?php endif; ?>

		<div class="recent-entry__branding">

			<h3 class="branding__title">
				<?php echo esc_html( $title ) ?>
			</h3>

			<div class="branding__meta">

				<?php if ( $recentPostsShowDate ) : ?>
					<span class="branding__meta__item branding__meta__date">
						<?php echo esc_html( get_the_date() ); ?>
					</span>
				<?php endif; ?>

			</div>

		</div>

	</a>
</li>