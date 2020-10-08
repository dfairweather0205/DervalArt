<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

if ( ! has_post_thumbnail( $data['item'] ) ) :
	return;
endif; ?>

<div class="card-header header-standard">
	<?php $this->partial( 'projects/featured-image/container-inner', $data ); ?>
</div>
