<?php
/**
 * Print Blocks class.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Classes
 * @version 2.2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Print_Blocks' ) ) :

/**
 * LPB_Print_Blocks Class
 */
class LPB_Print_Blocks {
	public $full_size     = 0;
	public $full_section  = false;
	public $close_section = false;

	/**
	 * Construct.
	 */
	public function __construct() {
		add_filter( 'the_content', array( $this, 'get_page_builder_content' ), 20 );
	}

	public function get_page_builder_content( $content ) {
		global $post;

		$is_active = ( get_post_meta( $post->ID, '_lpb_editor_type', true ) == 'page-builder' ) ? true : false;

		if ( $is_active ) {
			ob_start();

			if ( ! class_exists( 'DOMDocument' ) ) {
				echo '<span class="error">' . esc_html__( 'Please enable the DOM extension in your PHP configuration', 'lollum-page-builder' ) . '</span>';
			} else {
				$blocks = lpb_get_blocks();
				$xml    = get_post_meta( $post->ID, '_lollum_page_builder_xml_val', true );

				if ( $xml && $blocks && is_array( $blocks ) ) {
					$dom     = new DOMDocument();
					$success = $dom->loadXML( $xml );

					if ( $success ) {
						$this->full_size = 0;

						foreach ( $dom->documentElement->childNodes as $item ) {
							$tag = $item->nodeName;

							if ( in_array( $tag, $blocks ) ) {
								$this->print_block( $item );
							}
						}

						if ( $dom->documentElement->childNodes->length > 0 ) {
							echo '</div><!-- /.lpb-row -->' . "\n";
							echo '</div><!-- /.lpb-container -->' . "\n";
							echo '</div><!-- /.lpb-page-row -->' . "\n\n";
							if ( $this->full_section ) {
								echo '</div><!-- /.lpb-section -->' . "\n\n";
								echo '<div class="lpb-clear-section"></div><!-- .lpb-clear-section -->' . "\n\n";
								$this->full_section = false;
							}
						}
					}
				}
			}

			$content = ob_get_clean();
		}

		return $content;
	}

