<?php

namespace Pikart\WpBase\Widget\Type;

use Pikart\WpBase\Widget\WidgetFormHelper;
use Pikart\WpCore\Common\DataSanitizer;
use Pikart\WpCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\\SocialLinksWidget' ) ) {

	/**
	 * Class SocialLinksWidget
	 * @package Pikart\WpBase\Widget\Type
	 *
	 * @since 1.1.0
	 */
	class SocialLinksWidget extends GenericWidget {

		const NETWORK_LINKS_FIELD = 'network_links';
		const SOCIAL_LINK_HTML_PATTERN =
			'<a href="%s" target="%s" style="font-size: %spx"><i class="fa fa-fw fa-%s"></i></a>';

		/**
		 * @var Util
		 */
		protected $util;

		/**
		 * SocialLinksWidget constructor.
		 *
		 * @param WidgetFormHelper $widgetFormHelper
		 * @param DataSanitizer $dataSanitizer
		 * @param Util $util
		 */
		public function __construct( WidgetFormHelper $widgetFormHelper, DataSanitizer $dataSanitizer, Util $util ) {
			parent::__construct( $widgetFormHelper, $dataSanitizer );
			$this->util = $util;
		}

		/**
		 * @inheritdoc
		 */
		public function widget( $args, $data ) {
			$data['hasEmail']        = ! empty( $data['mail'] );
			$data['hasNetworkLinks'] = ! empty( $data[ self::NETWORK_LINKS_FIELD ] )
			                           && is_array( $data[ self::NETWORK_LINKS_FIELD ] );

			if ( ! $data['hasEmail'] && ! $data['hasNetworkLinks'] ) {
				return;
			}

			$this->beforeWidgetAndTitle( $args, $data );

			$this->includeWidgetTemplate( $data );

			$this->afterWidget( $args );
		}

		/**
		 * @inheritdoc
		 */
		public function form( $data ) {
			parent::form( $data );

			if ( isset( $data[ self::NETWORK_LINKS_FIELD ] ) && is_array( $data[ self::NETWORK_LINKS_FIELD ] ) ) {
				$networks = array_filter( $data[ self::NETWORK_LINKS_FIELD ] );

				$config = array(
					'type' => 'text',
					'name' => $this->getNetworkLinksFieldName()
				);

				$button = $this->formHelper->generateInputField( array(
					'type'  => 'button',
					'title' => 'Remove',
					'class' => 'widget-social-link-delete'
				) );

				foreach ( $networks as $networkLink ) {
					$config['value'] = $networkLink;
					print ( $this->formHelper->generateParagraph(
						$this->formHelper->generateInputField( $config ) . $button ) );
				}
			}

			$config = array(
				'title'      => esc_html__( 'Add social link', 'pikart-base' ),
				'class'      => 'widget-social-link-add',
				'type'       => 'button',
				'attributes' => array(
					'data-network-links-field' => $this->getNetworkLinksFieldName()
				)
			);

			print( $this->formHelper->generateParagraph( $this->formHelper->generateInputField( $config ) ) );
		}

		/**
		 * @inheritdoc
		 */
		public function update( $updatedData, $data ) {
			$data = parent::update( $updatedData, $data );

			if ( empty( $updatedData[ self::NETWORK_LINKS_FIELD ] )
			     || ! is_array( $updatedData[ self::NETWORK_LINKS_FIELD ] ) ) {
				return $data;
			}

			$data[ self::NETWORK_LINKS_FIELD ] = array_map(
				array( $this->dataSanitizer, 'url' ), $updatedData[ self::NETWORK_LINKS_FIELD ] );

			return $data;
		}

		/**
		 * @inheritdoc
		 */
		protected function getOptionsConfig() {
			return array(
				'title'        => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Title:', 'pikart-base' ),
					'default' => esc_html__( 'Social links', 'pikart-base' ),
					'class'   => 'widefat',
				),
				'font_size'    => array(
					'type'       => 'number',
					'label'      => esc_html__( 'Font size (pixels):', 'pikart-base' ),
					'default'    => 16,
					'class'      => 'tiny-text',
					'attributes' => array(
						'step' => 1,
						'min'  => 1
					)
				),
				'links_target' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Target:', 'pikart-base' ),
					'default' => '_blank',
					'class'   => 'tiny-text',
					'options' => array(
						'_blank' => esc_html__( '_blank', 'pikart-base' ),
						'_self'  => esc_html__( '_self', 'pikart-base' ),
					)
				),
				'mail'         => array(
					'type'  => 'email',
					'label' => esc_html__( 'Email:', 'pikart-base' ),
					'class' => 'widefat',
				)
			);
		}


		/**
		 * @inheritdoc
		 */
		protected function getShortId() {
			return 'social-links';
		}

		/**
		 * @inheritdoc
		 */
		protected function getName() {
			return esc_html__( 'Pikart Social Links', 'pikart-base' );
		}

		/**
		 * @inheritdoc
		 */
		protected function getDescription() {
			return esc_html__( 'Your social links.', 'pikart-base' );
		}

		/**
		 * @return string
		 */
		protected function getNetworkLinksFieldName() {
			return $this->get_field_name( self::NETWORK_LINKS_FIELD . '[]' );
		}

		/**
		 * @param string $href
		 * @param string $target
		 * @param string $type
		 * @param int $fontSize
		 *
		 * @return string
		 */
		protected function generateSocialLink( $href, $target, $type, $fontSize ) {
			if ( empty( $href ) || empty( $type ) ) {
				return '';
			}

			return sprintf( self::SOCIAL_LINK_HTML_PATTERN,
				esc_url( $href ), esc_attr( $target ), esc_attr( $fontSize ), esc_attr( $type ) );
		}
	}
}