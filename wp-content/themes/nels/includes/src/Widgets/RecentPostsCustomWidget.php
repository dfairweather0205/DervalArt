<?php

namespace Pikart\Nels\Widgets;

use Pikart\WpThemeCore\Common\Util;
use WP_Query;
use WP_Widget_Recent_Posts;

if ( ! class_exists( __NAMESPACE__ . '\\RecentPostsCustomWidget' ) ) {

	/**
	 * Class RecentPostsCustomWidget
	 * @package Pikart\Nels\Widgets
	 */
	class RecentPostsCustomWidget extends WP_Widget_Recent_Posts {

		const POST_PER_PAGE_NB_DEFAULT = 5;
		const SHOW_DATE_DEFAULT = false;

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * RecentPostsCustomWidget constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			parent::__construct();
			$this->util = $util;
		}

		/**
		 * @inheritdoc
		 */
		public function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}

			$query = $this->query( $instance );

			if ( ! $query->have_posts() ) {
				return;
			}

			$this->generateContent( $args, $instance, $query );

			wp_reset_postdata();
		}

		private function generateContent( $args, $instance, WP_Query $query ) {
			$showDate = isset( $instance['show_date'] ) ? $instance['show_date'] : self::SHOW_DATE_DEFAULT;
			set_query_var( 'recentPostsShowDate', $showDate );

			echo wp_kses_post( $args['before_widget'] . $this->generateTitle( $args, $instance ) );
			echo '<ul class="widget_recent_entries__list">';

			while ( $query->have_posts() ) {
				$query->the_post();
				$this->util->partial( 'widgets/recent-posts/post-content' );
			}

			echo '</ul>';
			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * @param array $instance
		 *
		 * @return WP_Query
		 */
		private function query( $instance ) {
			return new WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $this->getPostsPerPageNumber( $instance ),
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true
			) ) );
		}

		private function getPostsPerPageNumber( $instance ) {
			$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : self::POST_PER_PAGE_NB_DEFAULT;

			return $number ? $number : self::POST_PER_PAGE_NB_DEFAULT;
		}

		/**
		 * @param array $args
		 * @param array $instance
		 *
		 * @return string
		 */
		private function generateTitle( $args, $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'nels' );

			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			return $title ? $args['before_title'] . $title . $args['after_title'] : '';
		}
	}
}