	public function print_size( $args ) {
		$id              = isset ( $args[ 'id' ] ) ? 'id="' . esc_attr( $args[ 'id' ] ) . '"' : '';
		$class           = isset ( $args[ 'class' ] ) ? $args[ 'class' ] : '';
		$bg_image        = isset ( $args[ 'bg-image' ] ) ? $args[ 'bg-image' ] : false;
		$bg_color        = isset( $args[ 'bg-color' ] ) ? 'background-color:' . esc_attr( $args[ 'bg-color' ] ) . ';' : 'background-color:#ffffff;';
		$bg_x_position   = isset( $args[ 'bg-x-position' ] ) ? $args[ 'bg-x-position' ] : 'center';
		$bg_y_position   = isset( $args[ 'bg-y-position' ] ) ? $args[ 'bg-y-position' ] : 'center';
		$bg_repeat       = isset( $args[ 'bg-repeat' ] ) ? $args[ 'bg-repeat' ] : 'no-repeat';
		$bg_size         = isset( $args[ 'bg-size' ] ) ? $args[ 'bg-size' ] : 'auto';
		$is_full_section = isset ( $args[ 'full-section' ] ) ? true : false;
		$data_x          = '50%';

		if ( $bg_image ) {
			$image    = wp_get_attachment_image_src( $bg_image, 'full' );

			switch ( $bg_x_position ) {
				case 'left':
					$x = '0%';
					break;

				case 'middle-left':
					$x = '25%';
					break;

				case 'middle-right':
					$x = '75%';
					break;

				case 'right':
					$x = '100%';
					break;

				default:
					$x = '50%';
					break;
			}

			switch ( $bg_y_position ) {
				case 'top':
					$y = '0%';
					break;

				case 'bottom':
					$y = '100%';
					break;

				default:
					$y = '50%';
					break;
			}

			$bg_image = 'background-image:url( ' . esc_url( $image[ 0 ] ) . ' );background-repeat:' . esc_attr( $bg_repeat ) . ';background-position:' . esc_attr( $x ) . ' ' . esc_attr( $y ) . ';background-size:' . esc_attr( $bg_size ) . ';';
			$data_x   = $x;
		}

		if ( $bg_image || $bg_color ) {
			$style = 'style="' . $bg_image . $bg_color . '"';
			$class .= ' has-bg';
		}

		if ( $this->full_size >= 1 || ( $this->full_size + .24 ) >= 1 ) {
			echo "\n" . '</div><!-- /.lpb-row -->' . "\n";
			echo '</div><!-- /.lpb-container -->' . "\n";
			echo '</div><!-- /.lpb-page-row -->' . "\n\n";
			$this->full_size = 0;

			if ( $this->full_section && $this->close_section ) {
				echo '</div><!-- /.lpb-section -->' . "\n\n";
				echo '<div class="lpb-clear-section"></div><!-- .lpb-clear-section -->' . "\n\n";
				$this->full_section  = false;
				$this->close_section = false;
			}
		}

		if ( $this->full_size == 0 ) {
			if ( $is_full_section ) {
				$this->full_section = true;
				switch ($args[ 'stretch' ]) {
					case 'full':
					case 'default':
					case 'boxed':
						$row_stretch = 'full';

						break;

					default:
						$row_stretch = 'normal';

						break;
				}

				echo '<div class="lpb-section ' . esc_attr( $class ) . '" ' . $style . ' ' . $id . ' data-stretch="' . esc_attr( $row_stretch ) . '" data-x="' . esc_attr( $data_x ) . '"><!-- .lpb-section -->' . "\n\n";
			} else {
				echo '<div class="lpb-page-row"><!-- .lpb-page-row -->' . "\n";
				echo '<div class="lpb-container"><!-- .lpb-container -->' . "\n";
				echo '<div class="lpb-row"><!-- .lpb-row -->' . "\n\n";
			}
		}

		if ( ! $is_full_section ) {
			switch( $args[ 'size-item' ] ) {
				case '1-4':
					echo '<div class="lpb-col-3 ' . esc_attr( $class ) . '" ' . $id . '><!-- .lpb-page-item -->' . "\n";
					$this->full_size += 1/4;
					break;
				case '1-3':
					echo '<div class="lpb-col-4 ' . esc_attr( $class ) . '" ' . $id . '><!-- .lpb-page-item -->' . "\n";
					$this->full_size += 1/3;
					break;
				case '1-2':
					echo '<div class="lpb-col-6 ' . esc_attr( $class ) . '" ' . $id . '><!-- .lpb-page-item -->' . "\n";
					$this->full_size += 1/2;
					break;
				case '2-3':
					echo '<div class="lpb-col-8 ' . esc_attr( $class ) . '" ' . $id . '><!-- .lpb-page-item -->' . "\n";
					$this->full_size += 2/3;
					break;
				case '3-4':
					echo '<div class="lpb-col-9 ' . esc_attr( $class ) . '" ' . $id . '><!-- .lpb-page-item -->' . "\n";
					$this->full_size += 3/4;
					break;
				case '1-1':
					echo '<div class="lpb-col-12 ' . esc_attr( $class ) . '" ' . $id . '><!-- .lpb-page-item -->' . "\n";
					$this->full_size += 1;
					break;
			}
		}
	}

