<?php
/* @var \Pikart\Nels\Blog\Options\BlogOptions $blogOptions */

use Pikart\Nels\DependencyInjection\Service;

isset( $displayExcerpt ) || $displayExcerpt = false;

$post      = get_post();
$isExcerpt = has_excerpt() || $post->post_content !== '';
?>

<div class="card-content">
	<?php Service::util()->partial( 'blog/article/elements/header-branding' );

	if ( $displayExcerpt && $isExcerpt && ! post_password_required() ) :
		Service::util()->partial( 'blog/article/elements/excerpt' );
	endif; ?>

	<div class="card-info">
		<span class="card-info__item">
			<span class="date"><?php echo esc_html( get_the_date( '' ) ); ?></span>
		</span>

		<span class="card-info__item">
			<span class="card-button">
				<a class="button" href="<?php the_permalink(); ?>">
					<i class="icon-calendar"></i>
					<i class="icon-action-redo"></i>
					<span><?php echo esc_html__( 'Read more', 'nels' ); ?></span>
				</a>
			</span>
		</span>
	</div>
</div>