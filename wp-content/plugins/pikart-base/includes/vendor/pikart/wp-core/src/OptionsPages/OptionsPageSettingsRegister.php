<?php

namespace Pikart\WpCore\OptionsPages;

use Pikart\WpCore\Admin\Common\FormInputFieldGenerator;
use Pikart\WpCore\Admin\Media\MediaFilter;
use Pikart\WpCore\Common\CoreAssetHandle;
use Pikart\WpCore\Common\DataSanitizer;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPageSettingsRegister' ) ) {

	/**
	 * Class OptionsPageSettingsRegister
	 * @package Pikart\WpCore\OptionsPages
	 */
	class OptionsPageSettingsRegister {

		const HTML_DESCRIPTION_PATTERN = '<span class="options-pages__custom-field__description">%s</span>';

		/**
		 * @var DataSanitizer
		 */
		private $dataSanitizer;

		/**
		 * @var FormInputFieldGenerator
		 */
		private $fieldGenerator;

		/**
		 * @var OptionsPagesCoreUtil
		 */
		private $optionsPagesCoreUtil;

		/**
		 * OptionsPageSettingsRegister constructor.
		 *
		 * @param DataSanitizer $dataSanitizer
		 * @param FormInputFieldGenerator $fieldGenerator
		 * @param OptionsPagesCoreUtil $optionsPagesCoreUtil
		 */
		public function __construct(
			DataSanitizer $dataSanitizer,
			FormInputFieldGenerator $fieldGenerator,
			OptionsPagesCoreUtil $optionsPagesCoreUtil
		) {
			$this->dataSanitizer        = $dataSanitizer;
			$this->fieldGenerator       = $fieldGenerator;
			$this->optionsPagesCoreUtil = $optionsPagesCoreUtil;
		}

		/**
		 * @param array $page
		 */
		public function register( array $page ) {
			$this->setupAssets( $page );

			$controls = array();

			foreach ( $page['sections'] as $section ) {
				$this->addSettingsSection( $section, $page['id'] );

				foreach ( $section['controls'] as $control ) {
					$this->filterSettingOptions( $page['id'], $control );

					$control['value']       = $this->optionsPagesCoreUtil->getOption( $page['id'], $control['id'] );
					$control['description'] = $this->getDataValue( $control, 'description' );

					$this->addControl( $control, $section['id'], $page['id'] );

					$controls[ $control['id'] ] = $control;
				}
			}

			$this->registerOption( $page['id'], $controls );
		}

		/**
		 * @param string $pageId
		 * @param array $control
		 */
		private function filterSettingOptions( $pageId, &$control ) {
			if ( ! isset( $control['options'] ) ) {
				return;
			}

			$control['options'] = apply_filters(
				OptionsPagesFilterName::settingValueOptions( $pageId, $control['id'] ),
				$this->getDataValue( $control, 'options' )
			);
		}

		/**
		 * @param array $page
		 */
		private function setupAssets( array $page ) {
			$menuItemId = empty( $page['menu_parent_id'] ) ? $page['id'] : $page['menu_parent_id'];
			$hookName   = get_plugin_page_hookname( $menuItemId, '' );

			add_action( 'admin_enqueue_scripts', function ( $hook ) use ( $hookName ) {
				if ( $hook === $hookName ) {
					wp_enqueue_style( CoreAssetHandle::adminOptionsPagesStyle() );
				}
			} );

			$filterCallback = function ( $hooks ) use ( $hookName ) {
				$hooks[] = $hookName;

				return $hooks;
			};

			add_filter( MediaFilter::customGalleryHooks(), $filterCallback );
			add_filter( MediaFilter::customGalleryImageHooks(), $filterCallback );
		}

		/**
		 * @param array $control
		 * @param string $sectionId
		 * @param string $pageId
		 */
		private function addControl( $control, $sectionId, $pageId ) {
			$optionDbKey    = OptionsPagesConfig::getOptionsPageDbKey( $pageId );
			$controlName    = sprintf( '%s[%s]', $optionDbKey, $control['id'] );
			$fieldGenerator = $this->fieldGenerator;

			add_settings_field( $control['id'], $control['title'], function () use (
				$control, $controlName, $fieldGenerator
			) {
				$control['id'] = $controlName;

				echo call_user_func(array($fieldGenerator, 'generate'), $control, $control['type']);

				echo sprintf( OptionsPageSettingsRegister::HTML_DESCRIPTION_PATTERN,
					wp_kses_post( $control['description'] )
				);

			}, $pageId, $sectionId, array(
				'label_for' => $controlName
			) );
		}

		/**
		 * @param array $section
		 * @param string $pageId
		 */
		private function addSettingsSection( $section, $pageId ) {
			add_settings_section( $section['id'], $section['title'], function () use ( $section ) {
				echo sprintf( OptionsPageSettingsRegister::HTML_DESCRIPTION_PATTERN,
					wp_kses_post( $section['description'] )
				);
			}, $pageId );
		}

		/**
		 * @param string $pageId
		 * @param array $controls
		 */
		private function registerOption( $pageId, array $controls ) {
			$dataSanitizer = $this->dataSanitizer;

			register_setting( $pageId, OptionsPagesConfig::getOptionsPageDbKey( $pageId ), function ( $input ) use (
				$controls, $dataSanitizer
			) {
				$sanitizedInput = array();

				foreach ( $controls as $controlId => $control ) {
					$value = $this->getDataValue( $input, $controlId );

					$sanitizedInput[ $controlId ] = $dataSanitizer->sanitize( $value, $control['type'] );
				}

				return $sanitizedInput;
			} );
		}

		/**
		 * @param array $data
		 * @param string $key
		 * @param mixed $default
		 *
		 * @return mixed
		 */
		private function getDataValue( array $data, $key, $default = '' ) {
			return isset( $data[ $key ] ) ? $data[ $key ] : $default;
		}
	}
}