	public function print_block( $item ) {
		$block = $item->nodeName;

		if ( 'section-close' == $block ) {

			$this->close_section = true;

		} elseif ( 'section-open' == $block ) {

			$args  = array(
				'size-item'    => lpb_find_xml_value( $item, 'size' ),
				'full-section' => true,
			);

			if ( $id = lpb_find_xml_value( $item, 'custom-id' ) ) {
				$args[ 'id' ] = $id;
			}

			$config  = lpb_get_block( $block );
			$options = isset( $config[ 'options' ] ) ? $config[ 'options' ] : false;
			$class   = '';

			if ( $options ) {
				if ( isset( $options[ 'bg-color' ] ) && ( $bg_color = lpb_find_xml_value( $item, 'bg-color' ) ) ) {
					$args[ 'bg-color' ] = $bg_color;
				}

				if ( isset( $options[ 'bg-image' ] ) && ( $bg_image = lpb_find_xml_value( $item, 'bg-image' ) ) ) {
					$args[ 'bg-image' ] = $bg_image;
				}

				if ( isset( $options[ 'bg-x-position' ] ) && ( $bg_x_position = lpb_find_xml_value( $item, 'bg-x-position' ) ) ) {
					$args[ 'bg-x-position' ] = $bg_x_position;
				}

				if ( isset( $options[ 'bg-y-position' ] ) && ( $bg_y_position = lpb_find_xml_value( $item, 'bg-y-position' ) ) ) {
					$args[ 'bg-y-position' ] = $bg_y_position;
				}

				if ( isset( $options[ 'bg-repeat' ] ) && ( $bg_repeat = lpb_find_xml_value( $item, 'bg-repeat' ) ) ) {
					$args[ 'bg-repeat' ] = $bg_repeat;
				}

				if ( isset( $options[ 'bg-size' ] ) && ( $bg_size = lpb_find_xml_value( $item, 'bg-size' ) ) ) {
					$args[ 'bg-size' ] = $bg_size;
				}

				if ( isset( $options[ 'parallax-effect' ] ) && ( $parallax_effect = lpb_find_xml_value( $item, 'parallax-effect' ) ) ) {
					$class .= 'parallax-' . $parallax_effect;
				}

				if ( isset( $options[ 'text-color' ] ) && ( $text_color = lpb_find_xml_value( $item, 'text-color' ) ) ) {
					$class .= ' text-' . $text_color;
				}

				if ( isset( $options[ 'row-stretch' ] ) && ( $row_stretch = lpb_find_xml_value( $item, 'row-stretch' ) ) ) {
					$class .= ' row-stretch-' . $row_stretch;
					$args[ 'stretch' ] = $row_stretch;
				}

				if ( isset( $options[ 'columns-gap' ] ) && ( $columns_gap = lpb_find_xml_value( $item, 'columns-gap' ) ) ) {
					$class .= ' columns-gap-' . $columns_gap;
				}

				if ( isset( $options[ 'equal-height' ] ) && ( $equal_height = lpb_find_xml_value( $item, 'equal-height' ) ) ) {
					$class .= ' equal-height-' . $equal_height;
				}

				if ( isset( $options[ 'padding-top' ] ) && ( $padding_top = lpb_find_xml_value( $item, 'padding-top' ) ) ) {
					$class .= ' padding-top-' . $padding_top;
				}

				if ( isset( $options[ 'padding-bottom' ] ) && ( $padding_bottom = lpb_find_xml_value( $item, 'padding-bottom' ) ) ) {
					$class .= ' padding-bottom-' . $padding_bottom;
				}

				if ( isset( $options[ 'margin-bottom' ] ) && ( $margin_bottom = lpb_find_xml_value( $item, 'margin-bottom' ) ) ) {
					$class .= ' margin-bottom-' . $margin_bottom;
				}
			}

			if ( $class ) {
				$args[ 'class' ] = $class;
			}

			$this->print_size( $args );

		} elseif ( 'empty-column' == $block ) {

			$args  = array(
				'size-item' => lpb_find_xml_value( $item, 'size' ),
				'class'     => 'empty-column',
			);

			$this->print_size( $args );

			echo '</div><!-- /.lpb-page-item -->' . "\n";

		} else {

			$args  = array(
				'size-item' => lpb_find_xml_value( $item, 'size' ),
				'class'     => 'lpb-page-item',
			);

			if ( $id = lpb_find_xml_value( $item, 'custom-id' ) ) {
				$args[ 'id' ] = $id;
			}

			$config  = lpb_get_block( $block );
			$options = isset( $config[ 'options' ] ) ? $config[ 'options' ] : false;
			$data    = array();

			$this->print_size( $args );

			if ( $options && is_array( $options ) ) {
				foreach ( $options as $option => $value ) {
					$data[ $option ] = lpb_find_xml_value( $item, $option );
				}
			}

			lpb_get_template( "{$block}.php", array( 'lpb_data' => $data ) );

			echo '</div><!-- /.lpb-page-item -->' . "\n";
		}
	}
}

endif;

return new LPB_Print_Blocks();
