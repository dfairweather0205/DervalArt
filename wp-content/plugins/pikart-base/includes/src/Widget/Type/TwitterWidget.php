<?php

namespace Pikart\WpBase\Widget\Type;

use Pikart\WpBase\Common\AssetHandle;

if ( ! class_exists( __NAMESPACE__ . '\\TwitterWidget' ) ) {

	/**
	 * Class TwitterWidget
	 * @package Pikart\WpBase\Widget\Type
	 *
	 * @since 1.3.0
	 */
	class TwitterWidget extends GenericWidget {

		/**
		 * @inheritdoc
		 */
		public function widget( $args, $data ) {
			$twitterUser = $this->getOptionValue( 'twitter_user', $data );

			if ( ! $twitterUser ) {
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
				'title'         => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title:', 'pikart-base' ),
					'default' => esc_html__( 'Tweets', 'pikart-base' ),
					'class'   => 'widefat',
				),
				'twitter_user'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Twitter user:', 'pikart-base' ),
					'class' => 'widefat',
				),
				'tweets_number' => array(
					'type'       => 'number',
					'label'      => esc_html__( 'Number of tweets (max 20):', 'pikart-base' ),
					'default'    => 5,
					'class'      => 'tiny-text',
					'attributes' => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 20,
						'size' => 3
					)
				),
				'theme'         => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Theme:', 'pikart-base' ),
					'default' => 'light',
					'class'   => 'tiny-text',
					'options' => array(
						'light' => esc_html__( 'Light', 'pikart-base' ),
						'dark'  => esc_html__( 'Dark', 'pikart-base' ),
					)
				),
			);
		}

		/**
		 * @inheritdoc
		 */
		protected function getShortId() {
			return 'twitter';
		}

		/**
		 * @inheritdoc
		 */
		protected function getName() {
			return esc_html__( 'Pikart Twitter', 'pikart-base' );
		}

		/**
		 * @inheritdoc
		 */
		protected function getDescription() {
			return esc_html__( 'Your tweets.', 'pikart-base' );
		}

		/**
		 * @inheritdoc
		 */
		protected function getJsAssetHandles() {
			return array( AssetHandle::twitterWidgets() );
		}
	}
}