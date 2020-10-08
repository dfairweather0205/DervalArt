<?php

/**
 * @var $breadcrumb
 * @var $wrap_before
 * @var $before
 * @var $after
 * @var $wrap_after
 */

if ( empty( $breadcrumb ) ) :
	return;
endif;

echo wp_kses_post( $wrap_before );

foreach ( $breadcrumb as $key => $crumb ) :

	echo wp_kses_post( $before );

	if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) :
		printf( '<li><a href="%s">%s</a></li>', esc_url( $crumb[1] ), esc_html( $crumb[0] ) );
	else:
		printf( '<li><span class="breadcrumb-current">%s</span></li>', esc_html( $crumb[0] ) );
	endif;

	echo wp_kses_post( $after );

endforeach;

echo wp_kses_post( $wrap_after );
