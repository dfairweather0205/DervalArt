<?php
/**
 * @var $walkerComment
 * @var $walkerArgs
 * @var $walkerDepth
 */
?>

<section class="comment__content">

	<div class="comment__meta">
		<div class="meta__info">

			<div class="meta__author"><?php comment_author_link( $walkerComment ); ?></div>

			<a class="meta__date" href="<?php echo esc_url( get_comment_link( $walkerComment, $walkerArgs ) ) ?>">
				<time datetime="<?php comment_time( 'c' ); ?>">
					<?php
					/* translators: 1: comment date, 2: comment time */
					printf( esc_html__( '%1$s at %2$s', 'nels' ),
						esc_html( get_comment_date( '', $walkerComment ) ), esc_html( get_comment_time() ) );
					?>
				</time>
			</a>

		</div>

		<div class="meta__action">
			<?php
			edit_comment_link( esc_html__( 'Edit', 'nels' ), '<span class="meta__edit-link">', '</span>' );

			comment_reply_link( array_merge( $walkerArgs, array(
				'add_below' => 'div-comment',
				'depth'     => $walkerDepth,
				'max_depth' => $walkerArgs['max_depth'],
				'before'    => '<span class="comment__content__reply">',
				'after'     => '</span>'
			) ) );
			?>
		</div>

	</div>

	<div class="comment__input-area">
		<?php comment_text(); ?>
	</div>

	<?php if ( '0' == $walkerComment->comment_approved ) : ?>
		<p class="comment__content__awaiting-moderation">
			<?php esc_html_e( 'Your comment is awaiting moderation.', 'nels' ); ?>
		</p>
	<?php endif; ?>
</section>