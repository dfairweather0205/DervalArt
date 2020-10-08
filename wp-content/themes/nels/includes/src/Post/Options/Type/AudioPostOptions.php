<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\AudioPostOptions' ) ) {

	/**
	 * Class AudioPostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class AudioPostOptions extends MediaPostOptions {

		const SOURCE = 'audio_source';
		const POST_EXCERPT_ENABLED = 'audio_post_excerpt_enabled';
		const FEATURED_AUDIO = 'audio_featured_audio';

		/**
		 * @return bool
		 */
		public function isFeaturedAudio() {
			return $this->getBoolOption( self::FEATURED_AUDIO );
		}

		/**
		 * @return bool
		 */
		public function isPostExcerptEnabled() {
			return $this->getBoolOption( self::POST_EXCERPT_ENABLED );
		}

		/**
		 * @return string
		 */
		public function getSource() {
			return $this->getOption( self::SOURCE );
		}
	}
}