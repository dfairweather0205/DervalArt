<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer     $this
 * @var \Pikart\Nels\Post\Options\Type\ProjectOptions $options
 * @var array                                          $data
 */

$item    = $data['item'];
$options = $data['options'][ $item ];
?>

<div class="card-content">
	<a class="card-branding" href="<?php the_permalink( $item ); ?>">
		<?php $this->partial( 'projects/header-branding-titles', $data ); ?>
	</a>
</div>