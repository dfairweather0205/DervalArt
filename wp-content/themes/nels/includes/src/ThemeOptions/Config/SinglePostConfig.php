<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\SinglePostConfig' ) ) {

	/**
	 * Class SinglePostConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class SinglePostConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$util = $this->util;

			$spacingRightContentProperty = sprintf( 'border-right-width: %spx', self::DELIMITER );
			$spacingLeftContentProperty  = sprintf( 'border-left-width: %spx', self::DELIMITER );
			$postFooterPartial           = 'single/post/elements/footer';
			$postFooterSelector          = '.site-main--post .entry-footer';

			return $this->controlConfigBuilder
				->noInput( 'single_post_spacing_title' )
				->label( esc_html__( 'Spacing', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SINGLE_POST_COMPRESS_POST_CONTENT_LEFT )
				->defaultVal( 120 )
				->description( esc_html__( '_left (pixels)', 'nels' ) )
				->css( array(
					$spacingLeftContentProperty => array(
						'.site-main--post .entry-branding',
						'.site-main--post .entry-content',
						'.site-main--post .entry-author',
						'.site-main--post .entry-meta',
						'.site-main--post #comments',
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SINGLE_POST_COMPRESS_POST_CONTENT_RIGHT )
				->defaultVal( 120 )
				->description( esc_html__( '_right (pixels)', 'nels' ) )
				->css( array(
					$spacingRightContentProperty => array(
						'.site-main--post .entry-branding',
						'.site-main--post .entry-content',
						'.site-main--post .entry-author',
						'.site-main--post .entry-meta',
						'.site-main--post #comments',
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkboxMultiple( ThemeOption::SINGLE_POST_ELEMENTS_VISIBILITY )
				->label( esc_html__( 'Visibility', 'nels' ) )
				->defaultVal( array(
					'tags',
					'author',
					'related_posts',
					'comments',
					'navigation',
				) )
				->choices( $this->getSinglePostElementsVisibilityList() )
				->selectiveRefresh( $postFooterSelector, $postFooterPartial )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'related_posts_title' )
				->label( esc_html__( 'Related Posts', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::RELATED_POSTS_DISPLAY )
				->defaultVal( 'default' )
				->description( esc_html__( '_display type', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getDisplayTypes() )
				->selectiveRefresh( $postFooterSelector, $postFooterPartial )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::RELATED_POSTS_SKIN_TRANSPARENCY )
				->defaultVal( 15 )
				->description( esc_html__( '_*hover color transparency (%)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
					'max' => 100,
				) )
				->cssCallback( function ( $option ) use ( $util ) {
					$transparencyProperty = 'opacity: ' . $util->transparencyToOpacity( $option );

					return array(
						$transparencyProperty => array(
							'.related-items--posts .color-overlay-inner'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::RELATED_POSTS_COLUMNS_NUMBER )
				->defaultVal( 3 )
				->description( esc_html__( '_columns number', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getItemColumnsNumber() )
				->selectiveRefresh( $postFooterSelector, $postFooterPartial )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::RELATED_POSTS_COLUMNS_SPACING )
				->defaultVal( 30 )
				->description( esc_html__( '_columns spacing (pixels)', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->cssCallback( function ( $option ) {
					$paddingsProperty = 'padding-right: ' . $option . 'px;';
					$marginsProperty  = 'margin-right: ' . - $option . 'px;';

					return array(
						$paddingsProperty => array(
							'.related-items--posts .card'
						),
						$marginsProperty  => array(
							'.related-items--posts .related-items__list'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->text( ThemeOption::SINGLE_POST_ALL_POSTS_LINK )
				->label( esc_html__( 'All Posts Link', 'nels' ) )
				->defaultVal( '/' )
				->selectiveRefresh( $postFooterSelector, $postFooterPartial )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'single_post_excerpt_title' )
				->label( esc_html__( 'Post Excerpt', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::BLOG_POST_EXCERPT_WORDS_NB )
				->defaultVal( 55 )
				->description( esc_html__( '_words number', 'nels' ) )
				->inputAttributes( array(
					'min' => 0,
				) )
				->build();
		}

		/**
		 * @return array
		 */
		private function getSinglePostElementsVisibilityList() {

			$visibilityList = array(
				'tags'          => esc_html__( '_Tags', 'nels' ),
				'author'        => esc_html__( '_Author', 'nels' ),
				'related_posts' => esc_html__( '_Related Posts', 'nels' ),
				'comments'      => esc_html__( '_Comments', 'nels' ),
				'navigation'    => esc_html__( '_Navigation', 'nels' ),
			);

			return $visibilityList;
		}
	}
}