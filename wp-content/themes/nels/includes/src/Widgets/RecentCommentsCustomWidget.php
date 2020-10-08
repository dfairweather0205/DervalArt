<?php

namespace Pikart\Nels\Widgets;

use Pikart\WpThemeCore\Common\Util;
use WP_Widget_Recent_Comments;

if ( ! class_exists( __NAMESPACE__ . '\\RecentCommentsCustomWidget' ) ) {

	/**
	 * Class RecentCommentsCustomWidget
	 * @package Pikart\Nels\Widgets
	 */
	class RecentCommentsCustomWidget extends WP_Widget_Recent_Comments {

		const COMMENTS_NB_DEFAULT = 5;

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

			$comments = $this->getComments( $instance );

			$this->printWidgetContent( $args, $instance, $comments );
		}

		/**
		 * @param array $args
		 * @param array $instance
		 * @param array $comments
		 */
		private function printWidgetContent( $args, $instance, $comments ) {
			$html = '';

			if ( is_array( $comments ) && $comments ) {

				$this->updatePostsCache( $comments );

				foreach ( (array) $comments as $comment ) {
					$html .= $this->generateCommentRow( $comment );
				}
			}

			printf(
				'%s%s<ul id="recentcomments">%s</ul>%s',
				$args['before_widget'],
				$this->generateTitle( $args, $instance ),
				$html,
				$args['after_widget'] );
		}

		/**
		 * @param array $instance
		 *
		 * @return int
		 */
		private function getCommentsNumber( $instance ) {
			$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : self::COMMENTS_NB_DEFAULT;

			return $number ? $number : self::COMMENTS_NB_DEFAULT;
		}

		/**
		 * @param array $args
		 * @param array $instance
		 *
		 * @return string
		 */
		private function generateTitle( $args, $instance ) {
			$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Comments', 'nels' );

			$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			return $title ? $args['before_title'] . $title . $args['after_title'] : '';
		}

		/**
		 * @param array $instance
		 *
		 * @return array|int
		 */
		private function getComments( $instance ) {
			return get_comments( apply_filters( 'widget_comments_args', array(
				'number'      => $this->getCommentsNumber( $instance ),
				'status'      => 'approve',
				'post_status' => 'publish'
			) ) );
		}

		/**
		 * @param array $comments
		 */
		private function updatePostsCache( $comments ) {
			$postIds = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $postIds, strpos( get_option( 'permalink_structure' ), '%category%' ), false );
		}

		/**
		 * @param $comment
		 *
		 * @return string
		 */
		private function generateCommentRow( $comment ) {
			set_query_var( 'recentCommentsComment', $comment );

			ob_start();
			$this->util->partial( 'widgets/recent-comments/comment-row' );

			return ob_get_clean();
		}
	}
}
