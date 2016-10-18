<?php
/**
 * Revolution Slider block.
 *
 * This template can be overridden by copying it to yourtheme/lollum-page-builder/revslider.php.
 *
 * @author  Lollum
 * @package Lollum_Page_Builder/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slider = $lpb_data[ 'slider-alias' ];
?>

<div class="lpb-item-revslider>">
	<?php if ( shortcode_exists( 'rev_slider' ) ) {
		echo do_shortcode( '[rev_slider ' . $slider . ']' );
	} else {
		echo '<p>' . esc_html__( 'You need to install Revolution Slider to use this block', 'lollum-page-builder' ) . '</p>';
	} ?>
</div>
