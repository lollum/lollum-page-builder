<?php
/**
 * Available Page Builder Blocks.
 *
 * @author   Lollum
 * @category Class
 * @package  Lollum_Page_Builder/Classes
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LPB_Blocks' ) ) :

/**
 * LPB_Blocks Class
 */
class LPB_Blocks {

	/**
	 * Output general meta boxes
	 */
	public static function blocks() {
		$blocks = array(
			'section-open' => apply_filters( 'lollum_page_builder_block_section_open',
				array(
					'id'           => 'section-open',
					'name'         => esc_html__( 'Open Section', 'lollum-page-builder' ),
					'description'  => esc_html__( 'Place elements inside the section', 'lollum-page-builder' ),
					'icon'         => 'fa fa-toggle-down',
					'default-size' => '1-1',
					'options'      => array(
						'bg-color' => array(
							'label' => esc_html__( 'Background color', 'lollum-page-builder' ),
							'type'  => 'color',
							'std'   => '#ffffff',
						),
						'bg-image' => array(
							'label' => esc_html__( 'Background image', 'lollum-page-builder' ),
							'type'  => 'upload',
						),
						'bg-x-position' => array(
							'label'   => esc_html__( 'Background horizontal position', 'lollum-page-builder' ),
							'type'    => 'select',
							'std'     => 'center',
							'options' => array(
								'left'         => esc_html__( 'Left', 'lollum-page-builder' ),
								'middle-left'  => esc_html__( 'Middle Left', 'lollum-page-builder' ),
								'center'       => esc_html__( 'Center', 'lollum-page-builder' ),
								'middle-right' => esc_html__( 'Middle Right', 'lollum-page-builder' ),
								'right'        => esc_html__( 'Right', 'lollum-page-builder' ),
							),
						),
						'bg-y-position' => array(
							'label'   => esc_html__( 'Background vertical position', 'lollum-page-builder' ),
							'type'    => 'select',
							'std'     => 'center',
							'options' => array(
								'top'      => esc_html__( 'Top', 'lollum-page-builder' ),
								'center'   => esc_html__( 'Center', 'lollum-page-builder' ),
								'bottom'   => esc_html__( 'Bottom', 'lollum-page-builder' ),
							),
						),
						'bg-repeat' => array(
							'label'   => esc_html__( 'Background repeat', 'lollum-page-builder' ),
							'type'    => 'select',
							'options' => array(
								'no-repeat' => esc_html__( 'No-Repeat', 'lollum-page-builder' ),
								'repeat'    => esc_html__( 'Repeat', 'lollum-page-builder' ),
								'repeat-x'  => esc_html__( 'Repeat-x', 'lollum-page-builder' ),
								'repeat-y'  => esc_html__( 'Repeat-y', 'lollum-page-builder' ),
							),
						),
						'bg-size' => array(
							'label'   => esc_html__( 'Background size', 'lollum-page-builder' ),
							'type'    => 'select',
							'options' => array(
								'auto'    => esc_html__( 'Auto', 'lollum-page-builder' ),
								'cover'   => esc_html__( 'Cover', 'lollum-page-builder' ),
								'contain' => esc_html__( 'Contain', 'lollum-page-builder' ),
							),
						),
						'parallax-effect' => array(
							'label'   => esc_html__( 'Parallax effect?', 'lollum-page-builder' ),
							'type'    => 'select',
							'options' => array(
								'no'  => esc_html__( 'No', 'lollum-page-builder' ),
								'yes' => esc_html__( 'Yes', 'lollum-page-builder' ),
							),
						),
						'text-color' => array(
							'label'       => esc_html__( 'Text color', 'lollum-page-builder' ),
							'description' => esc_html__( 'This option defines the style of the child blocks. Select "Dark" when the section has a light background or viceversa. ', 'lollum-page-builder' ),
							'type'        => 'select',
							'options'     => array(
								'dark'  => esc_html__( 'Dark', 'lollum-page-builder' ),
								'light' => esc_html__( 'Light', 'lollum-page-builder' ),
							),
						),
						'row-stretch' => array(
							'label'       => esc_html__( 'Row stretch', 'lollum-page-builder' ),
							'description' => esc_html__( 'Select stretching options for the row and inner blocks. (Please note: full rows may not work properly if the parent container has "overflow: hidden" CSS property).', 'lollum-page-builder' ),
							'type'        => 'select',
							'std'         => 'default',
							'options'     => array(
								'default'      => esc_html__( 'Full row', 'lollum-page-builder' ),
								'full'         => esc_html__( 'Full row and full content', 'lollum-page-builder' ),
								'boxed'        => esc_html__( 'Full row and boxed content', 'lollum-page-builder' ),
								'normal'       => esc_html__( 'Same as container', 'lollum-page-builder' ),
								'normal-boxed' => esc_html__( 'Same as container and boxed content', 'lollum-page-builder' ),
							),
						),
						'columns-gap' => array(
							'label'       => esc_html__( 'Columns gap', 'lollum-page-builder' ),
							'description' => esc_html__( 'Select gap between inner columns', 'lollum-page-builder' ),
							'type'        => 'select',
							'options'     => array(
								'default'      => esc_html__( 'Default', 'lollum-page-builder' ),
								'no-gap'        => esc_html__( 'No gap', 'lollum-page-builder' ),
							),
						),
						'equal-height' => array(
							'label'       => esc_html__( 'Equal height?', 'lollum-page-builder' ),
							'description' => esc_html__( 'If selected, inner columns will have the same height', 'lollum-page-builder' ),
							'type'        => 'select',
							'options'     => array(
								'no'  => esc_html__( 'No', 'lollum-page-builder' ),
								'yes' => esc_html__( 'Yes', 'lollum-page-builder' ),
							),
						),
						'padding-top' => array(
							'label'   => esc_html__( 'Padding top?', 'lollum-page-builder' ),
							'type'    => 'select',
							'options' => array(
								'yes' => esc_html__( 'Yes', 'lollum-page-builder' ),
								'no'  => esc_html__( 'No', 'lollum-page-builder' ),
							),
						),
						'padding-bottom' => array(
							'label'   => esc_html__( 'Padding bottom?', 'lollum-page-builder' ),
							'type'    => 'select',
							'options' => array(
								'yes' => esc_html__( 'Yes', 'lollum-page-builder' ),
								'no'  => esc_html__( 'No', 'lollum-page-builder' ),
							),
						),
						'margin-bottom' => array(
							'label'   => esc_html__( 'Margin bottom?', 'lollum-page-builder' ),
							'type'    => 'select',
							'options' => array(
								'yes' => esc_html__( 'Yes', 'lollum-page-builder' ),
								'no'  => esc_html__( 'No', 'lollum-page-builder' ),
							),
						)
					)
				)
			),
			'section-close' => apply_filters( 'lollum_page_builder_block_section_close',
				array(
					'id'           => 'section-close',
					'name'         => esc_html__( 'Close Section', 'lollum-page-builder' ),
					'description'  => esc_html__( 'Close the section', 'lollum-page-builder' ),
					'icon'         => 'fa fa-toggle-up',
					'default-size' => '1-1',
					'custom-id'    => false,

				)
			),
			'empty-column' => apply_filters( 'lollum_page_builder_block_empty_column',
				array(
					'id'           => 'empty-column',
					'name'         => esc_html__( 'Empty Column', 'lollum-page-builder' ),
					'description'  => esc_html__( 'Blank horizontal space', 'lollum-page-builder' ),
					'icon'         => 'fa fa-arrows-h',
					'default-size' => '1-4',
					'sizes'        => array(
						'1-4',
						'1-3',
						'1-2',
						'2-3',
						'3-4',
						'1-1',
					),
					'custom-id'    => false,
				)
			),
			'column' => apply_filters( 'lollum_page_builder_block_column',
				array(
					'id'           => 'column',
					'name'         => esc_html__( 'Column', 'lollum-page-builder' ),
					'description'  => esc_html__( 'A block of text (accepts HTML and shortcodes)', 'lollum-page-builder' ),
					'icon'         => 'fa fa-file-text-o',
					'default-size' => '1-4',
					'sizes'        => array(
						'1-4',
						'1-3',
						'1-2',
						'2-3',
						'3-4',
						'1-1',
					),
					'options'      => array(
						// Editor instances must be named "content"
						'content' => array(
							'label' => esc_html__( 'Text', 'lollum-page-builder' ),
							'type'  => 'editor',
						),
						'bg-color' => array(
							'label' => esc_html__( 'Background color', 'lollum-page-builder' ),
							'type'  => 'color',
							'std'   => '',
						),
						'column-padding' => array(
							'label'       => esc_html__( 'Column padding', 'lollum-page-builder' ),
							'description' => esc_html__( 'The padding of the column (CSS values allowed)', 'lollum-page-builder' ),
							'type'        => 'text',
							'std'         => 0
						),
					),
				)
			),
			'service' => apply_filters( 'lollum_page_builder_block_service',
				array(
					'id'           => 'service',
					'name'         => esc_html__( 'Service', 'lollum-page-builder' ),
					'description'  => esc_html__( 'A text module with titles and icons', 'lollum-page-builder' ),
					'icon'         => 'fa fa-star-o',
					'default-size' => '1-4',
					'sizes'        => array(
						'1-4',
						'1-3',
						'1-2',
						'2-3',
						'3-4',
						'1-1',
					),
					'options'      => array(
						'service-title' => array(
							'label' => esc_html__( 'Title', 'lollum-page-builder' ),
							'type'  => 'text',
						),
						'service-icon' => array(
							'label' => esc_html__( 'Icon', 'lollum-page-builder' ),
							'type'  => 'icon',
						),
						'service-url' => array(
							'label' => esc_html__( 'URL', 'lollum-page-builder' ),
							'type'  => 'text',
							'description'  => esc_html__( 'Add an optional link', 'lollum-page-builder' ),
						),
						// Editor instances must be named "content"
						'content' => array(
							'label' => esc_html__( 'Text', 'lollum-page-builder' ),
							'type'  => 'editor',
						),
					),
				)
			),
			'image' => apply_filters( 'lollum_page_builder_block_image',
				array(
					'id'           => 'image',
					'name'         => esc_html__( 'Single Image', 'lollum-page-builder' ),
					'description'  => esc_html__( 'A single image', 'lollum-page-builder' ),
					'icon'         => 'fa fa-file-image-o',
					'default-size' => '1-4',
					'sizes'        => array(
						'1-4',
						'1-3',
						'1-2',
						'2-3',
						'3-4',
						'1-1',
					),
					'options'      => array(
						'image-id' => array(
							'label' => esc_html__( 'Image', 'lollum-page-builder' ),
							'type'  => 'upload',
						),
						'alignment' => array(
							'label'   => esc_html__( 'Alignment', 'lollum-page-builder' ),
							'type'    => 'select',
							'options' => array(
								'center' => esc_html__( 'Center', 'lollum-page-builder' ),
								'left'   => esc_html__( 'Left', 'lollum-page-builder' ),
								'right'  => esc_html__( 'Right', 'lollum-page-builder' ),
							),
						),
						'image-url' => array(
							'label' => esc_html__( 'URL', 'lollum-page-builder' ),
							'type'  => 'text',
							'description'  => esc_html__( 'Add an optional link', 'lollum-page-builder' ),
						),
					),
				)
			),
			'blog' => apply_filters( 'lollum_page_builder_block_blog',
				array(
					'id'           => 'blog',
					'name'         => esc_html__( 'Blog Grid', 'lollum-page-builder' ),
					'description'  => esc_html__( 'A list of posts in grid', 'lollum-page-builder' ),
					'icon'         => 'fa fa-th',
					'default-size' => '1-1',
					'options'      => array(
						'number' => array(
							'label' => esc_html__( 'Number of posts', 'lollum-page-builder' ),
							'type'  => 'number',
							'std'   => '4',
						),
						'columns' => array(
							'label' => esc_html__( 'Number of columns', 'lollum-page-builder' ),
							'type'  => 'number',
							'std'   => '4',
						),
						'order' => array(
							'label'   => esc_html__( 'Order by?', 'lollum-page-builder' ),
							'class'   => 'blog-order',
							'type'    => 'select',
							'options' => array(
								'date'     => esc_html__( 'Date', 'lollum-page-builder' ),
								'ids'      => esc_html__( 'IDs', 'lollum-page-builder' ),
								'category' => esc_html__( 'Category', 'lollum-page-builder' ),
							),
						),
						'ids' => array(
							'label'         => esc_html__( 'IDs', 'lollum-page-builder' ),
							'wrapper-class' => 'blog-order-ids',
							'description'   => esc_html__( 'Comma separated list of post IDs', 'lollum-page-builder' ),
							'type'          => 'text',
						),
						'category' => array(
							'label'         => esc_html__( 'Category', 'lollum-page-builder' ),
							'wrapper-class' => 'blog-order-category',
							'description'   => esc_html__( 'The slug of the category', 'lollum-page-builder' ),
							'type'          => 'text',
						),
					),
				)
			)
		);

		if ( in_array( 'revslider/revslider.php', get_option( 'active_plugins' ) ) ) {
			$blocks[ 'revslider' ] = apply_filters( 'lollum_page_builder_block_revslider',
				array(
					'id'           => 'revslider',
					'name'         => esc_html__( 'Revolution Slider', 'lollum-page-builder' ),
					'description'  => esc_html__( 'Place a slider', 'lollum-page-builder' ),
					'icon'         => 'fa fa-refresh',
					'default-size' => '1-4',
					'custom-id'    => false,
					'sizes'        => array(
						'1-4',
						'1-3',
						'1-2',
						'2-3',
						'3-4',
						'1-1',
					),
					'options' => array(
						'slider-alias' => array(
							'label'   => esc_html__( 'Select slider', 'lollum-page-builder' ),
							'type'    => 'revslider-select',
						),
					),
				)
			);
		}

		return apply_filters( 'lollum_page_builder_blocks', $blocks );
	}

}

endif;
