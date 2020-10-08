<?php

namespace Pikart\WpBase\Shortcode;

use Pikart\WpBase\Shortcode\Type\AccordionShortcode;
use Pikart\WpBase\Shortcode\Type\AlbumShortcode;
use Pikart\WpBase\Shortcode\Type\ButtonShortcode;
use Pikart\WpBase\Shortcode\Type\ColumnsShortcode;
use Pikart\WpBase\Shortcode\Type\CustomContentShortcode;
use Pikart\WpBase\Shortcode\Type\DropcapShortcode;
use Pikart\WpBase\Shortcode\Type\HeadingShortcode;
use Pikart\WpBase\Shortcode\Type\HighlightShortcode;
use Pikart\WpBase\Shortcode\Type\IconShortcode;
use Pikart\WpBase\Shortcode\Type\MapShortcode;
use Pikart\WpBase\Shortcode\Type\ProductsShortcode;
use Pikart\WpBase\Shortcode\Type\ProgressBarShortcode;
use Pikart\WpBase\Shortcode\Type\ProjectsShortcode;
use Pikart\WpBase\Shortcode\Type\QuoteShortcode;
use Pikart\WpBase\Shortcode\Type\RowShortcode;
use Pikart\WpBase\Shortcode\Type\SeparatorShortcode;
use Pikart\WpBase\Shortcode\Type\SliderShortcode;
use Pikart\WpBase\Shortcode\Type\TabsShortcode;
use Pikart\WpBase\Shortcode\Type\TeamMemberShortcode;
use Pikart\WpBase\Shortcode\Type\TestimonialsShortcode;
use Pikart\WpBase\Shortcode\Type\WishlistShortcode;
use Pikart\WpCore\Shortcode\ShortcodeActionName;
use Pikart\WpCore\Shortcode\ShortcodeFilterName;
use Pikart\WpCore\Shortcode\Type\Shortcode;

if ( ! class_exists( __NAMESPACE__ . '\\ShortcodesProvider' ) ) {

	/**
	 * Class ShortcodesProvider
	 * @package Pikart\WpBase\Shortcode
	 */
	class ShortcodesProvider {

		/**
		 * @var Shortcode[]
		 *
		 * @since 1.1.0
		 */
		private $finalShortcodes = array();

		/**
		 * @var Shortcode[]
		 *
		 * @since 1.1.0
		 */
		private $initialShortcodes = array();

		/**
		 * ShortcodesProvider constructor.
		 *
		 * @param ButtonShortcode $buttonShortcode
		 * @param ColumnsShortcode $columnsShortcode
		 * @param HeadingShortcode $headingShortcode
		 * @param IconShortcode $iconShortcode
		 * @param ProgressBarShortcode $progressBarShortcode
		 * @param QuoteShortcode $quoteShortcode
		 * @param SeparatorShortcode $separatorShortcode
		 * @param SliderShortcode $sliderShortcode
		 * @param TeamMemberShortcode $teamMemberShortcode
		 * @param DropcapShortcode $dropcapShortcode
		 * @param HighlightShortcode $highlightShortcode
		 * @param CustomContentShortcode $customContentShortcode
		 * @param TabsShortcode $tabsShortcode
		 * @param AccordionShortcode $accordionShortcode
		 * @param TestimonialsShortcode $testimonialsShortcode
		 * @param MapShortcode $mapShortcode
		 * @param ProjectsShortcode $projectsShortcode
		 * @param RowShortcode $rowShortcode
		 * @param AlbumShortcode $albumShortcode
		 * @param ProductsShortcode $productsShortcode
		 * @param WishlistShortcode $wishlistShortcode
		 */
		public function __construct(
			ButtonShortcode $buttonShortcode,
			ColumnsShortcode $columnsShortcode,
			HeadingShortcode $headingShortcode,
			IconShortcode $iconShortcode,
			ProgressBarShortcode $progressBarShortcode,
			QuoteShortcode $quoteShortcode,
			SeparatorShortcode $separatorShortcode,
			SliderShortcode $sliderShortcode,
			TeamMemberShortcode $teamMemberShortcode,
			DropcapShortcode $dropcapShortcode,
			HighlightShortcode $highlightShortcode,
			CustomContentShortcode $customContentShortcode,
			TabsShortcode $tabsShortcode,
			AccordionShortcode $accordionShortcode,
			TestimonialsShortcode $testimonialsShortcode,
			MapShortcode $mapShortcode,
			ProjectsShortcode $projectsShortcode,
			RowShortcode $rowShortcode,
			AlbumShortcode $albumShortcode,
			ProductsShortcode $productsShortcode,
			WishlistShortcode $wishlistShortcode
		) {
			$this->initialShortcodes = func_get_args();
		}

		/**
		 * @return Shortcode[]
		 */
		public function getShortcodes() {
			if ( empty( $this->finalShortcodes ) ) {
				foreach ( $this->initialShortcodes as $shortcode ) {
					$this->addShortcode( $shortcode );
				}
			}

			return apply_filters( ShortcodeFilterName::shortcodeList(), $this->finalShortcodes );
		}

		/**
		 * @param Shortcode $shortcode
		 */
		public function addShortcode( Shortcode $shortcode ) {
			do_action( ShortcodeActionName::shortcode( $shortcode->getShortName() ), $shortcode );

			if ( $shortcode->isFinal() && $shortcode->enabled() ) {
				$this->finalShortcodes[ $shortcode->getName() ] = $shortcode;
			}
		}
	}
}