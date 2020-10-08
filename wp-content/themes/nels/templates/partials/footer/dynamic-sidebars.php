<?php
/**
 * The footer sidebar for our theme.
 *
 * @package Nels
 */

use Pikart\Nels\DependencyInjection\Service;
use Pikart\Nels\Site\SidebarId;

$themeOptionsUtil = Service::themeOptionsUtil();
$nbColumns        = $themeOptionsUtil->getFooterSidebarNbColumns();

for ( $index = 1; $index <= $nbColumns; $index ++ ):
	$sidebarId = SidebarId::footer( $index ); ?>

	<div class="<?php echo esc_attr( sprintf( 'sidebar-column-%d column', $index ) ) ?>">
		<?php if ( is_active_sidebar( $sidebarId ) ):
			dynamic_sidebar( SidebarId::footer( $index ) );
		endif; ?>
	</div>

	<?php
endfor;
