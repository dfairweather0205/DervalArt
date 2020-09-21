<?php

namespace Pikart\WpThemeCore\ThemeOptions;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsBuilder' ) ) {
	/**
	 * Class ThemeOptionsBuilder
	 * @package Pikart\WpThemeCore\ThemeOptions
	 */
	class ThemeOptionsBuilder {

		/**
		 * @var ThemeOptionsWrapper
		 */
		private $themeOptionsWrapper;


		/**
		 * ThemeOptionsBuilder constructor.
		 *
		 * @param ThemeOptionsWrapper $themeOptionsWrapper
		 */
		public function __construct( ThemeOptionsWrapper $themeOptionsWrapper ) {
			$this->themeOptionsWrapper = $themeOptionsWrapper;
		}

		public function build( array $options ) {
			if ( isset( $options['panels'] ) ) {
				foreach ( $options['panels'] as $panel ) {
					$this->buildPanel( $panel );
				}
			}

			if ( isset( $options['sections'] ) ) {
				foreach ( $options['sections'] as $section ) {
					$this->buildSection( $section );
				}
			}
		}

		/**
		 * @param array $section
		 * @param string $panelId
		 */
		private function buildSection( $section, $panelId = null ) {
			$sectionId = $section['id'];

			if ( ! isset( $section['built-in'] ) || ! $section['built-in'] ) {
				$section   = apply_filters( ThemeOptionsFilterName::sectionConfig( $section['id'] ), $section );
				$sectionId = $this->themeOptionsWrapper->addSection(
					$section['id'],
					$panelId,
					$this->getValue( $section, 'title' ),
					$this->getValue( $section, 'description' ),
					$this->getValue( $section, 'priority' )
				);
			}

			if ( isset( $section['controls'] ) ) {
				foreach ( $section['controls'] as $control ) {
					$this->buildControl( $control, $sectionId );
				}
			}

		}

		/**
		 * @param array $control
		 * @param string $sectionId
		 */
		private function buildControl( $control, $sectionId ) {
			$control = apply_filters( ThemeOptionsFilterName::controlConfig( $control['id'] ), $control );
			$this->themeOptionsWrapper->addControl( $control['id'], $sectionId, $control['type'], $control );
		}

		/**
		 * @param array $panel
		 */
		private function buildPanel( $panel ) {
			$panel   = apply_filters( ThemeOptionsFilterName::panelConfig( $panel['id'] ), $panel );
			$panelId = $panel['id'];

			if ( ! isset( $panel['built-in'] ) || ! $panel['built-in'] ) {
				$panelId = $this->themeOptionsWrapper->addPanel(
					$panel['id'],
					$panel['title'],
					$this->getValue( $panel, 'description' ),
					$this->getValue( $panel, 'priority' )
				);
			}

			if ( isset( $panel['sections'] ) ) {
				foreach ( $panel['sections'] as $section ) {
					$this->buildSection( $section, $panelId );
				}
			}
		}

		/**
		 * @param array $values
		 * @param string $id
		 * @param string $default
		 *
		 * @return mixed
		 */
		private function getValue( $values, $id, $default = '' ) {
			return isset( $values[ $id ] ) ? $values[ $id ] : $default;
		}
	}
}
