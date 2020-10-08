<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Post\PostUtil;
use Pikart\WpCore\Shortcode\ShortcodeConfig;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\ShortcodeFilterName;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;
use Pikart\WpCore\ThemeOptions\GoogleFontsHelper;
use Pikart\WpCore\ThemeOptions\ThemeOptionsFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\CustomContentShortcode' ) ) {

	/**
	 * Class CustomContentShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class CustomContentShortcode extends AbstractShortcode {

		/**
		 * @var GoogleFontsHelper
		 */
		private $googleFontsHelper;

		/**
		 * @var PostUtil
		 */
		private $postUtil;

		/**
		 * CustomContentShortcode constructor.
		 *
		 * @param GoogleFontsHelper $googleFontsHelper
		 * @param PostUtil $postUtil
		 */
		public function __construct( GoogleFontsHelper $googleFontsHelper, PostUtil $postUtil ) {
			parent::__construct();

			$this->googleFontsHelper = $googleFontsHelper;
			$this->postUtil          = $postUtil;

			$this->setupSavePostFilterForFontFamilyList();
			$this->setupRegisteredGoogleFontsFilter();
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
		public function enabled() {
			return true;
		}

		/**
		 * @inheritdoc
		 */
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$fonts = array_merge(
				array( '' => esc_html__( 'Default', 'pikart-base' ) ),
				$this->googleFontsHelper->getGoogleFonts()
			);

			$builder
				->listBox( 'font_family', esc_html__( 'Font family', 'pikart-base' ), array(
					'options' => $fonts
				) )
				->listBox( 'font_size', esc_html__( 'Font size', 'pikart-base' ), array(
					'default' => 'inherit',
					'options' => array(
						'inherit' => 'inherit',
						'10'      => '10px',
						'14'      => '14px',
						'16'      => '16px',
						'18'      => '18px',
						'21'      => '21px',
						'28'      => '28px',
						'36'      => '36px',
						'48'      => '48px',
						'55'      => '55px',
						'63'      => '63px',
						'72'      => '72px',
						'84'      => '84px',
						'96'      => '96px',
						'120'     => '120px',
					)
				) )
				->listBox( 'font_weight', esc_html__( 'Font weight', 'pikart-base' ), array(
					'default' => '400',
					'options' => array(
						'100' => '100 Thin',
						'200' => '200 Extra Light',
						'300' => '300 Light',
						'400' => '400 Normal',
						'500' => '500 Medium',
						'600' => '600 Semi Bold',
						'700' => '700 Bold',
						'800' => '800 Extra Bold',
						'900' => '900 Black',
					)
				) )
				->number( 'letter_spacing', esc_html__( 'Letter spacing', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'pixels', 'pikart-base' ),
					'default' => 0,
					'step'    => 0.1,
					'min'     => - 5,
					'max'     => 5,
				) )
				->number( 'line_height', esc_html__( 'Line height', 'pikart-base' ), array(
					'default' => 1.68,
					'step'    => 0.01,
					'min'     => 0,
					'max'     => 10
				) )
				->listBox( 'text_decoration', esc_html__( 'Text decoration', 'pikart-base' ), array(
					'default' => 'none',
					'options' => array(
						'none'         => 'None',
						'underline'    => 'Underline',
						'overline'     => 'Overline',
						'line-through' => 'Line through'
					),
				) )
				->customColorPicker( 'text_color', esc_html__( 'Text color', 'pikart-base' ) )
				->textBox( 'paddings', esc_html__( 'Paddings', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'Top Right Bottom Left (pixels)', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->textBox( 'margins', esc_html__( 'Margins', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'Top Right Bottom Left (pixels)', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->textBox( 'borders_width', esc_html__( 'Borders', 'pikart-base' ), array(
					'tooltip'     => esc_html__( 'Top Right Bottom Left (pixels)', 'pikart-base' ),
					'placeholder' => esc_html__( '0px 0px 0px 0px', 'pikart-base' ),
				) )
				->customColorPicker( 'borders_color', esc_html__( 'Borders color', 'pikart-base' ) )
				->customColorPicker( 'background_color', esc_html__( 'Background color', 'pikart-base' ), array(
					'placeholder' => 'Enter color code'
				) )
				->checkBox( 'enable_position', esc_html__( 'Position', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'Position Custom-content to appear above other elements', 'pikart-base' ),
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
				->textArea( 'content', '', array(
					'is_content'  => true,
					'placeholder' => esc_html__( 'Content', 'pikart-base' )
				) );
		}

		private function setupSavePostFilterForFontFamilyList() {
			$extractFontFamilyListCallback = $this->extractFontFamilyListCallback();
			$postUtil                      = $this->postUtil;

			add_action( 'save_post', function ( $postId, $post ) use (
				$extractFontFamilyListCallback, $postUtil
			) {
				if ( ! $postId || ! is_object( $post ) ) {
					return;
				}

				$fields = apply_filters(
					ShortcodeFilterName::postFieldsWithShortcodes( $post->post_type ), array( 'post_content' ), $post );

				$fontFamilyList = array();

				foreach ( $fields as $field ) {
					$fontFamilyList = array_merge( $fontFamilyList, $extractFontFamilyListCallback( $post->$field ) );
				}

				$fontFamilyList = array_unique( array_filter( $fontFamilyList ) );
				$postUtil->saveOption( $postId, ShortcodeConfig::FONT_FAMILY_LIST_POST_OPTION, $fontFamilyList );

			}, 10, 2 );
		}

		/**
		 * @return \Closure
		 */
		private function extractFontFamilyListCallback() {
			$self = $this;

			return function ( $content ) use ( $self ) {
				if ( empty( $content ) || ! has_shortcode( $content, $self->getName() ) ) {
					return array();
				}

				$pattern = get_shortcode_regex( array( $self->getName() ) );

				if ( ! preg_match_all( sprintf( '/%s/', $pattern ), $content, $matches ) ) {
					return array();
				}

				$fontFamilyList = array_map( function ( $text ) {
					$attributes = shortcode_parse_atts( $text );

					return empty( $attributes['font_family'] ) ? '' : trim( $attributes['font_family'] );


				}, $matches[3] );

				return array_unique( array_filter( $fontFamilyList ) );
			};
		}

		private function setupRegisteredGoogleFontsFilter() {
			$postUtil = $this->postUtil;

			add_filter( ThemeOptionsFilterName::registeredGoogleFonts(), function ( $fonts ) use ( $postUtil ) {

				if ( is_singular() ) {
					$postFonts = $postUtil->getOption( get_the_ID(), ShortcodeConfig::FONT_FAMILY_LIST_POST_OPTION );

					if ( ! empty( $postFonts ) && is_array( $postFonts ) ) {
						$fonts = array_merge( $fonts, $postFonts );
					}
				}

				return $fonts;
			} );
		}
	}
}