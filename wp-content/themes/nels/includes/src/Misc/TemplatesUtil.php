<?php

namespace Pikart\Nels\Misc;

use Pikart\Nels\Blog\Options\BlogOptionsLoader;
use Pikart\Nels\Post\Options\PostOptionsLoader;
use Pikart\Nels\Post\Options\Type\CommonPostOptions;
use Pikart\Nels\Post\Options\Type\ProjectOptions;
use Pikart\Nels\ThemeOptions\ThemeOption;
use Pikart\Nels\ThemeOptions\ThemeOptionsUtil;
use Pikart\WpThemeCore\Common\TemplatesCoreUtil;
use Pikart\WpThemeCore\Common\Util;
use Pikart\WpThemeCore\Shop\ShopUtil;
use WP_Post;

if ( ! class_exists( __NAMESPACE__ . '\\TemplatesUtil' ) ) {

	/**
	 * Class TemplatesUtil
	 * @package Pikart\Nels\Misc
	 */
	class TemplatesUtil extends TemplatesCoreUtil {

		/**
		 * @var ThemeOptionsUtil
		 */
		private $themeOptionsUtil;

		/**
		 * @var BlogOptionsLoader
		 */
		private $blogOptionsLoader;

		/**
		 * @var BreadcrumbsGenerator
		 */
		private $breadcrumbsGenerator;

		/**
		 * @var PostOptionsLoader
		 */
		private $postOptionsLoader;

		/**
		 * TemplatesUtil constructor.
		 *
		 * @param ThemeOptionsUtil $themeOptionsUtil
		 * @param BlogOptionsLoader $blogOptionsLoader
		 * @param Util $util
		 * @param BreadcrumbsGenerator $breadcrumbsGenerator
		 * @param PostOptionsLoader $postOptionsLoader
		 */
		public function __construct(
			ThemeOptionsUtil $themeOptionsUtil,
			BlogOptionsLoader $blogOptionsLoader,
			Util $util,
			BreadcrumbsGenerator $breadcrumbsGenerator,
			PostOptionsLoader $postOptionsLoader
		) {
			parent::__construct( $util );
			$this->themeOptionsUtil     = $themeOptionsUtil;
			$this->blogOptionsLoader    = $blogOptionsLoader;
			$this->breadcrumbsGenerator = $breadcrumbsGenerator;
			$this->postOptionsLoader    = $postOptionsLoader;
		}

		/**
		 * @param int $pageId
		 *
		 * @return string
		 */
		public function getBlogTemplateInnerMargins( $pageId = null ) {
			$columnsSpacing = $this->blogOptionsLoader->load( $pageId )->getColumnsSpacing();

			return sprintf( 'margin-right: %spx;', - $columnsSpacing );
		}

		/**
		 * @param bool $isSidebarEnabled
		 *
		 * @return string
		 */
		public function getContentFloat( $isSidebarEnabled ) {
			$contentSidebarPosition = $this->themeOptionsUtil->getOption( ThemeOption::CONTENT_SIDEBAR_POSITION );
			$contentPosition        = $contentSidebarPosition === 'left' ? 'right' : 'left';

			return $isSidebarEnabled ? sprintf( 'float: %s', $contentPosition ) : '';
		}

		/**
		 * @param bool $isSidebarEnabled
		 *
		 * @return string
		 */
		public function getContentCssClass( $isSidebarEnabled ) {
			return $isSidebarEnabled
				? sprintf( 'small-12 large-%s', $this->themeOptionsUtil->getMainSiteNbCols() ) : '';
		}

		public function generateBreadcrumbs() {
			if ( $this->isBreadcrumbsEnabled() ) {
				$this->breadcrumbsGenerator->generate();
			}
		}

		/**
		 * @return bool
		 */
		public function isBreadcrumbsEnabled() {
			$itemId = $this->getItemId();

			return $itemId
				? $this->postOptionsLoader->loadCommonPostOptions( $itemId )->isBreadcrumbsEnabled()
				: $this->themeOptionsUtil->isBreadcrumbsEnabled();
		}

		/**
		 * Due to the fact that we need a wrapper for center aligned images and for the ones with alignnone,
		 * we need to wrap the images without a caption. The images with captions already are wrapped by the figure tag
		 */
		public function addContentFilterToWrapAlignedImages() {
			$cssClasses = array(
				'aligncenter',
				'alignnone',
				'alignleft',
				'alignright'
			);

			//match all the images that are not in captions and that have the X class
			//when an image is wrapped by an anchor tag, match that too
			$pattern = sprintf(
				'~\[caption[^\]]*\].*\[\/caption\]|\s*(<p>)?\s*((?:<a[^>]*>)?\s*<img[^<]+class="[^"]*(%s)[^"]*[^>]*>\s*'
				. '(?:<\/a>)?)\s*(<\/p>)?~i',
				implode( '|', $cssClasses )
			);

			add_filter( 'the_content', function ( $content ) use ( $pattern ) {
				if ( ! is_singular() ) {
					return $content;
				}

				return preg_replace_callback( $pattern, function ( $matches ) {

					if ( count( $matches ) < 4 ) {
						return $matches[0];
					}

					$figureTag = sprintf( '<figure class="%s">%s</figure>', $matches[3], $matches[2] );

					// if both <p> and </p> are present, ignore them
					if ( ! empty( $matches[1] ) && ! empty( $matches[4] ) ) {
						return $figureTag;
					}

					$figureTag = $matches[1] . $figureTag;

					return empty( $matches[4] ) ? $figureTag : $figureTag . $matches[4];
				}, $content );
			} );
		}

		/**
		 * @return string
		 */
		public function getArchiveTitle() {
			if ( is_home() ) {
				$queriedObject = get_queried_object();

				if ( ! empty( $queriedObject->post_title ) ) {
					return $queriedObject->post_title;
				}

				return esc_html__( 'News', 'nels' );
			}

			if ( is_search() ) {
				return esc_html__( 'Search Results for: ', 'nels' ) . get_search_query();
			}

			if ( is_archive() ) {
				return get_the_archive_title();
			}

			return esc_html__( 'Archives', 'nels' );
		}

		/**
		 * @param int|WP_Post $post
		 *
		 * @return string
		 */
		public function getDayArchiveLink( $post = null ) {
			list( $year, $month, $day ) = explode( '-', get_the_date( 'Y-m-d', $post ) );

			return get_day_link( $year, $month, $day );
		}

		/**
		 * @param int $columnsSpacing
		 *
		 * @return string
		 */
		public function getColumnsSpacingCssClassForMobile( $columnsSpacing ) {
			if ( $columnsSpacing === 0 ) {
				return 'no-gutter';
			}

			if ( $columnsSpacing > 0 && $columnsSpacing <= 6 ) {
				return 'pixel-gutter';
			}

			if ( $columnsSpacing > 6 && $columnsSpacing <= 15 ) {
				return 'small-gutter';
			}

			if ( $columnsSpacing > 15 && $columnsSpacing <= 30 ) {
				return 'medium-gutter';
			}

			if ( $columnsSpacing > 30 ) {
				return 'large-gutter';
			}

			return 'medium-gutter';
		}

		/**
		 * @param int $nbColumns
		 * @param int $columnsSpacing
		 *
		 * @return string
		 */
		public function getArchiveItemsCssClasses( $nbColumns, $columnsSpacing ) {
			$nbColumns       = (int) $nbColumns;
			$nbColumnsMedium = 1;

			if ( $nbColumns === 3 || $nbColumns === 4 ) {
				$nbColumnsMedium = 2;
			} elseif ( $nbColumns > 4 ) {
				$nbColumnsMedium = 3;
			}

			return sprintf(
				'archive-items masonry-cards small-up-1 medium-up-%d large-up-%d %s',
				$nbColumnsMedium,
				$nbColumns,
				$this->getColumnsSpacingCssClassForMobile( $columnsSpacing ) );
		}

		/**
		 * @param CommonPostOptions $postOptions
		 *
		 * @return string
		 */
		public function getSiteHeaderTransparencyCssClass( $postOptions ) {
			$siteHeaderTransparencyClass = 'site-header--transparency';

			if ( $postOptions ) {
				return $postOptions->isSiteHeaderTransparency() || post_password_required()
					? $siteHeaderTransparencyClass : '';
			}

			return $this->themeOptionsUtil->getBoolOption( ThemeOption::CONTENT_SITE_HEADER_TRANSPARENCY )
				? $siteHeaderTransparencyClass : '';
		}

		/**
		 * @param CommonPostOptions $postOptions
		 *
		 * @return string
		 */
		public function getSiteHeaderColorSkinCssClass( $postOptions ) {
			$siteHeaderColorSkinClass = $this->themeOptionsUtil->getOption( ThemeOption::HEADER_COLOR_SKIN );

			if ( $postOptions ) {
				return $postOptions->isSiteHeaderTransparency() || post_password_required()
					? 'light' : $siteHeaderColorSkinClass;
			}

			return $this->themeOptionsUtil->getBoolOption( ThemeOption::CONTENT_SITE_HEADER_TRANSPARENCY )
				? 'light' : $siteHeaderColorSkinClass;
		}

		/**
		 * @param string $displayType
		 *
		 * @return string
		 */
		public function getArticlesCssClasses( $displayType ) {
			$postClasses = get_post_class( sprintf( 'card card--masonry card--%s column', $displayType ) );

			return join( ' ', $postClasses );
		}

		/**
		 * @return bool
		 */
		public function isBlogTemplate() {
			return is_page_template( 'templates/blog.php' );
		}

		/**
		 * @return string
		 */
		public function getBackgroundImageUrl() {
			$defaultBackgroundImageUrl = get_header_image();

			if ( is_singular() ) {
				return has_post_thumbnail() ? get_the_post_thumbnail_url() : $defaultBackgroundImageUrl;
			}

			if ( ShopUtil::isShop() ) {
				$shopPageId = ShopUtil::getShopPageId();

				return has_post_thumbnail( $shopPageId )
					? get_the_post_thumbnail_url( $shopPageId ) : $defaultBackgroundImageUrl;
			}

			if ( ShopUtil::isShopActivated() && is_product_category() ) {
				$category    = get_queried_object();
				$thumbnailId = get_term_meta( $category->term_id, 'thumbnail_id', true );

				return $thumbnailId
					? wp_get_attachment_image_url( $thumbnailId, 'full' ) : $defaultBackgroundImageUrl;
			}

			return $defaultBackgroundImageUrl;
		}

		public function loadCommentsTemplate() {
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
		}

		/**
		 * @return string
		 */
		public function getPartialElementType() {
			return str_ireplace( PIKART_SLUG . '-', '', get_post_type() );
		}

		/**
		 * @param ProjectOptions $projectOptions
		 *
		 * @return string
		 */
		public function getProjectGalleryInnerMargins( ProjectOptions $projectOptions ) {
			$columnsSpacing = $projectOptions->getColumnsSpacing();

			$innerMargins = sprintf( 'margin-right: %dpx;', - $columnsSpacing );

			if ( ! $projectOptions->getProjectHeaderFullWidth() ) {
				return $innerMargins;
			}

			switch ( $projectOptions->getProjectDetailsPosition() ) {
				case 'top':
				case 'bottom':
					return sprintf( 'margin-top: %1$dpx; margin-left: %1$dpx;', $columnsSpacing );
				case 'right':
					return sprintf( 'margin-right: %dpx; margin-left: %dpx;', - $columnsSpacing, $columnsSpacing );
				case 'left':
					return '';
			}

			return $innerMargins;
		}

		/**
		 * @param string $display
		 *
		 * @return bool
		 */
		public function isTransparencyAllowed( $display ) {
			return in_array( $display, array( 'fade', 'pinned' ) );
		}

		/**
		 * @param string $wrapText contains a string format, ex: <div>%s</div>
		 * @param string $content
		 *
		 * @return string
		 */
		public function wrapContent( $wrapText, $content ) {
			return empty( $content ) ? '' : sprintf( $wrapText, $content );
		}

		/**
		 * @param string $prefixClasses
		 *
		 * @return string
		 */
		public function getShopCardIconCssClasses( $prefixClasses ) {
			$shopDisplay = get_query_var( PIKART_SLUG . 'ShopDisplay' );

			if ( ! $shopDisplay ) {
				$shopDisplay = $this->themeOptionsUtil->getOption( ThemeOption::SHOP_DISPLAY );
			}

			return sprintf(
				'%s %s', $prefixClasses, in_array( $shopDisplay, array( 'default', 'plain' ) ) ? 'left' : 'bottom' );
		}

		/**
		 * @return int
		 */
		public function getItemId() {
			if ( is_singular() && ! is_attachment() ) {
				return get_the_ID();
			}

			return ShopUtil::isShop() ? ShopUtil::getShopPageId() : null;
		}

		/**
		 * @return int
		 */
		public function getTotalPages() {
			$wpQuery = $GLOBALS['wp_query'];

			return isset( $wpQuery->max_num_pages ) ? intval( $wpQuery->max_num_pages ) : 1;
		}

		/**
		 * @return int
		 */
		public function getCurrentPage() {
			return get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		}

		/**
		 * @param int|null $current
		 *
		 * @return bool
		 */
		public function isFirstPage( $current = null ) {
			$current = $current === null ? $this->getCurrentPage() : $current;

			return ! $current || $current <= 1;
		}

		/**
		 * @param  int|null $current
		 * @param int|null $total
		 *
		 * @return bool
		 */
		public function isLastPage( $current = null, $total = null ) {
			$current = $current === null ? $this->getCurrentPage() : $current;
			$total   = $total === null ? $this->getTotalPages() : $total;

			return $current && $current >= $total;
		}
	}
}