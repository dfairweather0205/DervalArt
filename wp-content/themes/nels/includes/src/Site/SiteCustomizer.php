<?php

namespace Pikart\Nels\Site;

use Pikart\Nels\Misc\TemplatesUtil;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\ThemeOptions\ThemeOptionsFilterName;

if ( ! class_exists( __NAMESPACE__ . '\SiteCustomizer' ) ) {

	/**
	 * Class SiteCustomizer
	 * @package Pikart\Nels\Site\SiteCustomizer
	 */
	class SiteCustomizer {

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * @var TemplatesUtil
		 */
		private $templatesUtil;

		/**
		 * @var SqlCustomizer
		 */
		private $sqlCustomizer;

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * SiteCustomizer constructor.
		 *
		 * @param Util $util
		 * @param TemplatesUtil $templatesUtil
		 * @param SqlCustomizer $sqlCustomizer
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 */
		public function __construct(
			Util $util,
			TemplatesUtil $templatesUtil,
			SqlCustomizer $sqlCustomizer,
			ThemeOptionsUtil $themeOptionsUtil
		) {
			$this->util             = $util;
			$this->templatesUtil    = $templatesUtil;
			$this->sqlCustomizer    = $sqlCustomizer;
			$this->themeOptionsUtil = $themeOptionsUtil;
		}

		public function customize() {
			$this->editMenuItemAttributes();
			$this->filterPasswordProtectedForm();
			$this->customizeBodyClass();
			$this->customizerProductCategoryTitle();
			$this->templatesUtil->addContentFilterToWrapAlignedImages();
			$this->sqlCustomizer->customize();

			add_filter( 'wp_list_categories', function ( $html ) {
				$html = preg_replace( '/\<\/a> \((\d+)\)/', '<span>$1</span></a>', $html );

				return preg_replace( '/\((\d+)\)\<\/span>/', '$1</span>', $html );
			} );

			add_filter( 'get_archives_link', function ( $html ) {
				return preg_replace( '/\<\/a>\&nbsp;\((\d+)\)/', '<span>($1)</span></a>', $html );
			} );

			add_filter( 'wp_nav_menu', function ( $menu ) {
				return preg_replace( '/ class="sub-menu"/', ' class="menu" ', $menu );
			} );

			add_filter( 'comment_form_fields', function ( $fields ) {
				$comment = $fields['comment'];
				unset( $fields['comment'] );
				$fields['comment'] = $comment;

				return $fields;
			} );

			add_filter( ThemeOptionsFilterName::registeredGoogleFonts(), function ( $fontList ) {
				$fontList[] = 'Playfair+Display:400,400i,700,700i';

				return $fontList;
			} );
		}

		private function customizerProductCategoryTitle() {
			add_filter( 'get_the_archive_title', function ( $title ) {
				if ( function_exists( 'is_product_category' ) && is_product_category() ) {
					return single_term_title( '', false );
				}

				return $title;
			} );
		}

		private function customizeBodyClass() {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_filter( 'body_class', function ( $classes ) use ( $themeOptionsUtil ) {
				if ( is_singular() && post_password_required() ) {
					$classes[] = 'is-password-protected';
				}

				if ( get_header_textcolor() === 'blank' ) {
					$classes[] = 'title-tagline-hidden';
				}

				$classes[] = 'hover-style--' . $themeOptionsUtil->getOption( ThemeOption::SITE_HOVER_STYLE );

				return $classes;
			} );
		}

		private function editMenuItemAttributes() {
			$util = $this->util;

			add_filter( 'nav_menu_link_attributes', function ( $attributes, $item, $args ) use ( $util ) {
				$socialMenus = array(
					NavigationMenu::SOCIAL_PRIMARY,
					NavigationMenu::SOCIAL_FOOTER_BELOW,
					NavigationMenu::SOCIAL_HEADER_ABOVE
				);

				if ( 'custom' === $item->type && in_array( $args->theme_location, $socialMenus ) ) {

					$cssClassSuffix      = stripos( $item->url, 'mailto' ) === 0
						? 'envelope' : $util->getUrlDomain( $item->url, false );
					$attributes['class'] = isset( $attributes['class'] ) ? ' ' : '';
					$attributes['class'] .= 'fa fa-' . $cssClassSuffix;
				}

				return $attributes;
			}, 10, 3 );
		}

		private function filterPasswordProtectedForm() {
			$util = $this->util;

			add_filter( 'the_password_form', function () use ( $util ) {
				return $util->getPartialContent( 'forms/password-protected-form' );
			} );
		}
	}
}