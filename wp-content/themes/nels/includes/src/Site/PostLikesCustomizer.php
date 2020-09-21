<?php

namespace Pikart\Nels\Site;

use Pikart\WpThemeCore\Post\PostFilterName;

if ( ! class_exists( __NAMESPACE__ . '\PostLikesCustomizer' ) ) {

	/**
	 * Class PostLikesCustomizer
	 * @package Pikart\Nels\Site
	 */
	class PostLikesCustomizer {

		public function customize() {
			add_filter( PostFilterName::postLikesNumberText(), function ( $nbLikes ) {
				return sprintf( esc_html( _n( '%s Like', '%s Likes', (int) $nbLikes, 'nels' ) ), (int) $nbLikes );
			} );
		}
	}

}