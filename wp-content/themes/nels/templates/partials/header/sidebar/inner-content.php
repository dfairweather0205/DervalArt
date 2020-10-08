<?php

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Site\SidebarId;
use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! is_active_sidebar( SidebarId::header() ) ):
	return;
endif;

$headerSidebarTitle = Service::themeOptionsUtil()->getOption( ThemeOption::HEADER_SIDEBAR_TITLE );
?>

<div class="sidebar--site-header__heading">

	<?php if ( ! empty( $headerSidebarTitle ) ) : ?>
		<h3 class="sidebar--site-header__title">
			<?php echo esc_html( $headerSidebarTitle ) ?>
		</h3>
	<?php endif; ?>

	<a class="sidebar--site-header__close-button">
		<?php esc_html_e( 'Close', 'nels' ); ?>
	</a>

</div>

<div class="sidebar--site-header__wrapper">
	<?php dynamic_sidebar( SidebarId::header() ); ?>
</div>
