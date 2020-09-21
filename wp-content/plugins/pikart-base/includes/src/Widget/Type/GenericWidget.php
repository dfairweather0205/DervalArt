<?php

namespace Pikart\WpBase\Widget\Type;

use Pikart\WpBase\Common\PluginPathsUtil;
use Pikart\WpBase\Widget\WidgetFormHelper;
use Pikart\WpCore\Common\DataSanitizer;
use WP_Widget;

if ( ! class_exists( __NAMESPACE__ . '\\GenericWidget' ) ) {

	/**
	 * Class GenericWidget
	 * @package Pikart\WpBase\Widget\Type
	 *
	 * @since 1.1.0
	 */
	abstract class GenericWidget extends WP_Widget {

		/**
		 * @since 1.6.2
		 */
		const DEFAULT_TEMPLATE_PATTERN = '%s/widgets/pikart/%s.php';

		/**
		 * @since 1.6.2
		 */
		const CUSTOM_TEMPLATE_PATTERN = 'templates/widgets/pikart/%s.php';

		/**
		 * @var WidgetFormHelper
		 */
		protected $formHelper;

		/**
		 * @var DataSanitizer
		 */
		protected $dataSanitizer;

		/**
		 * GenericWidget constructor.
		 *
		 * @param WidgetFormHelper $widgetFormHelper
		 * @param DataSanitizer $dataSanitizer
		 */
		public function __construct( WidgetFormHelper $widgetFormHelper, DataSanitizer $dataSanitizer ) {
			parent::__construct(
				$this->getId(), $this->getName(), $this->getWidgetOptions(), $this->getControlOptions() );

			$this->formHelper    = $widgetFormHelper;
			$this->dataSanitizer = $dataSanitizer;

			$this->enqueueAssets();
		}

		/**
		 * @return string
		 */
		public function getId() {
			return sprintf( '%s-%s', PIKART_SLUG, $this->getShortId() );
		}

		/**
		 * @param array $data
		 *
		 * @since 1.6.2
		 */
		protected function includeWidgetTemplate( $data ) {
			$template = locate_template( sprintf( static::CUSTOM_TEMPLATE_PATTERN, $this->getShortId() ), false );

			if ( ! $template ) {
				$template = sprintf(
					static::DEFAULT_TEMPLATE_PATTERN,
					PluginPathsUtil::getTemplatesDir(),
					$this->getShortId()
				);
			}

			include $template;
		}

		/**
		 * @inheritdoc
		 */
		public function form( $data ) {
			foreach ( $this->getOptionsConfig() as $optionId => $config ) {
				$config['id']    = $this->get_field_id( $optionId );
				$config['name']  = $this->get_field_name( $optionId );
				$config['value'] = isset( $data[ $optionId ] )
					? $data[ $optionId ] : ( isset( $config['default'] ) ? $config['default'] : '' );

				print ( $this->formHelper->generateOption(
					$config['id'], $config['label'], $this->formHelper->generateInputField( $config ) ) );
			}
		}

		/**
		 * @inheritdoc
		 */
		public function update( $updatedData, $data ) {
			foreach ( $this->getOptionsConfig() as $optionId => $config ) {
				$data[ $optionId ] = $this->dataSanitizer->sanitize( $updatedData[ $optionId ], $config['type'] );
			}

			return $data;
		}

		/**
		 * @param array $options
		 *
		 * @return string
		 */
		protected function getWidgetTitle( $options ) {
			return apply_filters(
				'widget_title', $this->getOptionValue( 'title', $options ), $options, $this->id_base );
		}

		/**
		 *
		 * @return array
		 */
		protected function getWidgetOptions() {
			return array(
				'classname'   => $this->getWidgetContainerClassName(),
				'description' => $this->getDescription(),
			);
		}

		/**
		 * @return string
		 */
		protected function getWidgetContainerClassName() {
			return sprintf( 'widget_%s', str_replace( '-', '_', $this->getId() ) );
		}

		/**
		 * override if required
		 *
		 * @return array
		 */
		protected function getOptionsConfig() {
			return array();
		}

		/**
		 * override if required
		 *
		 * @return array
		 */
		protected function getControlOptions() {
			return array();
		}

		/**
		 * override if required
		 *
		 * @return string
		 */
		protected function getDescription() {
			return '';
		}

		/**
		 * @param string $id
		 * @param array $data
		 * @param string $default
		 *
		 * @return string
		 */
		protected function getOptionValue( $id, $data, $default = '' ) {
			$config = $this->getOptionsConfig();

			return isset( $data[ $id ] )
				? $data[ $id ] : ( isset( $config[ $id ]['default'] ) ? $config[ $id ]['default'] : $default );
		}

		/**
		 * @param array $args
		 * @param array $data
		 *
		 * @since 1.3.0
		 */
		protected function beforeWidgetAndTitle( $args, $data ) {
			$title = $this->getWidgetTitle( $data );

			echo wp_kses_post( $args['before_widget'] );

			if ( $title ) {
				echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
			}
		}

		/**
		 * @param array $args
		 *
		 * @since 1.3.0
		 */
		protected function afterWidget( $args ) {
			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * @return array
		 * @since 1.3.0
		 *
		 */
		protected function getCssAssetHandles() {
			return array();
		}

		/**
		 * @return array
		 * @since 1.3.0
		 *
		 */
		protected function getJsAssetHandles() {
			return array();
		}

		/**
		 * @return string
		 */
		abstract protected function getShortId();

		/**
		 * @return string
		 */
		abstract protected function getName();

		/**
		 * @since 1.3.0
		 */
		private function enqueueAssets() {
			if ( ! is_active_widget( false, false, $this->getId() ) ) {
				return;
			}

			$cssAssetHandles = $this->getCssAssetHandles();
			$jsAssetHandles  = $this->getJsAssetHandles();

			add_action( 'wp_enqueue_scripts', function () use ( $cssAssetHandles, $jsAssetHandles ) {
				foreach ( $cssAssetHandles as $assetHandle ) {
					wp_enqueue_style( $assetHandle );
				}

				foreach ( $jsAssetHandles as $assetHandle ) {
					wp_enqueue_script( $assetHandle );
				}
			} );
		}
	}
}