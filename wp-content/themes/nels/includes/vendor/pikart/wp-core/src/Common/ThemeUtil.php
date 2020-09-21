<?php

namespace Pikart\WpThemeCore\Common;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeUtil' ) ) {
	/**
	 * Class ThemeUtil
	 * @package Pikart\WpThemeCore\Common
	 */
	class ThemeUtil {

		/**
		 * @var \WP_Theme
		 */
		private $wpTheme;

		/**
		 * ThemeUtil constructor.
		 */
		public function __construct() {
			$this->wpTheme = wp_get_theme();
		}

		/**
		 * @return string
		 */
		public function getName() {
			return $this->wpTheme->get( 'Name' );
		}

		/**
		 * @return string
		 */
		public function getUri() {
			return $this->wpTheme->get( 'ThemeURI' );
		}

		/**
		 * @return string
		 */
		public function getStatus() {
			return $this->wpTheme->get( 'Status' );
		}

		/**
		 * @return string
		 */
		public function getDescription() {
			return $this->wpTheme->get( 'Description' );
		}

		/**
		 * @return string
		 */
		public function getVersion() {
			return $this->wpTheme->get( 'Version' );
		}

		/**
		 * @return string
		 */
		public function getAuthor() {
			return $this->wpTheme->get( 'Author' );
		}

		/**
		 * @return string
		 */
		public function getAuthorUri() {
			return $this->wpTheme->get( 'AuthorURI' );
		}

		/**
		 * @return string
		 */
		public function getTextDomain() {
			return $this->wpTheme->get( 'TextDomain' );
		}

		/**
		 * @return string
		 */
		public function getTags() {
			return $this->wpTheme->get( 'Tags' );
		}

		/**
		 * @return string
		 */
		public function getTemplate() {
			return $this->wpTheme->get( 'Template' );
		}

		/**
		 * @return string
		 */
		public function getDomainPath() {
			return $this->wpTheme->get( 'DomainPath' );
		}
	}
}
