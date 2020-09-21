<?php

namespace Pikart\WpCore\Admin\MetaBoxes\Generator;

use Pikart\WpCore\Admin\Common\FormInputFieldGenerator;
use Pikart\WpCore\Admin\MetaBoxes\MetaBoxConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\LineGenerator' ) ) {
	/**
	 * Class LineGenerator
	 * @package Pikart\WpCore\Admin\MetaBoxes\Generator
	 */
	class LineGenerator {
		const HTML_CONTAINER_PATTERN = '<div class="meta-box-custom-field%s">%s</div>';
		const HTML_OPTION_CONTAINER_PATTERN = '<div class="meta-box-field-field__option">%s</div>';
		const HTML_LABEL_PATTERN = '<label class="meta-box-custom-field__label" for="%s">%s</label>';
		const HTML_DESCRIPTION_PATTERN = '<span class="meta-box-custom-field__description">%s</span>';
		const HTML_NO_INPUT_PATTERN = '<span class="meta-box-custom-field__no-input">%s</span>';

		/**
		 * @var FormInputFieldGenerator
		 */
		private $fieldGenerator;

		/**
		 * LineGenerator constructor.
		 *
		 * @param FormInputFieldGenerator $fieldGenerator
		 */
		public function __construct( FormInputFieldGenerator $fieldGenerator ) {
			$this->fieldGenerator = $fieldGenerator;
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		public function generate( array $fieldConfig ) {
			if ( $fieldConfig['type'] === MetaBoxConfigBuilder::NO_INPUT ) {
				return sprintf( self::HTML_CONTAINER_PATTERN,
					' no-input-title', $this->generateNoInput( $fieldConfig ) );
			}

			$content = $this->generateLabel( $fieldConfig );

			$optionHtml = $this->fieldGenerator->generate( $fieldConfig, $fieldConfig['type'] )
			              . $this->generateDescription( $fieldConfig );

			$content .= sprintf( self::HTML_OPTION_CONTAINER_PATTERN, $optionHtml );

			return sprintf( self::HTML_CONTAINER_PATTERN, '', $content );
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @since 1.7.0
		 *
		 * @return string
		 */
		private function generateNoInput( array $fieldConfig ) {
			return isset( $fieldConfig['label'] ) && ! empty( $fieldConfig['label'] )
				? sprintf( self::HTML_NO_INPUT_PATTERN, $fieldConfig['label'] ) : '';
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		private function generateDescription( array $fieldConfig ) {
			return isset( $fieldConfig['description'] ) && ! empty( $fieldConfig['description'] )
				? sprintf( self::HTML_DESCRIPTION_PATTERN, $fieldConfig['description'] ) : '';
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		private function generateLabel( array $fieldConfig ) {
			return isset( $fieldConfig['label'] ) && ! empty( $fieldConfig['label'] )
				? sprintf( self::HTML_LABEL_PATTERN, $fieldConfig['id'], $fieldConfig['label'] ) : '';
		}
	}
}