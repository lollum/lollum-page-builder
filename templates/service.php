<?php
/**
 * Service block.
 *
 * This template can be overridden by copying it to yourtheme/lollum-page-builder/service.php.
 *
 * @author  Lollum
 * @package Lollum_Page_Builder/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$service_title = $lpb_data[ 'service-title' ];
$service_icon  = $lpb_data[ 'service-icon' ];
$service_url   = $lpb_data[ 'service-url' ];
$content       = wp_kses_post( $lpb_data[ 'content' ] );
?>

<div class="lpb-item-service">

	<?php if ( $service_icon ) : ?>
		<i class="<?php echo esc_attr( $service_icon ); ?>"></i>
	<?php endif; ?>

	<h4>
		<?php if ( $service_url ) : ?>
			<a href="<?php echo esc_url( $service_url ); ?>">
		<?php endif; ?>

		<?php echo esc_html( $service_title ); ?>

		<?php if ( $service_url ) : ?>
			</a>
		<?php endif; ?>
	</h4>

	<?php if ( $content ) : ?>
		<div class="lpb-item-content"><?php echo $content; ?></div>
	<?php endif; ?>

</div>
