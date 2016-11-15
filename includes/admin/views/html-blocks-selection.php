<?php
/**
 * Blocks button list.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php if ( class_exists( 'DOMDocument' ) ) : ?>
	<div id="blocks-selection">
		<ul>
			<?php foreach ( $blocks as $block ) : ?>
				<li><a href="#" class="block-icon" data-block="<?php echo esc_attr( $block ); ?>"><i class="<?php echo esc_attr( lpb_get_block_icon( $block ) ) ?>"></i><span class="block-name"><?php echo esc_html( lpb_get_block_name( $block ) ) ?></span><span class="block-description"><?php echo esc_html( lpb_get_block_description( $block ) ) ?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
