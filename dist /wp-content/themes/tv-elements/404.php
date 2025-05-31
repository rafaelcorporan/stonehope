<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package tvelements
 */

get_header(); ?>

<?php get_template_part( 'parts/part', 'featured-media' ); ?>

<div class="container">
	<div class="row">

		<div id="primary" class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 content-area">
			<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">

				<div class="page-content">
					<h6><?php _e('Oh Noes', 'tvelements'); ?></h6>
					<p class="lg">
						<?php _e( '<h5>— We can’t seem to find the page you were looking for. Perhaps a quick look through these pages will help you find what you’re looking for: </h5>', 'tvelements' ); ?>
					</p>
					
					<?php 
					wp_nav_menu( 
						array( 
							'theme_location' => 'main_menu',
							'container_class' => 'entry-content-menu',
							'depth' => 1
						) 
					); 
					?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
	
	</div>
</div>

<?php get_footer(); ?>
