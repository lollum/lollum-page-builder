<?php
/**
 * Print admin edit block.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$block = new LPB_Edit_Block( $block );
$data  = isset( $data ) ? $data : null;
$size  = $block->has_sizes() && isset( $data ) ? lpb_find_xml_value( $data, 'size' ) : $block->default_size();
?>

<div class="page-item item-<?php echo esc_attr( $block->id() ); ?> item-<?php echo esc_attr( $size ); ?>" data-type="<?php echo esc_attr( $block->id() ); ?>">

	<div class="page-item-header">
		<?php if ( $block->has_sizes() ) : ?>
			<div class="change-size">
				<span class="btn-change-size btn-plus"><i class="fa fa-plus"></i></span>
				<span class="btn-change-size btn-minus"><i class="fa fa-minus"></i></span>
			</div>
		<?php endif; ?>

		<h5 class="item-title handle"><span><?php echo esc_html( $block->name() ); ?></span></h5>

		<?php if ( $block->options() || $block->has_custom_id() ) : ?>
			<span class="edit-item-btn"><i class="fa fa-pencil"></i></span>
		<?php endif; ?>

		<?php if ( $block->is_clonable() ) : ?>
			<span class="btn-clone"><i class="fa fa-clone"></i></span>
		<?php endif; ?>

		<span class="delete-item"><i class="fa fa-close"></i></span>
	</div><!-- .page-item-header -->

	<div class="edit-item">
		<div class="header">
			<span class="edit-item-close-btn"><i class="fa fa-close"></i></span>
			<i class="item-icon <?php echo esc_attr( $block->icon() ); ?>"></i>
			<h5><?php echo esc_html( $block->name() ); ?><span><?php esc_html_e( 'Block settings', 'lollum-page-builder' ); ?></span></h5>
		</div>

		<div class="settings">

			<?php
			// print custom ID field if supported
			if ( $block->has_custom_id() ) {
				lpb_id_input( $data );
			}

			// print other specific settings
			if ( $options = $block->options() ) {
				foreach ( $options as $name => $field ) {
					lpb_block_setting( $name, $field, $data );
				}
			} ?>

			<input class="item-size xml" type="hidden" value="<?php echo esc_attr( $size ); ?>" data-type="size">
			<input class="item-xml" type="hidden" value="" <?php echo $selected ? 'name="item-xml[]"' : ''; ?>>

		</div><!-- .settings -->
	</div><!-- .edit-item -->

</div><!-- .page-item -->
