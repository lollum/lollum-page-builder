<?php
/**
 * Helper functions for the page builder.
 *
 * @author   Lollum
 * @category Core
 * @package  Lollum_Page_Builder/Functions
 * @version  1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'lpb_get_blocks' ) ) :
/**
 * Get an array of available blocks.
 */
function lpb_get_blocks() {
	$registered_blocks = LPB_Blocks::blocks();
	$blocks            = array();

	foreach ( $registered_blocks as $key => $value ) {
		$blocks[] = $key;
	}

	return $blocks;
}
endif;

if ( ! function_exists( 'lpb_get_block' ) ) :
/**
 * Get the block data from the array of available blocks.
 */
function lpb_get_block( $id ) {
	$blocks = LPB_Blocks::blocks();

	foreach ( $blocks as $value ) {
		if ( isset( $blocks[ $id ] ) ) {
			return $blocks[ $id ];
		}
	}
}
endif;

if ( ! function_exists( 'lpb_get_block_name' ) ) :
/**
 * Get the block name.
 */
function lpb_get_block_name( $id ) {
	$blocks = LPB_Blocks::blocks();

	foreach ( $blocks as $value ) {
		if ( isset( $blocks[ $id ] ) ) {
			if ( isset( $blocks[ $id ][ 'name' ] ) ) {
				return $blocks[ $id ][ 'name' ];
			}
		}
	}
}
endif;

if ( ! function_exists( 'lpb_get_block_description' ) ) :
/**
 * Get the block description.
 */
function lpb_get_block_description( $id ) {
	$blocks = LPB_Blocks::blocks();

	foreach ( $blocks as $value ) {
		if ( isset( $blocks[ $id ] ) ) {
			if ( isset( $blocks[ $id ][ 'description' ] ) ) {
				return $blocks[ $id ][ 'description' ];
			}
		}
	}
}
endif;

if ( ! function_exists( 'lpb_get_block_icon' ) ) :
/**
 * Get the block icon.
 */
function lpb_get_block_icon( $id ) {
	$blocks = LPB_Blocks::blocks();

	foreach ( $blocks as $value ) {
		if ( isset( $blocks[ $id ] ) ) {
			if ( isset( $blocks[ $id ][ 'icon' ] ) ) {
				return $blocks[ $id ][ 'icon' ];
			}
		}
	}
}
endif;

if ( ! function_exists( 'lpb_print_edit_block' ) ) :
/**
 * Print the edit block box.
 */
function lpb_print_edit_block( $id, $selected = null, $data = null ) {
	$selected = $selected ? true : false;
	lpb_get_view( 'admin/views/html-edit-block.php', array( 'block' => lpb_get_block( $id ), 'selected' => $selected, 'data' => $data ) );
}
endif;

if ( ! function_exists( 'lpb_block_setting' ) ) :
/**
 * Print block setting.
 */
function lpb_block_setting( $name, $field, $data = null ) {
	if ( isset( $field[ 'type' ] ) ) {
		switch ( $field[ 'type' ] ) {
			case 'text':
				lpb_text_input( $name, $field, $data);
				break;

			case 'number':
				lpb_number_input( $name, $field, $data);
				break;

			case 'editor':
				lpb_editor_input( $name, $field, $data);
				break;

			case 'textarea':
				lpb_textarea_input( $name, $field, $data);
				break;

			case 'select':
				lpb_select_input( $name, $field, $data);
				break;

			case 'select-images':
				lpb_select_images_input( $name, $field, $data);
				break;

			case 'upload':
				lpb_upload_input( $name, $field, $data);
				break;

			case 'color':
				lpb_color_input( $name, $field, $data);
				break;

			case 'icon':
				lpb_icon_input( $name, $field, $data);
				break;

			case 'revslider-select':
				lpb_revslider_select_input( $name, $field, $data);
				break;

		}
	}
}
endif;

if ( ! function_exists( 'lpb_text_input' ) ) :
/**
 * Print text input.
 */
