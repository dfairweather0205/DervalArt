<?php
/**
 * @var \Pikart\WpBase\Widget\Type\FlickrWidget $this
 * @var array $data
 *
 * @since 1.6.2
 */

printf(
	'<ul class="widget_pikart_flickr_photos photos-columns-%d photos-spacing-%s" data-flickr-id="%s" data-api-key="%s" data-photos-number="%s"
					data-photos-type="%s" data-photos-size="%s"></ul>',
	esc_attr( absint( $this->getOptionValue( 'photos_columns', $data ) ) ),
	esc_attr( $this->getOptionValue( 'photos_spacing', $data ) ),
	esc_attr( $this->getOptionValue( 'flickr_id', $data ) ),
	esc_attr( $this->getOptionValue( 'api_key', $data ) ),
	esc_attr( absint( $this->getOptionValue( 'photos_number', $data ) ) ),
	esc_attr( $this->getOptionValue( 'photos_type', $data ) ),
	esc_attr( $this->getOptionValue( 'photos_size', $data ) )
);