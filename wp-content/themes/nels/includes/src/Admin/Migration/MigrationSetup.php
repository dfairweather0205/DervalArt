<?php

namespace Pikart\Nels\Admin\Migration;

if ( ! class_exists( __NAMESPACE__ . '\MigrationSetup' ) ) {

	/**
	 * Class MigrationSetup
	 * @package Pikart\Nels\Admin\Migration
	 */
	class MigrationSetup {

		/**
		 * @var OneClickDemoImportSetup
		 */
		private $oneClickDemoImportSetup;

		/**
		 * @var WpImporterSetup
		 */
		private $wpImporterSetup;

		/**
		 * MigrationSetup constructor.
		 *
		 * @param OneClickDemoImportSetup $oneClickDemoImportSetup
		 * @param WpImporterSetup $wpImporterSetup
		 */
		public function __construct(
			OneClickDemoImportSetup $oneClickDemoImportSetup,
			WpImporterSetup $wpImporterSetup
		) {
			$this->oneClickDemoImportSetup = $oneClickDemoImportSetup;
			$this->wpImporterSetup         = $wpImporterSetup;
		}

		public function run() {
			$this->runOneClickDemoImportSetup();
			$this->wpImporterSetup->run();
		}

		/**
		 * @since 1.0.2
		 */
		private function runOneClickDemoImportSetup() {
			add_action( 'pt-ocdi/after_import', array( $this->oneClickDemoImportSetup, 'updatePageOptions' ) );

			add_action( 'pt-ocdi/after_import', array(
				$this->oneClickDemoImportSetup,
				'updateNavigationMenuLocations'
			) );

			add_filter( 'pt-ocdi/import_files', array( $this->oneClickDemoImportSetup, 'getDemoFilesConfig' ) );

			// Disable the ProteusThemes branding notice after successful demo import
			add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
		}
	}
}