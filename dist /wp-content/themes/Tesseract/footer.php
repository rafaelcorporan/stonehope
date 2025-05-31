<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Tesseract
 */
?>
	</div><!-- #content -->

		<div class="footer-right col-sm-7">
		<footer id="colophon" class="site-footer" role="contentinfo">
  <div id="footer-banner" class="cf menu-is-additional">
    <div id="horizontal-menu-wrap" class="is-additional social">
      <div id="horizontal-menu-before" class="switch thm-left-left is-menu">
        <ul class="hm-social">
          <li>
            <a target="_blank" href="https://www.facebook.com/stonehope.org" title="Follow Us on Facebook">
              <img width="24" height="24" alt="Facebook icon" src="http://104.197.132.141/wp-content/uploads/2015/06/FACEBOOK_.png">
            </a>
          </li>
          <li>
            <a target="_blank" href="https://twitter.com/twittstonehope" title="Follow Us on Twitter">
              <img width="24" height="24" alt="Twitter icon" src="http://104.197.132.141/wp-content/uploads/2015/06/TWITT-.png">
            </a>
          </li>
          <li>
            <a target="_blank" href="https://plus.google.com/+stonehopeorg2015/about" title="Follow Us on Google Plus">
              <img width="24" height="24" alt="Google Plus icon" src="http://104.197.132.141/wp-content/uploads/2015/06/G-PLUS.png">
            </a>
          </li>
          <li>
            <a target="_blank" href="http://www.linkedin.com/in/stonehope" title="Follow Us on LinkedIn">
              <img width="24" height="24" alt="LinkedIn icon" src="http://104.197.132.141/wp-content/uploads/2015/06/LINKED-IN1.png">
            </a>
          </li>
          <li>
    	   <a class="fancybox-youtube" target="_blank" href="https://www.youtube.com/watch?v=VM7QS5dTnqc" title="Follow Us on YouTube">
              <img width="24" height="24" alt="YouTube icon" src="http://104.197.132.141/wp-content/uploads/2015/06/YOUTUBE-.png">
            </a>
          </li>
          <li>
            <a target="_blank" href="https://www.pinterest.com/stonehopes/" title="Follow Us on Pinterest">
              <img width="24" height="24" alt="Pinterest icon" src="http://104.197.132.141/wp-content/uploads/2015/06/Pinterest___.png">
            </a>
          </li>
        </ul>
      </div>   
<?php $additional = get_theme_mod('tesseract_tfo_footer_additional_content') ? true : false;

        $menuClass = 'only-menu';
        if ( $additional ) $menuClass = 'is-additional';
       
        $menuEnable = get_theme_mod('tesseract_tfo_footer_content_enable');
        $menuSelect = get_theme_mod('tesseract_tfo_footer_content_select');
        $addcontent_hml = get_theme_mod('tesseract_tfo_footer_additional_content');		
		$addcontent_hml = $addcontent_hml ? $addcontent_hml : 'notset';		
		?>
    
    	<div id="footer-banner" class="cf<?php echo ' menu-' . $menuClass; ?>">		               
                    
                    <div id="horizontal-menu-wrap" class="<?php echo $menuClass . ' ' . $addcontent_hml; ?>">
                    
                        <?php // SHOUDLD some additional content added before the menu?
                        if ( ( $addcontent_hml !== 'nothing' ) && ( $addcontent_hml !== 'notset' ) ) : ?>
                        
                        	<div id="horizontal-menu-before" class="switch thm-left-left<?php if ( ( $menuEnable && ( $menuEnable == 1 ) ) || !$menuEnable ) echo ' is-menu'; ?>"><?php tesseract_horizontal_footer_menu_additional_content( $addcontent_hml ); ?></div>
                        
                        <?php endif; //EOF left menu - IS before content ?>
                        
                        <?php if ( ( $menuEnable && ( $menuEnable == 1 ) ) || !$menuEnable ) : ?>
                        
                            <section id="footer-horizontal-menu"<?php if ( $addcontent_hml && ( $addcontent_hml !== 'nothing' ) && ( $addcontent_hml !== 'notset' ) ) echo ' class="is-before"'; ?>>
                                <div>
                                    
                                    <?php $anyMenu = get_terms( 'nav_menu' ) ? true : false;
                                    
                                    if ( $anyMenu ) :
                                    
                                        if ( $menuSelect !== 'none' ) :  
                                            wp_nav_menu( array( 'menu' => $menuSelect, 'container_class' => 'footer-menu', 'depth' => 1 ) );
                                        elseif ( ( $menuSelect == 'none' ) || !$menuSelect || !$menuEnable ) :
                                            $menu = get_terms( 'nav_menu' ); 
                                            $menu_id = $menu[0]->term_id;						
                                            wp_nav_menu( array( 'menu_id' => $menu_id ) );																
                                        endif; ?>  
                                        
                                    <?php else : 
                                    
                                        wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'depth' => 1 ) );
                                   
                                    endif; ?>   
                                                                          
                                </div>
                                
                            </section> 
                       
                       	<?php endif; ?>                   
                                              
           			</div><!-- EOF horizontal-menu-wrap -->                       
               <div id="designer">               
                <?php printf(  '<a href="http://stonehope.org">stonehope</a>' ); ?>
            </div>            
            
      	</div>  
        
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
