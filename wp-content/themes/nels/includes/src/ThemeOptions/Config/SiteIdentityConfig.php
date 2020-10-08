<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\SiteIdentityConfig' ) ) {

	/**
	 * Class SiteIdentityConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class SiteIdentityConfig extends GenericConfig {

		const LOGO_SELECTOR = '.site-branding .logo';
		const LOGO_PARTIAL = 'header/branding/branding-logo';

		/**
		 * @return array
		 */
		public function getConfig() {
			$this->configureCustomLogoPartialArguments();

			return $this->configHelper
				->buildCroppedInvertedLogoConfig( $this->controlConfigBuilder )
				->selectiveRefresh( self::LOGO_SELECTOR, self::LOGO_PARTIAL )
				->textArea( ThemeOption::META_DESCRIPTION )
				->label( esc_html__( 'Meta Description', 'nels' ) )
				->build();
		}

		private function configureCustomLogoPartialArguments() {
			$util = $this->util;

			add_filter( 'customize_dynamic_partial_args', function ( $args, $id ) use ( $util ) {
				if ( $id !== 'custom_logo' ) {
					return $args;
				}

				$args['container_inclusive'] = false;
				$args['selector']            = SiteIdentityConfig::LOGO_SELECTOR;
				$args['render_callback']     = function () use ( $util ) {
					$util->partial( SiteIdentityConfig::LOGO_PARTIAL );
				};

				return $args;
			}, 10, 2 );
		}
	}
}