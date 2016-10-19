# Lollum Page Builder
A simple and lightweight WordPress page builder for developers.

## Description
The Lollum Page Builder plugin is a simple page builder meant for developers. It doesn't provide tons of features, mega-effects or super options. It's a simple grid with a few predefined blocks. And it provides a simple filter for the creation of new blocks. Unannounced pull requests generally not welcome, I maintain this repo as my own page builder. But feel free to open issues to discuss first: the idea is to keep this page builder as simple as possible.

## Usage

To add a new block:

```
function custom_new_blocks( $blocks ) {
	$blocks[ 'gallery' ] = array(
		'id'           => 'gallery',
		'name'         => esc_html__( 'Gallery', 'text-domain' ),
		'description'  => esc_html__( 'Slide of images from the Media library', 'text-domain' ),
		'icon'         => 'fa fa-image',
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
			'image-ids' => array(
				'label'       => esc_html__( 'Images', 'text-domain' ),
				'description' => esc_html__( 'The images in this block are not cropped (original size uploaded)', 'text-domain' ),
				'multiple'    => 'true',
				'type'        => 'upload',
			),
			'max-width' => array(
				'label'       => esc_html__( 'Max width (optional)', 'text-domain' ),
				'type'        => 'text',
				'description' => esc_html__( 'Type the value in px or % (ie. 600px or 80%)', 'text-domain' ),
			),
		)
	);

	return $blocks;
}
add_filter( 'lollum_page_builder_blocks', 'custom_new_blocks' );
```

## Options

### id
- Type: `String`

The ID of the block.

### name
- Type: `String`

The name of the block.

### description
- Type: `String`

The description of the block.

### icon
- Type: `String`

The icon of the block. Uses the Font Awesome icon font.

### custom-id
- Type: `Boolean`
- Default: `true`

(Optional) If false, the block will not have the *Custom ID* field.

### clonable
- Type: `Boolean`
- Default: `true`

(Optional) If false, the block will be not clonable.

### default-size
- Type: `String`

The initial size of the block.

### sizes
- Type: `Array`

(Optional) Array of sizes. Possible values:

```
'sizes' => array(
	'1-4',
	'1-3',
	'1-2',
	'2-3',
	'3-4',
	'1-1'
)
```
If not provided, the block will be full-width (1-1).

### options
- Type: `Array`

An array of options.

Available types and specific settings:

#### text
- **label** (`String`)
- **description** (`String`)
- **std** (`String`, the default value)

#### number
- **label** (`String`)
- **description** (`String`)
- **std** (`String`, the default value)

#### textarea
- **label** (`String`)
- **description** (`String`)
- **std** (`String`, the default value)

#### select
- **label** (`String`)
- **description** (`String`)
- **std** (`String`, the default value)
- **options** (`Array`)

#### upload
- **label** (`String`)
- **description** (`String`)
- **multiple** (`String`, "true" or "false")

## Templates
The plugin looks in `lollum-page-builder/templates/block-id.php` or in `yourtheme/lollum-page-builder/block-id.php` to load the block template. The `$lpb_data` variable is passed to each template. You can get the value of each option with `$lpb_data[ name-of-the-option ]`.

## Can I use this plugin with other themes, premium or free?
Yes.
