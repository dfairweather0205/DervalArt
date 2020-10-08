<?php

namespace Pikart\WpCore\Admin\MetaBoxes;

use Pikart\WpCore\Admin\MetaBoxes\Generator\MetaBoxGenerator;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxConfigBuilder' ) ) {

	/**
	 * Class MetaBoxConfigBuilder
	 * @package Pikart\WpCore\Admin\MetaBoxes
	 */
	class MetaBoxConfigBuilder {
		const DB_PREFIX = '_pikart_meta_';

		const GALLERY = 'gallery';
		const TEXT = 'text';
		const SELECT = 'select';
		const NUMBER = 'number';
		const MULTI_SELECT = 'multiSelect';
		const CHECKBOX = 'checkbox';
		const WP_EDITOR = 'wpEditor';
		const BUTTON = 'button';
		const URL = 'url';
		const TEXT_AREA = 'textArea';
		const WP_COLOR_PICKER = 'wpColorPicker';
		const GALLERY_IMAGE = 'galleryImage';

		/**
		 * @since 1.7.0
		 */
		const TAB = 'tab';
		const NO_INPUT = 'noInput';

		/**
		 * @var array
		 */
		private $metaBox = array();

		/**
		 * @var array
		 */
		private $config = array();

		/**
		 * @var array
		 *
		 * @since 1.7.0
		 */
		private $tab = array();

		/**
		 * @var bool
		 */
		private $isTab = false;

		/**
		 * @since 1.3.0 Added the `$context` parameter.
		 *
		 * @param string $id
		 * @param string $label
		 * @param string $priority
		 * @param string $context
		 *
		 * @return $this
		 */
		public function metaBox(
			$id,
			$label,
			$priority = MetaBoxGenerator::DEFAULT_META_BOX_PRIORITY,
			$context = MetaBoxGenerator::DEFAULT_META_BOX_CONTEXT
		) {
			$this->saveMetaBox();

			$this->metaBox = array(
				'id'       => $id,
				'label'    => $label,
				'nonce'    => array(
					'action' => self::DB_PREFIX . $id,
					'name'   => self::DB_PREFIX . $id . '_nonce'
				),
				'priority' => $priority,
				'context'  => $context,
				'fields'   => array()
			);

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $position
		 *
		 * @return $this
		 * @since 1.7.0
		 *
		 */
		public function tab( $id, $label, $position = 'vertical' ) {
			$this->saveTab();

			$this->tab = array(
				'id'       => $id,
				'type'     => self::TAB,
				'label'    => $label,
				'position' => $position,
				'fields'   => array()
			);

			$this->isTab = true;

			return $this;
		}

		/**
		 * @since 1.7.0
		 *
		 * @return $this
		 */
		public function endTab() {
			$this->saveTab();

			return $this;
		}

		/**
		 * @param $label
		 *
		 * @since 1.7.0
		 */
		public function noInput( $label ) {
			$settings = array(
				'type'    => self::NO_INPUT,
				'label'   => $label,
				'persist' => false
			);

			$this->addToFieldList( $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function gallery( $id, $label, $description = '', array $settings = array() ) {
			$this->buildField( self::GALLERY, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function text( $id, $label, $description = '', array $settings = array() ) {
			$this->buildField( self::TEXT, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function number( $id, $label, $description = '', array $settings = array() ) {
			$this->setInputFilter( $settings, FILTER_SANITIZE_NUMBER_FLOAT );
			$this->buildField( self::NUMBER, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function url( $id, $label, $description = '', array $settings = array() ) {
			$this->setInputFilter( $settings, FILTER_SANITIZE_URL );
			$this->buildField( self::URL, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function date( $id, $label, $description = '', array $settings = array() ) {
			$this->setAttribute( $settings, 'class', ' pikart-metabox-date' );

			$this->buildField( self::TEXT, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function select( $id, $label, $description = '', array $settings = array() ) {
			$this->buildField( self::SELECT, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function multiSelect( $id, $label, $description = '', array $settings = array() ) {
			$this->setInputFilter( $settings, FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
			$this->setAttribute( $settings, 'class', ' pikart-metabox-multi-select' );

			$this->buildField( self::MULTI_SELECT, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function checkbox( $id, $label, $description = '', array $settings = array() ) {
			$this->buildField( self::CHECKBOX, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function galleryImage( $id, $label = '', $description = '', array $settings = array() ) {
			$this->buildField( self::GALLERY_IMAGE, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function wpEditor( $id, $label, $description = '', array $settings = array() ) {
			$this->setInputFilter( $settings, FILTER_DEFAULT );
			$this->buildField( self::WP_EDITOR, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function wpColorPicker( $id, $label, $description = '', array $settings = array() ) {
			$this->setAttribute( $settings, 'class', ' pikart-metabox-wp-color-picker' );

			$this->buildField( self::WP_COLOR_PICKER, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function button( $id, $label, $description = '', array $settings = array() ) {
			$this->buildField( self::BUTTON, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 *
		 * @return $this
		 */
		public function textArea( $id, $label, $description = '', array $settings = array() ) {
			$this->setInputFilter( $settings, FILTER_DEFAULT );
			$this->buildField( self::TEXT_AREA, $id, $label, $description, $settings );

			return $this;
		}

		/**
		 * @return array
		 */
		public function build() {
			$this->saveMetaBox();

			$config       = $this->config;
			$this->config = array();

			return $config;
		}

		/**
		 * @return $this
		 */
		public function reset() {
			$this->config  = array();
			$this->metaBox = array();

			return $this;
		}

		/**
		 * @param string $type
		 * @param string $id
		 * @param string $label
		 * @param string $description
		 * @param array $settings
		 */
		private function buildField( $type, $id, $label, $description = '', array $settings = array() ) {
			$settings['id']    = self::DB_PREFIX . $id;
			$settings['type']  = $type;
			$settings['label'] = $label;

			if ( empty( $settings['description'] ) ) {
				$settings['description'] = $description;
			}

			$this->addToFieldList( $settings );
		}

		/**
		 * @param array $settings
		 *
		 * @since 1.7.0
		 */
		private function addToFieldList( array $settings ) {
			if ( $this->isTab ) {
				$this->tab['fields'][] = $settings;
			} else {
				$this->metaBox['fields'][] = $settings;
			}
		}

		private function saveMetaBox() {
			$this->saveTab();

			if ( empty( $this->metaBox ) ) {
				return;
			}

			$this->config[] = $this->metaBox;
			$this->metaBox  = array();
		}

		/**
		 * @since 1.7.0
		 */
		private function saveTab() {
			if ( empty( $this->tab ) ) {
				return;
			}

			$this->metaBox['fields'][] = $this->tab;
			$this->tab                 = array();
			$this->isTab               = false;
		}

		/**
		 * @param array $settings
		 * @param int $filter
		 * @param int $filterOptions
		 */
		private function setInputFilter( array &$settings, $filter, $filterOptions = null ) {
			$settings['input_filter']         = $filter;
			$settings['input_filter_options'] = $filterOptions;
		}

		/**
		 * @param array $settings
		 * @param string $attribute
		 * @param mixed $value
		 */
		private function setAttribute( array &$settings, $attribute, $value ) {
			if ( ! isset( $settings['attributes'] ) ) {
				$settings['attributes'] = array();
			}

			if ( ! isset( $settings['attributes'][ $attribute ] ) ) {
				$settings['attributes'][ $attribute ] = '';
			}

			$settings['attributes'][ $attribute ] .= $value;
		}
	}
}