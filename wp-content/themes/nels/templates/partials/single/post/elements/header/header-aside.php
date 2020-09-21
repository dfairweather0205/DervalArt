<?php

use Pikart\Nels\DependencyInjection\Service;

$options = Service::postOptionsLoader()->loadAsideOptions( get_the_ID() );
set_query_var( 'postOptions', $options );

if ( $options->getHeroHeader() ) : ?>

	<div class="entry-header__item entry-thumbnail hero-header">
		<?php echo Service::templatesUtil()->filterContent( $options->getHeroHeader() ); ?>
	</div>

<?php endif;