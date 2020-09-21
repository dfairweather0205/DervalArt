<?php

namespace Pikart\WpThemeCore\OptionsPages;

use Pikart\WpThemeCore\Common\Util;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsMenuPageGenericRegister' ) ) {

	/**
	 * Class OptionsMenuPageGenericRegister
	 * @package Pikart\WpThemeCore\OptionsPages
	 */
	abstract class OptionsMenuPageGenericRegister {

		const DEFAULT_MENU_ITEM_CAPABILITY = 'manage_options';

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * OptionsMenuPageRegister constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
		}

		/**
		 * @param $page
		 */
		public function register( array $page ) {
			if ( ! empty( $page['menu_parent_id'] ) ) {
				$this->addSubMenuPage( $page );
			} else {
				$this->addMenuPage( $page );
			}
		}

		/**
		 * @return string
		 */
		abstract protected function getAddMenuPageWpCallbackName();

		/**
		 * @return string
		 */
		abstract protected function getAddSubMenuPageWpCallbackName();

		/**
		 * @param array $page
		 */
		private function addSubMenuPage( array $page ) {
			$addSubMenuPageWpCallbackName = $this->getAddSubMenuPageWpCallbackName();

			$addSubMenuPageWpCallbackName(
				$page['menu_parent_id'],
				$page['title_tag_text'],
				$page['menu_title'],
				$this->getCapability( $page ),
				$page['id'],
				$this->getCallback( $page )
			);
		}

		/**
		 * @param $page
		 */
		private function addMenuPage( $page ) {
			$addMenuPageWpCallbackName = $this->getAddMenuPageWpCallbackName();

			$addMenuPageWpCallbackName(
				$page['title_tag_text'],
				$page['menu_title'],
				$this->getCapability( $page ),
				$page['id'],
				$this->getCallback( $page ),
				$this->getIconUrl( $page ),
				$this->getPosition( $page )
			);
		}

		/**
		 * @param array $page
		 *
		 * @return \Closure
		 */
		private function getCallback( array $page ) {
			$util = $this->util;

			return function () use ( $page, $util ) {
				if ( isset( $page['callback'] ) && is_callable( $page['callback'] ) ) {
					$page['callback'] ( $page );

					return;
				}

				if ( ! empty( $page['theme_partial'] ) ) {
					set_query_var( $page['partial_data_var'], $page );
					$util->partial( $page['theme_partial'] );

					return;
				}

				if ( ! empty( $page['plugin_partial'] ) ) {
					set_query_var( $page['partial_data_var'], $page );
					$util->pluginPartial( $page['plugin_base_dir'], $page['plugin_partial'] );
				}
			};
		}

		/**
		 * @param array $page
		 *
		 * @return string
		 */
		private function getIconUrl( array $page ) {
			return $this->getDataValue( $page, 'icon_url' );
		}

		/**
		 * @param array $page
		 *
		 * @return string
		 */
		private function getPosition( array $page ) {
			return $this->getDataValue( $page, 'position', null );
		}

		/**
		 * @param array $page
		 *
		 * @return string
		 */
		private function getCapability( array $page ) {
			return $this->getDataValue( $page, 'capability', self::DEFAULT_MENU_ITEM_CAPABILITY );
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