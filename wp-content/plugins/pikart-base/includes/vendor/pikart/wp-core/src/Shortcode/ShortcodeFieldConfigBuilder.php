<?php

namespace Pikart\WpCore\Shortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodeFieldConfigBuilder' ) ) {

	/**
	 * Class ShortcodeFieldConfigBuilder
	 * @package Pikart\WpCore\Shortcode
	 */
	class ShortcodeFieldConfigBuilder {

		const CUSTOM_COLOR_PICKER = 'CustomColorPicker';
		const TEXT_BOX = 'TextBox';
		const LIST_BOX = 'ListBox';
		const CHECK_BOX = 'CheckBox';
		const CONTAINER = 'Container';
		const MULTI_RANGE_SLIDER = 'MultiRangeSlider';
		const ICON = 'Icon';
		const WP_GALLERY = 'WpGallery';
		const TABS = 'Tabs';
		const NUMBER = 'number';
		const URL = 'url';
		const MULTI_SELECT = 'MultiSelect';
		const LABEL = 'Label';

		/**
		 * @var array
		 */
		private $config = array();

		/**
		 * @return ShortcodeFieldConfigBuilder
		 */
		public static function instance() {
			return new self;
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function customColorPicker( $field, $label, $settings = array() ) {
			$defaultSettings = array(
				'textBoxSettings' => array(
					'placeholder' => esc_html__( 'Enter color code', 'pikart-base' )
				),
				'buttonSettings'  => array(
					'text' => esc_html__( 'Select color', 'pikart-base' )
				),
				'classes'         => 'pikode-color',
			);

			return $this->buildField( $field, $label, self::CUSTOM_COLOR_PICKER, $settings, $defaultSettings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function textArea( $field, $label, array $settings = array() ) {
			$settings['multiline'] = true;

			return $this->buildField( $field, $label, self::TEXT_BOX, $settings, array( 'rows' => 5 ) );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function number( $field, $label, array $settings = array() ) {
			$settings['subtype'] = self::NUMBER;

			return $this->textBox( $field, $label, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function url( $field, $label, array $settings = array() ) {
			$settings['subtype'] = self::URL;

			return $this->textBox( $field, $label, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function textBox( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::TEXT_BOX, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function checkBox( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::CHECK_BOX, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function listBox( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::LIST_BOX, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function container( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::CONTAINER, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function multiRangeSlider( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::MULTI_RANGE_SLIDER, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function icon( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::ICON, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function wpGallery( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::WP_GALLERY, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function tabs( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::TABS, $settings );
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function multiSelect( $field, $label, array $settings = array() ) {
			return $this->buildField( $field, $label, self::MULTI_SELECT, $settings );
		}

		/**
		 * @param string $label
		 * @param array $settings
		 *
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function label( $label, array $settings = array() ) {
			$settings['text'] = $label;

			return $this->buildField( uniqid(), '', self::LABEL, $settings );
		}

		/**
		 * @return ShortcodeFieldConfigBuilder
		 */
		public function cssClass() {
			return $this->textBox( 'css_class', esc_html__( 'CSS Class', 'pikart-base' ) );
		}

		/**
		 * @param string $field
		 *
		 * @return $this
		 */
		public function removeField( $field ) {
			if ( isset( $this->config[ $field ] ) ) {
				unset( $this->config[ $field ] );
			}

			return $this;
		}

		/**
		 * @param string $field
		 * @param string $position (top, bottom, before, after)
		 * @param $dependentItem the item id before/after which the field should be moved, not required for top/bottom
		 *
		 * @return $this
		 */
		public function moveField( $field, $position, $dependentItem = null ) {
			$validPositions = array( 'top', 'bottom', 'after', 'before' );
			$newConfig      = $this->config;

			unset( $newConfig[ $field ] );

			$dependentItemPosition = $dependentItem
				? array_search( $dependentItem, array_keys( $newConfig ) ) : false;

			if ( ! isset( $this->config[ $field ] ) || ! in_array( $position, $validPositions )
			     || ( in_array( $position, array( 'after', 'before' ) ) && $dependentItemPosition === false ) ) {
				return;
			}

			$fieldConfig = $this->config[ $field ];

			switch ( $position ) {
				case 'top':
					$newConfig = array( $field => $fieldConfig ) + $newConfig;
					break;
				case 'bottom':
					$newConfig[ $field ] = $fieldConfig;
					break;
				default:
					if ( $position === 'after' ) {
						$dependentItemPosition ++;
					}

					$newConfig = array_slice( $newConfig, 0, $dependentItemPosition, true )
					             + array( $field => $fieldConfig )
					             + array_slice( $newConfig, $dependentItemPosition,
							count( $newConfig ) - $dependentItemPosition, true );
					break;
			}

			$this->config = $newConfig;

			return $this;
		}

		/**
		 * @param string $field
		 * @param string $label
		 * @param string $fieldType
		 * @param array $settings
		 * @param array $defaultSettings
		 *
		 * @return $this
		 */
		private function buildField(
			$field, $label, $fieldType, array $settings = array(), $defaultSettings = array()
		) {
			$settings['type'] = $fieldType;

			if ( ! empty( $label ) ) {
				$settings['label'] = $label;
			}

			if ( ! empty( $defaultSettings ) ) {
				$settings = array_replace_recursive( $defaultSettings, $settings );
			}

			$this->config[ $field ] = $settings;

			return $this;
		}

		/**
		 * @return array
		 */
		public function build() {
			return $this->config;
		}
	}
}