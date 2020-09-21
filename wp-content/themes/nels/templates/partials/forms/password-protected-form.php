<?php
$post = get_post();

if ( ! is_singular( $post ) ) :
	return;
endif;


$passwordInputId = sprintf( 'pwbox-%d', empty( $post->ID ) ? rand() : $post->ID );
?>

<form action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) ?>"
      class="password-protected-form" method="post">

	<div class="password-form-text">
		<?php esc_html_e( 'This area is password protected. To view it please enter the password.', 'nels' ) ?>
	</div>

	<input type="password" name="post_password" id="<?php echo esc_attr( $passwordInputId ) ?>" class="password-form" size="20"/>
	<input type="submit" name="Submit" class="password-form__button button--medium button--txt--small"
	       value="<?php esc_attr_e( 'Submit', 'nels' ) ?>"/>

</form>