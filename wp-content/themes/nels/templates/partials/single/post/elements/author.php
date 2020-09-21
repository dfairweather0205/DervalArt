<?php
use Pikart\Nels\DependencyInjection\Service;

$postOptions = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );
$siteWidth   = sprintf( 'max-width: %spx', $postOptions->getSiteWidth() );

$authorId          = get_the_author_meta( 'ID' );
$authorDescription = get_the_author_meta( 'description' );
?>

<div class="entry-footer__item entry-author" style="<?php echo esc_attr( $siteWidth ) ?>">
	<div class="entry-author-info">
		<div class="author__avatar">
			<?php echo get_avatar( $authorId, 72 ) ?>
		</div>

		<div class="author__data">
			<div class="author__title">
				<span><?php esc_html_e( 'About the author: ', 'nels' ); ?></span>
				<span class="author__name">
					<?php echo esc_html( get_the_author_meta( 'display_name', $authorId ) ); ?>
				</span>
			</div>
			<?php if ( $authorDescription ): ?>
				<div class="author__description">
					<?php echo wp_kses_post( $authorDescription ) ?>
				</div>
			<?php endif; ?>
		</div>

		<a class="author__link" href="<?php echo esc_url( get_author_posts_url( $authorId ) ) ?>">
			<span><?php esc_html_e( 'Discover more posts by ', 'nels' ); ?></span>
			<span class="author__name">
				<?php echo esc_html( get_the_author_meta( 'display_name', $authorId ) ); ?>
			</span>
		</a>
	</div>
</div>