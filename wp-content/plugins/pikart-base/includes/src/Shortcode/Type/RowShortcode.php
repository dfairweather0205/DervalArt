<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Common\Util;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\RowShortcode' ) ) {
	/**
	 * Class RowShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class RowShortcode extends AbstractShortcode {

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * RowShortcode constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
			parent::__construct();
		}

		/**
		 * @inheritdoc
		 */
		public function isSelfClosing() {
			return false;
		}

		/**
		 * @inheritdoc
		 */
		public function isFinal() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		public function processTemplateData( array &$data ) {
			$data['background_color_opacity'] = $this->util->transparencyToOpacity(
				$data['background_color_transparency'] );

			if ( $data['background_color_opacity'] === 0 ) {
				$data['background_color_opacity'] = '0.0';
			}
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$builder
				->label( esc_html__( 'General Properties', 'pikart-base' ), array(
					'classes' => 'pikode-inner-title',
				) )
				->textBox( 'anchor_id', esc_html__( 'Anchor ID', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'Enter here the anchor ID you introduce in a previous link', 'pikart-base' ),
				) )
				->textBox( 'padding', esc_html__( 'Paddings', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'Top Right Bottom Left (pixels)', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->textBox( 'margin', esc_html__( 'Margins', 'pikart-base' ), array(
					'tooltip'     => esc_html__(
						'Top Right Bottom Left (pixels). You could also use negative values', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->textBox( 'borders_width', esc_html__( 'Borders', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'Top Right Bottom Left (pixels)', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->customColorPicker( 'borders_color', esc_html__( 'Borders color', 'pikart-base' ) )
				->checkBox( 'enable_position', esc_html__( 'Position', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'Position Row to appear above other elements', 'pikart-base' ),
					'default' => false,
				) )
				->number( 'z_index', esc_html__( '_z-index', 'pikart-base' ), array(
					'default' => 1,
					'step'    => 1
				) )
				->number( 'position_top', esc_html__( '_top', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'pixels', 'pikart-base' ),
					'placeholder' => 0,
				) )
				->number( 'position_right', esc_html__( '_right', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'pixels', 'pikart-base' ),
					'placeholder' => 0,
				) )
				->number( 'position_bottom', esc_html__( '_bottom', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'pixels', 'pikart-base' ),
					'placeholder' => 0,
				) )
				->number( 'position_left', esc_html__( '_left', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'pixels', 'pikart-base' ),
					'placeholder' => 0,
				) )
				->cssClass()
				->label( esc_html__( 'Background Properties', 'pikart-base' ), array(
					'classes' => 'pikode-inner-title',
				) )
				->wpGallery( 'background_image', esc_html__( 'Image', 'pikart-base' ) )
				->customColorPicker( 'background_color', esc_html__( 'Color', 'pikart-base' ), array(
					'placeholder' => 'Enter color code'
				) )
				->number( 'background_color_transparency', esc_html__( 'Color transparency', 'pikart-base' ),
					array(
						'tooltip' => esc_html__( 'percents (%)', 'pikart-base' ),
						'min'     => 0,
						'max'     => 100,
						'default' => 50,
					)
				)
				->listBox( 'height', esc_html__( 'Height', 'pikart-base' ), array(
					'default' => 'auto',
					'options' => array(
						'auto'         => esc_html__( 'Auto', 'pikart-base' ),
						'fixed_values' => esc_html__( 'Fixed values', 'pikart-base' ),
						'custom'       => esc_html__( 'Custom', 'pikart-base' ),
					)
				) )
				->number( 'height_custom', esc_html__( '_pixels', 'pikart-base' ), array(
					'min'     => 0,
					'default' => 450,
				) )
				->listBox( 'height_fixed_values', esc_html__( '_ratio', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'Set the height as percentage from browser window height', 'pikart-base' ),
					'default' => 'full_height',
					'options' => array(
						'one_third'   => esc_html__( 'One third', 'pikart-base' ),
						'half'        => esc_html__( 'Half', 'pikart-base' ),
						'two_thirds'  => esc_html__( 'Two thirds', 'pikart-base' ),
						'full_height' => esc_html__( 'Full-height', 'pikart-base' ),
					)
				) )
				->checkBox( 'parallax', esc_html__( 'Parallax effect', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'It works just when the Image is set up', 'pikart-base' ),
					'default' => false
				) )
				->label( esc_html__( 'Content Properties', 'pikart-base' ), array(
					'classes' => 'pikode-inner-title',
				) )
				->listBox( 'width', esc_html__( 'Width', 'pikart-base' ), array(
					'default' => 'auto',
					'options' => array(
						'auto'   => esc_html__( 'Auto', 'pikart-base' ),
						'custom' => esc_html__( 'Custom', 'pikart-base' ),
					)
				) )
				->number( 'width_custom', esc_html__( '_pixels', 'pikart-base' ), array(
					'min'     => 0,
					'default' => 0,
				) )
				->listBox( 'horizontal_position', esc_html__( 'Horizontal position', 'pikart-base' ), array(
					'default' => 'center',
					'options' => array(
						'left'   => esc_html__( 'Left', 'pikart-base' ),
						'center' => esc_html__( 'Center', 'pikart-base' ),
						'right'  => esc_html__( 'Right', 'pikart-base' ),
					)
				) )
				->listBox( 'vertical_position', esc_html__( 'Vertical position', 'pikart-base' ), array(
					'default' => 'middle',
					'options' => array(
						'top'    => esc_html__( 'Top', 'pikart-base' ),
						'middle' => esc_html__( 'Middle', 'pikart-base' ),
						'bottom' => esc_html__( 'Bottom', 'pikart-base' ),
					)
				) )
				->listBox( 'color_skin', esc_html__( 'Color skin', 'pikart-base' ), array(
					'default' => 'none',
					'options' => array(
						'none'  => esc_html__( 'None', 'pikart-base' ),
						'light' => esc_html__( 'Light', 'pikart-base' ),
						'dark'  => esc_html__( 'Dark', 'pikart-base' ),
					)
				) )
				->listBox( 'animation', esc_html__( 'Animation', 'pikart-base' ), array(
					'default' => 'none',
					'options' => array(
						'none'   => esc_html__( 'None', 'pikart-base' ),
						'fadeIn' => esc_html__( 'Fade', 'pikart-base' ),
						'zoomIn' => esc_html__( 'Zoom', 'pikart-base' ),
					)
				) )
				->number( 'animation_delay', esc_html__( 'Animation delay', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'seconds', 'pikart-base' ),
					'min'     => 0,
					'max'     => 3,
					'default' => 0.3,
					'step'    => 0.1
				) )
				->textBox( 'padding_content', esc_html__( 'Paddings', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'Top Right Bottom Left (pixels)', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->textBox( 'margin_content', esc_html__( 'Margins', 'pikart-base' ), array(
					'tooltip'     => esc_html__(
						'Top Right Bottom Left (pixels). You could also use negative values', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->textBox( 'borders_width_content', esc_html__( 'Borders', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'Top Right Bottom Left (pixels)', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->customColorPicker( 'borders_color_content', esc_html__( 'Borders color', 'pikart-base' ) )
				->textArea( 'content', '', array(
					'is_content' => true,
					'default'    => esc_html__( 'Content goes here', 'pikart-base' )
				) );
		}

	}
}