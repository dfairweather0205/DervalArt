<?php
use Pikart\Nels\DependencyInjection\Service;

$options = Service::blogOptionsLoader()->load( get_the_ID() );

if ( $options->getPostsNbPages() < 2 ) :
	return;
endif;
?>

<nav class="nav nav--archive" role="navigation">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Blog navigation', 'nels' ) ?></h2>
	<div class="nav-links">
		<?php echo paginate_links( array(
			'total'     => $options->getPostsNbPages(),
			'current'   => $options->getPostsCurrentPage(),
			'prev_text' => '',
			'next_text' => '',
			'type'      => 'list',
		) ); ?>
	</div>
</nav>
