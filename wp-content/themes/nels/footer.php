<?php
/**
 * The footer for our theme.
 *
 * This is the template that displays everything after <div id="content">
 *
 * @package Nels
 */
use Pikart\Nels\DependencyInjection\Service;
?>

			</div>
			<?php Service::util()->partial( 'footer/content' ); ?>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>
