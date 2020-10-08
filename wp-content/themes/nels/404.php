<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;

get_header();

Service::util()->partial( '404-content' );

get_footer();
