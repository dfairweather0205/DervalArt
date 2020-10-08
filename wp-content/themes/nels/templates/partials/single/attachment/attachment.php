<?php use Pikart\Nels\DependencyInjection\Service; ?>

<?php if ( ! Service::themeOptionsUtil()->isFeaturedBrandingEnabled() ):
	Service::util()->partial( 'single/attachment/elements/branding' );
endif; ?>

<header class="entry-header header-image">
	<?php
	Service::util()->partial( 'single/attachment/elements/header' );
	Service::util()->partial( 'single/attachment/elements/details' ); ?>
</header>

<footer class="entry-footer">
	<?php
	Service::templatesUtil()->loadCommentsTemplate();
	Service::util()->partial( 'single/attachment/elements/navigation' );
	Service::util()->partial( 'single/navigation' ); ?>
</footer>