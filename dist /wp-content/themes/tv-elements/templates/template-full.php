<?php 
/**
 * The full width page template file.
 *
 * Template Name: Full Width
 *
 * @package tvelement
 */
 
get_header(); ?>

<?php get_template_part( 'parts/part', 'featured-media' ); ?>

<div class="container">
	<div class="row">

		<div id="primary" class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 content-area">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	
	</div>
</div>

<?php get_footer(); ?>
