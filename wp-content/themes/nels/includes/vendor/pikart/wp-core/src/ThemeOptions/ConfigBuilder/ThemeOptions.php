<?php

namespace Pikart\WpThemeCore\ThemeOptions\ConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptions' ) ) {

	/**
	 * Class ThemeOptions
	 * @package Pikart\WpThemeCore\ThemeOptions\ConfigBuilder
	 */
	class ThemeOptions {

		/**
		 * @var array
		 */
		private $customOptions = array();

		/**
		 * @var array
		 */
		private $wpOptions = array();

		/**
		 * ThemeOptions constructor.
		 *
		 * @param array $customOptions
		 * @param array $wpOptions
		 */
		public function __construct( array $customOptions, array $wpOptions ) {
			$this->customOptions = $customOptions;
			$this->wpOptions     = $wpOptions;
		}

		/**
		 * @param array $customOptions
		 *
		 * @return ThemeOptions
		 */
		public function setCustomOptions( $customOptions ) {
			$this->customOptions = $customOptions;

			return $this;
		}

		/**
		 * @param array $wpOptions
		 *
		 * @return ThemeOptions
		 */
		public function setWpOptions( $wpOptions ) {
			$this->wpOptions = $wpOptions;

			return $this;
		}

		/**
		 * @return array
		 */
		public function getCustomOptions() {
			return $this->customOptions;
		}

		/**
		 * @return array
		 */
		public function getWpOptions() {
			return $this->wpOptions;
		}
	}
}
