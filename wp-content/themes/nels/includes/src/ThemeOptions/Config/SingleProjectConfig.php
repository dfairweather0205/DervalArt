<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\SingleProjectConfig' ) ) {

	/**
	 * Class SingleProjectConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class SingleProjectConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$util = $this->util;

			$spacingRightContentProperty = sprintf( 'border-right-width: %spx', self::DELIMITER );
			$spacingLeftContentProperty  = sprintf( 'border-left-width: %spx', self::DELIMITER );
			$projectFooterPartial        = 'single/project/elements/footer';
			$projectFooterSelector       = '.site-main--project .entry-footer';

			return $this->controlConfigBuilder
				->noInput( 'single_project_spacing_title' )
				->label( esc_html__( 'Spacing', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SINGLE_PROJECT_COMPRESS_PROJECT_CONTENT_LEFT )
				->defaultVal( 0 )
				->description( esc_html__( '_left (pixels)', 'nels' ) )
				->css( array(
					$spacingLeftContentProperty => array(
						'.site-main--project .entry-branding',
						'.site-main--project .entry-content',
						'.site-main--project .details-position--top .entry-details',
						'.site-main--project .details-position--bottom .entry-details',
						'.site-main--project .entry-meta',
						'.site-main--project #comments',
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::SINGLE_PROJECT_COMPRESS_PROJECT_CONTENT_RIGHT )
				->defaultVal( 0 )
				->description( esc_html__( '_right (pixels)', 'nels' ) )
				->css( array(
					$spacingRightContentProperty => array(
						'.site-main--project .entry-branding',
						'.site-main--project .entry-content',
						'.site-main--project .details-position--top .entry-details',
						'.site-main--project .details-position--bottom .entry-details',
						'.site-main--project .entry-meta',
						'.site-main--project #comments',
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkboxMultiple( ThemeOption::SINGLE_PROJECT_ELEMENTS_VISIBILITY )
				->label( esc_html__( 'Visibility', 'nels' ) )
				->defaultVal( array(
					'tags',
					'related_projects',
					'comments',
					'navigation',
				) )
				->choices( array(
					'tags'             => esc_html__( '_Tags', 'nels' ),
					'related_projects' => esc_html__( '_Related Projects', 'nels' ),
					'comments'         => esc_html__( '_Comments', 'nels' ),
					'navigation'       => esc_html__( '_Navigation', 'nels' ),
				) )
				->selectiveRefresh( $projectFooterSelector, $projectFooterPartial )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'related_projects_title' )
				->label( esc_html__( 'Related Projects', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::RELATED_PROJECTS_DISPLAY )
				->defaultVal( 'default' )
				->description( esc_html__( '_display type', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getDisplayTypes() )
				->selectiveRefresh( $projectFooterSelector, $projectFooterPartial )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::RELATED_PROJECTS_SKIN_TRANSPARENCY )
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
							'.related-items--projects .color-overlay-inner'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::RELATED_PROJECTS_COLUMNS_NUMBER )
				->defaultVal( 3 )
				->description( esc_html__( '_columns number', 'nels' ) )
				->choices( ThemeOptionsConfigHelper::getItemColumnsNumber() )
				->selectiveRefresh( $projectFooterSelector, $projectFooterPartial )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::RELATED_PROJECTS_COLUMNS_SPACING )
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
							'.related-items--projects .card'
						),
						$marginsProperty  => array(
							'.related-items--projects .related-items__list'
						)
					);
				} )
				// -------------------------------------------------------------------------------------------------- \\
				->text( ThemeOption::SINGLE_PROJECT_ALL_PROJECTS_LINK )
				->label( esc_html__( 'All Projects Link', 'nels' ) )
				->defaultVal( '/' )
				->selectiveRefresh( $projectFooterSelector, $projectFooterPartial )
				->build();
		}
	}
}