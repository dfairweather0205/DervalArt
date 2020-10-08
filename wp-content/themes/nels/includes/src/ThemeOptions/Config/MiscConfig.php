<?php

namespace Pikart\Nels\ThemeOptions\Config;

use Pikart\Nels\ThemeOptions\ThemeOption;

if ( ! class_exists( __NAMESPACE__ . '\MiscConfig' ) ) {

	/**
	 * Class MiscConfig
	 * @package Pikart\Nels\ThemeOptions\Config
	 */
	class MiscConfig extends GenericConfig {

		/**
		 * @return array
		 */
		public function getConfig() {
			$this->controlConfigBuilder
				->noInput( 'site_loading_animation_title' )
				->label( esc_html__( 'Site loading animation', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->select( ThemeOption::SITE_LOADING_ANIMATION )
				->defaultVal( 'ball_clip_rotate' )
				->description( esc_html__( '_type', 'nels' ) )
				->choices( array(
					'none'                => esc_html__( 'None', 'nels' ),
					'bounce'              => esc_html__( 'Bounce', 'nels' ),
					'pulse'               => esc_html__( 'Pulse', 'nels' ),
					'wave'                => esc_html__( 'Wave', 'nels' ),
					'ocean'               => esc_html__( 'Ocean', 'nels' ),
					'ball_pulse'          => esc_html__( 'Ball Pulse', 'nels' ),
					'ball_clip_rotate'    => esc_html__( 'Ball Clip Rotate', 'nels' ),
					'ball_grid_pulse'     => esc_html__( 'Ball Grid Pulse', 'nels' ),
					'ball_scale_multiple' => esc_html__( 'Ball Scale Multiple', 'nels' ),
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->noInput( 'parallax_speed_title' )
				->label( esc_html__( 'Parallax', 'nels' ) )
				// -------------------------------------------------------------------------------------------------- \\
				->number( ThemeOption::PARALLAX_SPEED )
				->defaultVal( 3 )
				->description( esc_html__( '_speed value', 'nels' ) )
				->inputAttributes( array(
					'min' => 1,
					'max' => 6,
				) )
				// -------------------------------------------------------------------------------------------------- \\
				->checkbox( ThemeOption::SCROLL_TOP_BUTTON )
				->defaultVal( 1 )
				->label( esc_html__( 'Scroll Top button', 'nels' ) )
				->description( esc_html__( '_it appears at the bottom of browser window', 'nels' ) );

			$this->configHelper->buildResetOptionsConfig( $this->controlConfigBuilder );

			return $this->configHelper->buildCopyParentThemeOptionsConfig( $this->controlConfigBuilder )->build();
		}
	}
}