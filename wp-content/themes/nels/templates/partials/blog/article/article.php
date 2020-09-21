<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

/* @var \Pikart\Nels\Blog\Options\BlogOptions $blogOptions */
isset( $blogOptions ) || $blogOptions = Service::blogOptionsLoader()->load();

$isBlogTemplate = Service::templatesUtil()->isBlogTemplate();
$displayType    = $isBlogTemplate
	? $blogOptions->getBlogDisplay() : Service::themeOptionsUtil()->getOption( ThemeOption::ARCHIVE_DISPLAY );

$postStyle = $isBlogTemplate
	? sprintf( 'padding-right: %1$dpx; padding-bottom: %1$dpx; ', $blogOptions->getColumnsSpacing() ) : '';

$postOptions       = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );
$isCardLarge       = $isBlogTemplate && $postOptions->isMasonryLargeSize() ? ' card--large' : '';
$cardSpacingAround = Service::templatesUtil()->isBlogTemplate() && $postOptions->getMasonrySpacing() !== 'none'
	? 'spacing-' . $postOptions->getMasonrySpacing() : '';

$articleCssClasses = Service::templatesUtil()->getArticlesCssClasses( $displayType ) . $isCardLarge;
?>

<article id="post-<?php the_ID(); ?>" class="<?php echo esc_attr( $articleCssClasses ) ?>"
         style="<?php echo esc_attr( $postStyle ) ?>">

	<div class="card-body <?php echo esc_attr( $cardSpacingAround ) ?>">
		<?php Service::util()->partial( 'blog/article/content/content', get_post_format() ) ?>
	</div>

</article>