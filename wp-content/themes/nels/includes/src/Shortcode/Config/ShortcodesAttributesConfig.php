<?php

namespace Pikart\Nels\Shortcode\Config;

use Pikart\Nels\ThemeOptions\Config\ThemeOptionsConfigHelper;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Shortcode\ShortcodeActionName;
use Pikart\WpThemeCore\Shortcode\ShortcodeFieldConfigBuilder;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodesAttributesConfig' ) ) {

	/**
	 * Class ShortcodesAttributesConfig
	 * @package Pikart\Nels\Shortcode\Config
	 */
	class ShortcodesAttributesConfig {

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * ShortcodesAttributesConfig constructor.
		 *
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 */
		public function __construct( ThemeOptionsUtil $themeOptionsUtil ) {
			$this->themeOptionsUtil = $themeOptionsUtil;
		}

		public function configure() {
			$this->configureCustomPostTypeShortcodeAttributes( 'album' );
			$this->configureCustomPostTypeShortcodeAttributes( 'projects' );
			$this->configureCustomPostTypeShortcodeAttributes( 'products' );
			$this->configureSeparatorShortcodeAttributes();
			$this->configureCustomContentShortcodeAttributes();
		}

		private function configureCustomPostTypeShortcodeAttributes( $postType ) {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_action( ShortcodeActionName::attributesConfigBuild( $postType ),
				function ( $builder ) use ( $themeOptionsUtil ) {
					/* @var ShortcodeFieldConfigBuilder $builder */
					$builder
						->label( esc_html__( 'Typologies Display', 'nels' ), array(
							'classes' => 'pikode-inner-title'
						) )
						->listBox( 'type', esc_html__( 'Type', 'nels' ), array(
							'default' => 'masonry',
							'options' => array(
								'masonry'  => 'Masonry',
								'carousel' => 'Carousel'
							)
						) )
						->listBox( 'masonry_display', esc_html__( 'Display', 'nels' ), array(
							'default' => 'default',
							'tooltip' => esc_html__( 'The way items are displayed', 'nels' ),
							'options' => ThemeOptionsConfigHelper::getDisplayTypes()
						) )
						->listBox( 'masonry_nb_columns', esc_html__( 'Columns', 'nels' ), array(
							'default' => '3',
							'tooltip' => esc_html__( 'Columns of items to display', 'nels' ),
							'options' => ThemeOptionsConfigHelper::getItemColumnsNumber()
						) )
						->number( 'masonry_columns_spacing', esc_html__( 'Columns spacing', 'nels' ), array(
							'default' => 36,
							'min'     => 0,
							'tooltip' => esc_html__( 'Spacing between columns (pixels)', 'nels' ),
						) )
						->listBox( 'categories_filter_position', esc_html__( 'Filter position', 'nels' ), array(
							'default' => 'left',
							'options' => array(
								'left'   => esc_html__( 'Left', 'nels' ),
								'center' => esc_html__( 'Center', 'nels' ),
								'right'  => esc_html__( 'Right', 'nels' ),
							)
						) )
						->listBox( 'animation_effect', esc_html__( 'Animation effect', 'nels' ), array(
							'default' => 'progressive',
							'options' => array(
								'per_unit'  => esc_html__( 'Per unit', 'nels' ),
								'per_whole' => esc_html__( 'Per whole', 'nels' ),
							)
						) )
						->number( 'animation_progress_delay', esc_html__( 'Progress delay', 'nels' ), array(
							'tooltip' => esc_html__( 'seconds', 'nels' ),
							'min'     => 0,
							'max'     => 1,
							'default' => 0.1,
							'step'    => 0.1
						) )
						->checkBox( 'carousel_autoplay', esc_html__( 'Autoplay', 'nels' ), array(
							'default' => false
						) )
						->number( 'carousel_autoplay_speed', esc_html__( 'Autoplay speed', 'nels' ), array(
							'tooltip' => esc_html__( 'seconds', 'nels' ),
							'min'     => 0,
							'max'     => 10,
							'default' => 3,
							'step'    => 0.1
						) )
						->label( esc_html__( 'Additional Options', 'nels' ), array(
							'classes' => 'pikode-inner-subtitle'
						) )
						->customColorPicker( 'overlay_color', esc_html__( 'Overlay color', 'nels' ), array(
							'default' => $themeOptionsUtil->getOption( ThemeOption::FEATURE_COLOR )
						) )
						->number( 'overlay_color_transparency', esc_html__( 'Overlay transparency', 'nels' ),
							array(
								'tooltip' => esc_html__( 'percents (%)', 'nels' ),
								'default' => 50,
								'min'     => 0,
								'max'     => 100
							) )
						->listBox( 'text_color_skin', esc_html__( 'Text color skin', 'nels' ), array(
							'default' => 'light',
							'options' => array(
								'light' => esc_html__( 'Light', 'nels' ),
								'dark'  => esc_html__( 'Dark', 'nels' ),
							)
						) )
						->listBox( 'animation', esc_html__( 'Animation', 'nels' ), array(
							'default' => 'none',
							'options' => array(
								'none'          => esc_html__( 'None', 'nels' ),
								'fadeIn'        => esc_html__( 'Fade', 'nels' ),
								'fadeFromUp'    => esc_html__( 'Fade From Up', 'nels' ),
								'fadeFromRight' => esc_html__( 'Fade From Right', 'nels' ),
								'fadeFromDown'  => esc_html__( 'Fade From Down', 'nels' ),
								'fadeFromLeft'  => esc_html__( 'Fade From Left', 'nels' ),
								'zoomIn'        => esc_html__( 'Zoom', 'nels' ),
							)
						) )
						->number( 'animation_delay', esc_html__( 'Animation delay', 'nels' ), array(
							'tooltip' => esc_html__( 'seconds', 'nels' ),
							'min'     => 0,
							'max'     => 3,
							'default' => 0.3,
							'step'    => 0.1
						) )
						->moveField( 'categories_display', 'after', 'masonry_columns_spacing' );
				} );
		}

		private function configureSeparatorShortcodeAttributes() {
			add_action( ShortcodeActionName::attributesConfigBuild( 'separator' ),
				function (  $builder ) {
					/* @var ShortcodeFieldConfigBuilder $builder */
					$builder->removeField( 'type' );
				}
			);
		}

		private function configureCustomContentShortcodeAttributes() {
			add_action( ShortcodeActionName::attributesConfigBuild( 'custom_content' ),
				function ( $builder ) {
					/* @var ShortcodeFieldConfigBuilder $builder */
					$builder
						->removeField( 'font_size' )
						->listBox( 'font_size', esc_html__( 'Font size', 'nels' ), array(
							'default' => 'inherit',
							'options' => array(
								'inherit' => 'inherit',
								'10'      => '10px',
								'14'      => '14px',
								'16'      => '16px',
								'18'      => '18px',
								'24'      => '24px',
								'32'      => '32px',
								'42'      => '42px',
								'56'      => '56px',
								'76'      => '76px',
								'100'     => '100px',
								'134'     => '134px',
								'180'     => '180px',
								'240'     => '240px',
							)
						) )
						->moveField( 'font_size', 'after', 'font_family' );
				}
			);
		}
	}
}