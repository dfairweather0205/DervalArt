<?php

use Pikart\Nels\DependencyInjection\Service;

isset( $postOptions ) || $postOptions = Service::postOptionsLoader()->loadStandardOptions( get_the_ID() );

$title      = $postOptions->getTitleArea();
$cssClasses = empty( $title ) ? '' : 'reset-font-weight';

$isBlogTemplate     = Service::templatesUtil()->isBlogTemplate();
$masonryItemOptions = Service::postOptionsLoader()->loadCommonPostOptions( get_the_ID() );

$titleStyle = $isBlogTemplate ? sprintf( 'font-size: %dpx;', $masonryItemOptions->getMasonryTitleFontSize() ) : '';
$nbComments = get_comments_number();
?>

<a class="card-branding" href="<?php the_permalink(); ?>">
	<h4 class="branding__title <?php echo esc_attr( $cssClasses ) ?>" style="<?php echo esc_attr( $titleStyle ) ?>">
		<?php echo( empty( $title ) ? esc_html( get_the_title() ) : wp_kses_post( $title ) ) ?>
	</h4>

	<div class="branding__meta">

		<?php if ( has_category() ): ?>
			<div class="branding__meta__item branding__meta__taxonomies">
				<i class="icon-tag"></i>
				<span><?php echo esc_html( Service::templatesUtil()->joinCategoryNames( get_the_ID() ) ); ?></span>
			</div>
		<?php endif; ?>

		<div class="branding__meta__item">
			<i class="icon-bubble"></i>
			<span><?php echo esc_html ( $nbComments ); ?></span>
		</div>

	</div>
</a>