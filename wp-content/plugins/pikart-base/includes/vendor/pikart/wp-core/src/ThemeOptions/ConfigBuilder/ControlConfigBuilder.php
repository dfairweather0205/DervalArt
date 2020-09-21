<?php

namespace Pikart\WpCore\ThemeOptions\ConfigBuilder;

use Pikart\WpCore\ThemeOptions\ThemeCoreOptionsConfig;
use Pikart\WpCore\ThemeOptions\ThemeOptionsControlType;
use Pikart\WpCore\ThemeOptions\ThemeOptionsCssFilter;

if ( ! class_exists( __NAMESPACE__ . '\\ControlConfigBuilder' ) ) {
	/**
	 * Class ControlConfigBuilder
	 * @package Pikart\WpCore\ThemeOptions\ConfigBuilder
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
		 * @param SectionConfigBuilder $sectionConfigBuilder
		 *
		 * @since 1.5.0
		 *
		 * @return ControlConfigBuilder
		 */
		public function builtInControl( $id = '', $sectionConfigBuilder = null ) {
			return $this->control( $id, $sectionConfigBuilder )->builtIn( true );
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
		 * @return PanelConfigBuilder
		 */
		public function panel( $id = '' ) {
			return $this->parentConfigBuilder->panel( $id );
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
		 * @param false|string $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function label( $value ) {
			return $this->updateItem( 'label', $value );
		}

		/**
		 * @param array $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function choices( array $value ) {
			return $this->updateItem( 'choices', $value );
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
		 * @param array $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function htmlAttributes( array $value ) {
			return $this->updateItem( 'html_attributes', $value );
		}

		/**
		 * @param bool $persist
		 *
		 * @return $this
		 */
		public function persist( $persist ) {
			$this->updateItem( 'persist', $persist );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return $this
		 */
		public function select( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::SELECT );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function radio( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::RADIO );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function checkbox( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::CHECKBOX );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function checkboxMultiple( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::CHECKBOX_MULTIPLE );

			return $this;
		}

		/**
		 * @param $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function number( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::NUMBER );

			return $this;
		}

		/**
		 * @param $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function color( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::COLOR );
			$this->cssFilter( ThemeOptionsCssFilter::COLOR );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function text( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::TEXT );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function button( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::BUTTON );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function fontFamily( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::FONT_FAMILY );
			$this->cssFilter( ThemeOptionsCssFilter::FONT_FAMILY );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function image( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::IMAGE );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @since 1.5.0
		 *
		 * @return ControlConfigBuilder
		 */
		public function croppedImage( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::CROPPED_IMAGE );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function textArea( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::TEXT_AREA );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function url( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::URL );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function range( $id = '' ) {
			$this->control( $id );
			$this->type( ThemeOptionsControlType::RANGE );

			return $this;
		}

		/**
		 * @param string $id
		 *
		 * @return ControlConfigBuilder
		 */
		public function noInput( $id = '' ) {
			$this->control( $id );
			$this->persist( false );
			$this->type( ThemeOptionsControlType::NO_INPUT );

			return $this;
		}

		/**
		 * @param string $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function type( $value ) {
			return $this->updateItem( 'type', $value );
		}

		/**
		 * @param array $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function css( array $value ) {
			return $this->transportTypePostMessage()->updateItem( 'css', $value );
		}

		/**
		 * @param string $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function cssFilter( $value ) {
			return $this->updateItem( 'css_filter', $value );
		}

		/**
		 * @param array $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function cssItems( array $value ) {
			return $this->transportTypePostMessage()->updateItem( 'css_items', $value );
		}

		/**
		 * @param string $value
		 *
		 * @return ControlConfigBuilder
		 */
		public function cssItem( $value ) {
			return $this->cssItems( array( $value ) );
		}

		/**
		 * @param callable $callback
		 *
		 * @return ControlConfigBuilder
		 */
		public function cssCallback( $callback ) {
			return $this->updateItem( 'css_callback', $callback );
		}

		/**
		 * @param callable $action
		 *
		 * @return ControlConfigBuilder
		 */
		public function action( $action ) {
			return $this->updateItem( 'action', $action );
		}

		/**
		 * @return ControlConfigBuilder
		 */
		public function transportTypePostMessage() {
			return $this->transportType( ThemeCoreOptionsConfig::CONTROL_TRANSPORT_TYPE_POST_MESSAGE );
		}

		/**
		 * @return ControlConfigBuilder
		 */
		public function transportTypeRefresh() {
			return $this->transportType( ThemeCoreOptionsConfig::CONTROL_TRANSPORT_TYPE_REFRESH );
		}

		/**
		 * @param string $selector
		 * @param string $partial
		 * @param bool $containerInclusive
		 * @param callable $callback
		 *
		 * @return ControlConfigBuilder
		 */
		public function selectiveRefresh( $selector, $partial = '', $containerInclusive = false, $callback = null ) {
			if ( ! $partial && ! $callback ) {
				return $this;
			}

			$items   = $this->getItem( 'selective_refresh', array() );
			$data    = array();
			$items[] = &$data;


			if ( $selector ) {
				$data['selector'] = $selector;
			}

			if ( $partial ) {
				$data['partial'] = $partial;
			}

			if ( $callback ) {
				$data['callback'] = $callback;
			}

			$data['container_inclusive'] = $containerInclusive;

			$this->updateItem( 'selective_refresh', $items );

			return $this->transportTypePostMessage();
		}

		/**
		 * @param bool $allowed
		 *
		 * @return ControlConfigBuilder
		 */
		public function htmlAllowed( $allowed = false ) {
			return $this->updateItem( 'html_allowed', $allowed );
		}

		/**
		 * @param array $attributes
		 *
		 * @since 1.5.0
		 *
		 * @return $this
		 */
		public function additionalConfigAttributes( $attributes = array() ) {
			return $this->updateItem( 'additional_config_attributes', $attributes );
		}

		/**
		 * @inheritdoc
		 */
		public function title( $title ) {
			//For control it's not used, use label instead
			return $this;
		}

		/**
		 * @param string $value
		 *
		 * @return ControlConfigBuilder
		 */
		private function transportType( $value ) {
			return $this->updateItem( 'transport', $value );
		}
	}
}
