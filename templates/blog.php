<?php
/**
 * Blog block.
 *
 * This template can be overridden by copying it to yourtheme/lollum-page-builder/blog.php.
 *
 * @author  Lollum
 * @package Lollum_Page_Builder/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$number          = $lpb_data[ 'number' ] ? absint( $lpb_data[ 'number' ] ) : 4;
$columns         = $lpb_data[ 'columns' ] ? absint( $lpb_data[ 'columns' ] ) : 4;
$order           = sanitize_text_field( $lpb_data[ 'order' ] );
$ids_filter      = $lpb_data[ 'ids' ] ? implode( ',', wp_parse_id_list( $lpb_data[ 'ids' ] ) ) : '';
$category_filter = sanitize_text_field( $lpb_data[ 'category' ] );
$loop            = '';
?>

<div class="lpb-item-blog">
	<?php
	$query_args = array(
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true
	);

	if ( $order == 'ids' ) {

		$ids                      = explode( ',', $ids_filter );
		$query_args[ 'post__in' ] = $ids;
		$query_args[ 'orderby' ]  = 'post__in';

	} else if ( $order == 'category' ) {

		$query_args[ 'category_name' ]  = $category_filter;
		$query_args[ 'posts_per_page' ] = $number;

	} else {

		$query_args[ 'posts_per_page' ] = $number;
	}

	$posts = new WP_Query( apply_filters( 'lollum_page_builder_post_modules_query', $query_args ) );

	ob_start();

	if ( $posts->have_posts() ) : ?>

		<div class="post-module columns-<?php echo absint( $columns ); ?>">

			<ul class="posts">

				<?php while ( $posts->have_posts() ) : $posts->the_post();

					// Store loop count we're currently on
					if ( empty( $loop ) ) {
						$loop = 0;
					}

					// Increase loop count
					$loop++;

					// Extra post classes
					$classes = array();
					if ( 0 == ( $loop - 1 ) % $columns || 1 == $columns ) {
						$classes[] = 'first';
					}
					if ( 0 == $loop % $columns ) {
						$classes[] = 'last';
					}
					?>

					<li id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a class="post-thumbnail" href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium' ); ?>
							</a>
						<?php endif; ?>

						<header class="entry-header">
							<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
						</header><!-- .entry-header -->

						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div><!-- .entry-summary -->
					</li><!-- #post-## -->

				<?php endwhile; // end of the loop. ?>

			</ul><!-- .posts -->

		</div><!-- .post-module -->

	<?php endif;

	$loop = $columns = '';
	wp_reset_postdata();

	echo ob_get_clean(); ?>

</div>
