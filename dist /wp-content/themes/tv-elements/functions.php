<?php
/**
 * Functions and definitions
 *
 * @package tvelements
 */

define( 'THEME_VERSION', '4.0.3' );

function tvelements_version_id() {
	if ( WP_DEBUG )
		return time();
	return THEME_VERSION;
}

/**
 * Custom content width for jetpack galleries.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

// remove admin bar styles, we'll enqueue our own
add_theme_support( 'admin-bar', array( 'callback' => '__return_false') );

/**
 * Theme Setup
 *
 */
function tvelements_setup() {

	// Translation setup
	load_theme_textdomain( 'tvelements', get_template_directory() . '/languages' );

	// Add visual editor to resemble the theme styles.
	add_editor_style( array( 'style-editor.css', tvelements_fonts_url() ) );

	// Add automatic feed links in header
	add_theme_support( 'automatic-feed-links' );

	// Add support for post formats
	add_theme_support( 'post-formats', array( 'video', 'image' ) );

	// Add Post Thumbnail Image sizes and support
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'featured', 420, 300, true );
	add_image_size( 'featured-lg', 825 );

	// Register custom menus
	register_nav_menus( array(
		'main_menu' => __( 'Main Menu', 'tvelements' )
	));

}

add_action( 'after_setup_theme', 'tvelements_setup' );


/**
 * Load additional files and functions.
 */
require( get_template_directory() . '/inc/custom-background.php' );
require( get_template_directory() . '/inc/custom-header.php' );
require( get_template_directory() . '/inc/template-tags.php' );
require( get_template_directory() . '/inc/extras.php' );
require( get_template_directory() . '/inc/shortcodes.php' );
require( get_template_directory() . '/inc/customizer.php' );

/**
 * Returns the Google font stylesheet URL, if available.
 */
function tvelements_fonts_url() {
	$fonts_url = '';

	/* translators: If there are characters in your language that are not supported
	   by dosis, translate this to 'off'. Do not translate into your own language. */
	$opensans = _x( 'on', 'Open Sans font: on or off', 'tvelements' );

	if ( 'off' !== $opensans ) {
		$query_args = array(
			'family' => 'Playfair+Display:400,700,400italic,700italic|Lora:400,700|Lato:400,700',
		);

		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Required Theme Styles
 *
 */
function tvelements_theme_styles() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'tvelements-fonts', tvelements_fonts_url(), array(), null );
	wp_enqueue_style( 'tvelements', get_stylesheet_uri(), array(), tvelements_version_id() );
}

add_action( 'wp_enqueue_scripts', 'tvelements_theme_scripts' );

/**
 * Required Theme Scripts
 *
 */
function tvelements_theme_scripts() {
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins/plugins.min.js', false, tvelements_version_id(), true );
	wp_enqueue_script( 'tvelements', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), tvelements_version_id(), true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'tvelements_theme_styles' );

/**
 * Modify main query to show Category set in Theme Options if set.
 *
 * @param WP_Query $query
 * @return WP_Query
 */
function tvelements_main_query_pre_get_posts( $query ) {	
	// Bail if Home page template, not the home page, not a query, not main query
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() )
		return;
		
	$query->set( 'cat', get_tvelements_option( 'home_category', null ) );
	$query->set( 'posts_per_page', ( get_tvelements_option( 'home_posts_count') ? get_tvelements_option( 'home_posts_count') : get_option( 'posts_per_page', 9 ) ) );
	$query->set( 'paged', tvelements_get_paged_query_var() );
}

add_action( 'pre_get_posts',      'tvelements_main_query_pre_get_posts' );

/*  Add responsive container to embeds
/* ------------------------------------ */ 
function alx_embed_html( $html ) {
    return '<div class="video-container">' . $html . '</div>';
}
 
add_filter( 'embed_oembed_html', 'alx_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'alx_embed_html' ); // Jetpack

/**
 * Register widget areas.
 */
function tvelements_register_widget_areas() {
	register_sidebar( array(
		'id'            => 'sidebar-1',
		'name'          => __( 'Sidebar', 'tvelements' ),
		'description'   => __( 'Main sidebar area displayed on right side of page via trigger.', 'tvelements' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>'
	) );

	register_sidebar( array(
		'id'            => 'footer',
		'name'          => __( 'Footer', 'tvelements' ),
		'description'   => __( 'Main fppter area displayed on bottom of page via trigger.', 'tvelements' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s col-sm-6 padding-xs-45 padding-sm-60 padding-md-90">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>'
	) );
}

add_action( 'widgets_init', 'tvelements_register_widget_areas' );
