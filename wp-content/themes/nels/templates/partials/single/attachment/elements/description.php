<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Elementor\ElementorUtil;

$content = trim( get_the_content( '' ) );

if ( $content || ElementorUtil::isPreviewMode() ) : ?>

	<div class="entry-description">
		<div class="attachment__title">
			<?php echo esc_html__( 'Description', 'nels' ) ?>
		</div>
		<div class="attachment__content">
			<?php echo Service::templatesUtil()->filterPostContent( $content ); ?>
		</div>
	</div>

<?php endif;
