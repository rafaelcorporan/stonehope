<?php
/**
 * Get Option
 *
 * Return given option value or return default
 *
 * @since 1.0
 */
function get_tvelements_option( $option_name, $default = false ) {

	$tvelements_options = get_theme_mod( 'tvelements_options' );

	if ( isset( $tvelements_options[$option_name] ) )
		$option = $tvelements_options[$option_name];
	
	if ( ! empty( $option ) )
		return $option;
	
	return $default;
	
}

/**
 * Sanitize Text Input
 *
 * @since 1.0
 */
function input_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Sanitize Dropdown
 *
 * @since 1.0
 */
function dropdown_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function tvelements_customize_register( $wp_customize ) {

	if ( $wp_customize->is_preview() && ! is_admin() )
		add_action( 'wp_footer', 'tvelements_customize_preview', 21 );
	
	// load the control itself
	require_once dirname( __FILE__ ) . '/customizer/advanced-upload-control.php';

	/**
	 * Site Title & Description Section
	 */
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/**
	 * Site Colors
	 */
	$wp_customize->add_setting(
	    'tvelements_options[primary_color]',
	    array(
	        'default'     => '#988f80',
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'link_color',
	        array(
	            'label'      => __( 'Primary Site Color', 'tvelements' ),
	            'section'    => 'colors',
	            'settings'   => 'tvelements_options[primary_color]'
	        )
	    )
	);
	
	
	$wp_customize->add_setting(
	    'tvelements_options[secondary_color]',
	    array(
	        'default'     => '#efe8d9',
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'meta_color',
	        array(
	            'label'      => __( 'Secondary Site Color', 'tvelements' ),
	            'section'    => 'colors',
	            'settings'   => 'tvelements_options[secondary_color]'
	        )
	    )
	);
	
	$wp_customize->add_panel( 'tvelements_panel', array(
	    'priority'       => 120,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'TV Elements',
	    'description'    => 'This section controls the options for TV Elements.',
	) );

	/**
	 * General Section
	 */
	$wp_customize->add_section( 'general_section',
		array(
			'title'    => __( 'General Options', 'tvelements' ),
			'priority' => 112,
			'panel'   => 'tvelements_panel',
		)	
	);

	$wp_customize->add_setting( 'tvelements_options[header_scheme]',
	    array(
	        'default' => 'light',
	    )
	);
	$wp_customize->add_control( 'tvelements_options[header_scheme]',
		array(
			'type'    => 'select',
			'section' => 'general_section',
			'label'   => __( 'Header Color', 'tvelements' ),
			'priority' 	 => 1,
			'choices' => array(
				'dark' => 'Dark',
				'light' => 'Light',
			)
		)
	);

	$wp_customize->add_setting( 'tvelements_options[featured_image]' );
	$wp_customize->add_control(
	    new P75_Advanced_Upload_Control(
	        $wp_customize,
	        'p75-uploader',
	        array(
	            'label'      => __( 'Default Featured Image', 'tvelements' ),
				'section' => 'general_section',
	            'settings'   => 'tvelements_options[featured_image]'
	        )
	    )
	);

	/**
	 * Video Section Options
	 */

	$wp_customize->add_section( 'video_section',
		array(
			'title'    => __( 'Featured Video', 'tvelements' ),
			'priority' => 113,
			'panel'   => 'tvelements_panel',
		)	
	);
	
	$wp_customize->add_setting( 'tvelements_options[video_mp4]',
	    array(
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control( 'tvelements_options[video_mp4]',
		array(
			'type'    => 'text',
			'section' => 'video_section',
			'label'   => __( 'Video MP4', 'tvelements' ),
			'priority' 	 => 0,
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[video_ogv]',
	    array(
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control( 'tvelements_options[video_ogv]',
		array(
			'type'    => 'text',
			'section' => 'video_section',
			'label'   => __( 'Video OGV', 'tvelements' ),
			'priority' 	 => 0,
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[video_webm]',
	    array(
	        'sanitize_callback' => 'input_sanitize_text',
	    )
	);
	$wp_customize->add_control( 'tvelements_options[video_webm]',
		array(
			'type'    => 'text',
			'section' => 'video_section',
			'label'   => __( 'Video WebM', 'tvelements' ),
			'priority' 	 => 0,
		)
	);

	$wp_customize->add_setting('tvelements_options[video_image]');
	$wp_customize->add_control(
	    new P75_Advanced_Upload_Control(
	        $wp_customize,
	        'p75-video_image',
	        array(
	            'label'      => __( 'Featured Video Image', 'tvelements' ),
				'section' => 'video_section',
	            'settings'   => 'tvelements_options[video_image]',
				'priority' 	 => 5,
	        )
	    )
	);

	$wp_customize->add_setting('tvelements_options[video_graphic]');
	$wp_customize->add_control(
	    new P75_Advanced_Upload_Control(
	        $wp_customize,
	        'p75-video_graphic',
	        array(
				'section' => 'video_section',
				'label'   => __( 'Featured Image Overlay', 'tvelements' ),
	            'settings'   => 'tvelements_options[video_graphic]',
				'priority' 	 => 6,
	        )
	    )
	);
	
	/**
	 * Homepage
	 */
	$wp_customize->add_section( 'home_page',
		array(
			'title'    => __( 'Homepage', 'tvelements' ),
			'priority' => 114,
			'panel'   => 'tvelements_panel',
		)	
	);

	$wp_customize->add_setting( 'tvelements_options[featured_post]',
	    array(
	        'sanitize_callback' => 'dropdown_sanitize_integer',
	    )
	);
	$wp_customize->add_control( 'tvelements_options[featured_post]',
		array(
			'type'    => 'select',
			'section' => 'home_page',
			'label'   => __( 'Featured Post', 'tvelements' ),
			'choices' => tvelements_get_post_list( array( 'posts_per_page' => -1 ) ),
		)
	);

	$wp_customize->add_setting( 'tvelements_options[home_category]',
	    array(
	        'sanitize_callback' => 'dropdown_sanitize_integer',
	    )
	);
	$wp_customize->add_control( 'tvelements_options[home_category]',
		array(
			'type'    => 'select',
			'section' => 'home_page',
			'label'   => __( 'Latest Posts - Category', 'tvelements' ),
			'choices' => tvelements_get_category_list( array( 'show_count' => 1 ) ),
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[home_posts_count]' );
	$wp_customize->add_control( 'tvelements_options[home_posts_count]',
		array(
			'type'    => 'text',
			'section' => 'home_page',
			'label'   => __( 'Posts to Show', 'tvelements' ),
		)
	);


	/**
	 * Social Options
	 */

	$wp_customize->add_section( 'socials',
		array(
			'title'    => __( 'Social Icons', 'tvelements' ),
			'priority' => 115,
			'panel'   => 'tvelements_panel',
		)	
	);

	$wp_customize->add_setting( 'tvelements_options[socials_facebook]' );
	$wp_customize->add_control( 'tvelements_options[socials_facebook]',
		array(
			'type'    => 'text',
			'section' => 'socials',
			'label'   => __( 'Facebook', 'tvelements' ),
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[socials_twitter]' );
	$wp_customize->add_control( 'tvelements_options[socials_twitter]',
		array(
			'type'    => 'text',
			'section' => 'socials',
			'label'   => __( 'Twitter', 'tvelements' ),
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[socials_linkedin]' );
	$wp_customize->add_control( 'tvelements_options[socials_linkedin]',
		array(
			'type'    => 'text',
			'section' => 'socials',
			'label'   => __( 'Linkedin', 'tvelements' ),
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[socials_googleplus]' );
	$wp_customize->add_control( 'tvelements_options[socials_googleplus]',
		array(
			'type'    => 'text',
			'section' => 'socials',
			'label'   => __( 'Google Plus', 'tvelements' ),
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[socials_tumblr]' );
	$wp_customize->add_control( 'tvelements_options[socials_tumblr]',
		array(
			'type'    => 'text',
			'section' => 'socials',
			'label'   => __( 'Tumblr', 'tvelements' ),
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[socials_instagram]' );
	$wp_customize->add_control( 'tvelements_options[socials_instagram]',
		array(
			'type'    => 'text',
			'section' => 'socials',
			'label'   => __( 'Instagram', 'tvelements' ),
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[socials_youtube]' );
	$wp_customize->add_control( 'tvelements_options[socials_youtube]',
		array(
			'type'    => 'text',
			'section' => 'socials',
			'label'   => __( 'YouTube', 'tvelements' ),
		)
	);
	
	$wp_customize->add_setting( 'tvelements_options[socials_vimeo]' );
	$wp_customize->add_control( 'tvelements_options[socials_vimeo]',
		array(
			'type'    => 'text',
			'section' => 'socials',
			'label'   => __( 'Vimeo', 'tvelements' ),
		)
	);
	
	/**
	 * Portfolio
	 */

	$wp_customize->add_section( 'portfolio_section',
		array(
			'title'    => __( 'Portfolio', 'tvelements' ),
			'priority' => 116,
			'panel'   => 'tvelements_panel',
		)	
	);

	$wp_customize->add_setting( 'tvelements_options[portfolio_cat]',
	    array(
	        'sanitize_callback' => 'dropdown_sanitize_integer',
	    )
	);
	$wp_customize->add_control( 'tvelements_options[portfolio_cat]',
		array(
			'type'    => 'select',
			'section' => 'portfolio_section',
			'priority' 	 => 2,
			'label'   => __( 'Portfolio - Category', 'tvelements' ),
			'choices' => tvelements_get_category_list( array( 'show_count' => 1 ) ),
		)
	);

}
add_action( 'customize_register', 'tvelements_customize_register' );


/**
 * Customize Preview
 *
 * Allows transported customizer options to be displayed without delay.
 *
 * @since 1.0
 */
function tvelements_customize_preview() { ?>

<script type="text/javascript">
( function( $ ) {
	/* Site title and description. */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	});

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	});

	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			$( '#page' ).css('background-color', to );
		} );
	});

} )( jQuery );
</script>

<?php }
