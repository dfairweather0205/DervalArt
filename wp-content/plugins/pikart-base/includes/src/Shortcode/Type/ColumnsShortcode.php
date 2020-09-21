<?php

namespace Pikart\WpBase\Shortcode\Type;

use Pikart\WpCore\Shortcode\ShortcodeConfig;
use Pikart\WpCore\Shortcode\ShortcodeFieldConfigBuilder;
use Pikart\WpCore\Shortcode\Type\AbstractShortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ColumnsShortcode' ) ) {
	/**
	 * Class ColumnsShortcode
	 * @package Pikart\WpBase\Shortcode\Type
	 */
	class ColumnsShortcode extends AbstractShortcode {

		const NB_COLUMNS_DEFAULT = 2;
		const NB_COLUMNS_MAX = 12;
		const COLUMN_SHORTCODE_KEY = 'column';

		/**
		 * @var int[]
		 */
		private $columnsSliderValues = array();

		/**
		 * Columns_Shortcode constructor.
		 *
		 * @param ColumnShortcode $shortcode
		 */
		public function __construct( ColumnShortcode $shortcode ) {
			parent::__construct();

			$this->addChildShortcode( $shortcode, self::COLUMN_SHORTCODE_KEY );

			for ( $i = 1; $i < self::NB_COLUMNS_DEFAULT; $i ++ ) {
				$this->columnsSliderValues[] = self::NB_COLUMNS_MAX * $i / self::NB_COLUMNS_DEFAULT;
			}
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
		protected function buildDefaultAttributesConfig( ShortcodeFieldConfigBuilder $builder ) {
			$columnShortcode = $this->getChildShortcode( self::COLUMN_SHORTCODE_KEY );

			$builder
				->listBox( 'number', esc_html__( 'Number', 'pikart-base' ), array(
					'default' => (string) self::NB_COLUMNS_DEFAULT,
					'options' => array(
						'2'  => '2',
						'3'  => '3',
						'4'  => '4',
						'6'  => '6',
						'12' => '12',
					),
				) )
				->container( 'columns_slider', esc_html__( 'Size', 'pikart-base' ), array(
					'id'        => ShortcodeConfig::NAME_PREFIX . 'columns_slider_container',
					'shortcode' => $this->getJsShortcodeConfig( $columnShortcode ),
					'items'     => $this->getColumnsSliderItems(),
				) )
				->number( 'spacing', esc_html__( 'Spacing', 'pikart-base' ), array(
					'tooltip' => esc_html__( 'pixels', 'pikart-base' ),
					'default' => '36',
				) )
				->cssClass();
		}

		/**
		 * @return array
		 */
		private function getColumnsSliderItems() {
			return ShortcodeFieldConfigBuilder
				::instance()
				->multiRangeSlider( 0, '', array(
					'id'            => ShortcodeConfig::NAME_PREFIX . 'columns_slider',
					'nbColumns'     => self::NB_COLUMNS_DEFAULT,
					'sliderOptions' => array(
						'initialValues' => $this->columnsSliderValues,
						'gap'           => 1,
						'left'          => 1,
						'right'         => self::NB_COLUMNS_MAX - 1,
						'step'          => 1,
						'min'           => 0,
						'max'           => self::NB_COLUMNS_MAX,
					)
				) )
				->container( 1, '', array( 'id' => ShortcodeConfig::NAME_PREFIX . 'columns_slider_tooltips' ) )
				->build();
		}
	}
}