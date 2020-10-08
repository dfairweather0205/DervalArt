<?php

namespace Pikart\WpCore\OptionsPages\ConfigBuilder;

use Pikart\WpCore\OptionsPages\OptionsPagesControlType;

if ( ! class_exists( __NAMESPACE__ . '\\ControlConfigBuilder' ) ) {
	/**
	 * Class ControlConfigBuilder
	 * @package Pikart\WpCore\OptionsPages\ConfigBuilder
	 */
	class ControlConfigBuilder extends ItemConfigBuilder {

		/**
		 * @var SectionConfigBuilder
		 */
		protected $parentConfigBuilder;

		/**
		 * @param string $id
		 * @param SectionConfigBuilder $sectionConfigBuilder
		 *
		 * @return ControlConfigBuilder
		 */
		public function control( $id = '', $sectionConfigBuilder = null ) {
			return $this->newItem( $id, $sectionConfigBuilder );
		}

		/**
		 * @param string $id
		 *
		 * @return SectionConfigBuilder
		 */
		public function section( $id = '' ) {
			return $this->parentConfigBuilder->section( $id );
		}

		/**
		 * @param string $id
		 *
		 * @return PageConfigBuilder
		 */
		public function page( $id = '' ) {
			return $this->parentConfigBuilder->page( $id );
		}

		/**
		 * @param mixed $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function defaultVal( $value ) {
			return $this->updateItem( 'default', $value );
		}

		/**
		 * @param array $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function inputAttributes( array $value ) {
			return $this->updateItem( 'input_attrs', $value );
		}

		/**
		 * @param string $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function placeholder( $value ) {
			return $this->updateSubItem( 'input_attrs', 'placeholder', $value );
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function text( $id = '' ) {
			return $this->control( $id )->type( OptionsPagesControlType::TEXT );
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function galleryImage( $id = '' ) {
			return $this->control( $id )->type( OptionsPagesControlType::GALLERY_IMAGE );
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function multiSelect( $id = '' ) {
			return $this->control( $id )->type( OptionsPagesControlType::MULTI_SELECT );
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function select( $id = '' ) {
			return $this->control( $id )->type( OptionsPagesControlType::SELECT );
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function options( $options = array() ) {
			return $this->updateItem( 'options', $options );
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function multiCheckbox( $id = '' ) {
			return $this->control( $id )->type( OptionsPagesControlType::MULTI_CHECKBOX );
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function checkbox( $id = '' ) {
			return $this->control( $id )->type( OptionsPagesControlType::CHECKBOX );
		}

		/**
		 * @param string $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function type( $value ) {
			return $this->updateItem( 'type', $value );
		}
	}
}
