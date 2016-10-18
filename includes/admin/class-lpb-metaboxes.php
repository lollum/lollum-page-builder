<?php
/**
 * Page Builder Meta Boxes.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Admin
 * @version  1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Meta_Boxes' ) ) :

/**
 * LPB_Meta_Boxes Class
 */
class LPB_Meta_Boxes {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Actions
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 1 );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 10, 2 );

		$this->includes();
	}

	/**
	 * Include required files.
	 */
	private function includes() {
		include_once( 'class-lpb-meta-box-blocks.php' );
	}

	/**
	 * Add meta boxes
	 */
	public function add_meta_boxes() {
		// Pages
		add_meta_box( 'lollum-page-builder', esc_html__( 'Page Builder', 'lollum-page-builder' ), 'LPB_Meta_Box_Blocks::output', lpb_page_builder_get_supported_cpts(), 'normal', 'high' );
	}

	/**
	 * Save meta boxes
	 */
	public function save_meta_boxes( $post_id, $post ) {
		// Check the nonce
		if ( empty( $_POST[ 'lollum_page_builder_data_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'lollum_page_builder_data_nonce' ], 'lollum_page_builder_save_data' ) ) {
			return;
		}

		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if we are saving a supported post type
		if ( isset( $post->post_type ) && in_array( $post->post_type, lpb_page_builder_get_supported_cpts() ) ) {

			// Generate the XML string
			$xml_data = ''; // Will hold the XML string
			$xml      = isset( $_POST[ 'item-xml' ] ) ? $_POST[ 'item-xml' ] : '';
			$check_js = isset( $_POST[ 'check-js' ] ) ? $_POST[ 'check-js' ] : '';

			if ( $xml && is_array( $xml ) ) {
				foreach ( $xml as $key => $value ) {
					$xml_data .= $value;
				}
			}

			if ( $check_js == 'js' ) {
				if ( $xml_data ) {
					$xml_data = '<xml-tag>' . $xml_data . '</xml-tag>';

					update_post_meta( $post_id, '_lollum_page_builder_xml_val', $xml_data );
					update_post_meta( $post_id, '_lollum_page_builder_has_blocks', true );
				} else {
					delete_post_meta( $post_id, '_lollum_page_builder_xml_val' );
					delete_post_meta( $post_id, '_lollum_page_builder_has_blocks' );
				}
			}
		}
	}
}

endif;

new LPB_Meta_Boxes();
