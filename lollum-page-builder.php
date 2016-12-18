<?php
/**
 * Plugin Name:       Lollum Page Builder
 * Plugin URI:        http://lollum.com/
 * Description:       A simple and lightweight page builder for developers.
 * Version:           2.3.1
 * Author:            Lollum
 * Author URI:        http://lollum.com/
 * Requires at least: 4.1
 * Tested up to:      4.7
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       lollum-page-builder
 * Domain Path:       languages
 *
 * @package  Lollum_Page_Builder
 * @category Core
 * @author   Lollum
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Lollum_Page_Builder' ) ) :

/**
 * Main Lollum_Page_Builder Class
 */
final class Lollum_Page_Builder {

	/**
	 * @var string
	 */
	public $version = '2.3.1';

	/**
	 * @var Lollum_Page_Builder The single instance of the class
	 */
	private static $_instance = null;

	/**
	 * Main Lollum_Page_Builder Instance
	 *
	 * Insures that only one instance of Lollum_Page_Builder exists in memory at any one time.
	 *
	 * @static
	 * @see LPB()
	 * @return Lollum_Page_Builder - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Cloning is forbidden.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'lollum-page-builder' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'lollum-page-builder' ), '1.0.0' );
	}

	/**
	 * Lollum_Page_Builder Constructor.
	 */
	public function __construct() {
		$this->setup_constants();
		$this->includes();
		$this->init_hooks();

		do_action( 'lollum_page_builder_loaded' );
	}

	/**
	 * Hook into actions and filters
	 */
	private function init_hooks() {
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @return void
	 */
	private function setup_constants() {
		// Plugin version
		if ( ! defined( 'LPB_VERSION' ) ) {
			define( 'LPB_VERSION', $this->version );
		}

		// Plugin Folder Path
		if ( ! defined( 'LPB_PLUGIN_DIR' ) ) {
			define( 'LPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL
		if ( ! defined( 'LPB_PLUGIN_URL' ) ) {
			define( 'LPB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File
		if ( ! defined( 'LPB_PLUGIN_FILE' ) ) {
			define( 'LPB_PLUGIN_FILE', __FILE__ );
		}

		// Plugin Slug
		if ( ! defined( 'LPB_PLUGIN_SLUG' ) ) {
			define( 'LPB_PLUGIN_SLUG',  plugin_basename( __FILE__ ) );
		}
	}

	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Include required files used in admin and on the frontend.
	 *
	 * @access private
	 * @return void
	 */
	private function includes() {
		include_once LPB_PLUGIN_DIR . 'includes/class-lpb-blocks.php';
		include_once LPB_PLUGIN_DIR . 'includes/lpb-core-functions.php';
		include_once LPB_PLUGIN_DIR . 'includes/lpb-block-functions.php';

		if ( is_admin() ) {
			include_once LPB_PLUGIN_DIR . 'includes/admin/class-lpb-admin.php';
			include_once LPB_PLUGIN_DIR . 'includes/admin/class-lpb-edit-block.php';
			include_once LPB_PLUGIN_DIR . 'includes/admin/class-lpb-metaboxes.php';
			include_once LPB_PLUGIN_DIR . 'includes/admin/class-lpb-admin-scripts.php';
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->frontend_includes();
		}
	}

	/**
	 * Include required frontend files.
	 */
	public function frontend_includes() {
		include_once LPB_PLUGIN_DIR . 'includes/class-lpb-print-blocks.php';
		include_once LPB_PLUGIN_DIR . 'includes/class-lpb-frontend-scripts.php';
	}

	/**
	 * Init Lollum_Page_Builder when WordPress initialises.
	 *
	 * @access public
	 * @return void
	 */
	public function init() {
		// Before init action
		do_action( 'before_lollum_page_builder_init' );

		// Set up localisation
		$this->load_textdomain();

		// Init action
		do_action( 'lollum_page_builder_init' );

		// Hide page builder settings if a theme declares the page builder support
		if ( ! current_theme_supports( 'lollum-page-builder-theme' ) ) {
			include_once LPB_PLUGIN_DIR . 'includes/admin/class-lpb-admin-settings.php';
		}
	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @return void
	 */
	public function load_textdomain() {
		// Set filter for plugin's languages directory
		$lollum_page_builder_lang_dir = dirname( plugin_basename( LPB_PLUGIN_FILE ) ) . '/languages/';

		// Traditional WordPress plugin locale filter
		$locale = apply_filters( 'plugin_locale', get_locale(), 'lollum-page-builder' );
		$mofile = sprintf( '%1$s-%2$s.mo', 'lollum-page-builder', $locale );

		// Setup paths to current locale file
		$mofile_local  = $lollum_page_builder_lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/lollum-page-builder/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/lollum-page-builder folder
			load_textdomain( 'lollum-page-builder', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/lollum-page-builder/languages/ folder
			load_textdomain( 'lollum-page-builder', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'lollum-page-builder', false, $lollum_page_builder_lang_dir );
		}
	}

	/**
	 * Get the plugin url.
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Get the template path.
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'lollum_page_builder_template_path', 'lollum-page-builder/' );
	}

	/**
	 * Get Ajax URL.
	 * @return string
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}
}

endif;

/**
 * Returns the main instance of LPB to prevent the need to use globals.
 *
 * @return Lollum_Page_Builder
 */
function LPB() {
	return Lollum_Page_Builder::instance();
}

// Get LPB Running
LPB();
