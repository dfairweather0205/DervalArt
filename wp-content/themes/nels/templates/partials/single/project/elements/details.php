<?php
use Pikart\Nels\DependencyInjection\Service;

isset( $projectOptions ) || $projectOptions = Service::postOptionsLoader()->loadProjectOptions( get_the_ID() );

$projectDate  = $projectOptions->getProjectDate();
// exclude `slide_template` as it's a revolution slider custom field which should not be displayed
$customFields = Service::postUtil()->getCustomFields( get_the_ID(), array( 'slide_template' ) );

$detailsPosition = $projectOptions->getProjectDetailsPosition();
$detailsIsSticky = $projectOptions->getProjectDetailsSticky()
                   && ( $detailsPosition === 'right' || $detailsPosition === 'left' ) ? 'entry-details--sticky' : '';

if ( $projectOptions->getProjectDescription() || ! empty( $projectDate ) || ! empty( $customFields ) ) : ?>
	<div class="entry-header__item entry-details <?php echo esc_attr( $detailsIsSticky ) ?>">
		<div class="entry-details__wrapper">
			<?php
			Service::util()->partial( 'single/project/elements/description' );
			Service::util()->partial( 'single/project/elements/custom-fields' ); ?>
		</div>
	</div>
<?php endif;