<?php

namespace Pikart\WpBase\OptionsPages;

use Pikart\WpBase\Shop\ProductsCompare\ProductsCompareHelper;
use Pikart\WpBase\Shop\Wishlist\WishlistHelper;
use Pikart\WpCore\OptionsPages\ConfigBuilder\OptionsPagesConfigBuilder;
use Pikart\WpCore\OptionsPages\OptionsPagesFilterName;
use Pikart\WpCore\Post\Type\PostTypeSlug;

if ( ! class_exists( __NAMESPACE__ . '\\OptionsPagesConfigProvider' ) ) {

	/**
	 * Class OptionsPagesConfigProvider
	 * @package Pikart\WpBase\OptionsPages
	 */
	class OptionsPagesConfigProvider {

		/**
		 * @var OptionsPagesConfigBuilder
		 */
		private $builder;

		/**
		 * @var WishlistHelper
		 *
		 * @since 1.3.0
		 */
		private $wishlistHelper;

		/**
		 * @var ProductsCompareHelper
		 *
		 * @since 1.3.0
		 */
		private $productsCompareHelper;

		/**
		 * PluginOptionsConfigProvider constructor.
		 *
		 * @param OptionsPagesConfigBuilder $builder
		 * @param WishlistHelper $wishlistHelper
		 * @param ProductsCompareHelper $productsCompareHelper
		 */
		public function __construct(
			OptionsPagesConfigBuilder $builder,
			WishlistHelper $wishlistHelper,
			ProductsCompareHelper $productsCompareHelper
		) {
			$this->builder               = $builder;
			$this->wishlistHelper        = $wishlistHelper;
			$this->productsCompareHelper = $productsCompareHelper;
		}

		/**
		 * @return array
		 */
		public function getOptions() {
			return $this->builder
				->page( OptionsPage::PIKART_BASE )
				->title( esc_html__( 'Pikart Base Options', 'pikart-base' ) )
				->titleTagText( esc_html__( 'Pikart Base Options', 'pikart-base' ) )
				->menuTitle( esc_html__( 'Pikart Base', 'pikart-base' ) )
				->capability( 'manage_options' )
				->iconUrl( 'dashicons-admin-generic' )
				->pluginPartial( 'pikart-base-options', PIKART_BASE_PATH )
				->sections( $this->getPikartBaseSections() )
				->build();
		}

		/**
		 * @return array
		 */
		private function getPikartBaseSections() {
			return $this->builder
				->section( 'google_services' )
				->title( esc_html__( 'Google Services', 'pikart-base' ) )
				->description( esc_html__(
					'There are two types of Google Services that Pikart Base uses in order to enhance the existing '
					. 'theme features: Location and Analytics services. Each of them requires specific data from '
					. 'Google in order to make them working with actual theme.', 'pikart-base' ) )
				->controls( $this->getGoogleServicesControls() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'social_services' )
				->enabled( apply_filters( OptionsPagesFilterName::sectionEnabled(
					OptionsPage::PIKART_BASE, 'social_services' ), true ) )
				->title( esc_html__( 'Social Services', 'pikart-base' ) )
				->description( esc_html__(
					'Social Services — as the name already says it — are intended to connect and adapt actual theme to '
					. ' diverse social networks. There are two types of Social Services: Share and Likes.'
					, 'pikart-base' ) )
				->controls( $this->getSocialServicesControls() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'custom_social_profiles' )
				->enabled( apply_filters( OptionsPagesFilterName::sectionEnabled(
					OptionsPage::PIKART_BASE, 'custom_social_profiles' ), false ) )
				->title( esc_html__( 'Social Profiles', 'pikart-base' ) )
				->description( esc_html__(
					'Social Profiles — as the name already says it — are intended to connect and adapt actual theme to '
					. ' diverse social networks.'
					, 'pikart-base' ) )
				->controls( $this->getSocialProfilesControls() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'wishlist' )
				->enabled( $this->wishlistHelper->isWishlistAllowed() )
				->title( esc_html__( 'Wishlist', 'pikart-base' ) )
				->description( esc_html__( 'Wishlist is designed to enhance the shop features when WooCommerce Plugin '
				                           . 'is activated.', 'pikart-base' ) )
				->controls( $this->getWishlistControls() )
				// -------------------------------------------------------------------------------------------------- \\
				->section( 'products_compare' )
				->enabled( $this->productsCompareHelper->isProductsCompareAllowed() )
				->title( esc_html__( 'Products compare', 'pikart-base' ) )
				->description( esc_html__( 'Products compare is designed to enhance the shop features when WooCommerce '
				                           . 'Plugin is activated.', 'pikart-base' ) )
				->controls( $this->getProductsCompareControls() )
				->build();
		}

		private function getSocialProfilesControls() {
			$defaultSocialProfiles = 'facebook,twitter,pinterest,mail';
			$allSocialProfiles     = $defaultSocialProfiles . ',whatsapp,ok,vk,telegram';

			return $this->builder
				->getControlBuilder()
				->text( PageOption::CUSTOM_SOCIAL_PROFILES )
				->title( esc_html__( 'Social Share', 'pikart-base' ) )
				->defaultVal( $defaultSocialProfiles )
				->description( sprintf( '<p>' .
					esc_html__(
						'_add the social profiles, delimited by a single comma (no spaces), from the following list: %s',
						'pikart-base' ), '<i><u>' . $allSocialProfiles . '</u></i>' . '</p>'
				) )
				->placeholder( $defaultSocialProfiles )
				->build();
		}

		/**
		 * @return array
		 */
		private function getGoogleServicesControls() {
			return $this->builder
				->getControlBuilder()
				->galleryImage( PageOption::GOOGLE_MAPS_PIN_IMAGE )
				->enabled( apply_filters( OptionsPagesFilterName::settingEnabled(
					OptionsPage::PIKART_BASE, PageOption::GOOGLE_MAPS_PIN_IMAGE ), true ) )
				->title( esc_html__( 'Pin image', 'pikart-base' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->text( PageOption::GOOGLE_MAPS_API_KEY )
				->enabled( apply_filters( OptionsPagesFilterName::settingEnabled(
					OptionsPage::PIKART_BASE, PageOption::GOOGLE_MAPS_API_KEY ), true ) )
				->title( esc_html__( 'API Key', 'pikart-base' ) )
				->description( sprintf(
					'<p>%s.   <a href="%s" target="_blank">%s</a></p>',
					esc_html__( '_authenticate your site with API Key, in order to use Google Maps', 'pikart-base' ),
					'https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key',
					esc_html__( 'Get the key', 'pikart-base' )
				) )
				->text( PageOption::GOOGLE_ANALYTICS_TRACKING_ID )
				->title( esc_html__( 'Google Analytics Tracking ID', 'pikart-base' ) )
				->build();
		}

		/**
		 * @return array
		 */
		private function getSocialServicesControls() {
			$socialServices = 'facebook,twitter,pinterest_share,preferred,more';

			return $this->builder
				->getControlBuilder()
				->text( PageOption::SOCIAL_SHARE )
				->title( esc_html__( 'Social Share', 'pikart-base' ) )
				->defaultVal( $socialServices )
				->description( sprintf(
					'<p>%s <a href="https://www.addthis.com/services/list" target="_blank">%s</a></p><p>%s</p>'
					. '<p>%s <b><u>more</u></b> %s</p><p>%s <b><u>counter</u></b> %s</p><p>%s <b><u>preferred</u></b> %s </p>',
					esc_html__(
						'_add the share services, delimited by a single comma (no spaces). You can find the full list of services ',
						'pikart-base' ),
					esc_html__( 'here', 'pikart-base' ),
					esc_html__( 'Notes:', 'pikart-base' ),
					esc_html__( '&ndash; use the', 'pikart-base' ),
					esc_html__( 'tag to show the plus sign', 'pikart-base' ),
					esc_html__( '&ndash; use the', 'pikart-base' ),
					esc_html__( 'for a global share counter', 'pikart-base' ),
					esc_html__( '&ndash; use the', 'pikart-base' ),
					esc_html__( 'tag to show your visitors a personalized lists of buttons.', 'pikart-base' )
				) )
				->placeholder( $socialServices )
				// -------------------------------------------------------------------------------------------------- \\
				->multiCheckbox( PageOption::SOCIAL_SHARE_VISIBILITY )
				->title( esc_html__( 'Social Share Visibility', 'pikart-base' ) )
				->defaultVal( array(
					PostTypeSlug::POST,
					PostTypeSlug::PROJECT,
				) )
				->options( array(
					PostTypeSlug::POST    => esc_html__( 'Post', 'pikart-base' ),
					PostTypeSlug::PROJECT => esc_html__( 'Project', 'pikart-base' ),
					PostTypeSlug::PAGE    => esc_html__( 'Page', 'pikart-base' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->multiCheckbox( PageOption::LIKES_AREA_VISIBILITY )
				->title( esc_html__( 'Likes Area Visibility', 'pikart-base' ) )
				->defaultVal( array(
					PostTypeSlug::POST,
					PostTypeSlug::PROJECT,
				) )
				->options( array(
					PostTypeSlug::POST    => esc_html__( 'Post', 'pikart-base' ),
					PostTypeSlug::PROJECT => esc_html__( 'Project', 'pikart-base' ),
					PostTypeSlug::PAGE    => esc_html__( 'Page', 'pikart-base' ),
				) )
				->build();
		}

		/**
		 * @return array
		 * @since 1.3.0
		 *
		 */
		private function getWishlistControls() {
			return $this->builder
				->getControlBuilder()
				->checkbox( PageOption::WISHLIST_ENABLED )
				->title( esc_html__( 'Enabled', 'pikart-base' ) )
				->defaultVal( 1 )
				->select( PageOption::WISHLIST_PAGE )
				->title( esc_html__( 'Wishlist page', 'pikart-base' ) )
				->description( sprintf(
					'<p>%s</p>',
					esc_html__( '_be sure to select a page where the Wishlist shortcode is inserted',
						'pikart-base' )
				) )
				->options( $this->getPageList() )
				->build();
		}

		/**
		 * @return array
		 * @since 1.3.0
		 *
		 */
		private function getProductsCompareControls() {
			return $this->builder
				->getControlBuilder()
				->checkbox( PageOption::PRODUCTS_COMPARE_ENABLED )
				->title( esc_html__( 'Enabled', 'pikart-base' ) )
				->defaultVal( 1 )
				->build();
		}

		/**
		 * @return array
		 * @since 1.3.0
		 *
		 */
		private function getPageList() {
			$allPages = get_pages();
			$pageList = array( '' => esc_html__( 'None', 'pikart-base' ) );

			foreach ( $allPages as $page ) {
				$pageList[ $page->ID ] = get_the_title( $page );
			}

			return $pageList;
		}
	}
}