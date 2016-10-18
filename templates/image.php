<?php
/**
 * Image block.
 *
 * This template can be overridden by copying it to yourtheme/lollum-page-builder/image.php.
 *
 * @author  Lollum
 * @package Lollum_Page_Builder/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$image     = absint( $lpb_data[ 'image-id' ] );
$alignment = $lpb_data[ 'alignment' ];
$url       = $lpb_data[ 'image-url' ];
?>

<div class="lpb-item-image alignment-<?php echo esc_attr( $alignment ); ?>">
	<?php if ( $url ) : ?>
		<a href="<?php echo esc_url( $url ); ?>">
	<?php endif; ?>

	<?php echo wp_get_attachment_image( $image, 'full' ); ?>

	<?php if ( $url ) : ?>
		</a>
	<?php endif; ?>

</div>
