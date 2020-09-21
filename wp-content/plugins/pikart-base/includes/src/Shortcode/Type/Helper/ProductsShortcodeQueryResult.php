<?php

namespace Pikart\WpBase\Shortcode\Type\Helper;

if ( ! class_exists( __NAMESPACE__ . '\\ProductsShortcodeQueryResult' ) ) {

	/**
	 * Class ProductsShortcodeQueryResult
	 * @package Pikart\WpBase\Shortcode\Type\Helper
	 *
	 * @since 1.3.0
	 */
	class ProductsShortcodeQueryResult {

		/**
		 * @var int[]
		 */
		private $itemIdList;

		/**
		 * @var int
		 */
		private $totalItems;

		/**
		 * @var int
		 */
		private $totalPages;

		/**
		 * @var int
		 */
		private $itemsPerPage;

		/**
		 * @var int
		 */
		private $currentPage;

		/**
		 * ProductsShortcodeQueryResult constructor.
		 *
		 * @param array $itemIdList
		 * @param int $totalItems
		 * @param int $totalPages
		 * @param int $itemsPerPage
		 * @param int $currentPage
		 */
		public function __construct(
			array $itemIdList = array(), $totalItems = 0, $totalPages = 0, $itemsPerPage = 0, $currentPage = 0
		) {
			$this->itemIdList   = $itemIdList;
			$this->totalItems   = $totalItems;
			$this->totalPages   = $totalPages;
			$this->itemsPerPage = $itemsPerPage;
			$this->currentPage  = $currentPage;
		}

		/**
		 * @return int[]
		 */
		public function getItemIdList() {
			return $this->itemIdList;
		}

		/**
		 * @return int
		 */
		public function getTotalItems() {
			return $this->totalItems;
		}

		/**
		 * @return int
		 */
		public function getTotalPages() {
			return $this->totalPages;
		}

		/**
		 * @return int
		 */
		public function getItemsPerPage() {
			return $this->itemsPerPage;
		}

		/**
		 * @return int
		 */
		public function getCurrentPage() {
			return $this->currentPage;
		}
	}
}