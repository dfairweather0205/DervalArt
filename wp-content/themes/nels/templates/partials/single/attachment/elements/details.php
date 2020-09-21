<?php
use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\Elementor\ElementorUtil;

$content         = trim( get_the_content() );
$alternativeText = get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true );

if ( $content || ! empty ( $alternativeText ) || ElementorUtil::isPreviewMode() ) : ?>
	<div class="entry-header__item entry-details">
		<?php
		Service::util()->partial( 'single/attachment/elements/description' );
		Service::util()->partial( 'single/attachment/elements/text-alt' ); ?>
	</div>
<?php endif;