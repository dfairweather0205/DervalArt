<?php

use Pikart\WpBase\Admin\Sidebars\CustomSidebarFacade;

?>
<form method="POST">
	<?php wp_nonce_field( CustomSidebarFacade::NONCE_ACTION, CustomSidebarFacade::NONCE_NAME ) ?>
	<h3><?php esc_html_e( 'Add custom sidebar', 'pikart-base' ) ?></h3>
	<input id="custom-sidebar-input" name="sidebar_name"
		   placeholder="<?php esc_html_e( 'Enter the name of Sidebar', 'pikart-base' ) ?>"/>
	<input class="custom-sidebar-add-button" type="submit" value="<?php esc_html_e( 'Add Sidebar', 'pikart-base' ) ?>"
		   name="add_custom_sidebar"/>
</form>