<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\VideoPostOptions' ) ) {

	/**
	 * Class VideoPostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class VideoPostOptions extends MediaPostOptions {

		const FEATURED_VIDEO = 'video_featured_video';
		const POST_EXCERPT_ENABLED = 'video_post_excerpt_enabled';
		const VIDEO_TYPE = 'video_type';
		const SOURCE = 'video_source';
		const VIDEO_UPLOADED_LINK = 'video_uploaded_link';
		const VIDEO_AUTOPLAY = 'video_autoplay';

		/**
		 * @return bool
		 */
		public function isFeaturedVideo() {
			return $this->getBoolOption( self::FEATURED_VIDEO );
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
		public function getVideoType() {
			return $this->getOption( self::VIDEO_TYPE );
		}

		/**
		 * @return boolean
		 */
		public function isVideoTypeOnlineService() {
			return $this->getVideoType() === 'online_service' && $this->hasSource();
		}

		/**
		 * @return boolean
		 */
		public function isVideoTypeSelfHosted() {
			return $this->getVideoType() === 'self_hosted' && $this->getVideoUploadedLink();
		}

		/**
		 * @return string
		 */
		public function getSource() {
			return $this->getOption( self::SOURCE );
		}

		/**
		 * @return string
		 */
		public function getVideoUploadedLink() {
			return $this->getOption( self::VIDEO_UPLOADED_LINK );
		}

		/**
		 * @return bool
		 */
		public function getVideoAutoplay() {
			return $this->getBoolOption( self::VIDEO_AUTOPLAY );
		}
	}
}