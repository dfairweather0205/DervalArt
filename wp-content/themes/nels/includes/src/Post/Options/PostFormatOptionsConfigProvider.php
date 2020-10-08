<?php

namespace Pikart\Nels\Post\Options;


use Pikart\Nels\Post\Options\Config\Format\AsideFormatOptionsConfig;
use Pikart\Nels\Post\Options\Config\Format\AudioFormatOptionsConfig;
use Pikart\Nels\Post\Options\Config\Format\GalleryFormatOptionsConfig;
use Pikart\Nels\Post\Options\Config\Format\ImageFormatOptionsConfig;
use Pikart\Nels\Post\Options\Config\Format\LinkFormatOptionsConfig;
use Pikart\Nels\Post\Options\Config\Format\QuoteFormatOptionsConfig;
use Pikart\Nels\Post\Options\Config\Format\StandardFormatOptionsConfig;
use Pikart\Nels\Post\Options\Config\Format\VideoFormatOptionsConfig;
use Pikart\WpThemeCore\Post\Options\Config\Format\PostFormatOptionsConfig;

if ( ! class_exists( __NAMESPACE__ . '\\PostFormatOptionsConfigProvider' ) ) {

	/**
	 * Class PostFormatOptionsConfigProvider
	 * @package Pikart\Nels\Post\Options
	 */
	class PostFormatOptionsConfigProvider {

		/**
		 * @var PostFormatOptionsConfig[]
		 */
		private $postFormatOptionsConfigList = array();

		/**
		 * PostFormatOptionsConfigProvider constructor.
		 *
		 * @param GalleryFormatOptionsConfig $gallery
		 * @param LinkFormatOptionsConfig $link
		 * @param QuoteFormatOptionsConfig $quote
		 * @param AudioFormatOptionsConfig $audio
		 * @param VideoFormatOptionsConfig $video
		 * @param StandardFormatOptionsConfig $standard
		 * @param ImageFormatOptionsConfig $image
		 * @param AsideFormatOptionsConfig $aside
		 */
		public function __construct(
			GalleryFormatOptionsConfig $gallery, LinkFormatOptionsConfig $link, QuoteFormatOptionsConfig $quote,
			AudioFormatOptionsConfig $audio, VideoFormatOptionsConfig $video, StandardFormatOptionsConfig $standard,
			ImageFormatOptionsConfig $image, AsideFormatOptionsConfig $aside
		) {
			$this->postFormatOptionsConfigList = array_filter( array(
				$gallery,
				$link,
				$quote,
				$audio,
				$video,
				$standard,
				$image,
				$aside
			),
				function ( PostFormatOptionsConfig $format ) {
					return $format->enabled();
				}
			);
		}

		/**
		 * @return PostFormatOptionsConfig[]
		 */
		public function getPostFormatOptionsConfigList() {
			return $this->postFormatOptionsConfigList;
		}
	}
}