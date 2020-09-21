<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Elementor\ElementorUtil;
use Pikart\WpThemeCore\WpBakery\WpBakeryUtil;

isset( $projectOptions ) || $projectOptions = Service::postOptionsLoader()->loadProjectOptions( get_the_ID() );

$contentInnerClasses = Service::templatesUtil()->getContentCssClass( $projectOptions->isSiteContentSidebar() );
$contentInnerStyle   = Service::templatesUtil()->getContentFloat( $projectOptions->isSiteContentSidebar() );

$content = trim( get_the_content() );

$isProjectHeaderFullWidth = $projectOptions->getProjectHeaderFullWidth() ? ' is-full-width' : '';

$siteWidth   = sprintf( 'max-width: %spx', $projectOptions->getSiteWidth() );
$isFullWidth = $projectOptions->isFullWidth() ? 'is-full-width' : '';

/** @var int $numPages */
$numPages = $GLOBALS['numpages'];
?>

<?php if ( ! $projectOptions->isFeaturedBranding() ) :
	Service::util()->partial( 'single/elements/branding' );
endif; ?>

<header class="entry-header header-<?php echo esc_attr( $projectOptions->getType() ) . $isProjectHeaderFullWidth ?>">
	<?php
	Service::util()->partial( 'single/project/elements/header/' . $projectOptions->getType() );
	Service::util()->partial( 'single/project/elements/details' ); ?>
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

	if ( $projectOptions->isSiteContentSidebar() ):
		Service::util()->partial( 'main-sidebar' );
	endif; ?>
</div>

<footer class="entry-footer">
	<?php Service::util()->partial( 'single/project/elements/footer' ); ?>
</footer>