<?php

namespace Pikart\WpBase\Admin\Migration;

if ( ! class_exists( __NAMESPACE__ . '\MigrationSetup' ) ) {

	/**
	 * Class MigrationSetup
	 * @package Pikart\WpBase\Admin\Migration
	 *
	 * @since 1.5.3
	 */
	class MigrationSetup {

		/**
		 * @var WpImporterExtension
		 */
		private $importerExtension;

		/**
		 * @var PikartBaseOptionsMigrator
		 */
		private $pikartBaseOptionsMigrator;

		/**
		 * MigrationSetup constructor.
		 *
		 * @param WpImporterExtension $importerExtension
		 * @param PikartBaseOptionsMigrator $pikartBaseOptionsMigrator
		 */
		public function __construct(
			WpImporterExtension $importerExtension,
			PikartBaseOptionsMigrator $pikartBaseOptionsMigrator
		) {
			$this->importerExtension         = $importerExtension;
			$this->pikartBaseOptionsMigrator = $pikartBaseOptionsMigrator;
		}

		public function run() {
			$this->importerExtension->run();
			$this->pikartBaseOptionsMigrator->run();
			$this->registerAllPikartSidebarsDuringImport();
		}

		private function registerAllPikartSidebarsDuringImport() {
			add_filter( 'pt-ocdi/before_widgets_import_data', function ( $data ) {
				foreach ( $data as $sidebarId => $widgets ) {
					if ( strpos( $sidebarId, PIKART_THEME_SLUG ) === 0 ) {
						register_sidebar( array(
							'id' => $sidebarId
						) );
					}
				}

				return $data;
			} );
		}
	}
}