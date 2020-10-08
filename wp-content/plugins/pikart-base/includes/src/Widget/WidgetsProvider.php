<?php

namespace Pikart\WpBase\Widget;

use Pikart\WpBase\Widget\Type\FlickrWidget;
use Pikart\WpBase\Widget\Type\InstagramWidget;
use Pikart\WpBase\Widget\Type\RecentProjectsWidget;
use Pikart\WpBase\Widget\Type\SocialLinksWidget;
use Pikart\WpBase\Widget\Type\TwitterWidget;
use WP_Widget;

if ( ! class_exists( __NAMESPACE__ . '\\WidgetsProvider' ) ) {

	/**
	 * Class WidgetsProvider
	 * @package Pikart\WpBase\Widget
	 *
	 * @since 1.1.0
	 */
	class WidgetsProvider {

		/**
		 * @var WP_Widget[]
		 */
		private $widgets = array();

		/**
		 * WidgetsProvider constructor.
		 *
		 * @param RecentProjectsWidget $recentProjectsWidget
		 * @param SocialLinksWidget $socialLinksWidget
		 * @param FlickrWidget $flickrWidget
		 * @param TwitterWidget $twitterWidget
		 * @param InstagramWidget $instagramWidget
		 */
		public function __construct(
			RecentProjectsWidget $recentProjectsWidget,
			SocialLinksWidget $socialLinksWidget,
			FlickrWidget $flickrWidget,
			TwitterWidget $twitterWidget,
			InstagramWidget $instagramWidget
		) {
			$this->widgets = func_get_args();
		}

		/**
		 * @return WP_Widget[]
		 */
		public function getWidgets() {
			return $this->widgets;
		}
	}
}