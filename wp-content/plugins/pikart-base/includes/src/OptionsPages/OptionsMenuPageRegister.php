<?php

namespace Pikart\WpBase\OptionsPages;

use Pikart\WpCore\OptionsPages\OptionsMenuPageGenericRegister;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsMenuPageRegister' ) ) {

	/**
	 * Class OptionsMenuPageRegister
	 * @package Pikart\WpBase\OptionsPages
	 */
	class OptionsMenuPageRegister extends OptionsMenuPageGenericRegister {

		/**
		 * @inheritdoc
		 */
		protected function getAddMenuPageWpCallbackName() {
			return 'add_menu_page';
		}

		/**
		 * @inheritdoc
		 */
		protected function getAddSubMenuPageWpCallbackName() {
			return 'add_submenu_pagel';
		}
	}
}