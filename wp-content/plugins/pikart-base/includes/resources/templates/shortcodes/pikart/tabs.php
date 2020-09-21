<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array                                      $data
 */

$tabsData = $this->getShortcodeData( 'tab' );
$tabsId   = 'tabs-' . uniqid();

$tabsLinks    = array();
$tabsContents = array();

foreach ( $tabsData as $index => $tabData ):
	$tabId          = sprintf( '%s-%s', $tabsId, $index + 1 );
	$isActive       = $index === 0 ? 'is-active' : '';
	$tabsLinks[]    = sprintf(
		'<li class="tabs__title %s"><a href="#%s">%s</a></li>',
		$isActive, $tabId, esc_html( $tabData['attributes']['title'] )
	);
	$tabsContents[] = sprintf(
		'<div class="tabs__panel %s" id="%s">%s</div>',
		$isActive, $tabId, $tabData['content'] );
endforeach;

$cssClasses   = esc_attr( $data['css_class'] );
$tabsLinks    = implode( '', $tabsLinks );
$tabsContents = implode( '', $tabsContents );


echo <<<HTML
<div class="pikode pikode--tabs">
	<ul class="pikode--tabs__branding" data-tabs id="$tabsId">$tabsLinks</ul>
	<div class="pikode--tabs__content $cssClasses" data-tabs-content="$tabsId">$tabsContents</div>
</div>
HTML;
