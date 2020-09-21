<?php

namespace Pikart\Nels\Shortcode;

use Pikart\Nels\Common\AssetHandle;
use Pikart\Nels\Post\Options\Type\AsidePostOptions;
use Pikart\Nels\Post\Options\Type\BlogPageOptions;
use Pikart\Nels\Post\Options\Type\CommonPostOptions;
use Pikart\Nels\Post\Options\Type\PageOptions;
use Pikart\Nels\Post\Options\Type\ProductOptions;
use Pikart\Nels\Post\Options\Type\ProjectOptions;
use Pikart\Nels\Shortcode\Config\ShortcodesAttributesConfig;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Admin\MetaBoxes\MetaBoxConfigBuilder;
use Pikart\WpThemeCore\Post\PostUtil;
use Pikart\WpThemeCore\Post\Type\PostTypeSlug;
use Pikart\WpThemeCore\Shortcode\ShortcodeFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeShortcodesInitilizer' ) ) {

	/**
	 * Class ThemeShortcodesInitilizer
	 * @package Pikart\Nels\Shortcode
	 */
	class ThemeShortcodesInitilizer {

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * @var PostUtil
		 */
		private $postUtil;

		/**
		 * @var ShortcodesAttributesConfig
		 */
		private $shortcodesAttributesConfig;

		/**
		 * ThemeShortcodesInitilizer constructor.
		 *
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 * @param PostUtil $postUtil
		 * @param ShortcodesAttributesConfig $shortcodesAttributesConfig
		 */
		public function __construct(
			ThemeOptionsUtil $themeOptionsUtil,
			PostUtil $postUtil,
			ShortcodesAttributesConfig $shortcodesAttributesConfig
		) {
			$this->themeOptionsUtil           = $themeOptionsUtil;
			$this->postUtil                   = $postUtil;
			$this->shortcodesAttributesConfig = $shortcodesAttributesConfig;
		}

		public function initialize() {
			$this->initAdmin();
			$this->shortcodesAttributesConfig->configure();
			$this->configureRowOptions();
			$this->configureTeamMemberShortcode();
			$this->setupPostFieldsWithShortcodesFilter();
		}

		private function configureTeamMemberShortcode() {
			$postUtil = $this->postUtil;

			add_filter( ShortcodeFilterName::teamMemberHeaderBrandingBackgroundColor(),
				function ( $color, $postId ) use ( $postUtil ) {
					return $postUtil->getOption( $postId, CommonPostOptions::SITE_CONTENT_BACKGROUND );
				}, 10, 2
			);
		}

		private function configureRowOptions() {
			$themeOptionsUtil = $this->themeOptionsUtil;

			add_filter( ShortcodeFilterName::attributesConfig( 'row' ),
				function ( $attributes ) use ( $themeOptionsUtil ) {
					$attributes['width_custom']['default'] = $themeOptionsUtil->getOption( ThemeOption::SITE_WIDTH );

					return $attributes;
				} );
		}

		private function initAdmin() {
			add_action( 'admin_enqueue_scripts', function () {
				wp_enqueue_script( AssetHandle::adminShortcodes() );
			} );
		}

		private function setupPostFieldsWithShortcodesFilter() {
			$postOptionsWithShortcodes = array(
				PostTypeSlug::POST    => array(
					AsidePostOptions::HERO_HEADER,
				),
				PostTypeSlug::PAGE    => array(
					PageOptions::HERO_HEADER,
					BlogPageOptions::ADDITIONAL_CONTENT,
				),
				PostTypeSlug::PROJECT => array(
					ProjectOptions::HERO_HEADER,
				),
				PostTypeSlug::PRODUCT => array(
					ProductOptions::HERO_HEADER,
				),
			);

			foreach ( $postOptionsWithShortcodes as $postType => $options ) {
				add_filter( ShortcodeFilterName::postFieldsWithShortcodes( $postType ), function ( $fields ) use (
					$options
				) {

					$options = array_map( function ( $option ) {
						return MetaBoxConfigBuilder::DB_PREFIX . $option;
					}, $options );

					return array_merge( $fields, $options );
				} );
			}
		}
	}
}