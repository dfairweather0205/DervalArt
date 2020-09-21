<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

use Pikart\Nels\DependencyInjection\Service;

?>

<a class="card-thumbnail" href="<?php the_permalink( $data['item'] ); ?>">

	<?php if ( Service::templatesUtil()->isTransparencyAllowed( $data['masonry_display'] ) ) :
		$this->partial( 'common/header-overlay', $data );
	endif;

	echo get_the_post_thumbnail( $data['item'], 'post-thumbnail' ); ?>

</a>