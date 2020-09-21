<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$commonOptions = Service::postOptionsLoader()->loadCommonPostOptions( Service::templatesUtil()->getItemId() );

$parallaxCssClass = Service::themeOptionsUtil()->getBoolOption( ThemeOption::FEATURED_BRANDING_PARALLAX )
	? 'parallax' : '';
?>

<div class="featured-branding">
	<div class="featured-branding__wrapper <?php echo esc_attr( $parallaxCssClass ) ?>">
		<div class="featured-branding-inner">

			<div class="featured-branding__background">
				<?php Service::util()->partial( 'featured-branding/background' ); ?>
			</div>

			<?php if ( ! is_singular() || is_attachment() || $commonOptions->isBrandingEnabled() ) : ?>
				<div class="featured-branding__branding">
					<?php
					Service::util()->partial( 'featured-branding/branding' );
					Service::templatesUtil()->generateBreadcrumbs(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
