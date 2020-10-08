<?php
use Pikart\Nels\DependencyInjection\Service;

$isSidebarEnabled    = Service::themeOptionsUtil()->isArchiveSidebarEnabled();
$contentInnerClasses = Service::templatesUtil()->getContentCssClass( $isSidebarEnabled );
$contentInnerStyle   = Service::templatesUtil()->getContentFloat( $isSidebarEnabled );

get_header(); ?>

<?php if ( ! Service::themeOptionsUtil()->isFeaturedBrandingEnabled() ): ?>
	<div class="entry-branding">
		<div class="default-branding">
			<h1 class="branding__title"><?php esc_html_e( 'Nothing Found', 'nels' ); ?></h1>
		</div>
	</div>
<?php endif; ?>

<div class="entry-content">
	<div class="entry-content__item entry-content-area <?php echo esc_attr( $contentInnerClasses ) ?>"
	     style="<?php echo esc_attr( $contentInnerStyle ) ?>">
		<div class="nothing-found-wrapper">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p class="nothing-found-message">
				<?php esc_html_e( 'Ready to publish your first post?', 'nels' ); ?>
				<a href="<?php echo esc_url( admin_url( 'post-new.php' ) ) ?>">
					<?php esc_html_e( 'Get started here', 'nels' ) ?>
				</a>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p class="nothing-found-message">
				<?php esc_html_e(
					'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
					'nels' );
				?>
			</p>
			<?php Service::util()->partial( 'forms/searchform-alt' );

		else : ?>

			<p class="nothing-found-message">
				<?php esc_html_e(
					'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.',
					'nels'
				); ?>
			</p>
			<?php Service::util()->partial( 'forms/searchform-alt' );

		endif; ?>

		</div>
	</div>

	<?php if ( $isSidebarEnabled ):
		Service::util()->partial( 'main-sidebar' );
	endif; ?>
</div>