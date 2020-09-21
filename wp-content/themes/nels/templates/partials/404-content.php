<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$themeOptionsUtil     = Service::themeOptionsUtil();
$errorPageTitle       = $themeOptionsUtil->getOption( ThemeOption::ERROR_PAGE_TITLE );
$errorPageSubtitle    = $themeOptionsUtil->getOption( ThemeOption::ERROR_PAGE_SUBTITLE );
$errorPageText        = $themeOptionsUtil->getOption( ThemeOption::ERROR_PAGE_TEXT );
$errorPageButtonLabel = $themeOptionsUtil->getOption( ThemeOption::ERROR_PAGE_BUTTON_LABEL );
$errorPageButtonLink  = $themeOptionsUtil->getOption( ThemeOption::ERROR_PAGE_BUTTON_LINK );
$errorPageColorSkin   = $themeOptionsUtil->getOption( ThemeOption::ERROR_PAGE_COLOR_SKIN );

?>

<main id="error-404" class="error-404 error-404--skin-<?php echo esc_attr( $errorPageColorSkin ) ?>" role="main">
	<div class="error-404__wrapper">
		<div class="error-404__wrapper-inner">
			<div class="error-404-inner">

				<header class="error-404__branding">

					<?php if ( ! empty( $errorPageTitle ) ) : ?>
						<h1 class="error-404__branding__title"><?php echo esc_html( $errorPageTitle ) ?></h1>
					<?php endif; ?>

					<?php if ( ! empty( $errorPageSubtitle ) ) : ?>
						<h2 class="error-404__branding__subtitle"><?php echo esc_html( $errorPageSubtitle ) ?></h2>
					<?php endif; ?>

					<?php if ( ! empty( $errorPageText ) ) : ?>
						<p class="error-404__description"><?php echo esc_html( $errorPageText ) ?></p>
					<?php endif; ?>

				</header>

				<?php if ( ! empty( $errorPageButtonLabel ) ) : ?>
					<div class="error-404__content">
						<a class="error-404__button button--medium button--txt--small"
						   href="<?php echo esc_url( $errorPageButtonLink ) ?>">
							<?php echo esc_html( $errorPageButtonLabel ) ?>
						</a>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</main>