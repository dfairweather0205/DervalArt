<?php

use Pikart\WpThemeCore\Post\Type\PostTypeSlug;

$nbComments    = get_comments_number();
$hasCategories = has_term( '', PostTypeSlug::PROJECT_CATEGORY );

if ( ! $nbComments && ! $hasCategories ) :
	return;
endif; ?>

<div class="branding__meta">

	<?php if ( $hasCategories ): ?>

		<div class="branding__meta__item branding__meta__taxonomies">
			<i class="icon-tag"></i>
			<span><?php the_terms( get_the_ID(), PostTypeSlug::PROJECT_CATEGORY ) ?></span>
		</div>

	<?php endif; ?>

	<?php if ( $nbComments ) : ?>

		<span class="branding__meta__item branding__meta__comments">
			<i class="icon-bubble"></i>
			<a href="#comments">
				<?php printf( esc_html( _n( '%d Comment', '%d Comments', $nbComments, 'nels' ) ), $nbComments ) ?>
			</a>
		</span>

	<?php endif; ?>

</div>