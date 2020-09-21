<?php
/**
 * @var array $pikartOptionsPageData
 */
?>
<div id="options-pages" class="wrap">
	<h1 class="options-pages__title"><?php echo esc_html( $pikartOptionsPageData['title'] ) ?></h1>

	<form class="options-pages__form" action="options.php" method="POST">

		<?php
		settings_fields( $pikartOptionsPageData['id'] );
		do_settings_sections( $pikartOptionsPageData['id'] );
		submit_button();
		?>

	</form>

</div>