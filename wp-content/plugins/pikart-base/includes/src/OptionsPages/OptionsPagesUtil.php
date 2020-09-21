<?php

namespace Pikart\WpBase\OptionsPages;

use Pikart\WpCore\OptionsPages\OptionsPagesCoreUtil;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesUtil' ) ) {

	/**
	 * Class OptionsPagesUtil
	 * @package Pikart\WpBase\OptionsPages
	 */
	class OptionsPagesUtil {

		/**
		 * @var OptionsPagesCoreUtil
		 */
		private $optionsPagesCoreUtil;

		/**
		 * PluginOptionsUtil constructor.
		 *
		 * @param OptionsPagesCoreUtil $optionsPagesUtil
		 */
		public function __construct( OptionsPagesCoreUtil $optionsPagesUtil ) {
			$this->optionsPagesCoreUtil = $optionsPagesUtil;
		}

		/**
		 * @param $optionId
		 *
		 * @return mixed
		 */
		public function getPikartBaseOption( $optionId ) {
			return $this->optionsPagesCoreUtil->getOption( OptionsPage::PIKART_BASE, $optionId );
		}

		/**
		 * @return string
		 */
		public function getGoogleMapsPinImageUrl() {
			return wp_get_attachment_url( $this->getPikartBaseOption( PageOption::GOOGLE_MAPS_PIN_IMAGE ) );
		}

		/**
		 * @return array
		 */
		public function getSocialServices() {
			$preferred = 1;

			$getSocialService = function ( $service ) use ( &$preferred ) {
				$service = trim( $service );

				switch ( $service ) {
					case 'preferred':
						return sprintf( 'preferred_%d', $preferred ++ );
					case 'more':
						return 'compact';
					case 'counter':
						return 'counter addthis_counter';
				}

				return $service;
			};

			$socialServices = explode( ',', $this->getPikartBaseOption( PageOption::SOCIAL_SHARE ) );

			// array_filter removes empty strings
			return array_filter( array_map( $getSocialService, $socialServices ) );
		}

		/**
		 * @since 1.7.0
		 *
		 * @return array
		 */
		public function getCustomSocialProfiles() {
			return ( explode( ',', $this->getPikartBaseOption( PageOption::CUSTOM_SOCIAL_PROFILES ) ) );
		}

		/**
		 * @param string $value
		 *
		 * @return bool
		 */
		public function isSocialShareVisible( $value ) {
			return $this->multiPikartBaseOptionHasValue( PageOption::SOCIAL_SHARE_VISIBILITY, $value );
		}

		/**
		 * @param string $value
		 *
		 * @return bool
		 */
		public function isLikesAreaVisible( $value ) {
			return $this->multiPikartBaseOptionHasValue( PageOption::LIKES_AREA_VISIBILITY, $value );
		}

		/**
		 * @param string $optionId
		 * @param string $value
		 *
		 * @return bool
		 */
		public function multiPikartBaseOptionHasValue( $optionId, $value ) {
			return $this->optionsPagesCoreUtil->multiOptionHasValue( OptionsPage::PIKART_BASE, $optionId, $value );
		}

		/**
		 * @return bool
		 * @since 1.3.0
		 *
		 */
		public function isWishlistEnabled() {
			return (bool) $this->getPikartBaseOption( PageOption::WISHLIST_ENABLED );
		}

		/**
		 * @return int
		 * @since 1.3.0
		 *
		 */
		public function getWishlistPageId() {
			return (int) $this->getPikartBaseOption( PageOption::WISHLIST_PAGE );
		}

		/**
		 * @return bool
		 * @since 1.3.0
		 *
		 */
		public function isProductsCompareEnabled() {
			return (bool) $this->getPikartBaseOption( PageOption::PRODUCTS_COMPARE_ENABLED );
		}

		/**
		 * @param string $optionId
		 * @param mixed $optionValue
		 *
		 * @since 1.5.2
		 */
		public function updatePikartBasePageOption( $optionId, $optionValue ) {
			$this->optionsPagesCoreUtil->updateOption( OptionsPage::PIKART_BASE, $optionId, $optionValue );
		}
	}
}