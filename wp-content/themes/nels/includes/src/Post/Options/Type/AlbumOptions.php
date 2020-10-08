<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\AlbumOptions' ) ) {

	/**
	 * Class AlbumOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class AlbumOptions extends CommonPostOptions {

		const TITLE = 'album_title';
		const SUBTITLE = 'album_subtitle';
		const DESCRIPTION = 'album_description';
		const BUTTON_LABEL = 'album_button_label';
		const BUTTON_LINK = 'album_button_link';
		const NEW_TAB = 'album_new_tab';
		const VIDEO_TYPE = 'album_video_type';
		const VIDEO_SOURCE = 'video_source';
		const VIDEO_UPLOADED_LINK = 'album_video_uploaded_link';
		const VIDEO_AUTOPLAY = 'album_video_autoplay';

		/**
		 * @return string
		 */
		public function getTitle() {
			return $this->getOption( self::TITLE );
		}

		/**
		 * @return string
		 */
		public function getSubtitle() {
			return $this->getOption( self::SUBTITLE );
		}

		/**
		 * @return string
		 */
		public function getDescription() {
			return $this->getOption( self::DESCRIPTION );
		}

		/**
		 * @return string
		 */
		public function getButtonLabel() {
			return $this->getOption( self::BUTTON_LABEL );
		}

		/**
		 * @return string
		 */
		public function getButtonLink() {
			return $this->getOption( self::BUTTON_LINK );
		}

		/**
		 * @return bool
		 */
		public function getNewTab() {
			return $this->getBoolOption( self::NEW_TAB );
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
			return $this->getVideoType() === 'online_service' && $this->getVideoSource();
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
		public function getVideoSource() {
			return $this->getOption( self::VIDEO_SOURCE );
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