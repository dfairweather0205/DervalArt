<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\PageOptions' ) ) {

	/**
	 * Class PageOptions
	 * @package Pikart\Nels\Post\Options
	 */
	class PageOptions extends CommonPostOptions {

		const HERO_HEADER = 'page_hero_header';

		/**
		 * @return string
		 */
		public function getHeroHeader() {
			return $this->getOption( self::HERO_HEADER );
		}
	}
}