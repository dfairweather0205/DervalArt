<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$isSidebarEnabled    = Service::themeOptionsUtil()->isArchiveSidebarEnabled();

$contentInnerClasses = Service::templatesUtil()->getContentCssClass( $isSidebarEnabled );
$contentInnerStyle   = Service::templatesUtil()->getContentFloat( $isSidebarEnabled );

$archiveItemsCssClasses = Service::templatesUtil()->getArchiveItemsCssClasses(
	Service::themeOptionsUtil()->getIntOption( ThemeOption::ARCHIVE_COLUMNS_NUMBER ),
	Service::themeOptionsUtil()->getIntOption( ThemeOption::ARCHIVE_COLUMNS_SPACING )
);

get_header(); ?>

<?php if ( ! Service::themeOptionsUtil()->isFeaturedBrandingEnabled() ) : ?>
	<div class="entry-branding">
		<div class="default-branding">
			<?php Service::templatesUtil()->generateBreadcrumbs(); ?>

			<h1 class="branding__title"><?php echo wp_kses_post( Service::templatesUtil()->getArchiveTitle() ); ?></h1>
		</div>
	</div>
<?php endif; ?>

<div class="entry-content">
	<div class="entry-content__item entry-content-area <?php echo esc_attr( $contentInnerClasses ) ?>"
	     style="<?php echo esc_attr( $contentInnerStyle ) ?>">
		<div class="archive-list archive-list--main">
			<div class="<?php echo esc_attr( $archiveItemsCssClasses ) ?>">

				<?php while ( have_posts() ) :
					the_post();
					Service::util()->partial( 'blog/article/article', get_post_format() );
				endwhile; ?>

			</div>
			<?php Service::util()->partial( 'main-archive/navigation' ); ?>
		</div>
	</div>

	<?php if ( $isSidebarEnabled ):
		Service::util()->partial( 'main-sidebar' );
	endif; ?>
</div>