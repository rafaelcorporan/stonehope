<?php

class NN_Customizer{

	public static function register ( $wp_customize ) {

		//Default modifications

		$wp_customize->remove_section('background_image');
		$wp_customize->remove_section('title_tagline');
		$wp_customize->add_section( 'general' , array(
		    'title'      => __( 'General Options', 'no-nonsense' ),
		    'priority'   => 10,
		) );

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_control( 'blogname' )->section = 'general';

		$wp_customize->remove_control( 'blogdescription' );

		$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
		$wp_customize->get_control( 'background_color' )->section = 'general';
		$wp_customize->get_control( 'background_image' )->section = 'general';


		$wp_customize->remove_control( 'header_textcolor' );
		$wp_customize->get_section( 'header_image' )->title = __( 'Header Options', 'no-nonsense' );

		// Header Options

		$wp_customize->add_setting( 'header_background_color',
			array(
				'default' => '#141414',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_header_background_color',
			array(
				'label' => __( 'Background Color', 'no-nonsense' ),
				'section' => 'header_image',
				'settings' => 'header_background_color',
				'priority' => 0,
			)
		));


		$wp_customize->add_setting( 'header_text_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_header_text_color',
			array(
				'label' => __( 'Text Color', 'no-nonsense' ),
				'section' => 'header_image',
				'settings' => 'header_text_color',
				'priority' => 0,
			)
		));


