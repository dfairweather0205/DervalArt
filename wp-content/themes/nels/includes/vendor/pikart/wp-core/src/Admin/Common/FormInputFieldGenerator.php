<?php

namespace Pikart\WpThemeCore\Admin\Common;

use Pikart\WpThemeCore\Admin\Media\CustomGallery;
use Pikart\WpThemeCore\Admin\Media\CustomGalleryImage;

if ( ! class_exists( __NAMESPACE__ . '\\FormInputFieldGenerator' ) ) {

	/**
	 * Class FormInputFieldGenerator
	 * @package Pikart\WpThemeCore\Admin\MetaBoxes\Generator
	 */
	class FormInputFieldGenerator {
		const INPUT_PATTERN = '<input type="%s" name="%s" id="%s" value="%s" %s />';
		const INPUT_WITHOUT_VALUE_PATTERN = '<input type="%s" name="%s" id="%s" %s />';
		const BUTTON_PATTERN = '<a id="%s" %s >%s</a>';
		const SELECT_PATTERN = '<select name="%s" id="%s" %s >%s</select>';
		const SELECT_OPTION_PATTERN = '<option value="%s" %s >%s</option>';
		const SELECT_OPTGROUP_PATTERN = '<optgroup label="%s" id="%s">%s</optgroup>';
		const TEXT_AREA_PATTERN = '<textarea name="%s" id="%s" %s>%s</textarea>';
		const CHECKBOX_ITEMS_CONTAINER_PATTERN = '<div class="form-table__checkbox-items"> %s %s </div>';

		const DEFAULT_FIELD_TYPE = 'input';

		/**
		 * @var CustomGallery
		 */
		private $customGallery;
		/**
		 * @var CustomGalleryImage
		 */
		private $customGalleryImage;

		/**
		 * FieldGenerator constructor.
		 *
		 * @param CustomGallery $customGallery
		 * @param CustomGalleryImage $customGalleryImage
		 */
		public function __construct( CustomGallery $customGallery, CustomGalleryImage $customGalleryImage ) {
			$this->customGallery      = $customGallery;
			$this->customGalleryImage = $customGalleryImage;

			$this->customGallery->setup();
			$this->customGalleryImage->setup();
		}

		/**
		 * @param array $fieldConfig
		 * @param string $type
		 *
		 * @return string
		 */
		public function generate( array $fieldConfig, $type = 'input' ) {
			$generateMethod            = method_exists( $this, $type ) ? $type : self::DEFAULT_FIELD_TYPE;
			$fieldConfig['attributes'] = $this->getAttributeListString( $fieldConfig );

			return $this->$generateMethod( $fieldConfig );
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		public function gallery( array $fieldConfig ) {
			$imageIds = empty( $fieldConfig['value'] ) ? array() : explode( ',', $fieldConfig['value'] );

			return $this->customGallery->generateGalleryHtml( $fieldConfig['id'], $imageIds );
		}

		/**
		 * @param $fieldConfig
		 *
		 * @return string
		 */
		public function wpEditor( array $fieldConfig ) {
			$settings = isset( $fieldConfig['editor_settings'] ) ? $fieldConfig['editor_settings'] : '';

			$settings['textarea_name'] = $fieldConfig['id'];

			ob_start();
			wp_editor( $fieldConfig['value'], 'wp_editor_' . $fieldConfig['id'], $settings );
			$content = ob_get_contents();
			ob_end_clean();

			return $content;
		}

		/**
		 * @param $fieldConfig
		 *
		 * @return string
		 */
		public function input( array $fieldConfig ) {
			return sprintf(
				self::INPUT_PATTERN,
				esc_attr( $fieldConfig['type'] ),
				esc_attr( $fieldConfig['id'] ),
				esc_attr( $fieldConfig['id'] ),
				esc_attr( $fieldConfig['value'] ),
				$fieldConfig['attributes']
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
				esc_attr( $fieldConfig['id'] ),
				$fieldConfig['attributes'],
				esc_html( $fieldConfig['title'] )
			);
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		public function multiCheckbox( array $fieldConfig ) {
			$items = array();

			$id                  = $fieldConfig['id'];
			$fieldConfig['type'] = 'checkbox';
			$options             = (array) $fieldConfig['value'];

			foreach ( $fieldConfig['options'] as $option => $label ) {
				$fieldConfig['id']    = sprintf( '%s[%s]', $id, $option );
				$fieldConfig['value'] = isset( $options[ $option ] )
					? $options[ $option ] : in_array( $option, $options );

				$items[] = sprintf( self::CHECKBOX_ITEMS_CONTAINER_PATTERN, $this->checkbox( $fieldConfig ), $label );
			}

			return implode( '', $items );
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		public function checkbox( array $fieldConfig ) {
			$checked = $fieldConfig['value'] ? 'checked="checked"' : '';

			return sprintf(
				self::INPUT_WITHOUT_VALUE_PATTERN,
				esc_attr( $fieldConfig['type'] ),
				esc_attr( $fieldConfig['id'] ),
				esc_attr( $fieldConfig['id'] ),
				$fieldConfig['attributes'] . ' ' . $checked
			);
		}

		/**
		 * @param array $fieldConfig
		 * @param bool $multiple
		 *
		 * @return string
		 */
		public function select( array $fieldConfig, $multiple = false ) {
			$optionPattern = self::SELECT_OPTION_PATTERN;

			$buildOption = function ( $option, $label ) use ( $fieldConfig, $optionPattern ) {
				$isOptionSelected = function ( $value, $option ) {
					return ( $value == $option ) || ( is_array( $value ) && in_array( $option, $value ) );
				};

				$selected = $isOptionSelected( $fieldConfig['value'], $option ) ? 'selected' : '';

				return sprintf( $optionPattern, esc_attr( $option ), esc_attr( $selected ), esc_html( $label ) );
			};

			$groups = array();

			foreach ( $fieldConfig['options'] as $option => $data ) {
				if ( is_array( $data ) ) {
					$options = array();
					foreach ( $data['items'] as $id => $item ) {
						$options[] = $buildOption( $id, $item );
					}
					$groups[] =
						sprintf( self::SELECT_OPTGROUP_PATTERN,
							esc_attr( $data['group_name'] ), esc_attr( $option ), implode( '', $options ) );
				} else {
					$groups[] = $buildOption( $option, $data );
				}
			}

			return sprintf(
				self::SELECT_PATTERN,
				esc_attr( $fieldConfig['id'] ) . ( $multiple ? '[]' : '' ),
				esc_attr( $fieldConfig['id'] ),
				$fieldConfig['attributes'] . ( $multiple ? ' multiple="multiple"' : '' ),
				implode( '', $groups )
			);
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		public function multiSelect( array $fieldConfig ) {
			return $this->select( $fieldConfig, true );
		}

		/**
		 * @param array $fieldConfig
		 *
		 * @return string
		 */
		public function textArea( array $fieldConfig ) {
			return sprintf(
				self::TEXT_AREA_PATTERN,
				esc_attr( $fieldConfig['id'] ),
				esc_attr( $fieldConfig['id'] ),
				$fieldConfig['attributes'],
				esc_textarea( $fieldConfig['value'] )
			);
		}

		/**
		 * @param $fieldConfig
		 *
		 * @return string
		 */
		public function wpColorPicker( array $fieldConfig ) {
			$fieldConfig['type'] = 'text';

			return $this->input( $fieldConfig );
		}

		/**
		 * @param $fieldConfig
		 *
		 * @return string
		 */
		public function galleryImage( array $fieldConfig ) {
			return $this->customGalleryImage->generateGalleryImageHtml( $fieldConfig['id'], $fieldConfig['value'] );
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