<?php
/**
 * Edit Block class.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Classes
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Edit_Block' ) ) :

/**
 * LPB_Edit_Block Class
 */
class LPB_Edit_Block {
	/**
	 * The raw block structure.
	 */
	private $config = array();

	/**
	 * The post ID.
	 */
	private $post_id = 0;

	/**
	 * Get things going
	 */
	public function __construct( $config ) {
		$this->config = $config;
		$this->post_id = get_the_ID();
	}

	/**
	 * Returns the ID of the block.
	 */
	public function id() {
		return isset( $this->config[ 'id' ] ) ? $this->config[ 'id' ] : '';
	}

	/**
	 * Returns the nice name of the block.
	 */
	public function name() {
		return isset( $this->config[ 'name' ] ) ? $this->config[ 'name' ] : '';
	}

	/**
	 * Returns the icon of the block.
	 */
	public function icon() {
		return isset( $this->config[ 'icon' ] ) ? $this->config[ 'icon' ] : '';
	}

	/**
	 * Returns the default size of the block.
	 */
	public function default_size() {
		return isset( $this->config[ 'default-size' ] ) ? $this->config[ 'default-size' ] : '';
	}

	/**
	 * Checks if the block can be resized.
	 */
	public function has_sizes() {
		return isset( $this->config[ 'sizes' ] ) ? true : false;
	}

	/**
	 * Returns the available sizes of the block.
	 */
	public function sizes() {
		return $this->has_sizes() ? $this->config[ 'sizes' ] : array();
	}

	/**
	 * Checks if the block can have a custom ID.
	 */
	public function has_custom_id() {
		return isset( $this->config[ 'custom-id' ] ) && $this->config[ 'custom-id' ] === false ? false : true;
	}

	/**
	 * Checks if the block can be cloned.
	 */
	public function is_clonable() {
		return isset( $this->config[ 'clonable' ] ) && $this->config[ 'clonable' ] === false ? false : true;
	}

	/**
	 * Returns the options of the block.
	 */
	public function options() {
		return isset( $this->config[ 'options' ] ) ? $this->config[ 'options' ] : false;
	}
}

endif;
