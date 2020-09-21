<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\SinglePageConfig' ) ) {

	/**
	 * Class SinglePageConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class SinglePageConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {

			$paddingRightContentProperty = sprintf( 'border-right-width: %spx', self::DELIMITER );
			$paddingLeftContentProperty  = sprintf( 'border-left-width: %spx', self::DELIMITER );

			return $this->controlConfigBuilder
				->noInput( 'page_spacing_title' )
				->label( esc_html__( 'Spacing', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::PAGE_COMPRESS_PAGE_CONTENT_LEFT )
				->defaultVal( 0 )
				->description( esc_html__( '_left (pixels)', 'nels' ) )
				->css( array(
					$paddingLeftContentProperty => array(
						'.site-main--page .entry-branding',
						'.site-main--page .entry-content',
						'.site-main--page .entry-social-area',
						'.site-main--page #comments',
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::PAGE_COMPRESS_PAGE_CONTENT_RIGHT )
				->defaultVal( 0 )
				->description( esc_html__( '_right (pixels)', 'nels' ) )
				->css( array(
					$paddingRightContentProperty => array(
						'.site-main--page .entry-branding',
						'.site-main--page .entry-content',
						'.site-main--page .entry-social-area',
						'.site-main--page #comments',
					),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkboxMultiple( ThemeOption::PAGE_ELEMENTS_VISIBILITY )
				->label( esc_html__( 'Visibility', 'nels' ) )
				->defaultVal( array(
					'comments',
				) )
				->choices( array(
					'comments'     => esc_html__( '_Comments', 'nels' ),
					'navigation'   => esc_html__( '_Navigation', 'nels' ),
				) )
				->selectiveRefresh(
					'.site-main--default-page .entry-footer, .site-main--blog-template .entry-footer',
					'single/page/elements/footer'
				)
				->build();
		}
	}
}