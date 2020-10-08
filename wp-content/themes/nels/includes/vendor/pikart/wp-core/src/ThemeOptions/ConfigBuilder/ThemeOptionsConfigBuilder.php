<?php

namespace Pikart\WpThemeCore\ThemeOptions\ConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsConfigBuilder' ) ) {
	/**
	 * Class ThemeOptionsConfigBuilder
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	class ThemeOptionsConfigBuilder {

		/**
		 * @var PanelConfigBuilder
		 */
		private $panelBuilder;

		/**
		 * @var SectionConfigBuilder
		 */
		private $sectionBuilder;

		/**
		 * @var ControlConfigBuilder
		 */
		private $controlBuilder;

		/**
		 * @var array
		 */
		private $config = array();

		/**
		 * ThemeOptionsConfigBuilder constructor.
		 *
		 * @param PanelConfigBuilder $panelBuilder
		 * @param SectionConfigBuilder $sectionBuilder
		 * @param ControlConfigBuilder $configBuilder
		 */
		public function __construct(
			PanelConfigBuilder $panelBuilder,
			SectionConfigBuilder $sectionBuilder,
			ControlConfigBuilder $configBuilder
		) {

			$this->panelBuilder   = $panelBuilder;
			$this->sectionBuilder = $sectionBuilder;
			$this->controlBuilder = $configBuilder;
		}

		/**
		 * @param array $panels
		 * @param array $sections
		 *
		 * @return $this
		 */
		public function customOptions( $panels = array(), $sections = array() ) {
			$this->config['customOptions'] = array();

			if ( ! empty( $panels ) ) {
				$this->config['customOptions']['panels'] = $panels;
			}

			if ( ! empty( $sections ) ) {
				$this->config['customOptions']['sections'] = $sections;
			}

			return $this;
		}

		/**
		 * @param array $options
		 *
		 * @return $this
		 */
		public function wpOptions( array $options ) {
			$this->config['wpOptions'] = $options;

			return $this;
		}

		/**
		 * @return ThemeOptions
		 */
		public function buildThemeOptions() {
			return new ThemeOptions( $this->config['customOptions'], $this->config['wpOptions'] );
		}


		/**
		 * @param string $id
		 *
		 * @return PanelConfigBuilder
		 */
		public function panel( $id = '' ) {
			return $this->panelBuilder->panel( $id );
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
		public function getPanelBuilder() {
			return $this->panelBuilder;
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
