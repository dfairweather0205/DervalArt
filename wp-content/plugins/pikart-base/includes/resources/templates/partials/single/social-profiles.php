<?php

use Pikart\WpBase\DependencyInjection\Service;

$socialProfilesConfig = array(
	'facebook'  => array(
		'url'       => 'https://www.facebook.com/sharer/sharer.php?u=%s',
		'iconClass' => 'fa-facebook-official',
	),
	'twitter'   => array(
		'url' => 'http://twitter.com/share?url=%s',
	),
	'pinterest' => array(
		'url' => 'http://pinterest.com/pin/create/button/?url=%s',
	),
	'mail'      => array(
		'url'       => 'mailto:?subject=' . esc_html__( 'SeeThis:', 'pikart-base' ) . '%s',
		'iconClass' => 'fa-envelope',
		'label'     => esc_html__( 'Email', 'pikart-base' ),
	),
	'whatsapp'  => array(
		'url'   => 'whatsapp://send?text=%s',
		'label' => 'WhatsApp',
	),
	'ok'        => array(
		'url'       => 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=%s',
		'label'     => 'Odnoklassniki',
		'iconClass' => 'fa-odnoklassniki',
		'linkClass' => 'social-odnoklassniki',
	),
	'vk'        => array(
		'url'   => 'https://vk.com/share.php?url=%s',
		'label' => 'VKontakte',
	),
	'telegram'  => array(
		'url' => 'https://telegram.me/share/url?url=%s',
	),
);

$socialProfiles = Service::optionsPagesUtil()->getCustomSocialProfiles();
$pageLink       = get_the_permalink();
?>

<div class="entry-social">

	<?php
	foreach ( $socialProfiles as $profile ):
		$profile = strtolower( $profile );

		if ( ! isset( $socialProfilesConfig[ $profile ] ) ):
			continue;
		endif;

		$profileConfig = $socialProfilesConfig[ $profile ];

		$url       = sprintf( $profileConfig['url'], $pageLink );
		$label     = isset( $profileConfig['label'] ) ? $profileConfig['label'] : ucfirst( $profile );
		$iconClass = isset( $profileConfig['iconClass'] ) ? $profileConfig['iconClass'] : 'fa-' . $profile;
		$linkClass = isset( $profileConfig['linkClass'] ) ? $profileConfig['linkClass'] : 'social-' . $profile;
		?>

		<a class="social-icon <?php echo esc_attr( $linkClass ) ?>"
		   href="<?php echo esc_url( $url ) ?>"
		   title="<?php printf( esc_attr__( 'Click to share on %s', 'pikart-base' ), $label ) ?>">
			<i class="fa <?php echo esc_attr( $iconClass ) ?>"></i>
			<span><?php echo esc_html( $label ) ?></span>
		</a>

	<?php
	endforeach;
	?>

</div>