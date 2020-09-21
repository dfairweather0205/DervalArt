<?php

namespace Pikart\WpCore\Admin\MetaBoxes\Generator;

use Pikart\WpCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpCore\Admin\MetaBoxes\MetaBoxDal;
use Pikart\WpCore\Admin\MetaBoxes\MetaBoxFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\MetaBoxGeneratorHelper' ) ) {

	/**
	 * Class MetaBoxGeneratorHelper
	 * @package Pikart\WpCore\Admin\MetaBoxes\Generator
	 *
	 * @since 1.7.0
	 */
	class MetaBoxGeneratorHelper {

		const HTML_TABS_CONTAINER_PATTERN = '<div class="meta-box-custom-field meta-box-custom-field__tabs">%s</div>';
		const HTML_TABS_PATTERN = '<ul class="meta-box-tabs meta-box-tabs__%s">%s</ul>';
		const HTML_TAB_TITLE_PATTERN = '<li class="meta-box-tab__title"><a href="#">%s</a></li>';
		const HTML_TAB_CONTENT_PATTERN = '<div class="meta-box-tab__content">%s</div>';

		/**
		 * @var LineGenerator
		 */
		private $lineGenerator;

		/**
		 * @var MetaBoxDal
		 */
		private $metaBoxDal;

		/**
		 * MetaBoxGenerator constructor.
		 *
		 * @param LineGenerator $lineGenerator
		 * @param MetaBoxDal $metaBoxDal
		 */
		public function __construct( LineGenerator $lineGenerator, MetaBoxDal $metaBoxDal ) {
			$this->lineGenerator = $lineGenerator;
			$this->metaBoxDal    = $metaBoxDal;
		}

		/**
		 * @param string $metaBoxId
		 * @param int $postId
		 * @param array $metaBoxFields
		 *
		 * @return string
		 */
		public function generateMetaBoxFields( $metaBoxId, $postId, $metaBoxFields ) {
			if ( empty( $metaBoxFields ) ) {
				return '';
			}

			$content = '';
			$tabs    = array();

			foreach ( $metaBoxFields as $fieldConfig ) {
				if ( ! empty( $fieldConfig['id'] ) ) {
					$configFilterName = MetaBoxFilterName::fieldConfig( $metaBoxId,
						str_replace( MetaBoxConfigBuilder::DB_PREFIX, '', $fieldConfig['id'] ) );

					$fieldConfig = apply_filters( $configFilterName, $fieldConfig );
				}

				if ( isset( $fieldConfig['disable'] ) && $fieldConfig['disable'] ) {
					continue;
				}

				if ( MetaBoxConfigBuilder::TAB === $fieldConfig['type'] ) {
					$tabs[] = $fieldConfig;
					continue;
				} elseif ( ! empty( $tabs ) ) {
					$content .= $this->generateTabs( $metaBoxId, $postId, $tabs );
					$tabs    = array();
				}

				$fieldConfig['value'] = $this->metaBoxDal->getFieldValue( $postId, $fieldConfig );

				$content .= $this->lineGenerator->generate( $fieldConfig );
			}

			if ( ! empty( $tabs ) ) {
				$content .= $this->generateTabs( $metaBoxId, $postId, $tabs );
			}

			return $content;
		}

		/**
		 * @param string $metaBoxId
		 * @param int $postId
		 * @param array $tabs
		 *
		 * @return string
		 */
		private function generateTabs( $metaBoxId, $postId, array $tabs ) {
			$htmlTabTitles    = array();
			$htmlTabsContents = array();

			foreach ( $tabs as $tab ) {
				$htmlTabTitles[]    = sprintf( self::HTML_TAB_TITLE_PATTERN, $tab['label'] );
				$tabFields          = isset( $tab['fields'] ) ? $tab['fields'] : array();
				$htmlTabsContents[] = sprintf(
					self::HTML_TAB_CONTENT_PATTERN,
					$this->generateMetaBoxFields( $metaBoxId, $postId, $tabFields ) );
			}

			$position = empty( $tab['position'] ) ? 'vertical' : $tab['position'];

			$tabsHtml = sprintf( self::HTML_TABS_PATTERN, $position, implode( '', $htmlTabTitles ) )
			            . implode( '', $htmlTabsContents );


			return sprintf( self::HTML_TABS_CONTAINER_PATTERN, $tabsHtml );
		}
	}
}