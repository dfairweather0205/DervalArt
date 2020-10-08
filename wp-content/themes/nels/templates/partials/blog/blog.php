<?php
use Pikart\Nels\DependencyInjection\Service;

$options = Service::blogOptionsLoader()->load( get_the_ID() );

$contentInnerClasses = Service::templatesUtil()->getContentCssClass( $options->isSiteContentSidebar() );
$contentInnerStyle   = Service::templatesUtil()->getContentFloat( $options->isSiteContentSidebar() );

set_query_var( 'pageOptions', $options );

$content = trim( get_the_content() );

$siteWidth   = sprintf( 'max-width: %spx', $options->getSiteWidth() );
$isFullWidth = $options->isFullWidth() ? 'is-full-width' : '';
?>

<?php if ( ! $options->isFeaturedBranding() ):
	Service::util()->partial( 'single/elements/branding' );
endif; ?>

<header class="entry-header header-page is-full-width">
	<?php Service::util()->partial( 'single/page/elements/header' ); ?>
</header>

<div class="entry-content <?php echo esc_attr( $isFullWidth ) ?>" style="<?php echo esc_attr( $siteWidth ) ?>">
	<div class="entry-content__item entry-content-area <?php echo esc_attr( $contentInnerClasses ) ?>"
	     style="<?php echo esc_attr( $contentInnerStyle ) ?>">

		<?php if ( $content ) :
			echo Service::templatesUtil()->filterPostContent( $content );
		endif;

		Service::util()->partial( 'blog/elements/archive-list' );
		Service::util()->partial( 'blog/elements/additional-content' ); ?>

	</div>

	<?php if ( $options->isSiteContentSidebar() ):
		Service::util()->partial( 'main-sidebar' );
	endif; ?>
</div>

<footer class="entry-footer">
	<?php Service::util()->partial( 'single/page/elements/footer' ); ?>
</footer>