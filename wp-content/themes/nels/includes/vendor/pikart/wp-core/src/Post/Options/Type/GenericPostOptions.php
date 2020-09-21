<?php

namespace Pikart\WpThemeCore\Post\Options\Type;

use Pikart\WpThemeCore\Post\PostFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\GenericPostOptions' ) ) {

	/**
	 * Class GenericPostOptions
	 * @package Pikart\WpThemeCore\Post\Options
	 */
	class GenericPostOptions {

		/**
		 * @var array
		 */
		private $options = array();

		/**
		 * @var int
		 */
		private $postId;

		/**
		 * GenericPostOptions constructor.
		 *
		 * @param int $postId
		 * @param array $options
		 */
		public function __construct( $postId, $options = array() ) {
			$this->postId = $postId;
			$this->setOptions( $options );

			return $this;
		}

		/**
		 * @return int
		 */
		public function getPostId() {
			return $this->postId;
		}

		/**
		 * @return array
		 */
		public function getOptions() {
			return $this->options;
		}

		/**
		 * @param string $option
		 *
		 * @return mixed
		 */
		public function getOption( $option ) {
			if ( ! isset( $this->options[ $option ] ) ) {
				$this->options[ $option ] = apply_filters( PostFilterName::postOptionDefaultValue( $option ), '' );
			}

			return $this->options[ $option ];
		}

		/**
		 * @param string $name
		 * @param mixed $value
		 */
		public function setOption( $name, $value ) {
			$this->options[ $name ] = $value;
		}

		/**
		 * @param array $options
		 */
		public function setOptions( array $options ) {
			$this->options = $options;
		}

		/**
		 * @param string $option
		 * @param string $separator
		 *
		 * @return array
		 */
		public function getArrayOption( $option, $separator = ',' ) {
			if ( ! isset( $this->options[ $option ] ) ) {
				$this->options[ $option ] = apply_filters( PostFilterName::postOptionDefaultValue( $option ), array() );
			}

			if ( is_array( $this->options[ $option ] ) ) {
				return $this->options[ $option ];
			}

			$option = (string) $this->options[ $option ];

			$this->options[ $option ] = $option === '' ? array() : explode( $separator, $option );

			return $this->options[ $option ];
		}

		/**
		 * @param string $option
		 *
		 * @return bool
		 */
		public function getBoolOption( $option ) {
			return (bool) $this->getOption( $option );
		}

		/**
		 * @param string $option
		 *
		 * @return int
		 */
		public function getIntOption( $option ) {
			return (int) $this->getOption( $option );
		}

		/**
		 * @param string $optionId
		 * @param string $value
		 *
		 * @since 1.8.0
		 *
		 * @return bool
		 */
		public function multiValueOptionHasValue( $option, $value ) {
			$values = $this->getArrayOption( $option );

			return ! empty( $values ) && in_array( $value, $values, true );
		}

		/**
		 * @param $date
		 *
		 * @return string
		 */
		protected function formatDate( $date ) {
			return empty( $date ) ? '' : mysql2date( get_option( 'date_format' ), $date );
		}
	}

}