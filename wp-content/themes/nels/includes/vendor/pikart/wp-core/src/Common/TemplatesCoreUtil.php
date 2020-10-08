<?php

namespace Pikart\WpThemeCore\Common;

use Pikart\WpThemeCore\Post\PostFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\TemplatesCoreUtil' ) ) {
	/**
	 * Class TemplatesCoreUtil
	 * @package Pikart\WpThemeCore\Common
	 */
	class TemplatesCoreUtil {

		/**
		 * @var Util
		 */
		protected $util;

		/**
		 * TemplatesUtil constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
		}

		/**
		 * @param string $html
		 *
		 * @return string
		 */
		public function removeHtmlOuterTag( $html ) {
			return preg_replace( '/^<[^>]+>|<\/[^>]+>$/', '', $html );
		}

		/**
		 * @param array $attributes
		 *
		 * @return string
		 */
		public function htmlAttributesToString( $attributes ) {
			$attributesList = array();
			foreach ( $attributes as $name => $value ) {
				$attributesList[] = $name . '="' . $value . '"';
			}

			return implode( ' ', $attributesList );
		}

		/**
		 * @param string $content
		 *
		 * @return string
		 */
		public function filterPostContent( $content ) {
			return str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $content ) );
		}

		/**
		 * @param string $content
		 *
		 * @since 1.3.0
		 *
		 * @return string
		 */
		public function filterContent( $content ) {
			$contentFilterName = apply_filters( PostFilterName::contentFilterName(), 'the_content' );

			return str_replace( ']]>', ']]&gt;', apply_filters( $contentFilterName, $content ) );
		}

		/**
		 * @param int $postId
		 * @param string $separator
		 *
		 * @return string
		 */
		public function joinCategoryNames( $postId, $separator = ', ' ) {
			$categoryNames = array();

			foreach ( get_the_category( $postId ) as $category ) {
				$categoryNames[] = $category->cat_name;
			}

			return implode( $separator, $categoryNames );
		}

		/**
		 * @param int $postId
		 * @param string $taxonomy
		 * @param string $separator
		 *
		 * @since 1.3.0
		 *
		 * @return string
		 */
		public function joinTermNames( $postId, $taxonomy, $separator = ', ' ) {
			$termNames = array();

			foreach ( get_the_terms( $postId, $taxonomy ) as $term ) {
				$termNames[] = $term->name;
			}

			return implode( $separator, $termNames );
		}

		/**
		 * @param $hexColor
		 * @param $alpha
		 *
		 * @return string
		 */
		public function hexToRgbString( $hexColor ) {
			$rgb = $this->util->hexToRgbColor( $hexColor );

			return sprintf( 'rgba(%d, %d, %d)', $rgb['r'], $rgb['g'], $rgb['b'] );
		}

		/**
		 * @param string $hexColor
		 * @param float $alpha
		 *
		 * @return string
		 */
		public function hexToRgbaString( $hexColor, $alpha ) {
			$rgb = $this->util->hexToRgbColor( $hexColor );

			return sprintf( 'rgba(%d, %d, %d, %.1f)', $rgb['r'], $rgb['g'], $rgb['b'], $alpha );
		}

		/**
		 * @param string $hexColor
		 * @param int $transparency
		 *
		 * @return string
		 */
		public function hexWithTransparencyToRgbaString( $hexColor, $transparency ) {
			return $this->hexToRgbaString( $hexColor, $this->util->transparencyToOpacity( $transparency ) );
		}
	}
}
