<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package tvelements
 */

get_header(); ?>

<?php get_template_part( 'parts/part', 'featured-media' ); ?>

<div class="container">
	<div class="row">

		<div id="primary" class="col-sm-8 content-area">
			<main id="main" class="site-main" role="main">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post(); ?>
					
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