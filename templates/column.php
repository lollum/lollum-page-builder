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

$bg      = $lpb_data[ 'bg-color' ] ? $lpb_data[ 'bg-color' ] : false;
$padding = $lpb_data[ 'column-padding' ] ? $lpb_data[ 'column-padding' ] : false;
$content = wp_kses_post( $lpb_data[ 'content' ] );
$style   = '';

if ( $bg || $padding ) {
	$style = 'style="';

	if ( $bg ) {
		$style .=  'background-color:' . esc_attr( $bg ) . ';';
	}

	if ( $padding ) {
		$style .=  'padding:' . esc_attr( $padding ) . ';';
	}

	$style .= '"';
}
?>

<div class="lpb-item-column" <?php echo $style; // WPCS: XSS ok, sanitization ok. ?>>
	<div class="lpb-item-content"><?php echo do_shortcode( wpautop( $content ) ); ?></div>
</div>
