<?php

/** @var WP_Comment $comment */
$comment  = $GLOBALS['comment'];
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) : ?>

	<p class="meta">
		<em class="woocommerce-review__awaiting-approval">
			<?php esc_html_e( 'Your review is awaiting approval', 'nels' ); ?>
		</em>
	</p>

<?php else : ?>

	<div class="meta__info">
		<div class="woocommerce-review__author meta__author"><?php comment_author(); ?></div>

		<?php if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) : ?>
			<em class="woocommerce-review__verified verified">
				(<?php esc_attr_e( 'verified owner', 'nels' ) ?>)
			</em>
		<?php endif; ?>

		<time class="woocommerce-review__published-date meta__date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>">
			<?php echo esc_html( get_comment_date( wc_date_format() ) ); ?>
		</time>
	</div>

<?php endif;
