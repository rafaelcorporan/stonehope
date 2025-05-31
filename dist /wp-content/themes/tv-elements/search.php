<?php
/**
 * The template for displaying search results pages.
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

					<?php get_template_part( 'content', 'search' ); ?>

				<?php endwhile; ?>

				<?php tvelements_paginate(); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>
	
	</div>
</div>

<?php get_footer(); ?>
