<?php  
/**
 * @package tvelements
 */
?>		

	<?php if ( is_active_sidebar('footer') ) : ?>
	<div class="footer-widgets">
		<div class="container">
			<hr />

			<div class="row">
				<?php if ( ! dynamic_sidebar( 'footer' ) ) : endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<footer class="footer">
		<div class="container">
			<div class="row">
		
				<div class="footer-left col-sm-5">
			
					<p>
						<?php printf( __( 'Copyright %s', 'tvelements' ), date('Y') ); ?>
						<a href="<?php echo esc_url('http://press75.com', 'tvelements'); ?>" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'tvelements' ); ?>" rel="generator" target="_blank">
							<?php _e('Press 75', 'tvelements'); ?>
						</a>
					</p>
					<p><?php printf( __( 'tvelements - A %s Theme by %s', 'tvelements' ), 'WordPress', 'Press75' ); ?></p>
					
				</div>
				
				<div class="footer-right col-sm-7">
				
				
					<div class="socials">	
						<ul>
							<?php $socials = array('youtube', 'twitter', 'facebook', 'googleplus', 'linkedin', 'tumblr', 'vimeo', 'instagram' ); ?>
				
							<?php foreach($socials as $social) : ?>
								<?php $link = get_tvelements_option('socials_'  . $social ); ?>
								<?php if( $link ) : ?>
								<li>
									<a href="<?php echo esc_url($link); ?>" target="_blank">
										<svg class="icon icon-<?php echo $social; ?>" viewBox="0 0 32 32"><use xlink:href="#icon-<?php echo $social; ?>"></use></svg>
									</a>
								</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
						
						<a class="p75" href="<?php echo esc_url('http://press75.com', 'tvelements'); ?>" target="_blank">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logo.png" alt="<?php esc_attr_e("Press75",'tvelements'); ?>" />
						</a>
					</div>
				</div>
			
			</div>	
		</div><!-- .footer-content -->
	</footer><!-- .footer -->
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>