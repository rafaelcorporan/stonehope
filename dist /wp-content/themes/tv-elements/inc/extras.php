<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package tvelements
 */

/**
 * Post Page Pagination
 *
 * @since 1.0
 */
function tvelements_paginate( $container = false ) {
		
	ob_start();
	?>
	<div class="clearfix"></div>
	
	<div class="pagination">
		<?php echo ($container ? '<div class="pagination-inner">' : ''); ?>
			<?php previous_posts_link( '<div class="dashicons dashicons-arrow-left-alt2"></div>' ); ?>	
			<?php global $wp_query; ?>
			
			<div class="pagenums">
				<?php 
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
				$current = sprintf("%02s", $paged);
				$last = sprintf("%02s", $wp_query->max_num_pages);
				?>
				<div class="diag"></div>
				<span class="left"><?php echo $current; ?></span>
				<span class="right"><?php echo $last; ?></span>
			</div>
			
			<?php next_posts_link( '<div class="dashicons dashicons-arrow-right-alt2"></div>' ); ?>
		<?php echo ($container ? '</div>' : '');?>
	</div>
	<?php
	$paginate = ob_get_contents();
	ob_end_clean();
	
	if($last > 1) {
		return $paginate;
	}
	else {
		return false;
	}
}


/**
 * Custom Excerpt Length
 *
 */
function tvelements_excerpt_boxed( $length ) {
	return 18;
}
add_filter( 'excerpt_length', 'tvelements_excerpt_blog' );

function tvelements_excerpt_blog( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'tvelements_excerpt_blog' );


/**
 * Custom Excerpt More
 *
 */
function tvelements_new_excerpt_readmore( $more ) {
	return ' ...';
}

add_filter( 'excerpt_more', 'tvelements_new_excerpt_readmore' );

function wpe_excerpt($length_callback='', $more_callback='') {
	global $post;
	
	if(function_exists($length_callback)){
		add_filter('excerpt_length', $length_callback);
	}
	if(function_exists($more_callback)){
		add_filter('excerpt_more', $more_callback);
	}
	$output = get_the_excerpt();
	$output = apply_filters('wptexturize', $output);
	$output = apply_filters('convert_chars', $output);
	$output = '<p class="excerpt">'.$output.'</p>';
	echo $output;
}


/**
 * Pings Callback Setup
 *
 * @since 1.0
 */
if ( ! function_exists( 'tvelements_pings_callback' ) ) {
	function tvelements_pings_callback( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li class="ping" id="li-comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
		<?php
	}
}


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since 4.0
 */
function tvelements_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'starter' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'wp_title', 'tvelements_wp_title', 10, 2 );