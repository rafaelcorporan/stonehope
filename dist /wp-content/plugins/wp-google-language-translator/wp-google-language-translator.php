<?php
/*
*	Plugin Name:wp-google-language-translator
	Plugin URI: http://webriti.com/plugins/wp-google-language-translator/
	Description:Google Language Translator for WordPress. 
	Version: 0.1
	Author: vibhorp,priyanshu.mittal
	Author URI: http://webriti.com
	License: GPL V2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
/////##########################/////////////
define( 'WPGLT', plugin_dir_url( __FILE__ ) );
////###########################////////////


	function wpglt_activate() {
        add_option('webrititranslator_active', 1); 
        add_option('webrititranslator_display','Vertical');
	}

	function wpglt_page_layout (){      
      $wpt_page=add_menu_page('WP', 'WP Google Language Translator', 'manage_options', 'wp_google_language_translator', 'wpglt_layout_cb');	
	  add_action( 'admin_print_styles-'.$wpt_page, 'wpglt_scripts');  
    }	
    add_action('admin_menu', 'wpglt_page_layout');	

	//Inc scripts
	function wpglt_scripts() { 			
			wp_enqueue_style( 'style-option',WPGLT.'/css/style-option.css');
			wp_enqueue_script( 'easytab',WPGLT.'/js/easy_tab.js'  ); 
	  }
	
	//Settings INIT  
	function wpglt_initialize_settings() {    
    
	add_settings_section(  
        'wpglt_settings',
        'Settings',
        '',
        'wp_google_language_translator'
		);   
    

    //Settings
    add_settings_field( 'webrititranslator_active','Plugin status:','wpglt_active_cb','wp_google_language_translator','wpglt_settings');
    add_settings_field( 'webrititranslator_display', 'Layout Options','wpglt_display_cb','wp_google_language_translator','wpglt_settings');
    
  
  
    //Register Settings
    register_setting( 'wp_google_language_translator','webrititranslator_active'); 
    register_setting( 'wp_google_language_translator','webrititranslator_display');	
  
    function wpglt_active_cb() {	  
	  $display_option_name = 'webrititranslator_active' ;
      $set_new_value = 1;

      if ( get_option( $display_option_name ) === false ) {
     
      update_option( $display_option_name, $set_new_value );
	  } 
	  
	  $options_active = get_option (''.$display_option_name.'');
	  		
	  $html = '<input type="checkbox" name="webrititranslator_active" id="webrititranslator_active" value="1" '.checked(1,$options_active,false).'/> &nbsp; Activate WP-Google-Language-Translator?';
	  echo $html;
	} 
  
  function wpglt_display_cb() {
	
	$display_option_name = 'webrititranslator_display' ;
    $set_new_value = 'Vertical';

      if ( get_option( $display_option_name ) === false ) {       
      update_option( $display_option_name, $set_new_value );
	  }	  
	  $options_active = get_option (''.$display_option_name.'');
	  ?>
	  <select name="webrititranslator_display" id="webrititranslator_display" style="width:170px;">
		 <option value="Vertical" <?php if(get_option('webrititranslator_display')=='Vertical'){echo "selected";}?>>Vertical</option>
		 <option value="Horizontal" <?php if(get_option('webrititranslator_display')=='Horizontal'){echo "selected";}?>>Horizontal</option>		 
	  </select>  
<?php } 
} 
add_action('admin_init', 'wpglt_initialize_settings');

 //Style 1 
 function wpglt_translator_horizontal(){
  $is_active = get_option ( 'webrititranslator_active' ); 
  $str = null;
	if( $is_active == 1) {
        $str.='<script type="text/javascript">function GoogleLanguageTranslatorInit() {new google.translate.TranslateElement({pageLanguage: \'\',layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL,autoDisplay: false }, \'google_language_translator\'); } </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=GoogleLanguageTranslatorInit"></script><div id="google_language_translator"></div>';
		return $str;
				
	}
}

 //Style 2
function wpglt_translator_vertical() {    
  $is_active = get_option ( 'webrititranslator_active' ); 
  $str = null;
	if( $is_active == 1){        		  
		
        $str.='<script type="text/javascript">     
         function GoogleLanguageTranslatorInit() { new google.translate.TranslateElement({pageLanguage: \'\',autoDisplay: false }, \'google_language_translator\'); } </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=GoogleLanguageTranslatorInit"></script><div id="google_language_translator"></div>';
		return $str;
  }
}
//Form for plugin
function wpglt_layout_cb() { ?>
<div id="wpbody">
	<div id="wpbody-content">
		<div class="webriti-header webriti-themepromo">
				<h2 class="head_title_img"><a href="http://www.webriti.com/"><img class="logo_webriti" src="<?php echo WPGLT.'/images/logo.png' ?>"></a></h2>
				<div class="wpt_heading">WP-GOOGLE-LANGUAGE-TRANSLATOR</div>				
		</div>
		<div  class="wrap"> 
			<div id="icon-options-general" class="icon32"><br></div>
				<h2 class="nav-tab-wrapper">
					<a href="#wpt_translator"  class="nav-tab nav-tab-active" id="wpt_translator_tab">Settings</a>
					<a href="#wpt_translator_help" class="nav-tab" id="wpt_translator_tab">Subscribe to Newsletter</a>
				</h2>
			<div id="easy_optionsframework-metabox" class="metabox-holder">				
				<div class="group "style="display: active; background:white" id="wpt_translator" >
					<form method="post" action = "<?php echo admin_url('options.php'); ?>">
						<div class="postbox _wpt">
						<?php settings_fields('wp_google_language_translator'); ?>
							<div class="inside">
							<div class="wpt_install"><p>Use [wp-google-language-translator] shortcode in pages or posts.</p>
							<p>Plugin Enable:&nbsp;&nbsp;<?php wpglt_active_cb(); ?></p>
							<p>Position:&nbsp;&nbsp;<?php wpglt_display_cb(); ?></p>
							<p><?php submit_button(); ?></p>
							</div>													
							<div class="wpt_preview"><h4>Preview</h4>							
							<h4 class="heading_wpt"><?php echo do_shortcode('[wp-google-language-translator]'); ?></h4>
							<h4 class="heading">Translated text:&nbsp;&nbsp;</h4><span>Hello</span>
							</div>							
							</div>
						</div>
					</form>
				</div>
				<div class="group postbox" style="display: none; background:white" id="wpt_translator_help" >
						<div title="Click to toggle" class="handlediv"><br></div>
						<h3 class="hndle"><span>Help And Support<span class="postbox-title-action"></h3>
						<div class="inside">				
							<p style = "font-size: 15px;"><strong>1. Get Support</strong></p>
							<p style = "font-size: 14px;">If you have any question or need support then feel free to contact us via the WordPress Support Forums.</p>
							<p style = "font-size: 15px;"><strong>2.Join Our Newsletter</strong></p>
							<p style = "font-size: 14px;">
								<a target="_blank" href="http://webriti.com/news/">
									<img class="subs_img" src="<?php echo WPGLT; ?>/images/subscribe_newsletter.jpg">
								</a> 
							</p>
						</div>
				</div>	
			</div>
		</div>
	</div>
</div>
</div>	
<?php
}
function wpglt_shortcode() {
    if (get_option('webrititranslator_display')=='Vertical'){
    return wpglt_translator_vertical();
    }

    elseif(get_option('webrititranslator_display')=='Horizontal'){
    return wpglt_translator_horizontal();
    }
}
add_shortcode( 'wp-google-language-translator', 'wpglt_shortcode');
add_filter('widget_text', 'do_shortcode');


///////////////////********Sidebar Widget***************////////////////////////////////
add_action( 'widgets_init','wpglt_widget'); 
function wpglt_widget() { return   register_widget( 'WP_Google_Lanuage_Translator' ); }

class WP_Google_Lanuage_Translator  extends WP_Widget {

public function __construct() {
parent::__construct(
'WP_Google_Lanuage_Translator', // Base ID
'WP Google Language Translator', // Widget Name
array( 'description' => __( 'Go to Plugin Admin Page > WP Google Language Translator to configure this widget.', '' ), ) // Args
);
}

public function widget( $args, $instance ) {

$title = null;
extract( $args );
if (! empty( $instance['title'] ) ) { $title = apply_filters('widget_title', $instance['title'] ); }
echo $before_widget;
echo wpglt_shortcode();
echo $after_widget;
}
}
?>