<?php
/**
 * Core functions.
 *
 * @author   Lollum
 * @category Core
 * @package  Lollum_Page_Builder/Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'lpb_get_view' ) ) :
/**
 * Include an admin view and pass an (optional) array.
 */
function lpb_get_view( $path, $args = array() ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}

	include( $path );
}
endif;

if ( ! function_exists( 'lpb_get_template_part' ) ) :
/**
 * Get template part.
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 */
function lpb_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Look in yourtheme/slug-name.php and yourtheme/lollum-page-builder/slug-name.php
	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", LPB()->template_path() . "{$slug}-{$name}.php" ) );
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( LPB()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
		$template = LPB()->plugin_path() . "/templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/lollum-page-builder/slug.php
	if ( ! $template ) {
		$template = locate_template( array( "{$slug}.php", LPB()->template_path() . "{$slug}.php" ) );
	}

	if ( $template ) {
		load_template( $template, false );
	}
}
endif;

if ( ! function_exists( 'lpb_get_template' ) ) :
/**
 * Get other templates passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 */
function lpb_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}

	$located = lpb_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '1.0.0' );
		return;
	}

	include( $located );
}
endif;

if ( ! function_exists( 'lpb_locate_template' ) ) :
/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function lpb_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) {
		$template_path = LPB()->template_path();
	}

	if ( ! $default_path ) {
		$default_path = LPB()->plugin_path() . '/templates/';
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found
	return $template;
}
endif;

if ( ! function_exists( 'lpb_page_builder_search' ) ) :
/**
 * Include page builder elements in search results.
 *
 */
function lpb_page_builder_search( $where ) {
	if ( ! is_admin() && is_search() && empty( $_GET[ 'post_type' ] ) ) {
		global $wpdb;
		$query = get_search_query();
		$query = $wpdb->esc_like( $query ) ;

		$where .= " OR {$wpdb->posts}.ID IN (";
		$where .= "SELECT {$wpdb->postmeta}.post_id ";
		$where .= "FROM {$wpdb->posts}, {$wpdb->postmeta} ";
		$where .= "WHERE {$wpdb->posts}.post_type = 'page' ";
		$where .= "AND {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id ";
		$where .= "AND {$wpdb->postmeta}.meta_key IN('page-xml-val') ";
		$where .= "AND {$wpdb->postmeta}.meta_value LIKE '%$query%' )";
	}
	return $where;
}
endif;
add_filter( 'posts_where', 'lpb_page_builder_search');

/**
 * Get an option from the "lpb_settings" array.
 * @return mixed
 */
function lpb_page_builder_get_option( $key = '', $default = false ) {
	$settings = get_option( 'lpb_options' );
	$value = isset( $settings[ $key ] ) ? $settings[ $key ] : $default;

	return $value;
}

/**
 * Returns a list of supported post types.
 */
function lpb_page_builder_get_supported_cpts() {
	return apply_filters( 'lollum_page_builder_supported_cpts', lpb_page_builder_get_option( 'cpt', array( 'page' ) ) );
}

/**
 * Add a custom class to the body tag when the page builder is active.
 */
function lpb_body_class( $classes ) {
	if ( is_singular( lpb_page_builder_get_supported_cpts() ) && get_post_meta( get_the_ID(), '_lollum_page_builder_has_blocks', true ) ) {
		$classes[] = 'lpb-active';
	}

	return $classes;
}
add_filter( 'body_class', 'lpb_body_class' );
