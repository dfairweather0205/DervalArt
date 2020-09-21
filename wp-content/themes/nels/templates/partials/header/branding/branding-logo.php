<?php


use Pikart\Nels\DependencyInjection\Service;
use Pikart\WpThemeCore\ThemeOptions\ThemeCoreOption;
use Pikart\WpThemeCore\ThemeOptions\WpOption;

$themeOptionsUtil = Service::themeOptionsUtil();
$logoId           = get_theme_mod( WpOption::CUSTOM_LOGO );
$invertedLogoId   = $themeOptionsUtil->getOption( ThemeCoreOption::LOGO_INVERTED );
$bothLogos        = $logoId && $invertedLogoId;
$noLogo           = ! $logoId && ! $invertedLogoId;
$singleLogoId     = $logoId ? $logoId : $invertedLogoId;
$siteDescription  = get_bloginfo( 'description', 'display' );

if ( $noLogo ) : ?>

	<div class="site-branding-text">
		<h1 class="site-title"><?php echo esc_html( get_bloginfo( 'name', 'display' ) ) ?></h1>

		<?php if ( $siteDescription || is_customize_preview() ) : ?>
			<span class="site-description"><?php echo esc_html( $siteDescription ) ?></span>
		<?php endif; ?>
	</div>

<?php elseif ( $bothLogos ) :

	$themeOptionsUtil->printLogoImageHtml( $invertedLogoId, 'light' );
	$themeOptionsUtil->printLogoImageHtml( $logoId, 'dark' );

else:

	$themeOptionsUtil->printLogoImageHtml( $singleLogoId, 'single' );

endif;