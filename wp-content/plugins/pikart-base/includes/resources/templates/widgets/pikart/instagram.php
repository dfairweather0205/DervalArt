<?php
/**
 * @var \Pikart\WpBase\Widget\Type\InstagramWidget $this
 * @var array $data
 *
 * @since 1.6.2
 */

printf(
	'<ul class="widget_pikart_instagram_photos photos-columns-%d photos-spacing-%s" data-user-id-hash-tag="%s" data-is-hash-tag="%s"
					data-photos-number="%d"></ul>',
	esc_attr( absint( $this->getOptionValue( 'photos_columns', $data ) ) ),
	esc_attr( $this->getOptionValue( 'photos_spacing', $data ) ),
	esc_attr( $data['userIdHashTag'] ),
	esc_attr( $data['isHashTag'] ),
	esc_attr( absint( $this->getOptionValue( 'photos_number', $data ) ) )
);