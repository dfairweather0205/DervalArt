<?php

namespace Pikart\WpBase\Widget\Type;

if ( ! class_exists( __NAMESPACE__ . '\\InstagramWidget' ) ) {

	/**
	 * Class InstagramWidget
	 * @package Pikart\WpBase\Widget\Type
	 *
	 * @since 1.3.0
	 */
	class InstagramWidget extends GenericWidget {

		/**
		 * @inheritdoc
		 */
		public function widget( $args, $data ) {
			$userIdHashTag         = $this->getOptionValue( 'user_id_hash_tag', $data );
			$data['isHashTag']     = strpos( $userIdHashTag, '#' ) === 0;
			$data['userIdHashTag'] = str_replace( array( '#', '@' ), '', $userIdHashTag );

			if ( ! $data['userIdHashTag'] ) {
				return;
			}

			$this->beforeWidgetAndTitle( $args, $data );

			$this->includeWidgetTemplate( $data );

			$this->afterWidget( $args );
		}

		/**
		 * @inheritdoc
		 */
		protected function getOptionsConfig() {
			return array(
				'title'            => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title:', 'pikart-base' ),
					'default' => esc_html__( 'Instagram', 'pikart-base' ),
					'class'   => 'widefat',
				),
				'user_id_hash_tag' => array(
					'type'  => 'text',
					'label' => esc_html__( '@Username or #Hashtag:', 'pikart-base' ),
					'class' => 'widefat',
				),
				'photos_number'    => array(
					'type'       => 'number',
					'label'      => esc_html__( 'Number of photos:', 'pikart-base' ),
					'default'    => 6,
					'class'      => 'tiny-text',
					'attributes' => array(
						'step' => 1,
						'min'  => 1,
						'size' => 3
					)
				),
				'photos_columns'   => array(
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
				'photos_spacing'   => array(
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
			return 'instagram';
		}

		/**
		 * @inheritdoc
		 */
		protected function getName() {
			return esc_html__( 'Pikart Instagram', 'pikart-base' );
		}

		/**
		 * @inheritdoc
		 */
		protected function getDescription() {
			return esc_html__( 'Your Instagram photos.', 'pikart-base' );
		}
	}
}