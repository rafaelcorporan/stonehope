<?php
/**
 * No Nonsense functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */


/*====================================
=            Hook Library            =
====================================*/

add_action( 'after_setup_theme', 'nn_setup' );
add_action( 'init', 'nn_editor_styles' );
add_action( 'wp_enqueue_scripts', 'nn_enqueues' );
add_filter( 'wp_link_pages', 'nn_wp_link_pages', 10, 2 );
add_action( 'widgets_init', 'no_nonsense_widgets_init' );
add_filter( 'wp_title', 'no_nonsense_wp_title', 10, 2 );

/*-----  End of Hook Library  ------*/

// Content Width
if ( ! isset( $content_width ) ) {
	$content_width = 767;
}


/**
 * Theme Setup
 *
 * Contains all the includes, definitions and functions which set up the basic functionality of the theme
 *
 * @since No Nonsense 1.0
 *
 */
function nn_setup() {

	// Includes
	include( 'includes/NN_Customizer.class.php' );
	include( 'includes/Dynamic_Color.class.php' );

	// Theme Supports
	$custom_header = array(
		'default-image'          => get_template_directory_uri() . '/images/defaults/header.jpg',
		'random-default'         => false,
		'width'                  => '',
		'height'                 => 430,
		'flex-height'            => true,
		'flex-width'             => true,
		'default-text-color'     => '#ffffff',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);

	add_theme_support( 'custom-header', $custom_header );
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	// Nav Menus
	register_nav_menu( 'header_menu', __( 'Header Menu', 'no-nonsense' ) );
	register_nav_menu( 'footer_menu', __( 'Footer Menu', 'no-nonsense' ) );

	// Translation Support
	load_theme_textdomain( 'no-nonsense', get_stylesheet_directory() . '/languages' );
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// Image Sizes
	add_image_size( 'nn_list', 730, 288, true );

}

/**
 * Theme Sidebars
 *
 * Adds the theme sidebars
 *
 * @since No Nonsense 1.0
 *
 */
function no_nonsense_widgets_init() {
	register_sidebar( array(
	    'name'         => __( 'Sidebar', 'no-nonsense' ),
	    'id'           => 'sidebar',
	    'description'  => __( 'Widgets in this area will be shown in the main sidebar.', 'no-nonsense' ),
	    'before_title' => '<h3>',
	    'after_title'  => '</h3>',
	));
}


/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since No Nonsense 1.0
 *
 * @global int $paged WordPress archive pagination page count.
 * @global int $page  WordPress paginated post page count.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function no_nonsense_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'no-nonsense' ), max( $paged, $page ) );
	}

	return $title;
}

/**
 * Editor Styles
 *
 * Adds editor styles to the theme backend. The default fonts are also includes to be used in the post editor
 *
 * @since No Nonsense 1.0
 *
 */
function nn_editor_styles() {
    $font_url = '//fonts.googleapis.com/css?family=Lato:300,400,700|Open+Sans:400,300,700';

    add_editor_style( str_replace( ',', '%2C', $font_url ) );
    add_editor_style( 'style-editor.css' );
}


/**
 * Theme Styles And Scripts
 *
 * Enqueues the themes and scripts we need to get the theme going nicely. The footer scripts file is minified and concatenated from a number of different files. These development files can be found in the github repository.
 *
 * @since No Nonsense 1.0
 *
 */
function nn_enqueues() {
	wp_enqueue_style( 'no-nonsense', get_stylesheet_uri() );

	wp_enqueue_script( 'no-nonsense', get_template_directory_uri() . '/js/footer-scripts.min.js', array('jquery') );

	wp_enqueue_style( 'nn_fonts', '//fonts.googleapis.com/css?family=Lato:100,300,700|Open+Sans:400,600,300' );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Menu Standardization
 *
 * This function standardizes the auto-generated and hand crafted WordPress menus to make styling them easier.
 *
 * @since No Nonsense 1.0
 *
 */
function nn_nav_menu() {
	$menu = wp_page_menu( array(
		'menu_class' => 'menu-container',
		'echo'       => false
	));

	$menu = str_replace(
		array(
			'current_page_item',
			'current_page_parent',
			'current_page_ancestor',
			'<ul>',
			'page_item',
			'<ul class=\'children\'>'
		),
		array(
			'current-menu-item',
			'current-menu-parent',
			'current-menu-ancestor',
			'<ul class="menu">',
			'menu-item',
			'<ul class="sub-menu">'
		),
		$menu
	);

	echo $menu;
}


if( !function_exists( 'nn_comments' ) ) {

	/**
	 * Theme Comments
	 *
	 * This function is responsible for outputting comments. It is a pluggable function which means you can overwrite it by redefining it in your child theme.
	 *
	 * @param  object  $comment WordPress comment object
	 * @param  array   $args    Arguments for the comments section
	 * @param  integer $depth   The depth of the comment
	 *
	 * @since No Nonsense 1.0
	 *
	 */
	function nn_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		global $post;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
		?>
			<li <?php comment_class( 'comment pingback' ); ?> id="comment-<?php comment_ID(); ?>">
				<article class='primary-links'>

					<span class='pingback-title'>
						<?php _e( 'Pingback', 'no-nonsense' ) ?>
					</span>
					<span class='pingback-content'>
					<?php comment_author_link(); ?>
					</span>

					<?php edit_comment_link( 'Edit', ' - <span class="edit-link">', '</span>' ); ?>
				</article>
		<?php
			break;
			default :
		?>
			<li <?php comment_class( 'comment' ); ?> id="comment-<?php comment_ID(); ?>">

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<div class="alert-box comment-awaiting-moderation">
						<?php _e( 'Your comment is awaiting moderation.', 'no-nonsense' ); ?>
						<a href="" class="close">&times;</a>
						</div>
					<?php endif; ?>

					<header>
						<div class='comment-avatar'>
							<?php echo get_avatar( $comment, 62 ) ?>
						</div>

						<div class="comment-meta">
							<h4>
								<cite class='fn'><?php comment_author_link() ?></cite>
								<?php
									if( $comment->user_id == $post->post_author ) :
								?>
									<span class="button"><?php _e( 'author', 'no-nonsense' ) ?>
								<?php endif ?>
							</h4>
							<div class='comment-date'><?php comment_time( ' F j, Y' ) ?>  <?php edit_comment_link( __('Edit', 'no-nonsense'), '<span class="edit-link">', '</span>' ); ?></div>
						</div>

					</header>

					<article class='comment-box'>


						<section class='comment-content user-content'>
							<?php comment_text() ?>
						</section>

						<div class="comment-reply button-container">
							<?php
								comment_reply_link( array_merge( $args, array(
									'reply_text' => __('Reply', 'no-nonsense'),
									'depth' => $depth,
									'max_depth' => $args['max_depth']
								)));
							?>
						</div>


					</article>

		<?php
		break;
		endswitch;
	}
}



