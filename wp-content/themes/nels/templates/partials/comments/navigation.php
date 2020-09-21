<?php
$commentsNavigationPosition || $commentsNavigationPosition = 'unknown';
?>

<nav id="nav--comments--<?php echo esc_attr( $commentsNavigationPosition ) ?>" class="nav nav--comments"
     role="navigation">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'nels' ); ?></h2>
	<div class="nav-links">
		<?php paginate_comments_links( array(
			'prev_text'          => '',
			'next_text'          => '',
			'type'               => 'list',
		) ); ?>
	</div>
</nav>