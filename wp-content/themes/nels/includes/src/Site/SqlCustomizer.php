<?php

namespace Pikart\Nels\Site;

if ( ! class_exists( __NAMESPACE__ . '\SqlCustomizer' ) ) {

	/**
	 * Class SqlCustomizer
	 * @package Pikart\Nels\Site
	 */
	class SqlCustomizer {

		public function customize() {
			$this->changeAdjacentAttachmentSqlWhere();
		}

		private function changeAdjacentAttachmentSqlWhere() {
			$changeAdjacentAttachmentSqlWhere = function ( $sqlWhere, $inSameTerm, $excludedTerms, $taxonomy, $post ) {
				if ( 'attachment' !== $post->post_type ) {
					return $sqlWhere;
				}

				return str_replace( "p.post_status = 'publish'", "p.post_status = 'inherit'", $sqlWhere );
			};

			add_filter( 'get_previous_post_where', $changeAdjacentAttachmentSqlWhere, 10, 5 );
			add_filter( 'get_next_post_where', $changeAdjacentAttachmentSqlWhere, 10, 5 );
		}
	}
}