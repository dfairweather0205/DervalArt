<?php
use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadQuoteOptions( get_the_ID() );
set_query_var( 'postOptions', $options );

if ( ! $options->isFeaturedQuote() || ! $options->getContent() ) :
	return;
endif;
?>

<div class="entry-header__item entry-thumbnail">
	<blockquote class="quote-text--medium quote-text--center">

		<div class="quote__content">
			<?php echo esc_html( $options->getContent() ); ?>
		</div>

		<?php if ( $options->getAuthorName() ) : ?>

			<div class="quote__author-name">

				<?php if ($options->getAuthorLink()) : ?>
					<a class="quote__author-name-link" href="<?php echo esc_url( $options->getAuthorLink() ) ?>" >
				<?php endif;

				echo esc_html( $options->getAuthorName() );

				if ($options->getAuthorLink()) : ?>
					</a>
				<?php endif; ?>

			</div>

		<?php endif; ?>

	</blockquote>
</div>