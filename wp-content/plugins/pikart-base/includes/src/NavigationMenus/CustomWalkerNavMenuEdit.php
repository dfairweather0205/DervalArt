<?php

namespace Pikart\WpBase\NavigationMenus;

use Pikart\WpBase\DependencyInjection\Service;
use Pikart\WpCore\Admin\Media\CustomGalleryImage;
use Pikart\WpCore\Admin\Sidebars\SidebarUtil;
use Pikart\WpCore\Common\Util;
use Pikart\WpCore\NavigationMenus\NavigationMenusFilterName;
use Walker_Nav_Menu_Edit;

if ( ! class_exists( __NAMESPACE__ . '\\CustomWalkerNavMenuEdit' ) ) {

	/**
	 * Class CustomWalkerNavMenuEdit
	 * @package Pikart\WpBase\Admin\NavigationMenus
	 *
	 * @since 1.1.0
	 */
	class CustomWalkerNavMenuEdit extends Walker_Nav_Menu_Edit {

		const INPUT_PATTERN = '<input type="%s" id="%s" name="%s" value="%s" %s />';
		const SELECT_PATTERN = '<select id="%s" name="%s" >%s</select>';
		const SELECT_OPTION_PATTERN = '<option value="%s" %s >%s</option>';

		/**
		 * @var SidebarUtil
		 */
		private $sidebarUtil;

		/**
		 * @var CustomGalleryImage
		 */
		private $customGalleryImage;

		/**
		 * @var Util
		 *
		 * @since 1.4.0
		 */
		private $util;

		/**
		 * CustomWalkerNavMenuEdit constructor.
		 */
		public function __construct() {
			$this->sidebarUtil        = Service::sidebarUtil();
			$this->customGalleryImage = Service::customGalleryImage();
			$this->util               = Service::util();
			$this->customGalleryImage->setup();
		}

		/**
		 * @inheritdoc
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			parent::start_el( $output, $item, $depth, $args, $id );

			$wideMenuContent = $this->generateAlternativeLabelOptions( $item, $args );
			$wideMenuContent .= $this->generateWideMenuOptions( $item, $args );

			$output = $this->util->strReplaceLast(
				'<fieldset class="field-move', $wideMenuContent . '<fieldset class="field-move', $output );
		}

		/**
		 * @param object $item
		 * @param array $args
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		protected function generateAlternativeLabelOptions( $item, $args = array() ) {
			if ( ! apply_filters( NavigationMenusFilterName::alternativeLabelsEnabled(), true, $args ) ) {
				return '';
			}

			$itemId = esc_attr( $item->ID );

			$fieldId = NavigationMenusOption::ALTERNATIVE_LABEL;
			$label   = esc_html__( 'Alternative label', 'pikart-base' );
			$html    = $this->generateTextField( $fieldId, $itemId, $item->{$fieldId}, $label );

			$fieldId = NavigationMenusOption::ALTERNATIVE_LABEL_COLOR;
			$label   = esc_html__( 'Alternative label color', 'pikart-base' );
			$html    .= $this->generateTextField( $fieldId, $itemId, $item->{$fieldId}, $label, '#ffffff' );

			$fieldId = NavigationMenusOption::ALTERNATIVE_LABEL_BACKGROUND_COLOR;
			$label   = esc_html__( 'Alternative label background color', 'pikart-base' );
			$html    .= $this->generateTextField( $fieldId, $itemId, $item->{$fieldId}, $label, '#000000' );

			return $html;
		}

		/**
		 * @param object $item
		 * @param array $args
		 *
		 * @return string
		 */
		protected function generateWideMenuOptions( $item, $args = array() ) {
			if ( ! apply_filters( NavigationMenusFilterName::wideMenuEnabled(), true, $args ) ) {
				return '';
			}

			$itemId = esc_attr( $item->ID );

			$fieldId = NavigationMenusOption::WIDE_MENU;
			$label   = esc_html__( 'Wide Menu', 'pikart-base' );
			$html    = $this->generateCheckboxField( $fieldId, $itemId, $item->{$fieldId}, $label );

			$fieldId   = NavigationMenusOption::NB_COLUMNS;
			$columns   = range( 1, 6 );
			$nbColumns = $item->{$fieldId} ? $item->{$fieldId} : 4;
			$label     = esc_html__( 'Number of columns', 'pikart-base' );
			$html      .= $this->generateSelectField(
				$fieldId, $itemId, $nbColumns, $label, array_combine( $columns, $columns ) );

			$fieldId = NavigationMenusOption::BACKGROUND_IMAGE;
			$label   = esc_html__( 'Background image', 'pikart-base' );
			$html    .= $this->generateCustomGalleryImage( $fieldId, $itemId, $item->{$fieldId}, $label );

			$customSidebars = $this->sidebarUtil->getCustomSidebars();

			if ( empty( $customSidebars ) ) {
				return $html;
			}

			$sidebars = array_merge( array(
				'none' => esc_html__( 'None', 'pikart-base' ),
			), $customSidebars );

			$fieldId = NavigationMenusOption::CUSTOM_WIDGET_AREA;
			$label   = esc_html__( 'Custom widget area', 'pikart-base' );
			$html    .= $this->generateSelectField(
				$fieldId, $itemId, esc_attr( $item->{$fieldId} ), $label, $sidebars );

			return $html;
		}

		/**
		 * @param string $fieldId
		 * @param string $itemId
		 * @param string $value
		 * @param string $labelText
		 *
		 * @return string
		 */
		protected function generateCustomGalleryImage( $fieldId, $itemId, $value, $labelText ) {
			$fieldId = $this->getFieldIdForHtml( $fieldId );

			$image = $this->customGalleryImage->generateGalleryImageHtml(
				$this->generateInputId( $fieldId, $itemId ), $value, $this->generateInputName( $fieldId, $itemId ) );

			return $this->generateParagraph(
				$fieldId, $this->generateLabel( $fieldId, $itemId, $labelText . $image ) );
		}

		/**
		 * @param string $fieldId
		 * @param string $itemId
		 * @param string $value
		 * @param string $labelText
		 * @param array $options
		 *
		 * @return string
		 */
		protected function generateSelectField( $fieldId, $itemId, $value, $labelText, array $options ) {
			$optionGroups = array();
			$fieldId      = $this->getFieldIdForHtml( $fieldId );

			foreach ( $options as $option => $label ) {
				$selected       = strval( $option ) === strval( $value ) ? 'selected' : '';
				$optionGroups[] = sprintf(
					self::SELECT_OPTION_PATTERN,
					esc_attr( $option ),
					esc_attr( $selected ),
					esc_html( $label )
				);
			}

			$select = sprintf(
				self::SELECT_PATTERN,
				esc_attr( $this->generateInputId( $fieldId, $itemId ) ),
				esc_attr( $this->generateInputName( $fieldId, $itemId ) ),
				implode( '', $optionGroups )
			);

			return $this->generateParagraph(
				$fieldId, $this->generateLabel( $fieldId, $itemId, $labelText . ' ' . $select ) );
		}

		/**
		 * @param string $fieldId
		 * @param string $itemId
		 * @param string $value
		 * @param string $labelText
		 * @param string $placeholder
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		protected function generateTextField( $fieldId, $itemId, $value, $labelText, $placeholder = '' ) {
			$fieldId   = $this->getFieldIdForHtml( $fieldId );
			$x         = empty( $placeholder ) ? '' : sprintf( 'placeholder="%s"', esc_attr( $placeholder ) );
			$textInput = sprintf(
				self::INPUT_PATTERN,
				'text',
				esc_attr( $this->generateInputId( $fieldId, $itemId ) ),
				esc_attr( $this->generateInputName( $fieldId, $itemId ) ),
				esc_attr( $value ),
				$this->generatePlaceholderAttribute( $placeholder )
			);


			return $this->generateParagraph(
				$fieldId, $this->generateLabel( $fieldId, $itemId, $labelText . ' ' . $textInput ) );
		}

		/**
		 * @param string $fieldId
		 * @param string $itemId
		 * @param string $value
		 * @param string $labelText
		 *
		 * @return string
		 */
		protected function generateCheckboxField( $fieldId, $itemId, $value, $labelText ) {
			$fieldId = $this->getFieldIdForHtml( $fieldId );

			$checkboxInput = sprintf(
				self::INPUT_PATTERN,
				'checkbox',
				esc_attr( $this->generateInputId( $fieldId, $itemId ) ),
				esc_attr( $this->generateInputName( $fieldId, $itemId ) ),
				esc_attr( $fieldId ),
				checked( esc_attr( $value ), esc_attr( $fieldId ), false )
			);


			return $this->generateParagraph(
				$fieldId, $this->generateLabel( $fieldId, $itemId, $checkboxInput . $labelText ) );
		}

		/**
		 * @param string $fieldId
		 * @param string $content
		 *
		 * @return string
		 */
		protected function generateParagraph( $fieldId, $content ) {
			return sprintf( '<p class="field-%s description">%s</p>', $fieldId, $content );
		}

		/**
		 * @param string $fieldId
		 * @param string $menuItemId
		 * @param string $content
		 *
		 * @return string
		 */
		protected function generateLabel( $fieldId, $menuItemId, $content ) {
			return sprintf( '<label for="edit-menu-item-%s-%s">%s</label>', $fieldId, $menuItemId, $content );
		}

		/**
		 * @param string $fieldId
		 * @param string $menuItemId
		 *
		 * @return string
		 */
		protected function generateInputId( $fieldId, $menuItemId ) {
			return sprintf( 'edit-menu-item-%s-%s', $fieldId, $menuItemId );
		}

		/**
		 * @param string $fieldId
		 * @param string $menuItemId
		 *
		 * @return string
		 */
		protected function generateInputName( $fieldId, $menuItemId ) {
			return sprintf( 'menu-item-%s[%s]', $fieldId, $menuItemId );
		}

		/**
		 * @param string $placeholder
		 *
		 * @since 1.4.0
		 *
		 * @return string
		 */
		protected function generatePlaceholderAttribute( $placeholder ) {
			return empty( $placeholder ) ? '' : sprintf( 'placeholder="%s"', esc_attr( $placeholder ) );
		}

		/**
		 * @param string $fieldId
		 *
		 * @return string
		 */
		private function getFieldIdForHtml( $fieldId ) {
			return str_replace( '_', '-', $fieldId );
		}

	}
}
