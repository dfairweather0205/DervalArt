<?php

$commenter    = wp_get_current_commenter();
$ariaRequired = get_option( 'require_name_email' ) ? 'aria-required="true"' : '';

$authorField = sprintf(
	'<input id="author" name="author" type="text" class="%s" placeholder="%s" size="30" value="%s" %s />',
	'comment-form__item comment-form__item--author',
	esc_html__( 'Name *', 'nels' ),
	esc_attr( $commenter['comment_author'] ),
	$ariaRequired
);

$emailField = sprintf(
	'<input id="email" name="email" type="text" class="%s" placeholder="%s" size="30" value="%s" %s />',
	'comment-form__item comment-form__item--email',
	esc_html__( 'Email *', 'nels' ),
	esc_attr( $commenter['comment_author_email'] ),
	$ariaRequired
);

$urlField = sprintf(
	'<input id="url" name="url" type="text" class="%s" placeholder="%s" size="30" value="%s" />',
	'comment-form__item comment-form__item--url',
	esc_html__( 'Website', 'nels' ),
	esc_attr( $commenter['comment_author_url'] )
);

$commentField = sprintf(
	'<textarea id="comment" class="%s" name="comment" rows="10" aria-required="true" placeholder="%s" ></textarea>',
	'comment-form__item comment-form__item--textarea',
	esc_html__( 'Your thoughts...', 'nels' )
);

$commentsNotesBefore = sprintf(
	'<p class="%s">%s</p>',
	'comment-notes-before',
	esc_html__( 'Your email address will not be published. Fill up required fields *', 'nels' )
);

comment_form( array(
	'title_reply'          => esc_html__( 'Leave a Reply', 'nels' ),
	'title_reply_before'   => '<h3 id="respond__title" class="respond__title entry-footer__title">',
	'title_reply_after'    => '</h3>',
	'comment_form_top'     => '',
	'comment_notes_before' => $commentsNotesBefore,
	'comment_notes_after'  => '',
	'id_form'              => 'comment-form',
	'class_form'           => 'comment-form',
	'label_submit'         => esc_html__( 'Submit comment', 'nels' ),
	'class_submit'         => 'comment-form__btn',
	'comment_field'        => $commentField,
	'fields'               => apply_filters( 'comment_form_default_fields', array(
		'author' => $authorField,
		'email'  => $emailField,
		'url'    => $urlField
	) ),
) );