<?php

namespace Pikart\Nels\Admin\Migration;

use Pikart\Nels\Post\Options\Type\AsidePostOptions;
use Pikart\Nels\Post\Options\Type\BlogPageOptions;
use Pikart\Nels\Post\Options\Type\PageOptions;
use Pikart\Nels\Post\Options\Type\ProductOptions;
use Pikart\Nels\Post\Options\Type\ProjectOptions;
use Pikart\WpThemeCore\Admin\Migration\MigrationFilterName;

if ( ! class_exists( __NAMESPACE__ . '\WpImporterSetup' ) ) {

	/**
	 * Class WpImporterSetup
	 * @package Pikart\Nels\Admin\Migration
	 *
	 * @since 1.0.3
	 */
	class WpImporterSetup {

		public function run() {
			add_filter( MigrationFilterName::metaFieldsWithShortcodes(), function ( $metaFields ) {
				$metaFields = array_merge( $metaFields, array(
					AsidePostOptions::HERO_HEADER,
					PageOptions::HERO_HEADER,
					ProjectOptions::HERO_HEADER,
					ProductOptions::HERO_HEADER,
					BlogPageOptions::ADDITIONAL_CONTENT,
					ProjectOptions::PROJECT_DESCRIPTION,
				) );

				return $metaFields;
			} );

			add_filter( MigrationFilterName::metaFieldsWithTermIds(), function ( $metaFields ) {
				$metaFields = array_merge( $metaFields, array(
					BlogPageOptions::POST_CATEGORY_IDS,
					BlogPageOptions::POST_TAG_IDS,
				) );

				return $metaFields;
			} );
		}
	}
}