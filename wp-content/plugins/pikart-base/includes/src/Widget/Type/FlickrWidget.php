<?php

namespace Pikart\WpBase\Widget\Type;

if ( ! class_exists( __NAMESPACE__ . '\\FlickrWidget' ) ) {

	/**
	 * Class FlickrWidget
	 * @package Pikart\WpBase\Widget\Type
	 *
	 * @since 1.3.0
	 */
	class FlickrWidget extends GenericWidget {

		/**
		 * @inheritdoc
		 */
		public function widget( $args, $data ) {
			$flickrId = $this->getOptionValue( 'flickr_id', $data );
			$apiKey   = $this->getOptionValue( 'api_key', $data );

			if ( ! $flickrId || ! $apiKey ) {
				return;
			}

			$this->beforeWidgetAndTitle( $args, $data );

			$this->includeWidgetTemplate( $data );

			$this->afterWidget( $args );
		}

		/**
		 * @since 1.3.0 photos_dimensions
		 *
		 * @inheritdoc
		 */
		protected function getOptionsConfig() {
			return array(
				'title'          => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title:', 'pikart-base' ),
					'default' => esc_html__( 'Flickr', 'pikart-base' ),
					'class'   => 'widefat',
				),
				'flickr_id'      => array(
					'type'  => 'text',
					'label' => esc_html__( 'Flickr ID:', 'pikart-base' )
					           . sprintf( ' <a href="https://idgettr.com/" target="_blank">%s</a>',
							esc_html__( 'Gey your Flickr ID', 'pikart-base' ) ),
					'class' => 'widefat',
				),
				'api_key'        => array(
					'type'  => 'text',
					'label' => esc_html__( 'Flickr Api Key:', 'pikart-base' )
					           . sprintf( ' <a href="https://www.flickr.com/services/api/misc.api_keys.html" target="_blank">%s</a>',
							esc_html__( 'Gey the Api Key', 'pikart-base' ) ),
					'class' => 'widefat',
				),
				'photos_number'  => array(
					'type'       => 'number',
					'label'      => esc_html__( 'Number of photos:', 'pikart-base' ),
					'default'    => 6,
					'class'      => 'tiny-text',
					'attributes' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 500,
						'size' => 3
					)
				),
				'photos_type'    => array(
					'type'    => 'select',
					'label'   => esc_html__( 'The type of photos from user or group.', 'pikart-base' ),
					'default' => 'user',
					'class'   => 'tiny-text',
					'options' => array(
						'user'  => esc_html__( 'user', 'pikart-base' ),
						'group' => esc_html__( 'group', 'pikart-base' ),
					)
				),
				'photos_size'    => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Photo Size', 'pikart-base' ),
					'default' => 's',
					'options' => array(
						's' => esc_html__( 'Small square', 'pikart-base' ),
						'q' => esc_html__( 'Large square', 'pikart-base' ),
						't' => esc_html__( 'Thumbnail', 'pikart-base' ),
						'n' => esc_html__( 'Small', 'pikart-base' ),
						'z' => esc_html__( 'Medium', 'pikart-base' ),
					)
				),
				'photos_columns' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Columns', 'pikart-base' ),
					'default' => 3,
					'options' => array(
						1 => 1,
						2 => 2,
						3 => 3,
						4 => 4,
						5 => 5,
						6 => 6,
					)
				),
				'photos_spacing' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Columns spacing', 'pikart-base' ),
					'default' => 'none',
					'options' => array(
						'none'   => esc_html__( 'None', 'pikart-base' ),
						'small'  => esc_html__( 'Small', 'pikart-base' ),
						'medium' => esc_html__( 'Medium', 'pikart-base' ),
						'large'  => esc_html__( 'Large', 'pikart-base' ),
					)
				),
			);
		}

		/**
		 * @inheritdoc
		 */
		protected function getShortId() {
			return 'flickr';
		}

		/**
		 * @inheritdoc
		 */
		protected function getName() {
			return esc_html__( 'Pikart Flickr', 'pikart-base' );
		}

		/**
		 * @inheritdoc
		 */
		protected function getDescription() {
			return esc_html__( 'Your Flickr photos.', 'pikart-base' );
		}
	}
}