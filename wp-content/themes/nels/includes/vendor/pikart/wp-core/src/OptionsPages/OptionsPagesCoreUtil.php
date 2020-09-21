<?php

namespace Pikart\WpThemeCore\OptionsPages;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesCoreUtil' ) ) {

	/**
	 * Class OptionsPagesCoreUtil
	 * @package Pikart\WpThemeCore\OptionsPages
	 */
	class OptionsPagesCoreUtil {

		/**
		 * @var array
		 */
		private $options = array();

		/**
		 * @var array
		 */
		private $optionsConfig = array();

		/**
		 * @param array $optionsConfig
		 */
		public function initOptionsConfig( array $optionsConfig ) {
			foreach ( $optionsConfig as $page ) {
				foreach ( $page['sections'] as $section ) {
					foreach ( $section['controls'] as $control ) {
						$this->optionsConfig[ $page['id'] ][ $control['id'] ] = $control;
					}
				}
			}
		}

		/**
		 * @param string $pageId
		 *
		 * @return array
		 */
		public function getOptions( $pageId ) {
			if ( ! isset( $this->options[ $pageId ] ) ) {
				$options = get_option( OptionsPagesConfig::getOptionsPageDbKey( $pageId ), array() );

				$this->options[ $pageId ] = is_array( $options ) ? $options : array();
			}

			return $this->options[ $pageId ];
		}

		/**
		 * @param string $pageId
		 * @param string $optionId
		 *
		 * @return mixed
		 */
		public function getOption( $pageId, $optionId ) {
			$options = $this->getOptions( $pageId );

			return isset( $options[ $optionId ] )
				? $options[ $optionId ] : $this->getOptionDefaultValue( $pageId, $optionId );
		}

		/**
		 * @param string $pageId
		 * @param string $optionId
		 * @param mixed $optionValue
		 *
		 * @since 1.6.1
		 */
		public function updateOption( $pageId, $optionId, $optionValue ) {
			$options = $this->getOptions( $pageId );

			$options[ $optionId ] = $optionValue;

			$this->updateOptions($pageId, $options);
		}

		/**
		 * @param string $pageId
		 * @param array $options
		 *
		 * @since 1.6.2
		 */
		public function updateOptions( $pageId, $options ) {
			update_option( OptionsPagesConfig::getOptionsPageDbKey( $pageId ), $options );
		}

		/**
		 * @param string $pageId
		 * @param string $optionId
		 * @param string $value
		 *
		 * @return bool
		 */
		public function multiOptionHasValue( $pageId, $optionId, $value ) {
			$option = $this->getOption( $pageId, $optionId );

			return ! empty( $option ) && in_array( $value, $option, true ) || isset( $option[ $value ] );
		}


		/**
		 * @param string $pageId
		 * @param string $optionId
		 *
		 * @return mixed
		 */
		private function getOptionDefaultValue( $pageId, $optionId ) {
			$controlType = isset( $this->optionsConfig[ $pageId ][ $optionId ]['type'] )
				? $this->optionsConfig[ $pageId ][ $optionId ]['type'] : OptionsPagesConfig::DEFAULT_CONTROL_TYPE;

			$defaultValue = isset( $this->optionsConfig[ $pageId ][ $optionId ]['default'] )
				? $this->optionsConfig[ $pageId ][ $optionId ]['default']
				: ( in_array( $controlType, OptionsPagesConfig::getArrayControlTypes() ) ? array() : '' );

			return apply_filters(
				OptionsPagesFilterName::settingDefaultValue( $pageId, $optionId ),
				$defaultValue
			);
		}
	}
}