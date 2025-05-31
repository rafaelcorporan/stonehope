<?php
/**
 * Setup the WordPress core custom header feature.
 *
 * @package tvelements
 */

function tvelements_custom_background_setup() {

	$args = array(
		'default-color' => '252525',
	);

	add_theme_support( 'custom-background', apply_filters( 'tvelements_custom_background_args', $args ) );

}

add_action( 'after_setup_theme', 'tvelements_custom_background_setup' );
