<?php

namespace Pikart\Nels\Widgets;

use Pikart\WpThemeCore\Widget\WidgetFilterName;

if ( ! class_exists( __NAMESPACE__ . '\\WidgetsInitializer' ) ) {

	/**
	 * Class WidgetsInitializer
	 * @package Pikart\Nels\Widgets
	 */
	class WidgetsInitializer {

		/**
		 * @var RecentPostsCustomWidget
		 */
		private $recentPostsCustomWidget;

		/**
		 * @var RecentCommentsCustomWidget
		 */
		private $recentCommentsCustomWidget;

		/**
		 * WidgetsInitializer constructor.
		 *
		 * @param RecentPostsCustomWidget $recentPostsCustomWidget
		 * @param RecentCommentsCustomWidget $recentCommentsCustomWidget
		 */
		public function __construct(
			RecentPostsCustomWidget $recentPostsCustomWidget, RecentCommentsCustomWidget $recentCommentsCustomWidget
		) {
			$this->recentPostsCustomWidget    = $recentPostsCustomWidget;
			$this->recentCommentsCustomWidget = $recentCommentsCustomWidget;
		}

		public function init() {
			$recentPostsCustomWidget    = $this->recentPostsCustomWidget;
			$recentCommentsCustomWidget = $this->recentCommentsCustomWidget;

			add_filter( WidgetFilterName::widgetList(), function ( $widgets ) use (
				$recentPostsCustomWidget, $recentCommentsCustomWidget
			) {
				$widgets[] = $recentPostsCustomWidget;
				$widgets[] = $recentCommentsCustomWidget;

				return $widgets;
			} );
		}
	}
}