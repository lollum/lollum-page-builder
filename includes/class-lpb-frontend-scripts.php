<?php
/**
 * Load frontend assets.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Classes
 * @version  2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Frontend_Scripts' ) ) :

/**
 * LPB_Frontend_Scripts Class
 */
class LPB_Frontend_Scripts {
	/**
	 * Construct.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

		// Inline CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'mobile_breakpoint' ), 11 );
		add_action( 'wp_enqueue_scripts', array( $this, 'boxed_width' ), 11 );
	}

	/**
	 * Enqueue frontend scripts and styles.
	 */
	public function frontend_scripts() {
		if ( is_singular( lpb_page_builder_get_supported_cpts() ) && get_post_meta( get_the_ID(), '_lollum_page_builder_has_blocks', true ) ) {
			// Allow developers to use their own CSS
			if ( apply_filters( 'lollum_page_builder_enqueue_styles', true ) ) {
				wp_enqueue_style( 'lollum-page-builder', LPB_PLUGIN_URL . 'assets/css/lollum-page-builder.css', array(), LPB_VERSION );
				wp_enqueue_style( 'font-awesome', LPB_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), '4.6.3' );
				wp_enqueue_style( 'simple-line-icons', LPB_PLUGIN_URL . 'assets/css/simple-line-icons.min.css', array(), '2.2.4' );
			}

			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			// Load smartresize in a separate file to avoid double inclusions (it may be loaded by the theme)
			wp_register_script( 'smartresize', LPB_PLUGIN_URL . 'assets/js/lib/smartresize.min.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_script( 'lollum-page-builder', LPB_PLUGIN_URL . 'assets/js/frontend/lollum-page-builder' . $suffix . '.js', array( 'jquery', 'smartresize' ), LPB_VERSION, true );
		}
	}

	/**
	 * Mobile breakpoint.
	 */
	public function mobile_breakpoint() {
		$mobile_breakpoint = lpb_page_builder_get_option( 'mobile_breakpoint', '992' );

		$css = "
			@media (min-width: {$mobile_breakpoint}px) {
				.lpb-col-1,
				.lpb-col-2,
				.lpb-col-3,
				.lpb-col-4,
				.lpb-col-5,
				.lpb-col-6,
				.lpb-col-7,
				.lpb-col-8,
				.lpb-col-9,
				.lpb-col-10,
				.lpb-col-11 {
					float: left;
					padding-left: 15px;
					padding-right: 15px;
				}

				.lpb-col-1 {
					width: 8.333333333333332%;
				}

				.lpb-col-2 {
					width: 16.666666666666664%;
				}

				.lpb-col-3 {
					width: 25%;
				}

				.lpb-col-4 {
					width: 33.33333333333333%;
				}

				.lpb-col-5 {
					width: 41.66666666666667%;
				}

				.lpb-col-6 {
					width: 50%;
				}
				.lpb-col-7 {
					width: 58.333333333333336%;
				}

				.lpb-col-8 {
					width: 66.66666666666666%;
				}

				.lpb-col-9 {
					width: 75%;
				}

				.lpb-col-10 {
					width: 83.33333333333334%;
				}

				.lpb-col-11 {
					width: 91.66666666666666%;
				}

				.lpb-col-12 {
					width: 100%;
				}

				.lpb-section > .lpb-page-row:last-child .lpb-page-item {
					margin-bottom: 0;
				}

				.lpb-section.equal-height-yes .lpb-page-row .lpb-row {
					display: flex;
				}

				.lpb-section.equal-height-yes .lpb-page-row .lpb-row .lpb-page-item {
						flex: 1;
				}

				.lpb-section.equal-height-yes .lpb-page-row .lpb-row .lpb-item-column {
					height: 100%;
				}
			}
		";

		wp_add_inline_style( 'lollum-page-builder', $css );
	}

	/**
	 * Boxed content max width.
	 */
	public function boxed_width() {
		$boxed_width = lpb_page_builder_get_option( 'boxed_width', '570' );

		$css = "
			.lpb-section.row-stretch-boxed .lpb-page-row,
			.lpb-section.row-stretch-full-boxed .lpb-page-row {
			  max-width: {$boxed_width}px;
			}
		";

		wp_add_inline_style( 'lollum-page-builder', $css );
	}
}

endif;

return new LPB_Frontend_Scripts();
