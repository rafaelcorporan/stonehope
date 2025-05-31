<?php
/**
 * Adds custom shortcode functionality
 *
 * @since 2.0
 */

// Button Shortcodes
function button_function( $atts ) {
      $atts = shortcode_atts( array(
           'type' => 'primary',
           'url' => '#',
           'text' => 'Button',
      ), $atts );

      return '<a class="btn btn-'.$atts['type'].'" href="'.$atts['url'].'">'.$atts['text'].'</a>';
}
add_shortcode( 'button', 'button_function' );


// Columns Shortcodes
function row_start_function( $atts, $content="" ) {
     return "<div class='row'>";
}
add_shortcode( 'row_start', 'row_start_function' );

function row_end_function( $atts, $content="" ) {
     return "</div>";
}
add_shortcode( 'row_end', 'row_end_function' );

// One Half
function one_half_function( $atts, $content="" ) {
     return "<div class='col-sm-6 col-sc'>$content</div>";
}
add_shortcode( 'one_half', 'one_half_function' );

function one_half_last_function( $atts, $content="" ) {
     return "<div class='col-sm-6 col-sc'>$content</div><div class='clearfix'></div>";
}
add_shortcode( 'one_half_last', 'one_half_last_function' );

// One Third
function one_third_function( $atts, $content="" ) {
     return "<div class='col-sm-4 col-sc'>$content</div>";
}
add_shortcode( 'one_third', 'one_third_function' );

function one_third_last_function( $atts, $content="" ) {
     return "<div class='col-sm-4 col-sc'>$content</div><div class='clearfix'></div>";
}
add_shortcode( 'one_third_last', 'one_third_last_function' );

// Two Third
function two_third_function( $atts, $content="" ) {
     return "<div class='col-sm-8 col-sc'>$content</div>";
}
add_shortcode( 'two_third', 'two_third_function' );

function two_third_last_function( $atts, $content="" ) {
     return "<div class='col-sm-8 col-sc'>$content</div><div class='clearfix'></div>";
}
add_shortcode( 'two_third_last', 'two_third_last_function' );

// One Fourth
function one_fourth_function( $atts, $content="" ) {
     return "<div class='col-sm-3 col-sc'>$content</div>";
}
add_shortcode( 'one_fourth', 'one_fourth_function' );

function one_fourth_last_function( $atts, $content="" ) {
     return "<div class='col-sm-3 col-sc'>$content</div><div class='clearfix'></div>";
}
add_shortcode( 'one_fourth_last', 'one_fourth_last_function' );

// Three Fourth
function three_fourth_function( $atts, $content="" ) {
     return "<div class='col-sm-9 col-sc'>$content</div>";
}
add_shortcode( 'three_fourth', 'three_fourth_function' );

function three_fourth_last_function( $atts, $content="" ) {
     return "<div class='col-sm-9 col-sc'>$content</div><div class='clearfix'></div>";
}
add_shortcode( 'three_fourth_last', 'three_fourth_last_function' );