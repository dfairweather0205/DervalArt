<?php

namespace Pikart\Nels\Misc;

use Pikart\WpThemeCore\Post\Dal\CategoryRepository;
use Pikart\WpThemeCore\Post\Dal\ProjectCategoryRepository;
use Pikart\WpThemeCore\Post\PostUtil;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! class_exists( __NAMESPACE__ . '\\BreadcrumbsGenerator' ) ) {

	/**
	 * Class BreadcrumbsGenerator
	 * @package Pikart\Nels\Misc
	 */
	class BreadcrumbsGenerator {

		/**
		 * @var PostUtil
		 */
		private $postUtil;

		/**
		 * @var CategoryRepository
		 */
		private $categoryRepository;

		/**
		 * @var ProjectCategoryRepository
		 */
		private $projectCategoryRepository;

		/**
		 * BreadcrumbsGenerator constructor.
		 *
		 * @param PostUtil                  $postUtil
		 * @param CategoryRepository        $categoryRepository
		 * @param ProjectCategoryRepository $projectCategoryRepository
		 */
		public function __construct(
			PostUtil $postUtil,
			CategoryRepository $categoryRepository,
			ProjectCategoryRepository $projectCategoryRepository
		) {
			$this->postUtil                  = $postUtil;
			$this->categoryRepository        = $categoryRepository;
			$this->projectCategoryRepository = $projectCategoryRepository;
		}

		public function generate() {
			if ( is_front_page() ) {
				return;
			}

			echo '<nav class="nav nav--breadcrumbs"><ul class="breadcrumbs">';

			$this->printItems();

			echo '</ul></nav>';
		}

		private function printItems() {
			if ( ShopUtil::isShopActivated() ) {
				woocommerce_breadcrumb( array(
					'delimiter'   => '',
					'wrap_before' => '',
					'wrap_after'  => '',
				) );

				return;
			}

			$this->printLinkItem( home_url(), esc_html__( 'Home', 'nels' ) );

			$this->printIfSingle();
			$this->printIfCategory();
			$this->printIfPage();
			$this->printIfTag();
			$this->printIfPaged();
			$this->printIfSearch();
			$this->printIfDay();
			$this->printIfMonth();
			$this->printIfYear();
		}

		private function printIfSingle() {
			if ( is_single() ) {
				$this->printCategoriesForSingle();
				$this->printCurrentItem( get_the_title() );
			}
		}

		private function printIfCategory() {
			if ( is_category() || $this->projectCategoryRepository->isProjectCategory() ) {
				$this->printCategoryHierarchy( get_queried_object_id() );
			}
		}

		private function printIfPage() {
			if ( is_page() ) {
				$this->printPostAncestors();
				$this->printCurrentItem( get_the_title() );
			}
		}

		private function printIfTag() {
			if ( is_tag() ) {
				$this->printCurrentItem( single_tag_title( '', false ) );
			}
		}

		private function printIfPaged() {
			if ( is_paged() ) {
				$this->printCurrentItem( esc_html__( 'Archives', 'nels' ) );
			}
		}

		private function printIfSearch() {
			if ( is_search() ) {
				$this->printCurrentItem( esc_html__( 'Search Results', 'nels' ) );
			}
		}

		private function printIfDay() {
			if ( is_day() ) {
				$this->printCurrentItem( get_the_time( 'F j, Y' ) );
			}
		}

		private function printIfMonth() {
			if ( is_month() ) {
				$this->printCurrentItem( get_the_time( 'F, Y' ) );
			}
		}

		private function printIfYear() {
			if ( is_year() ) {
				$this->printCurrentItem( get_the_time( 'Y' ) );
			}
		}

		private function printLinkItem( $link, $title ) {
			printf(
				'<li><a href="%s" title="%s">%s</a></li>', esc_url( $link ), esc_attr( $title ), esc_html( $title ) );
		}

		private function printCurrentItem( $title ) {
			printf( '<li><span class="breadcrumb-current" title="%s">%s</span></li>',
				esc_attr( $title ), esc_html( $title ) );
		}

		private function printPostAncestors() {
			$post = get_post();

			if ( ! $post->post_parent ) {
				return;
			}

			$ancestors   = get_post_ancestors( $post );
			$nbAncestors = count( $ancestors );

			for ( $i = $nbAncestors - 1; $i >= 0; $i -- ) {
				$this->printLinkItem( get_permalink( $ancestors[ $i ] ), get_the_title( $ancestors[ $i ] ) );
			}
		}

		private function printCategoriesForSingle() {
			if ( ! $this->postUtil->postHasCategory() ) {
				return;
			}

			$post = get_post();

			$categories = get_categories( array(
				'number'     => 2,
				'orderby'    => 'count',
				'order'      => 'DESC',
				'object_ids' => $post->ID,
				'taxonomy'   => $this->postUtil->getPostPrimaryTaxonomySlug()
			) );

			$postCategory = count( $categories ) > 1 && $categories[0]->term_id === 1 ? $categories[1] : $categories[0];

			$categoryHierarchy = $this->categoryRepository->getCategoryHierarchy( $postCategory->term_id );

			foreach ( $categoryHierarchy as $category ) {
				$this->printLinkItem( get_category_link( $category ), $category->name );
			}
		}

		/**
		 * @param $categoryId
		 */
		private function printCategoryHierarchy( $categoryId ) {
			$category = get_category( $categoryId );
			$parents  = $this->categoryRepository->getCategoryHierarchy( $category->parent );

			foreach ( $parents as $parent ) {
				$this->printLinkItem( get_category_link( $parent ), $parent->name );
			}

			$this->printCurrentItem( $category->name );
		}
	}
}