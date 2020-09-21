<?php
wp_link_pages( array(
	'before'      =>
		'<nav class="nav nav--page-breaks" role="navigation"><div class="nav-links"><ul class="page-numbers"><li>',
	'after'       => '</li></ul></div></nav>',
	'link_before' => '<span class="page-numbers">',
	'link_after'  => '</span>',
	'separator'   => '</li><li>'
) );