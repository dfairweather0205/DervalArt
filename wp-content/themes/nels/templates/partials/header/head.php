<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\ThemeOptions\ThemeOption;

$metaDescription = '';
$postId          = Service::templatesUtil()->getItemId();

if ( $postId ) :
	$postOptions     = Service::postOptionsLoader()->loadCommonPostOptions( $postId );
	$metaDescription = $postOptions->getMetaDescription();
endif;

if ( empty( $metaDescription ) ) :
	$metaDescription = Service::themeOptionsUtil()->getOption( ThemeOption::META_DESCRIPTION );
endif;

?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<?php if ( ! empty ( $metaDescription ) ) : ?>
		<meta name="description" content="<?php echo esc_attr( $metaDescription ) ?>">
	<?php endif; ?>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>
