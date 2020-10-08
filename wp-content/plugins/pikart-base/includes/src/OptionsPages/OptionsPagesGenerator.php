<?php

namespace Pikart\WpBase\OptionsPages;

use Pikart\WpCore\OptionsPages\OptionsPagesFacade;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesGenerator' ) ) {

	/**
	 * Class OptionsPagesGenerator
	 * @package Pikart\WpBase\OptionsPages
	 */
	class OptionsPagesGenerator {

		/**
		 * @var OptionsPagesConfigProvider
		 */
		private $configProvider;

		/**
		 * @var OptionsPagesFacade
		 */
		private $optionsPagesFacade;

		/**
		 * @var OptionsMenuPageRegister
		 */
		private $optionsMenuPageRegister;

		/**
		 * OptionsPagesGenerator constructor.
		 *
		 * @param OptionsPagesConfigProvider $configProvider
		 * @param OptionsPagesFacade $optionsPagesFacade
		 * @param OptionsMenuPageRegister $optionsMenuPageRegister
		 */
		public function __construct(
			OptionsPagesConfigProvider $configProvider,
			OptionsPagesFacade $optionsPagesFacade,
			OptionsMenuPageRegister $optionsMenuPageRegister
		) {
			$this->configProvider          = $configProvider;
			$this->optionsPagesFacade      = $optionsPagesFacade;
			$this->optionsMenuPageRegister = $optionsMenuPageRegister;
		}

		public function run() {
			$optionsPagesFacade      = $this->optionsPagesFacade;
			$optionsMenuPageRegister = $this->optionsMenuPageRegister;
			$configProvider          = $this->configProvider;

			add_action( 'init', function () use (
				$optionsPagesFacade, $optionsMenuPageRegister, $configProvider
			) {
				$optionsPagesFacade->setMenuRegister( $optionsMenuPageRegister );
				$optionsPagesFacade->setupOptions( $configProvider->getOptions() );
			}, 1 );
		}
	}
}