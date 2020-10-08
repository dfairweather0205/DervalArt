<?php

namespace Pikart\WpThemeCore\Shortcode\Type;

if ( ! interface_exists( __NAMESPACE__ . '\\Shortcode' ) ) {

	/**
	 * Interface Shortcode
	 * @package Pikart\WpThemeCore\Shortcode\Type
	 */
	interface Shortcode {

		/**
		 * @return string
		 */
		public function getName();

		/**
		 * @return string
		 */
		public function getShortName();

		/**
		 * where a shortcode is final or part of another shortcode,
		 * non-final examples: slide(part of slider), row (part of columns)
		 *
		 * @return bool
		 */
		public function isFinal();

		/**
		 * whether or not a shortocde is active
		 *
		 * @return bool
		 */
		public function enabled();

		/**
		 * enqueue all the resources(js,css...) necessary for the shortcode
		 */
		public function enqueueAssets();

		/**
		 * get shortcode attributes configuration
		 *
		 * @return array
		 */
		public function getAttributesConfig();

		/**
		 * @return bool is the shortcode is
		 * self-closing: [some_shortcode attributes] OR [some_shortcode attributes /]
		 * or not (enclosing): [some_shortcode attributes] content [/some_shortcode]
		 */
		public function isSelfClosing();

		/**
		 * returns all the children shortcodes (Ex: columns has column as child)
		 *
		 * @return Shortcode[]
		 */
		public function getChildrenShortcodes();

		/**
		 * @param array $data
		 */
		public function processTemplateData( array &$data );
	}
}
