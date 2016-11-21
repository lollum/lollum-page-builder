<?php
/**
 * Load admin assets.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Admin
 * @version  2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Admin_Scripts' ) ) :

/**
 * LPB_Admin_Scripts Class
 */
class LPB_Admin_Scripts {
	/**
	 * Construct.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueue admin scripts and styles.
	 */
	public function admin_scripts( $hook ) {
		global $post;

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		if ( ( $hook == 'post-new.php' || $hook == 'post.php' ) && ( isset( $post->post_type ) && in_array( $post->post_type, lpb_page_builder_get_supported_cpts() ) ) ) {
			wp_enqueue_style( 'lollum-page-builder-admin', LPB_PLUGIN_URL . 'assets/css/lollum-page-builder-admin.css', array(), LPB_VERSION );
			wp_enqueue_style( 'font-awesome', LPB_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), '4.6.3' );
			wp_enqueue_style( 'simple-line-icons', LPB_PLUGIN_URL . 'assets/css/simple-line-icons.min.css', array(), '2.2.4' );

			wp_register_script( 'lollum-page-builder-editor', LPB_PLUGIN_URL . 'assets/js/admin/lollum-page-builder-editor' . $suffix . '.js', array( 'jquery' ), LPB_VERSION );

			wp_localize_script( 'lollum-page-builder-editor', 'lpb_vars',
				array(
					'ajaxurl'                     => admin_url( 'admin-ajax.php' ),
					'post_id'                     => absint( $post->ID ),
					'nonce'                       => wp_create_nonce( 'lpb-set-editor-type-nonce' ),
					'override_dialog_description' => esc_html__( 'Would you like to copy this editor\'s existing content and clear the page builder?', 'lollum-page-builder' ),
					'override_dialog_stay'        => esc_html__( 'Stay in WP editor', 'lollum-page-builder' ),
					'override_dialog_clear'       => esc_html__( 'Clear page builder', 'lollum-page-builder' ),
					'override_dialog_keep'        => esc_html__( 'Keep page builder and discard the content', 'lollum-page-builder' ),
					'page_builder_button'         => esc_html__( 'Page Builder', 'lollum-page-builder' ),
					'back_to_editor'              => esc_html__( 'Back to WP Editor', 'lollum-page-builder' ),
				)
			);

			wp_register_script( 'lollum-page-builder-admin', LPB_PLUGIN_URL . 'assets/js/admin/lollum-page-builder-admin' . $suffix . '.js', array( 'jquery', 'lollum-page-builder-editor' ), LPB_VERSION );

			wp_localize_script( 'lollum-page-builder-admin', 'lpb_admin_vars',
				array(
					'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
					'post_id'                  => absint( $post->ID ),
					'nonce'                    => wp_create_nonce( 'lpb-append-blocks-nonce' ),
                    'delete_block'             => esc_html__( 'Are you sure you want to remove this block?', 'lollum-page-builder' ),
                    'paste_blocks'             => esc_html__( 'Append blocks', 'lollum-page-builder' ),
                    'copy_blocks_description'  => esc_html__( 'To reuse these blocks in another page copy this value to the clipboard. Then use the "Paste blocks" button (in the other page) to import the data.', 'lollum-page-builder' ),
                    'paste_blocks_description' => esc_html__( 'To import the blocks of another page use the "Copy blocks" button (in the other page) and paste here the data.', 'lollum-page-builder' ),
				)
			);

			wp_enqueue_script( 'lollum-page-builder-admin' );

			// jquery-minicolors
			wp_enqueue_style( 'jquery-minicolors', LPB_PLUGIN_URL . 'assets/lib/minicolors/minicolors.css', array(), LPB_VERSION );
			wp_enqueue_script( 'jquery-minicolors', LPB_PLUGIN_URL . 'assets/lib/minicolors/minicolors.min.js', array( 'jquery' ), LPB_VERSION );
		}
	}

}

endif;

return new LPB_Admin_Scripts();
