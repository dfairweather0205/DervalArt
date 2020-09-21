<?php
/**
 * The footer for our theme.
 *
 * This is the template that displays everything after <div id="content">
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;

$itemId = Service::templatesUtil()->getItemId();

if ( $itemId ) :
	$options                  = Service::postOptionsLoader()->loadCommonPostOptions( $itemId );
	$isFooterSidebarEnabled   = $options->getSiteFooterSidebar();
	$isFooterBelowAreaEnabled = $options->getSiteFooterBelowArea();
else:
	$isFooterSidebarEnabled   = Service::themeOptionsUtil()->isFooterSidebarEnabled();
	$isFooterBelowAreaEnabled = Service::themeOptionsUtil()->isFooterBelowAreaEnabled();
endif;

if ( ! $isFooterSidebarEnabled && ! $isFooterBelowAreaEnabled ) :
	return;
endif;
?>

<footer id="site-footer" class="site-footer" role="contentinfo">
	<?php if ( $isFooterSidebarEnabled ) :
		Service::util()->partial( 'footer/sidebar' );
	endif;

	if ( $isFooterBelowAreaEnabled ) :
		Service::util()->partial( 'footer/below-area' );
	endif; ?>

</footer>
