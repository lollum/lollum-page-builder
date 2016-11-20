<?php
/**
 * Page Builder Meta Boxes.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Meta_Box_Blocks' ) ) :

/**
 * LPB_Meta_Box_Blocks Class
 */
class LPB_Meta_Box_Blocks {

	/**
	 * Output the metabox
	 */
	public static function output( $post ) {
		wp_nonce_field( 'lollum_page_builder_save_data', 'lollum_page_builder_data_nonce' );

		$blocks = lpb_get_blocks();

		if ( $blocks && is_array( $blocks ) ) {
			lpb_get_view( 'admin/views/html-blocks-selection.php', array( 'blocks' => $blocks ) );
			$thepostid = empty( $thepostid ) ? $post->ID : $thepostid;
			$xml       = get_post_meta( $thepostid, '_lollum_page_builder_xml_val', true );
			?>

			<div id="default-blocks">
				<?php foreach ( $blocks as $block ) {
					lpb_print_edit_block( $block );
				} ?>
			</div>

			<?php if ( class_exists( 'DOMDocument' ) ) : ?>

				<div id="page-builder-actions">
					<button type="button" id="copy-blocks" <?php echo $xml ? '' : 'disabled'; ?>><i class="fa fa-copy"></i><?php esc_html_e( 'Copy blocks', 'lollum-page-builder' ); ?></button>

					<button type="button" id="paste-blocks"><i class="fa fa-paste"></i><?php esc_html_e( 'Paste blocks', 'lollum-page-builder' ); ?></button>

					<button type="button" id="delete-all-blocks" <?php echo $xml ? '' : 'disabled'; ?>><i class="fa fa-remove"></i><?php esc_html_e( 'Delete all blocks', 'lollum-page-builder' ); ?></button>
				</div>

			<?php endif; ?>

			<div id="selected-blocks">
				<div id="grid-blocks">
					<?php if ( ! class_exists( 'DOMDocument' ) ) : ?>

						<span class="error"><?php esc_html_e( 'Please enable the DOM extension in your PHP configuration', 'lollum-page-builder' ); ?></span>

					<?php else : ?>

						<span class="empty <?php echo $xml ? 'hidden' : ''; ?>"><?php esc_html_e( 'Click above to add some blocks', 'lollum-page-builder' ); ?></span>

						<?php
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

					endif; ?>
				</div>
			</div>

			<input type="hidden" name="check-js" id="check-js" value="no-js">
		<?php
		}
	}
}

endif;
