<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Elementor\ElementorUtil;
use Pikart\WpThemeCore\WpBakery\WpBakeryUtil;

$postOptions = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );

$contentInnerClasses = Service::templatesUtil()->getContentCssClass( $postOptions->isSiteContentSidebar() );
$contentInnerStyle   = Service::templatesUtil()->getContentFloat( $postOptions->isSiteContentSidebar() );

$content = trim( get_the_content() );

$isPostHeaderFullWidth = has_post_format( 'aside' ) ? ' is-full-width' : '';
$postFormatClass       = strtolower( get_post_format_string( get_post_format() ) );

$siteWidth   = sprintf( 'max-width: %spx', $postOptions->getSiteWidth() );
$isFullWidth = $postOptions->isFullWidth() ? 'is-full-width' : '';

/** @var int $numPages */
$numPages = $GLOBALS['numpages'];
?>

<?php if ( ! $postOptions->isFeaturedBranding() ) :
	Service::util()->partial( 'single/elements/branding' );
endif; ?>

<header class="entry-header header-<?php echo esc_attr( $postFormatClass . $isPostHeaderFullWidth ) ?>">
	<?php Service::util()->partial( 'single/post/elements/header/header', get_post_format() ); ?>
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

	if ( $postOptions->isSiteContentSidebar() ):
		Service::util()->partial( 'main-sidebar' );
	endif; ?>
</div>

<footer class="entry-footer">
	<?php Service::util()->partial( 'single/post/elements/footer' ); ?>
</footer>