function lpb_text_input( $name, $field, $data = null ) {
	$field[ 'placeholder' ]   = isset( $field[ 'placeholder' ] ) ? $field[ 'placeholder' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : '';

	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$value                    = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;

	echo '<div class="form-field ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span><input type="text" data-type="' . esc_attr( $name ) . '" class="xml esc ' . esc_attr( $field[ 'class' ] ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $field[ 'placeholder' ] ) . '" /></label>';

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_number_input' ) ) :
/**
 * Print number input.
 */
function lpb_number_input( $name, $field, $data = null ) {
	$field[ 'placeholder' ]   = isset( $field[ 'placeholder' ] ) ? $field[ 'placeholder' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : '';

	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$value                    = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;

	echo '<div class="form-field ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span><input type="number" data-type="' . esc_attr( $name ) . '" class="xml esc ' . esc_attr( $field[ 'class' ] ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $field[ 'placeholder' ] ) . '" /></label>';

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_editor_input' ) ) :
/**
 * Print editor input.
 */
function lpb_editor_input( $name, $field, $data = null ) {
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'value' ]         = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;
	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';

	echo '<div class="form-field ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span></label>';

	$settings = array(
		'media_buttons' => true,
		'quicktags'     => array( 'buttons' => 'em,strong,link' ),
		'tinymce'       => false,
		'editor_class'  => 'xml esc',

	);

	add_filter( 'the_editor', 'lpb_add_data' );
	wp_editor( htmlspecialchars_decode( $field[ 'value' ] ), uniqid(), $settings );
	remove_filter( 'the_editor', 'lpb_add_data' );

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_textarea_input' ) ) :
/**
 * Print textarea input.
 */
function lpb_textarea_input( $name, $field, $data = null ) {
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : '';
	$field[ 'value' ]         = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;
	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';

	echo '<div class="form-field ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span><textarea cols="10" name="custom" rows="8" data-type="' . esc_attr( $name ) . '" class="xml esc ' . esc_attr( $field[ 'class' ] ) . '">' . wp_kses_post( $field[ 'value' ] ) . '</textarea></label>';

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_select_input' ) ) :
/**
 * Print select input.
 */
function lpb_select_input( $name, $field, $data = null ) {
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : '';
	$field[ 'value' ]         = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;
	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';

	echo '<div class="form-field ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span><select data-type="' . esc_attr( $name ) . '" class="xml ' . esc_attr( $field[ 'class' ] ) . '">';

	foreach ( $field[ 'options' ] as $key => $value ) {
		echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field[ 'value' ] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
	}

	echo '</select></label>';

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_select_images_input' ) ) :
/**
 * Print select input.
 */
function lpb_select_images_input( $name, $field, $data = null ) {
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : '';
	$field[ 'value' ]         = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;
	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';

	echo '<div class="form-field ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span><select data-type="' . esc_attr( $name ) . '" class="xml select-images ' . esc_attr( $field[ 'class' ] ) . '">';

	foreach ( $field[ 'options' ] as $key => $value ) {
		echo '<option data-url="' . esc_url( $field[ 'base-url' ] . $key . '.png' ) . '" value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field[ 'value' ] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
	}

	echo '</select></label>';

	echo '<div class="select-images-wrapper"><img src="' . esc_url( $field[ 'base-url' ] . $field[ 'value' ] . '.png' ) . '"></div>';

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_revslider_select_input' ) ) :
/**
 * Print revslider select input.
 */
function lpb_revslider_select_input( $name, $field, $data = null ) {
	$field[ 'value' ] = isset( $data ) ? lpb_find_xml_value( $data, $name ) : '';
	$field[ 'label' ] = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';

	echo '<div class="form-field">';

	$slider = new RevSlider();
	$get_sliders = $slider->getArrSliders();

	$sliders = array();
	if ( $get_sliders ) {
		foreach ( $get_sliders as $slider ) {
			$sliders[ $slider->getAlias() ] = $slider->getTitle();
		}
	} else {
		$sliders = false;
	}

	if ( $sliders ) {

		echo '<label><span>' . esc_html( $field[ 'label' ] ) . '</span><select data-type="' . esc_attr( $name ) . '" class="xml">';

		foreach ( $sliders as $key => $value ) {
			echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field[ 'value' ] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
		}

		echo '</select></label>';

		if ( ! empty( $field[ 'description' ] ) ) {
			echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
		}

	} else {
		echo '<br><span class="description">' . esc_html__( 'No sliders found', 'lollum-page-builder' ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_upload_input' ) ) :
/**
 * Print upload input.
 */
function lpb_upload_input( $name, $field, $data = null ) {
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : '';
	$field[ 'value' ]         = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;
	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';
	$field[ 'multiple' ]      = isset( $field[ 'multiple' ] ) ? $field[ 'multiple' ] : 'false';

	echo '<div class="form-field ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span><input type="hidden" data-type="' . esc_attr( $name ) . '" class="xml esc input-image ' . esc_attr( $field[ 'class' ] ) . '" value="' . esc_attr( $field[ 'value' ] ) . '" /></label>';

	echo '<div class="block-images-container">';
	echo '<ul class="block-images sortable-' . $field[ 'multiple' ] . '">';

	$attachments = array_filter( explode( ',', $field[ 'value' ] ) );

	if ( ! empty( $attachments ) ) {
		foreach ( $attachments as $attachment_id ) {
			echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
				' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
				<a href="#" class="delete-block-image">' . esc_html__( 'Delete', 'lollum-page-builder' ) . '</a>
			</li>';
		}
	}

	echo '</ul>';
	echo '</div>';

	echo '<button type="button" data-multiple="' . esc_attr( $field[ 'multiple' ] ) . '" data-text="' . esc_html__( 'Delete', 'lollum-page-builder' ) . '" class="button button-primary block-upload">' . esc_html__( 'Upload', 'lollum-page-builder' ) . '</button>';

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_color_input' ) ) :
/**
 * Print color input.
 */
function lpb_color_input( $name, $field, $data = null ) {
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$field[ 'placeholder' ]   = isset( $field[ 'placeholder' ] ) ? $field[ 'placeholder' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : '';
	$field[ 'value' ]         = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;
	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';

	echo '<div class="form-field ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span><input type="text" data-type="' . esc_attr( $name ) . '" class="xml esc input-color ' . esc_attr( $field[ 'class' ] ) . '" value="' . esc_attr( $field[ 'value' ] ) . '" placeholder="' . esc_attr( $field[ 'placeholder' ] ) . '" /></label>';

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_icon_input' ) ) :
/**
 * Print icon input.
 */
function lpb_icon_input( $name, $field, $data = null ) {
	$std                      = isset( $field[ 'std' ] ) ? $field[ 'std' ] : '';
	$field[ 'placeholder' ]   = isset( $field[ 'placeholder' ] ) ? $field[ 'placeholder' ] : '';
	$field[ 'wrapper-class' ] = isset( $field[ 'wrapper-class' ] ) ? $field[ 'wrapper-class' ] : '';
	$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : '';
	$field[ 'value' ]         = isset( $data ) ? lpb_find_xml_value( $data, $name ) : $std;
	$field[ 'label' ]         = isset( $field[ 'label' ] ) ? $field[ 'label' ] : '';

	echo '<div class="form-field form-field-icon ' . esc_attr( $field[ 'wrapper-class' ] ) . '"><label><span>' . esc_html( $field[ 'label' ] ) . '</span><input type="text" data-type="' . esc_attr( $name ) . '" class="xml esc input-icon ' . esc_attr( $field[ 'class' ] ) . '" value="' . esc_attr( $field[ 'value' ] ) . '" placeholder="' . esc_attr( $field[ 'placeholder' ] ) . '" /></label>';

	echo '<button class="button-primary">'. esc_html__( 'Select an icon', 'lollum-page-builder' ) . '</button>';

	if ( ! empty( $field[ 'description' ] ) ) {
		echo '<br><span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
	}

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_id_input' ) ) :
/**
 * Print text input.
 */
function lpb_id_input( $data = null ) {
	$value = isset( $data ) ? lpb_find_xml_value( $data, 'custom-id' ) : '';

	echo '<div class="form-field"><label><span>' . esc_html__( 'Custom ID', 'lollum-page-builder' ) . '</span><input type="text" data-type="custom-id" class="xml esc" value="' . esc_attr( $value ) . '" /></label>';

	echo '<br><span class="description">' . esc_html__( 'You can add a custom ID and refer to it in your custom CSS', 'lollum-page-builder' ) . '</span>';

	echo '</div>';
}
endif;

if ( ! function_exists( 'lpb_add_data' ) ) :
/**
 * Filter the editor to include the data-type attribute..
 */
function lpb_add_data( $output ) {
	$output = str_replace( '<textarea', '<textarea data-type="content"', $output );
	return $output;
}
endif;

if ( ! function_exists( 'lpb_add_custom_quicktags' ) ) :
/**
 * Add custom quicktags button to the editor.
 */
function lpb_add_custom_quicktags() {
    if ( wp_script_is( 'quicktags' ) ) {
	?>
    <script type="text/javascript">
    QTags.addButton( 'lpb_h1', 'h1', '<h1>', '</h1>', false, 'H1', false );
    QTags.addButton( 'lpb_h2', 'h2', '<h2>', '</h2>', false, 'H2', false );
    QTags.addButton( 'lpb_h3', 'h3', '<h3>', '</h3>', false, 'H3', false );
    QTags.addButton( 'lpb_h4', 'h4', '<h4>', '</h4>', false, 'H4', false );
    QTags.addButton( 'lpb_center', 'center', '<div style="text-align: center;">', '</div>', false, 'Center', false );
    QTags.addButton( 'lpb_big', 'big', '<div class="big">', '</div>', false, 'Big paragraph', false );
    QTags.addButton( 'lpb_button', 'button', '<a href="http://example.com/" class="button normal">', '</a>', false, 'Button', false );
    </script>
	<?php
    }
}
endif;
add_action( 'admin_print_footer_scripts', 'lpb_add_custom_quicktags' );

if ( ! function_exists( 'lpb_find_xml_value' ) ) :
/**
 * Find XML value.
 */
function lpb_find_xml_value( $xml, $field ) {
	if ( $xml ) {
		foreach( $xml->childNodes as $xmlChild ) {
			if ( $xmlChild->nodeName == $field ) {
				return $xmlChild->nodeValue;
			}
		}
	}

	return '';
}
endif;

if ( ! function_exists( 'lpb_find_xml_node' ) ) :
/**
 * Find XML node.
 */
function lpb_find_xml_node( $xml, $node ) {
	if ( $xml ) {
		foreach( $xml->childNodes as $xmlChild ) {
			if( $xmlChild->nodeName == $node ) {
				return $xmlChild;
			}
		}
	}

	return '';
}
endif;
