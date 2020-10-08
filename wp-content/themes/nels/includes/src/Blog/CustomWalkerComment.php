<?php

namespace Pikart\Nels\Blog;

use Pikart\WpThemeCore\Common\Util;
use Walker_Comment;
use WP_Comment;

if ( ! class_exists( __NAMESPACE__ . '\\CustomWalkerComment' ) ) {

	/**
	 * Class CustomWalkerComment
	 * @package Pikart\Nels\Blog
	 */
	class CustomWalkerComment extends Walker_Comment {

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * CustomWalkerComment constructor.
		 *
		 * @param Util $util
		 */
		public function __construct( Util $util ) {
			$this->util = $util;
		}

		/**
		 * @inheritdoc
		 */
		protected function ping( $comment, $depth, $args ) {
			$this->displayStartTag( $args, $comment );

			$this->setupPartialsVariables( $comment, $depth, $args );

			$this->util->partial( 'comments/walker/ping' );
		}

		/**
		 * @inheritdoc
		 */
		protected function comment( $comment, $depth, $args ) {
			$this->displayStartTag( $args, $comment, $this->has_children ? 'parent' : '' );

			$this->setupPartialsVariables( $comment, $depth, $args );

			$this->util->partial( 'comments/walker/comment' );
		}

		/**
		 * @inheritdoc
		 */
		protected function html5_comment( $comment, $depth, $args ) {
			$this->comment( $comment, $depth, $args );
		}

		/**
		 * @param array $args
		 * @param WP_Comment $comment
		 * @param string $additionalCommentClass
		 */
		private function displayStartTag( $args, $comment, $additionalCommentClass = '' ) {
			$tag          = 'div' === $args['style'] ? 'div' : 'li';
			$commentClass = join( ' ', get_comment_class( $additionalCommentClass, $comment ) );

			printf( '<%s id="comment-%d" class="%s">', $tag, esc_attr( get_comment_ID() ), esc_attr( $commentClass ) );
		}

		/**
		 * @param WP_Comment $comment
		 * @param int $depth
		 * @param array $args
		 */
		private function setupPartialsVariables( $comment, $depth, $args ) {
			set_query_var( 'walkerComment', $comment );
			set_query_var( 'walkerArgs', $args );
			set_query_var( 'walkerDepth', $depth );
		}
	}
}
