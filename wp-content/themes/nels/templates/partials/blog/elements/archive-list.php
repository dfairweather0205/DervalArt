<?php

use Pikart\Nels\DependencyInjection\Service;

isset( $blogOptions ) || $blogOptions = Service::blogOptionsLoader()->load();

$columnsSpacing  = $blogOptions->getColumnsSpacing();
$archiveListStyle = $blogOptions->isFullWidth()
	? sprintf( 'padding-right: %1$dpx; padding-left: %1$dpx;', $columnsSpacing ) : '';

$archiveItemsCssClasses = Service::templatesUtil()->getArchiveItemsCssClasses(
	$blogOptions->getNbColumns(),
	$columnsSpacing
);
?>

<div class="archive-list archive-list--blog" style="<?php echo esc_attr( $archiveListStyle ) ?>">

	<?php if ( $blogOptions->getCategoriesDisplay() !== 'none' ) :
		Service::util()->partial( 'blog/elements/archive-filter' );
	endif; ?>

	<div class="<?php echo esc_attr( $archiveItemsCssClasses ) ?>"
		 style="<?php echo esc_attr( Service::templatesUtil()->getBlogTemplateInnerMargins( get_the_ID() ) ) ?>">

		<?php foreach ( $blogOptions->getPosts() as $post ) :
			setup_postdata( $post );
			Service::util()->partial( 'blog/article/article', get_post_format() );
		endforeach;
		wp_reset_postdata(); ?>

	</div>

	<?php Service::util()->partial( 'blog/elements/navigation' ); ?>

</div>