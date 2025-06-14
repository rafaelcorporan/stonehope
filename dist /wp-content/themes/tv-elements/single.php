<?php
/**
 * The template for displaying all single posts.
 *
 * @package tvelements
 */

get_header(); ?>

<?php get_template_part( 'parts/part', 'featured-media' ); ?>

<div class="container">
	<div class="row">
		
		<?php if( 'video' != get_post_format() ) : ?>

			<div id="primary" class="col-sm-8 content-area">
				<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'single' ); ?>

						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		<?php else : ?>

			<?php get_template_part( 'parts/part', 'single-video' ); ?>

		<?php endif; ?>
	
	</div>
</div>

<?php get_footer(); ?>