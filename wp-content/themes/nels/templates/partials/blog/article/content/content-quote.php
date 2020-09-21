<?php
use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadQuoteOptions( get_the_ID() );
set_query_var( 'postOptions', $options );

if ( $options->getContent() ) : ?>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="card-header header-quote">
			<a class="card-thumbnail" href="<?php the_permalink(); ?>"
			     style="background-image: url(<?php echo esc_url ( get_the_post_thumbnail_url() ) ?>)">
			</a>
		</div>
	<?php endif;?>

	<blockquote class="card-content">
		<a class="card-branding" href="<?php the_permalink(); ?>">
			<div class="quote__content">
				<?php echo esc_html( $options->getContent() ); ?>
			</div>
			<?php if ( $options->getAuthorName() ) : ?>
				<div class="quote__author-name"><?php echo esc_html( $options->getAuthorName() ) ?></div>
			<?php endif; ?>
		</a>
	</blockquote>

<?php else :
	Service::util()->partial( 'blog/article/elements/content-card' );
endif;