if ( ! function_exists( 'nn_pagination' ) ) {
	/**
	 * Query Pagination
	 *
	 * This function handles the pagination of pages. It uses the query data to output a list of page numbers and previous/next links.
	 *
	 * @since No Nonsense 1.0
	 *
	 */
	function nn_pagination() {

		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $GLOBALS['wp_query']->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'twentyfourteen' ),
			'next_text' => __( 'Next &rarr;', 'twentyfourteen' ),
		) );

		if ( $links ) :

		?>
		<nav class="pagination" role="navigation">
			<?php echo $links; ?>
		</nav><!-- .navigation -->
		<?php
		endif;
	}
}

if ( ! function_exists( 'nn_wp_link_pages' ) ) {
	/**
	 * Post Pagination
	 *
	 * This function handles the pagination of post content if it is split into multiple pages. The function standardizes the classes and look of this pagination with the query pagination function.
	 *
	 * @since No Nonsense 1.0
	 *
	 */
	function nn_wp_link_pages( $output, $args = '' ) {
		$defaults = array(
			'before' => '',
			'after' => '',
			'text_before' => '',
			'text_after' => '',
			'next_or_number' => 'number',
			'nextpagelink' => __( 'Next page', 'no-nonsense' ),
			'previouspagelink' => __( 'Previous page', 'no-nonsense' ),
			'pagelink' => '%',
			'echo' => 1
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );
		extract( $r, EXTR_SKIP );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';
		if ( $multipage ) {
			$output .= '<div class="pagination">';
			if ( 'number' == $next_or_number ) {
				$output .= $before;
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $pagelink );
					$output .= ' ';
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= _wp_link_page( $i );
					else
						$output .= '<span class="current">';

					$output .= $text_before . $j . $text_after;
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) )
						$output .= '</a>';
					else
						$output .= '</span>';
				}
				$output .= $after;
			}
			else {
				if ( $more ) {
					$output .= $before;
					$i = $page - 1;
					if ( $i && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $previouspagelink . $text_after . '</a>';
					}
					$i = $page + 1;
					if ( $i <= $numpages && $more ) {
						$output .= _wp_link_page( $i );
						$output .= $text_before . $nextpagelink . $text_after . '</a>';
					}
					$output .= $after;
				}
			}
			$output .= '</div>';
		}

		return $output;
	}
}


/**
 * Content Classes
 *
 * This function determines the classes we need to add to the content
 *
 */
function nn_content_class(){
	$sidebar_location = get_theme_mod( 'sidebar_location', 'left' );
	$classes = array( 'columns', 'small-12', 'medium-8', 'large-9' );
	if( $sidebar_location == 'left' ) {
		$classes[] = 'medium-push-4';
		$classes[] = 'large-push-3';
	}

	$classes = implode( ' ', $classes );
	echo 'class="' . $classes . '"';
}


/**
 * Sidebar Classes
 *
 * This function determines the classes we need to add to the sidebar
 *
 */
function nn_sidebar_class(){
	$sidebar_location = get_theme_mod( 'sidebar_location', 'left' );
	$classes = array( 'columns', 'small-12', 'medium-4', 'large-3' );
	if( $sidebar_location == 'left' ) {
		$classes[] = 'medium-pull-8';
		$classes[] = 'large-pull-9';
	}

	$classes = implode( ' ', $classes );
	echo 'class="' . $classes . '"';
}


?>
