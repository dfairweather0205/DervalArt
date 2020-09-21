<?php

namespace Pikart\Nels\Post\Options\Type;

if ( ! class_exists( __NAMESPACE__ . '\\QuotePostOptions' ) ) {

	/**
	 * Class QuotePostOptions
	 * @package Pikart\Nels\Post\Options\Type
	 */
	class QuotePostOptions extends CommonPostOptions {

		const CONTENT = 'quote_content';
		const AUTHOR_NAME = 'quote_author_name';
		const AUTHOR_LINK = 'quote_author_link';
		const FEATURED_QUOTE = 'quote_featured_quote';

		/**
		 * @return string
		 */
		public function getContent() {
			return $this->getOption( self::CONTENT );
		}

		/**
		 * @return string
		 */
		public function getAuthorName() {
			return $this->getOption( self::AUTHOR_NAME );
		}

		/**
		 * @return string
		 */
		public function getAuthorLink() {
			return $this->getOption( self::AUTHOR_LINK );
		}

		/**
		 * @return bool
		 */
		public function isFeaturedQuote() {
			return $this->getBoolOption( self::FEATURED_QUOTE );
		}
	}
}