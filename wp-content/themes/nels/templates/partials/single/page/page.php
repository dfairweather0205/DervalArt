<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Elementor\ElementorUtil;
use Pikart\WpThemeCore\WpBakery\WpBakeryUtil;

$pageOptions = Service::postOptionsLoader()->loadPageOptions( get_the_ID() );

$contentInnerClasses = Service::templatesUtil()->getContentCssClass( $pageOptions->isSiteContentSidebar() );
$contentInnerStyle   = Service::templatesUtil()->getContentFloat( $pageOptions->isSiteContentSidebar() );

set_query_var( 'pageOptions', $pageOptions );

$content = trim( get_the_content( '' ) );

$siteWidth   = sprintf( 'max-width: %spx', $pageOptions->getSiteWidth() );
$isFullWidth = $pageOptions->isFullWidth() ? 'is-full-width' : '';

/** @var int $numPages */
$numPages = $GLOBALS['numpages'];
?>

<?php if ( ! $pageOptions->isFeaturedBranding() ) :
	Service::util()->partial( 'single/elements/branding' );
endif; ?>

<header class="entry-header header-page is-full-width">
	<?php Service::util()->partial( 'single/page/elements/header' ); ?>
</header>

<div class="entry-content <?php echo esc_attr( $isFullWidth ) ?>" style="<?php echo esc_attr( $siteWidth ) ?>">
	<?php if ( $content || $numPages > 1 || WpBakeryUtil::isVcPageEditable() || ElementorUtil::isPreviewMode() ) : ?>

        <div class="entry-content__item entry-content-area <?php echo esc_attr( $contentInnerClasses ) ?>"
             style="<?php echo esc_attr( $contentInnerStyle ) ?>">
			<?php
			echo Service::templatesUtil()->filterPostContent( $content );
			Service::util()->partial( 'single/elements/page-break' ); ?>
        </div>

	<?php endif;

	if ( $pageOptions->isSiteContentSidebar() ):
		Service::util()->partial( 'main-sidebar' );
	endif; ?>
</div>

<footer class="entry-footer">
	<?php Service::util()->partial( 'single/page/elements/footer' ); ?>
</footer>