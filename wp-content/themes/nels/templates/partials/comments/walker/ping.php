<?php
use Pikart\Nels\DependencyInjection\Service;

?>

<article id="comment-<?php comment_ID(); ?>" class="comment__wrapper">
	<?php Service::util()->partial( 'comments/walker/comment-content' ); ?>
</article>