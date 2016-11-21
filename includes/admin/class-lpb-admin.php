<?php
/**
 * Admin functions.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Admin
 * @version  1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Admin' ) ) :

/**
 * LPB_Admin Class
 */
class LPB_Admin {

	/**
	 * Hook in methods
	 */
	public static function init() {
		add_action( 'wp_ajax_lpb_set_editor_type', array( __CLASS__, 'set_editor_type' ) );
		add_action( 'wp_ajax_lpb_get_editor_type', array( __CLASS__, 'get_editor_type' ) );
		add_action( 'wp_ajax_lpb_append_blocks', array( __CLASS__, 'append_blocks' ) );
	}

	/**
	 * Set the editor's type (save it in a meta box)
	 */
	public static function set_editor_type() {
		if ( isset( $_POST[ 'editor_type' ] ) && isset( $_POST[ 'post_id' ] ) && wp_verify_nonce( $_POST[ 'set_editor_type_nonce' ], 'lpb-set-editor-type-nonce' ) ) {

			$editor_type = $_POST[ 'editor_type' ] == 'page-builder' ? 'page-builder' : 'default-editor';
			update_post_meta( absint( $_POST[ 'post_id' ] ), '_lpb_editor_type', $editor_type );
		}

		die();
	}

	/**
	 * Get the editor's type (query the meta box)
	 */
	public static function get_editor_type() {
		if ( isset( $_POST[ 'post_id' ] ) ) {
			echo get_post_meta( absint( $_POST[ 'post_id' ] ), '_lpb_editor_type', true );
		}

		die();
	}

	/**
	 * Append copied blocks
	 */
	public static function append_blocks() {
		if ( isset( $_POST[ 'blocks_to_append' ] ) && wp_verify_nonce( $_POST[ 'append_blocks_nonce' ], 'lpb-append-blocks-nonce' ) ) {
			$blocks = lpb_get_blocks();

			if ( $blocks && is_array( $blocks ) ) {
				$xml = $_POST[ 'blocks_to_append' ];

				if ( $xml ) {
					$dom     = new DOMDocument();
					$success = $dom->loadXML( $xml );

					if ( $success ) {
						foreach ( $dom->documentElement->childNodes as $item ) {
							$tag = $item->nodeName;

							if ( in_array( $tag, $blocks ) ) {
								lpb_print_edit_block( $tag, true, $item );
							}
						}
					}
				}
			}
		}

		die();
	}
}

endif;

LPB_Admin::init();
