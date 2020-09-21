<?php

namespace Pikart\WpCore\OptionsPages\ConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesConfigBuilder' ) ) {

	/**
	 * Class OptionsPagesConfigBuilder
	 * @package Pikart\WpCore\OptionsPages\ConfigBuilder
	 */
	class OptionsPagesConfigBuilder {

		/**
		 * @var PageConfigBuilder
		 */
		private $pageBuilder;

		/**
		 * @var SectionConfigBuilder
		 */
		private $sectionBuilder;

		/**
		 * @var ControlConfigBuilder
		 */
		private $controlBuilder;

		/**
		 * OptionsPagesConfigBuilder constructor.
		 *
		 * @param SectionConfigBuilder $sectionBuilder
		 * @param ControlConfigBuilder $configBuilder
		 * @param PageConfigBuilder $pageBuilder
		 */
		public function __construct(
			SectionConfigBuilder $sectionBuilder,
			ControlConfigBuilder $configBuilder,
			PageConfigBuilder $pageBuilder
		) {

			$this->sectionBuilder = $sectionBuilder;
			$this->controlBuilder = $configBuilder;
			$this->pageBuilder    = $pageBuilder;
		}

		/**
		 * @param string $id
		 *
		 * @return PageConfigBuilder
		 */
		public function page( $id = '' ) {
			return $this->pageBuilder->page( $id );
		}

		/**
		 * @param string $id
		 *
		 * @return SectionConfigBuilder
		 */
		public function section( $id = '' ) {
			return $this->sectionBuilder->section( $id );
		}

		/**
		 * @param $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function control( $id = '' ) {
			return $this->controlBuilder->control( $id );
		}

		/**
		 * @return PanelConfigBuilder
		 */
		public function getPageBuilder() {
			return $this->pageBuilder;
		}


		/**
		 * @return SectionConfigBuilder
		 */
		public function getSectionBuilder() {
			return $this->sectionBuilder;
		}

		/**
		 * @return ControlConfigBuilder
		 */
		public function getControlBuilder() {
			return $this->controlBuilder;
		}
	}
}
