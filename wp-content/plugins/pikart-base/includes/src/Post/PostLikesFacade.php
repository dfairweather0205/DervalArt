<?php

namespace Pikart\WpBase\Post;

use Pikart\WpBase\Common\AssetHandle;
use Pikart\WpBase\OptionsPages\OptionsPagesUtil;
use Pikart\WpCore\Common\Util;
use Pikart\WpCore\Post\PostFilterName;
use Pikart\WpCore\Post\PostUtil;
use Pikart\WpCore\Post\Type\PostTypeSlug;
use Pikart\WpCore\Shop\ShopUtil;

if ( ! class_exists( __NAMESPACE__ . '\\PostLikesFacade' ) ) {

	/**
	 * Class PostLikesFacade
	 * @package Pikart\WpCore\Post
	 */
	class PostLikesFacade {

		const POST_LIKES_IP_LIST_KEY = 'post_likes_ip_list';
		const NB_LIKES_KEY = 'nb_likes';

		/**
		 * @var Util
		 */
		private $util;

		/**
		 * @var PostUtil
		 */
		private $postUtil;

		/**
		 * @var OptionsPagesUtil
		 *
		 * @since 1.1.0
		 */
		private $optionsPagesUtil;

		/**
		 * PostLikesFacade constructor.
		 *
		 * @param Util $util
		 * @param PostUtil $postUtil
		 * @param OptionsPagesUtil $optionsPagesUtil
		 */
		public function __construct( Util $util, PostUtil $postUtil, OptionsPagesUtil $optionsPagesUtil ) {
			$this->util             = $util;
			$this->postUtil         = $postUtil;
			$this->optionsPagesUtil = $optionsPagesUtil;
		}

		public function setupPostLikes() {
			$this->registerLikePostAjaxCall();
			$this->enqueueScripts();
		}

		/**
		 * @param int $postId
		 *
		 * @return int
		 */
		public function getPostNbLikes( $postId ) {
			return (int) $this->postUtil->getOption( $postId, PostLikesFacade::NB_LIKES_KEY );
		}

		/**
		 * @param int $postId
		 *
		 * @return bool
		 */
		public function isPostLiked( $postId ) {
			$clientIp = $this->util->getClientIp();
			$ipList   = $this->postUtil->getOption( $postId, PostLikesFacade::POST_LIKES_IP_LIST_KEY );

			return is_array( $ipList ) && in_array( $clientIp, $ipList );
		}

		private function registerLikePostAjaxCall() {
			$likePostNonceAction = $this->getLikePostNonceAction();
			$util                = $this->util;
			$postUtil            = $this->postUtil;

			$ajaxCallback = function () use ( $likePostNonceAction, $util, $postUtil ) {

				$postId = filter_input( INPUT_POST, 'postId', FILTER_SANITIZE_NUMBER_INT );

				if ( ! check_ajax_referer( $likePostNonceAction, 'nonce', false ) || ! $postId ) {
					wp_send_json_error();
				}

				$ipList   = $postUtil->getOption( $postId, PostLikesFacade::POST_LIKES_IP_LIST_KEY );
				$clientIp = $util->getClientIp();

				if ( ! empty( $ipList ) && is_array( $ipList ) && in_array( $clientIp, $ipList ) ) {
					wp_send_json_success( array(
						'alreadyLiked' => true
					) );
				}

				if ( ! is_array( $ipList ) ) {
					$ipList = array();
				}

				$ipList[] = $clientIp;

				$postUtil->saveOption( $postId, PostLikesFacade::POST_LIKES_IP_LIST_KEY, $ipList );

				$nbLikes = (int) $postUtil->getOption( $postId, PostLikesFacade::NB_LIKES_KEY );
				$nbLikes ++;

				$postUtil->saveOption( $postId, PostLikesFacade::NB_LIKES_KEY, $nbLikes );

				wp_send_json_success( array(
						'nbLikes'     => $nbLikes,
						'nbLikesText' => apply_filters( PostFilterName::postLikesNumberText(), $nbLikes )
					)
				);
			};

			add_action( sprintf( 'wp_ajax_%s_like_post', PIKART_SLUG ), $ajaxCallback );
			add_action( sprintf( 'wp_ajax_nopriv_%s_like_post', PIKART_SLUG ), $ajaxCallback );
		}

		private function enqueueScripts() {
			$likePostNonceAction = $this->getLikePostNonceAction();
			$optionsPagesUtil    = $this->optionsPagesUtil;

			add_action( 'wp_enqueue_scripts', function () use ( $likePostNonceAction, $optionsPagesUtil ) {
				$enqueue = ( is_singular() && $optionsPagesUtil->isLikesAreaVisible( get_post_type() ) )
				           || ( ShopUtil::isShop() && $optionsPagesUtil->isLikesAreaVisible( PostTypeSlug::PAGE ) );

				if ( ! $enqueue ) {
					return;
				}

				wp_enqueue_script( AssetHandle::postLikes() );

				wp_localize_script( AssetHandle::postLikes(), PIKART_SLUG . 'PostLikesConfig', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( $likePostNonceAction )
				) );
			} );
		}

		private function getLikePostNonceAction() {
			return PIKART_SLUG . '_like_post';
		}
	}
}