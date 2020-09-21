<?php

namespace Pikart\WpBase\Admin\Migration;

if ( ! class_exists( __NAMESPACE__ . '\\PikartBaseOptionsMigrator' ) ) {

	/**
	 * Class PikartBaseOptionsMigrator
	 * @package Pikart\WpBase\Admin\Migration
	 *
	 * @since 1.5.3
	 */
	class PikartBaseOptionsMigrator {

		/**
		 * @var PikartBaseOptionsMigratorHelper
		 */
		private $migratorHelper;

		/**
		 * PikartBaseOptionsMigrator constructor.
		 *
		 * @param PikartBaseOptionsMigratorHelper $migratorHelper
		 */
		public function __construct( PikartBaseOptionsMigratorHelper $migratorHelper ) {
			$this->migratorHelper = $migratorHelper;
		}

		public function run() {
			add_action( 'in_admin_footer', array( $this->migratorHelper, 'generateDownloadExportFileArea' ) );
			add_action( 'export_wp', array( $this->migratorHelper, 'downloadExportFile' ) );
			add_action( 'pt-ocdi/after_content_import_execution',
				array( $this->migratorHelper, 'importOptions' ), 99, 3 );
		}
	}
}