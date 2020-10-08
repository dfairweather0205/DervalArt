<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\AsidePostOptions' ) ) {

	/**
	 * Class AsidePostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class AsidePostOptions extends CommonPostOptions {

		const HERO_HEADER = 'aside_hero_header';
		const POST_EXCERPT_ENABLED = 'aside_post_excerpt_enabled';

		/**
		 * @return string
		 */
		public function getHeroHeader() {
			return $this->getOption( self::HERO_HEADER );
		}

		/**
		 * @return bool
		 */
		public function isPostExcerptEnabled() {
			return $this->getBoolOption( self::POST_EXCERPT_ENABLED );
		}
	}
}