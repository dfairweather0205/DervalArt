<?php

use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadLinkOptions( get_the_ID() );
set_query_var( 'postOptions', $options );

$linkContent = $options->getLinkText() ? $options->getLinkText() : $options->getUrl();

if ( ! $options->isFeaturedLink() || ! $linkContent ) :
	return;
endif;
?>

<div class="entry-header__item entry-thumbnail">
	<blockquote class="quote-text--medium quote-text--center">
		<a href="<?php echo esc_url( $options->getUrl() ) ?>" class="quote__content">
			<?php echo esc_html( $linkContent ) ?>
		</a>
	</blockquote>
</div>