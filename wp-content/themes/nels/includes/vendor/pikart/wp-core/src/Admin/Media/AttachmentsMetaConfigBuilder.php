<?php
namespace Pikart\WpThemeCore\Admin\Media;

if ( ! class_exists( __NAMESPACE__ . '\AttachmentsMetaConfigBuilder' ) ) {

	/**
	 * Class AttachmentsMetaConfigBuilder
	 * @package Pikart\WpThemeCore\Admin\Media
	 */
	class AttachmentsMetaConfigBuilder {

		const TEXT = 'text';
		const TEXT_AREA = 'textarea';
		const HIDDEN = 'hidden';

		/**
		 * @var array
		 */
		private $field = array();

		/**
		 * @var array
		 */
		private $config = array();

		/**
		 * @return array
		 */
		public function build() {
			$this->saveField();

			$config       = $this->config;
			$this->config = array();

			return $config;
		}

		/**
		 * @param string $id
		 *
		 * @return $this
		 */
		public function text( $id = '' ) {
			return $this->buildField( self::TEXT, $id );
		}

		/**
		 * @param string $id
		 *
		 * @return $this
		 */
		public function textArea( $id = '' ) {
			return $this->buildField( self::TEXT_AREA, $id );
		}

		/**
		 * @param string $id
		 *
		 * @return $this
		 */
		public function hidden( $id = '' ) {
			return $this->buildField( self::HIDDEN, $id );
		}

		/**
		 * @param string $id
		 *
		 * @return $this
		 */
		public function id( $id ) {
			$this->field['id'] = $id;

			return $this;
		}

		/**
		 * @param mixed $default
		 *
		 * @return $this
		 */
		public function defaultVal( $default ) {
			$this->field['default'] = $default;

			return $this;
		}

		/**
		 * @param string $label
		 *
		 * @return $this
		 */
		public function label( $label ) {
			$this->field['label'] = $label;

			return $this;
		}

		/**
		 * @param string $description
		 *
		 * @return $this
		 */
		public function description( $description ) {
			$this->field['helps'] = $description;

			return $this;
		}

		/**
		 * @param bool $required
		 *
		 * @return $this
		 */
		public function required( $required ) {
			$this->field['required'] = $required;

			return $this;
		}


		/**
		 * @param string $type
		 * @param string $id
		 *
		 * @return $this
		 */
		private function buildField( $type, $id = '' ) {
			$this->saveField();

			$this->field['input'] = $type;

			return $this->id( $id );
		}

		private function saveField() {
			if ( empty( $this->field ) ) {
				return;
			}

			$this->config[ $this->field['id'] ] = $this->field;
			$this->field                        = array();
		}
	}
}