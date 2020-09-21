<?php
/**
 * @var \Pikart\WpBase\Widget\Type\SocialLinksWidget $this
 * @var array $data
 *
 * @since 1.6.2
 */

$target       = $this->getOptionValue( 'links_target', $data );
$fontSize     = $this->getOptionValue( 'font_size', $data );
$networkLinks = $data['hasNetworkLinks'] ? $data[ $this::NETWORK_LINKS_FIELD ] : array();
$networkLinks = array_filter( $networkLinks );

?>
<div class="widget_social_links__list">

	<?php
	if ( $data['hasEmail'] ) :
		print( $this->generateSocialLink(
			'mailto:' . antispambot( $data['mail'] ), '_self', 'envelope', $fontSize ) );
	endif;

	foreach ( $networkLinks as $networkLink ) :
		print ( $this->generateSocialLink(
			$networkLink, $target, $this->util->getUrlDomain( $networkLink, false ), $fontSize ) );
	endforeach;
	?>

</div>
