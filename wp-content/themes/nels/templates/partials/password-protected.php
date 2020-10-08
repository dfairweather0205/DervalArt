<?php

get_header();
?>

<main id="password-protected" class="password-protected" role="main">
	<div class="password-protected__wrapper">
		<div class="password-protected__wrapper-inner">
			<div class="password-protected-inner">

				<div class="password-protected__branding">
					<span class="icon_lock_alt"></span>
				</div>

				<div class="password-protected__content">
					<?php echo get_the_password_form(); ?>
				</div>

			</div>
		</div>
	</div>
</main>

<?php
get_footer();