<?php

namespace Pikart\WpCore\ThemeOptions;

use Pikart\WpCore\Common\DataSanitizer;
use Pikart\WpCore\Common\Util;
use WP_Customize_Manager;

if ( ! class_exists( __NAMESPACE__ . '\\ThemeOptionsWrapper' ) ) {

	/**
	 * Class ThemeOptionsWrapper
	 * @package Pikart\WpCore\ThemeOptions
	 */
	class ThemeOptionsWrapper {

		/**
		 * @var int
		 */
		private static $panelPriority = 5;

		/**
		 * @var int
		 */
		private static $sectionPriority = 5;

		/**
		 * @var int
		 */
		private static $controlPriority = 5;

		/**
		 * @var WP_Customize_Manager
		 */
		private $wpCustomizeManager;

		/**
		 * @var DataSanitizer
		 */
		private $dataSanitizer;

		/**
		 * @var ThemeOptionsCoreUtil
		 */
		private $themeOptionsUtil;

		/**
		 * @var ThemeOptionsControlWrapper
		 */
		private $controlWrapper;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * ThemeOptionsWrapper constructor.
		 *
		 * @param DataSanitizer $dataSanitizer
		 * @param ThemeOptionsCoreUtil $themeOptionsUtil
		 * @param ThemeOptionsControlWrapper $controlWrapper
		 * @param Util $util
		 */
		public function __construct(
			DataSanitizer $dataSanitizer,
			ThemeOptionsCoreUtil $themeOptionsUtil,
			ThemeOptionsControlWrapper $controlWrapper,
			Util $util
		) {
			$this->dataSanitizer    = $dataSanitizer;
			$this->themeOptionsUtil = $themeOptionsUtil;
			$this->controlWrapper   = $controlWrapper;
			$this->util             = $util;

			$this->initWpCustomizeManager();
		}

		/**
		 * @param string $id
		 * @param string $title
		 * @param string $description
		 * @param int $priority
		 *
		 * @return string
		 */
		public function addPanel( $id, $title, $description = '', $priority = null ) {
			$panelId = $this->themeOptionsUtil->buildPanelId( $id );
			$this->wpCustomizeManager->add_panel(
				$panelId,
				array(
					'priority'    => empty( $priority ) ? static::$panelPriority ++ : $priority,
					'capability'  => 'edit_theme_options',
					'title'       => $title,
					'description' => $description,
				)
			);

			return $panelId;
		}

		/**
		 * @param string $id
		 * @param string $panelId
		 * @param string $title
		 * @param string $description
		 * @param int $priority
		 *
		 * @return string
		 */
		public function addSection( $id, $panelId = '', $title = '', $description = '', $priority = null ) {
			$sectionId = $this->themeOptionsUtil->buildSectionId( $id );

			$this->wpCustomizeManager->add_section(
				$sectionId,
				array(
					'title'       => $title,
					'priority'    => empty( $priority ) ? static::$sectionPriority ++ : $priority,
					'capability'  => 'edit_theme_options',
					'description' => $description,
					'panel'       => $panelId,
				)
			);

			return $sectionId;
		}

		/**
		 * @param string $controlId
		 * @param string $sectionId
		 * @param string $type
		 * @param array $options
		 *
		 * @return string
		 */
		public function addControl(
			$controlId, $sectionId, $type, array $options = array()
		) {
			$getOption = function ( $id, $default = '' ) use ( $options ) {
				return isset( $options[ $id ] ) ? $options[ $id ] : $default;
			};

			$fullControlId = $this->addSetting(
				$controlId,
				$type,
				$getOption( 'default' ),
				$getOption( 'transport', ThemeCoreOptionsConfig::DEFAULT_CONTROL_TRANSPORT_TYPE ),
				$getOption( 'persist', ThemeCoreOptionsConfig::PERSIST_SETTING_DEFAULT )
			);

			if ( ! isset( $options['priority'] ) ) {
				$options['priority'] = static::$controlPriority ++;
			}

			if ( isset( $options['additional_config_attributes'] ) ) {
				$options = array_merge( $options, $options['additional_config_attributes'] );
				unset( $options['additional_config_attributes'] );
			}

			$options = array_merge( $options,
				array(
					'label'    => $getOption( 'label' ),
					'section'  => $sectionId,
					'settings' => $fullControlId,
				)
			);

			$this->controlWrapper->add( $fullControlId, $type, $options );

			$this->setupSelectiveRefresh( $fullControlId, $options );

			return $fullControlId;
		}

		private function initWpCustomizeManager() {
			$customizeManager = &$this->wpCustomizeManager;
			$controlWrapper   = $this->controlWrapper;

			add_action( 'customize_register',
				function ( WP_Customize_Manager $wpCustomizeManager ) use ( &$customizeManager, $controlWrapper ) {
					$customizeManager = $wpCustomizeManager;
					$controlWrapper->setWpCustomizeManager( $wpCustomizeManager );
				}, 1 );
		}

		/**
		 * @param string $settingId
		 * @param string $controlType
		 * @param string $defaultValue
		 * @param string $transport
		 * @param bool $persist
		 *
		 * @return string
		 */
		private function addSetting( $settingId, $controlType, $defaultValue, $transport, $persist ) {
			$fullSettingId = $this->themeOptionsUtil->buildSettingId( $settingId );
			$config        = array(
				'default'           => $defaultValue,
				'transport'         => $transport,
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => $this->getControlSanitizeCallback( $controlType, $persist ),
			);

			$this->wpCustomizeManager->add_setting(
				$fullSettingId,
				$config
			);

			return $fullSettingId;
		}

		/**
		 * @param string $controlId
		 * @param array $options
		 */
		private function setupSelectiveRefresh( $controlId, array $options = array() ) {
			if ( empty( $options['selective_refresh'] ) || ! is_array( $options['selective_refresh'] ) ) {
				return;
			}

			foreach ( $options['selective_refresh'] as $data ) {
				if ( empty( $data['selector'] ) ) {
					continue;
				}

				$partial  = ! empty( $data['partial'] ) ? $data['partial'] : null;
				$callback = isset( $data['callback'] ) && is_callable( $data['callback'] ) ? $data['callback'] : null;

				if ( ! $partial && ! $callback ) {
					continue;
				}

				if ( ! $callback ) {
					$util     = $this->util;
					$callback = function () use ( $partial, $util ) {
						$util->partial( $partial );
					};
				}

				$partialId = $controlId . '_' . preg_replace( "/\W/", '', $data['selector'] );

				$this->wpCustomizeManager->selective_refresh->add_partial( $partialId, array(
					'selector'            => $data['selector'],
					'settings'            => array( $controlId ),
					'render_callback'     => $callback,
					'container_inclusive' => ! empty( $data['container_inclusive'] )
				) );
			}
		}

		/**
		 * @param string $controlType
		 * @param string $persist persist or not the setting in db
		 *
		 * @return array|\closure
		 */
		private function getControlSanitizeCallback( $controlType, $persist ) {
			if ( $persist ) {
				$sanitizeMethod = method_exists( $this->dataSanitizer, $controlType ) ? $controlType : 'sanitize';

				return array( $this->dataSanitizer, $sanitizeMethod );
			}

			// if no persistence is required, the sanitize callback will always return empty value
			return function () {
				return '';
			};
		}
	}
}