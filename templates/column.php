<?php
/**
 * Column block.
 *
 * This template can be overridden by copying it to yourtheme/lollum-page-builder/column.php.
 *
 * @author  Lollum
 * @package Lollum_Page_Builder/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$transparent = $lpb_data[ 'transparent' ] == 'yes' ? 'transparent-yes' : 'transparent-no';
$content     = wp_kses_post( $lpb_data[ 'content' ] );
?>

<div class="lpb-item-column <?php echo esc_attr( $transparent ); ?>">
	<div class="lpb-item-content"><?php echo do_shortcode( wpautop( $content ) ); ?></div>
</div>
