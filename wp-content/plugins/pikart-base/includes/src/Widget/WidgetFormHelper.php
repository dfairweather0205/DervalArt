<?php

namespace Pikart\WpBase\Widget;

if ( ! class_exists( __NAMESPACE__ . '\\WidgetFormHelper' ) ) {

	/**
	 * Class WidgetFormHelper
	 * @package Pikart\WpBase\Widget
	 *
	 * @since 1.1.0
	 */
	class WidgetFormHelper {

		const CONTAINER_PATTERN = '<p>%s</p>';
		const LABEL_PATTERN = '<label for="%s">%s</label>';
		const INPUT_PATTERN = '<input type="%s" id="%s" name="%s" value="%s" class="%s" %s />';
		const SELECT_PATTERN = '<select id="%s" name="%s" class="%s" %s >%s</select>';
		const SELECT_OPTION_PATTERN = '<option value="%s" %s >%s</option>';
		const BUTTON_PATTERN = '<button type="button" class="%s" %s>%s</button>';

		const DEFAULT_FIELD_TYPE = 'input';

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $input
		 *
		 * @return string
		 */
		public function generateOption( $id, $label, $input ) {
			$labelAllowedTags = array(
				'a' => array(
					'href'   => true,
					'target' => true,
				),
			);

			$label = sprintf( self::LABEL_PATTERN, esc_attr( $id ), wp_kses( $label, $labelAllowedTags ) );

			return $this->generateParagraph( $label . $input );
		}

		/**
		 * @param string $content
		 *
		 * @return string
		 */
		public function generateParagraph( $content ) {
			return sprintf( self::CONTAINER_PATTERN, $content );
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		public function generateInputField( array $fieldConfig ) {
			$type = empty( $fieldConfig['type'] ) ? self::DEFAULT_FIELD_TYPE : $fieldConfig['type'];

			$generateMethod            = method_exists( $this, $type ) ? $type : self::DEFAULT_FIELD_TYPE;
			$fieldConfig['attributes'] = $this->getAttributeListString( $fieldConfig );

			if ( ! isset( $fieldConfig['id'] ) ) {
				$fieldConfig['id'] = '';
			}

			if ( ! isset( $fieldConfig['class'] ) ) {
				$fieldConfig['class'] = '';
			}

			return $this->$generateMethod( $fieldConfig );
		}

		/**
		 * @param array $config
		 *
		 * @return string
		 */
		public function input( array $config = array() ) {
			return sprintf(
				self::INPUT_PATTERN,
				esc_attr( $config['type'] ),
				esc_attr( $config['id'] ),
				esc_attr( $config['name'] ),
				esc_attr( $config['value'] ),
				esc_attr( $config['class'] ),
				$config['attributes']
			);
		}

		/**
		 * @param array $config
		 *
		 * @return string
		 */
		public function select( array $config = array() ) {
			$optionGroups = array();
			$value        = $config['value'];

			foreach ( $config['options'] as $option => $label ) {
				$selected       = strval( $option ) === strval( $value ) ? 'selected' : '';
				$optionGroups[] = sprintf(
					self::SELECT_OPTION_PATTERN,
					esc_attr( $option ),
					esc_attr( $selected ),
					esc_html( $label )
				);
			}

			return sprintf(
				self::SELECT_PATTERN,
				esc_attr( $config['id'] ),
				esc_attr( $config['name'] ),
				esc_attr( $config['class'] ),
				$config['attributes'],
				implode( '', $optionGroups )
			);
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		public function button( array $fieldConfig ) {
			return sprintf(
				self::BUTTON_PATTERN,
				esc_attr( $fieldConfig['class'] ),
				$fieldConfig['attributes'],
				esc_attr( $fieldConfig['title'] )
			);
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		private function getAttributeListString( array $fieldConfig ) {
			if ( ! isset( $fieldConfig['attributes'] ) ) {
				return '';
			}

			$attributesList = array();

			foreach ( $fieldConfig['attributes'] as $attr => $val ) {
				$attributesList[] = sprintf( '%s="%s"', esc_attr( $attr ), esc_attr( $val ) );
			}

			return implode( ' ', $attributesList );
		}
	}
}