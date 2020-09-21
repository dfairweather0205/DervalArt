<?php use Pikart\Nels\DependencyInjection\Service; ?>

<div class="entry-branding">
	<div class="default-branding">

		<?php Service::templatesUtil()->generateBreadcrumbs(); ?>

		<h1 class="branding__title">
			<?php echo esc_html( get_the_title() ); ?>
		</h1>

		<?php Service::util()->partial( 'single/attachment/elements/branding-meta' ); ?>

	</div>
</div>
