<?php
use Pikart\Nels\DependencyInjection\Service;

$nbComments = get_comments_number();
$authorId   = get_post_field( 'post_author', get_queried_object_id() );
?>

<div class="branding__meta">

	<span class="branding__meta__item branding__meta__author">
		<span class="branding__meta__by"><?php esc_html_e( 'By ', 'nels'  ); ?></span>
		<span class="branding__meta__author-avatar">
			<?php echo get_avatar( $authorId, 18 ) ?>
		</span>
		<a class="branding__meta__author-link" href="<?php echo esc_url( get_author_posts_url( $authorId ) ) ?>">
			<?php echo esc_html( get_the_author_meta( 'display_name', $authorId ) ); ?>
		</a>
	</span>

	<?php if ( has_category() ): ?>
		<div class="branding__meta__item branding__meta__taxonomies">
			<i class="icon-tag"></i>
			<span><?php the_category( ', ' ); ?></span>
		</div>
	<?php endif; ?>

	<span class="branding__meta__item branding__meta__date">
		<i class="icon-calendar"></i>
		<a href="<?php echo esc_url( Service::templatesUtil()->getDayArchiveLink() ) ?>">
			<?php echo esc_html( get_the_date() ) ?>
		</a>
	</span>

	<?php if ( $nbComments ) : ?>

		<span class="branding__meta__item branding__meta__comments">
			<i class="icon-bubble"></i>
			<a href="#comments">
				<?php printf( esc_html( _n( '%s Comment', '%s Comments', (int) $nbComments, 'nels' ) ), (int) $nbComments ) ?>
			</a>
		</span>

	<?php endif; ?>

</div>