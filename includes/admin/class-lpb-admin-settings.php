<?php
/**
 * Plugin Dashboard Page.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Admin
 * @version  1.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Admin_Settings' ) ) :

/**
 * LPB_Admin Class
 */
class LPB_Admin_Settings {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_filter( 'plugin_action_links_' . LPB_PLUGIN_SLUG, array( $this, 'add_settings_link' ) );
	}

	/**
	 * Add settings link
	 *
	 * @param array $links List of links on the plugin page
	 */
	public function add_settings_link( $links ) {
		$links[] = '<a href="' . esc_url( admin_url( 'options-general.php?page=lpb-options' ) ) . '">' . esc_html__( 'Settings', 'lollum-page-builder' ) . '</a>';
		return $links;
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		add_options_page(
			'Lollum Page Builder',
			'Lollum Page Builder Settings',
			'manage_options',
			'lpb-options',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		$this->options = get_option( 'lpb_options' );
		?>
		<div class="wrap">

			<h2><?php echo esc_html_e( 'Lollum Page Builder Settings', 'lollum-page-builder' ); ?> <a href="http://themeforest.net/user/lollum/portfolio?ref=lollum" class="add-new-h2" target="_blank">Browse Premium WordPress Themes</a></h2>

			<div class="welcome-panel">
				<h3>Premium WordPress Themes</h3>
				<p class="about-description">
					Are you looking for cool Premium WordPress Themes? <a href="http://lollum.com" target="_blank">Lollum</a> provides premium and affordable WordPress themes for any kind of website.
				</p>

				<p><a href="http://themeforest.net/user/lollum/portfolio?ref=lollum" target="_blank" class="button-primary">Browse Premium Themes</a></p>
			</div>

			<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields
				settings_fields( 'lpb_options_group' );
				do_settings_sections( 'lpb-options' );
				submit_button();
			?>
			</form>

		</div>
		<?php
	}

	/**
	 * Register and add settings
	 *
	 * @todo Make the code more modular using a generic setting call
	 *       instead of write each setting individually
	 */
	public function page_init() {
		register_setting(
			'lpb_options_group', // Option group
			'lpb_options', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'general_settings', // ID
			esc_html__( 'General Settings', 'lollum-page-builder' ), // Title
			array( $this, 'general_settings_info' ), // Callback
			'lpb-options' // Page
		);

		add_settings_field(
			'post_types', // ID
			esc_html__( 'Post Types', 'lollum-page-builder' ), // Title
			array( $this, 'setting_post_types' ), // Callback
			'lpb-options', // Page
			'general_settings' // Section
		);

		add_settings_field(
			'mobile_breakpoint', // ID
			esc_html__( 'Mobile Breakpoint', 'lollum-page-builder' ), // Title
			array( $this, 'setting_mobile_breakpoint' ), // Callback
			'lpb-options', // Page
			'general_settings' // Section
		);

		add_settings_field(
			'boxed_width', // ID
			esc_html__( 'Boxed Max Width', 'lollum-page-builder' ), // Title
			array( $this, 'setting_boxed_width' ), // Callback
			'lpb-options', // Page
			'general_settings' // Section
		);
	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();

		if ( isset( $input[ 'mobile_breakpoint' ] ) ) {
			$new_input[ 'mobile_breakpoint' ] = absint( $input[ 'mobile_breakpoint' ] );
		}

		if ( isset( $input[ 'boxed_width' ] ) ) {
			$new_input[ 'boxed_width' ] = absint( $input[ 'boxed_width' ] );
		}

		if ( isset( $input[ 'cpt' ] ) ) {
			foreach ( $input[ 'cpt' ] as $key => $value) {
				$new_input[ 'cpt' ][ $key ] = sanitize_text_field( $input[ 'cpt' ][ $key ] );
			}
		}

		return $new_input;
	}

	/**
	 * General settings info
	 */
	public function general_settings_info() {
		?>

		<p><?php esc_html_e( 'Here you can tweek the default options of Lollum Page Builder', 'lollum-page-builder' ); ?></p>
		<?php
	}

	/**
	 * Print mobile_breakpoint field
	 */
	public function setting_mobile_breakpoint() {
		$val = isset( $this->options[ 'mobile_breakpoint' ] ) ? $this->options[ 'mobile_breakpoint' ] : 992;
		?>

		<input type="number" class="small-text" id="mobile_breakpoint" name="lpb_options[mobile_breakpoint]" value="<?php echo esc_attr( $val ); ?>" /> px
		<p class="description"><?php echo esc_html_e( 'The grid system is stacked when the screen size is smaller than the value defined here (default 992px).', 'lollum-page-builder' ); ?></p>
		<?php
	}

	/**
	 * Print boxed_width field
	 */
	public function setting_boxed_width() {
		$val = isset( $this->options[ 'boxed_width' ] ) ? $this->options[ 'boxed_width' ] : 570;
		?>

		<input type="number" class="small-text" id="boxed_width" name="lpb_options[boxed_width]" value="<?php echo esc_attr( $val ); ?>" /> px
		<p class="description"><?php echo esc_html_e( 'The max width of the content when using a "Default row stretch and boxed content" or "Full row and boxed content".', 'lollum-page-builder' ); ?></p>
		<?php
	}

	/**
	 * Print post_types field
	 */
	public function setting_post_types() {
		$val = isset( $this->options[ 'cpt' ] ) ? $this->options[ 'cpt' ] : array( 'page' );
		$types = $this->get_post_types();
		?>

		<ul>
			<?php foreach ( $types as $type => $label ) :
				?>
				<li>
					<label>
						<input type="checkbox" name="lpb_options[cpt][]" value="<?php echo esc_html( $type ); ?>" <?php checked( in_array( $type, $val ) ); ?> />
						<?php echo esc_html( $label ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php
	}

	/**
	 * Get a post type array
	 */
	public function get_post_types() {
		$types = array_merge( array( 'page' => 'page', 'post' => 'post' ), get_post_types( array( '_builtin' => false ) ) );

		// Skip unwanted CPTs
		unset( $types[ 'room_reservation' ] );

		foreach ( $types as $type_id => $type ) {
			$type_object = get_post_type_object( $type_id );

			if ( ! $type_object->show_ui ) {
				unset( $types[ $type_id ] );
				continue;
			}

			$types[ $type_id ] = $type_object->label;
		}

		return $types;
	}
}

endif;

new LPB_Admin_Settings();
