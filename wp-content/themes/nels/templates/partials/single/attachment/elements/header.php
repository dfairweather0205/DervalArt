<?php
use Pikart\Nels\DependencyInjection\Service;

?>

<div class="entry-header__item entry-thumbnail">

	<div class="featured-image">
		<?php echo Service::attachmentsUtil()->getMediaHtml( get_the_ID() ); ?>
	</div>

	<?php if ( has_excerpt() ) : ?>
		<figcaption class="single-caption"><?php echo wp_kses_post( get_the_excerpt() ) ?></figcaption>
	<?php endif; ?>

</div>