		$wp_customize->add_setting( 'header_logo_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_header_logo_color',
			array(
				'label' => __( 'Logo Color', 'no-nonsense' ),
				'section' => 'header_image',
				'settings' => 'header_logo_color',
				'priority' => 0,
			)
		));



		$wp_customize->add_setting( 'header_background_color',
			array(
				'default' => '#141414',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_header_background_color',
			array(
				'label' => __( 'Background Color', 'no-nonsense' ),
				'section' => 'header_image',
				'settings' => 'header_background_color',
				'priority' => 0,
			)
		));



		$wp_customize->add_setting( 'header_title',
			array(
				'default' => "Welcome To Our Site",
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
		    'nn_header_title',
		    array(
		        'label' => 'Header Title',
		        'section' => 'header_image',
		        'settings' => 'header_title',
		        'type' => 'text',
		        'priority' => 40
		    )
		);



		$wp_customize->add_setting( 'header_text',
			array(
				'default' => "",
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
		    'nn_header_text',
		    array(
		        'label' => 'Header Text',
		        'section' => 'header_image',
		        'settings' => 'header_text',
		        'type' => 'text',
		        'priority' => 50
		    )
		);



		// General Options

		$wp_customize->add_setting( 'box_background_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_box_background_color',
			array(
				'label' => __( 'Box Background Color', 'no-nonsense' ),
				'section' => 'general',
				'settings' => 'box_background_color',
				'priority' => 30,
			)
		));




		$wp_customize->add_setting( 'body_color',
			array(
				'default' => '#444444',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_body_color',
			array(
				'label' => __( 'Body Text Color', 'no-nonsense' ),
				'section' => 'general',
				'settings' => 'body_color',
				'priority' => 40,
			)
		));

		$wp_customize->add_setting( 'heading_color',
			array(
				'default' => '#222222',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_heading_color',
			array(
				'label' => __( 'Heading Text Color', 'no-nonsense' ),
				'section' => 'general',
				'settings' => 'heading_color',
				'priority' => 50,
			)
		));



		$wp_customize->add_setting( 'highlight_color',
			array(
				'default' => '#5592b9',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_highlight_color',
			array(
				'label' => __( 'Highlight Color', 'no-nonsense' ),
				'section' => 'general',
				'settings' => 'highlight_color',
				'priority' => 60,
			)
		));



		$wp_customize->add_setting( 'highlight_text_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_highlight_text_color',
			array(
				'label' => __( 'Highlight Text Color', 'no-nonsense' ),
				'section' => 'general',
				'settings' => 'highlight_text_color',
				'priority' => 70,
			)
		));



		$wp_customize->add_setting( 'sidebar_location',
			array(
				'default' => 'left',
				'transport' => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
		    'nn_sidebar_location',
		    array(
		        'type' => 'radio',
		        'label' => 'Sidebar Location',
				'section' => 'general',
				'settings' => 'sidebar_location',
		        'priority' =>80,
		        'choices' => array(
		            'left' => 'Left',
		            'right' => 'Right',
		        ),
		    )
		);



		// Footer Options

		$wp_customize->add_section( 'footer_options' , array(
		    'title'      => __( 'Footer Options', 'no-nonsense' ),
		    'priority'   => 40,
		) );


		$wp_customize->add_setting( 'footer_background_color',
			array(
				'default' => '#141414',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_footer_background_color',
			array(
				'label' => __( 'Background Color', 'no-nonsense' ),
				'section' => 'footer_options',
				'settings' => 'footer_background_color',
				'priority' => 0,
			)
		));


		$wp_customize->add_setting( 'footer_text_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_footer_text_color',
			array(
				'label' => __( 'Text Color', 'no-nonsense' ),
				'section' => 'footer_options',
				'settings' => 'footer_text_color',
				'priority' => 0,
			)
		));


		$wp_customize->add_setting( 'footer_logo_color',
			array(
				'default' => '#ffffff',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_footer_logo_color',
			array(
				'label' => __( 'Logo Color', 'no-nonsense' ),
				'section' => 'footer_options',
				'settings' => 'footer_logo_color',
				'priority' => 0,
			)
		));



		$wp_customize->add_setting( 'footer_background_color',
			array(
				'default' => '#141414',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'nn_footer_background_color',
			array(
				'label' => __( 'Background Color', 'no-nonsense' ),
				'section' => 'footer_options',
				'settings' => 'footer_background_color',
				'priority' => 0,
			)
		));

		// Error Settings

		$wp_customize->add_section( 'error_options' , array(
		    'title'      => __( 'Error Options', 'no-nonsense' ),
		    'priority'   => 50,
		) );


		$wp_customize->add_setting( '404_page_title',
			array(
				'default' => 'Page Not Found',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'nn_404_page_title',
			array(
				'label' => __( '404 Error Title', 'no-nonsense' ),
				'section' => 'error_options',
				'settings' => '404_page_title',
				'priority' => 0,
		        'type' => 'text',
			)
		);



		$wp_customize->add_setting( '404_page_text',
			array(
				'default' => 'It seems that the page you are looking for doesn\'t exist. Sorry for the inconveniense, try going back to the main page!',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			'nn_404_page_text',
			array(
				'label' => __( '404 Error Subtitle', 'no-nonsense' ),
				'section' => 'error_options',
				'settings' => '404_page_text',
				'priority' => 0,
		        'type' => 'text',
			)
		);

		$wp_customize->add_setting( '404_background',
			array(
				'default' => get_template_directory_uri() . '/images/defaults/error_404.jpg',
				'transport' => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);


		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'nn_404_background',
		        array(
		            'label' => 'Background Image',
		            'section' => 'error_options',
		            'settings' => '404_background'
		        )
		    )
		);

   }

	public static function header_output() {


	?>
	<!--Customizer CSS-->
	<style type="text/css">
		<?php self::generate_css('#headerBar', 'background', 'header_background_color'); ?>
		<?php self::generate_css('#headerLogo h2', 'color', 'header_logo_color'); ?>
		<?php self::generate_css_color('#headerMenu > div > ul > li > ul', 'background', 'header_background_color', 8); ?>
		<?php self::generate_css('#headerMenu > div > ul > li > ul li:hover,
#headerMenu > div > ul > li > ul li.current-menu-item,
#headerMenu > div > ul > li > ul li.current-menu-parent,
#headerMenu > div > ul > li > ul li.current-menu-ancestor', 'background', 'header_background_color'); ?>

		<?php self::generate_css('#headerMenu > div > ul > li a, #headerLogo h2 a', 'color', 'header_text_color'); ?>
		<?php self::generate_css_color('#headerMenu > div > ul > li:hover > a,
 #headerMenu > div > ul > li.current-menu-item > a,
 #headerMenu > div > ul > li.current-menu-parent > a,
 #headerMenu > div > ul > li.current-menu-ancestor > a', 'background', 'header_background_color', 8); ?>


		<?php self::generate_css('.box, .widget, .widget > ul li ul li, .widget_search form input[type="text"], .widget_categories .customSelect, .widget_archive .customSelect, .pagination .page-numbers', 'background', 'box_background_color'); ?>

		<?php self::generate_css_color('.box .box-content', 'border-color', 'box_background_color', -6 ); ?>

		<?php self::generate_css_color('input[type="text"], .box footer, input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], textarea, .customSelect, .widget h3, .widget_calendar #prev, .widget_calendar #next, .widget_calendar tfood .pad, .pagination .page-numbers:hover', 'background', 'box_background_color', -4 ); ?>



		<?php self::generate_css_color('input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], textarea, .widget, .customSelect', 'border-color', 'box_background_color', -8 ); ?>

		<?php self::generate_css_color('.widget_rss ul li', 'border-color', 'box_background_color', -4 ); ?>


		<?php self::generate_css('input[type="submit"], .button, .pagination .page-numbers.current', 'background', 'highlight_color'); ?>
		<?php self::generate_css('input[type="submit"], .button, .pagination .page-numbers.current', 'color', 'highlight_text_color'); ?>
		<?php self::generate_css('.widget h3', 'border-color', 'highlight_color' ); ?>

		<?php self::generate_css('a, .layout-post-list .meta-time a:hover, #headerLogo h2 a:hover', 'color', 'highlight_color' ); ?>
		<?php self::generate_css('*:focus', 'outline-color', 'highlight_color' ); ?>


		<?php self::generate_css_color('input[type="submit"]:hover, .button:hover', 'background', 'highlight_color', -6 ); ?>

	<?php
		$bg_404 = get_theme_mod( '404_background', get_template_directory_uri() . '/images/defaults/error404.jpg' );
		if( !empty( $bg_404 ) ) :
	?>
		body.custom-background.error404, body.error404 {
			background-image: url("<?php echo $bg_404 ?>");
			background-repeat:none;
			background-size:cover;
		}
	<?php endif ?>

	</style>
	<!--/Customizer CSS-->
	<?php
	}




	public static function live_preview() {
		wp_enqueue_script(
			'nn-themecustomizer',
			get_template_directory_uri() . '/js/theme-customizer.js',
			array(  'jquery', 'customize-preview', 'xcolor' ),
			'',
			true
		);

		wp_enqueue_script(
			'xcolor',
			get_template_directory_uri() . '/js/xcolor.min.js',
			array(  'jquery' ),
			'',
			true
		);

	}

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     *
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors and a property.
     * @since MyTheme 1.0
     */
    public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }


	public static function generate_css_color( $selector, $style, $mod_name, $amount = 0, $opacity = 1, $before = '', $after = '' ) {
		$mod = get_theme_mod($mod_name);

		if ( ! empty( $mod ) ) {
			$value = $mod;
			if( substr( $value, 0, 1 ) != '#' ) {
				$value = '#' . $value;
			}

			$color = new Dynamic_Color( $value );

			if( $amount > 0 ) {
				$value = $color->lighten( $amount );
			}
			elseif( $amount < 0 ) {
				$value = $color->darken( abs( $amount ) );
			}


			echo $selector . '{ ' . $style . ': ' . $before . ' ' . $value . ' ' . $after . ' }';
		}
	}


}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'NN_Customizer' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'NN_Customizer' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'NN_Customizer' , 'live_preview' ) );


?>
