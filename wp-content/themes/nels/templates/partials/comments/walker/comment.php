<?php
/**
 * @var $walkerComment
 * @var $walkerArgs
 */
use Pikart\Nels\DependencyInjection\Service;

?>

<article class="comment__wrapper">

	<div class="comment__header">
		<div class="comment__header__avatar">

			<?php if ( $walkerArgs['avatar_size'] ) :
				echo get_avatar( $walkerComment, $walkerArgs['avatar_size'] );
			endif; ?>

		</div>
	</div>

	<?php Service::util()->partial( 'comments/walker/comment-content' ); ?>

</article>