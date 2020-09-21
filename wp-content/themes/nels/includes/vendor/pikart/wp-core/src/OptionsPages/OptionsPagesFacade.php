<?php

namespace Pikart\WpThemeCore\OptionsPages;

use InvalidArgumentException;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesFacade' ) ) {

	/**
	 * Class OptionsPagesFacade
	 * @package Pikart\WpThemeCore\OptionsPages
	 */
	class OptionsPagesFacade {

		/**
		 * @var OptionsMenuPageGenericRegister
		 */
		private $menuRegister;

		/**
		 * @var OptionsPageSettingsRegister
		 */
		private $settingsRegister;

		/**
		 * @var OptionsPagesCoreUtil
		 */
		private $optionsPagesCoreUtil;

		/**
		 * OptionsPagesFacade constructor.
		 *
		 * @param OptionsPageSettingsRegister $settingsRegister
		 * @param OptionsPagesCoreUtil $optionsPagesCoreUtil
		 */
		public function __construct(
			OptionsPageSettingsRegister $settingsRegister,
			OptionsPagesCoreUtil $optionsPagesCoreUtil
		) {
			$this->settingsRegister     = $settingsRegister;
			$this->optionsPagesCoreUtil = $optionsPagesCoreUtil;
		}

		/**
		 * @param array $options
		 */
		public function setupOptions( array $options ) {
			if ( null === $this->menuRegister ) {
				throw new InvalidArgumentException( 'Please set menu page register' );
			}

			$menuRegister     = $this->menuRegister;
			$settingsRegister = $this->settingsRegister;

			$this->optionsPagesCoreUtil->initOptionsConfig( $options );

			add_action( 'admin_menu', function () use ( $options, $menuRegister ) {
				foreach ( $options as $page ) {
					$menuRegister->register( $page );
				}
			} );

			add_action( 'admin_init', function () use ( $options, $settingsRegister ) {
				foreach ( $options as $page ) {
					$settingsRegister->register( $page );
				}
			} );
		}

		/**
		 * @param OptionsMenuPageGenericRegister $menuRegister
		 */
		public function setMenuRegister( $menuRegister ) {
			$this->menuRegister = $menuRegister;
		}
	}
}