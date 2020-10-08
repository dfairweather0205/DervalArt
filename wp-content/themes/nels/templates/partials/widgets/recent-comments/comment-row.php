<?php
/** @var $recentCommentsComment */

$comment = $recentCommentsComment;
?>

<li class="recentcomments">

	<div class="recentcomments__branding">

		<span class="comment-author-link"><?php comment_author_link( $comment ) ?></span>
		<span class="recentcomments__on"><?php esc_html_e( 'on', 'nels' ) ?></span>

		<a class="branding__title" href="<?php echo esc_url( get_comment_link( $comment ) ) ?>">
			<?php echo esc_html( get_the_title( $comment->comment_post_ID ) ) ?>
		</a>

	</div>

	<div class="recentcomments__content"><?php comment_text( $comment ) ?></div>

</li>