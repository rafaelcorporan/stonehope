<?php 
/**
 * The blog posts template file.
 *
 * Template Name: Blog
 *
 * @package tvelement
 */
 
get_header(); ?>

<?php get_template_part( 'parts/part', 'featured-media' ); ?>

<div class="container">
	<div class="row">

		<div id="primary" class="col-sm-8 content-area">
			<main id="main" class="site-main" role="main">

				<?php
				$wp_query = new WP_Query(
					array(
						'post_type'			=> 'post',
						'paged'				=> $paged,
						'posts_per_page' 	=> get_option('posts_per_page'),
					)
				);
				?>
				<?php if( $wp_query->have_posts() ) : ?>
					
					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
					
						<?php get_template_part( 'content' ); ?>
							
					<?php endwhile; ?>
						
				<?php else : ?>
		
					<?php get_template_part( 'content', 'none' ); ?>
		
				<?php endif; ?>
				
				<?php echo tvelements_paginate(); ?>
		
			</main><!-- #main -->

		</div><!-- #primary -->

		<?php get_sidebar(); ?>
	
	</div>
</div>

<?php get_footer(); ?>
