<?php
/**
 * The template for displaying all single video posts.
 *
 * @package tvelements
 */

get_header(); ?>

<div id="video" class="col-sm-3 col-md-2 col-md-offset-1 no-gutter">
	<div class="video-meta">	
		<?php printf('<p><strong>Date:</strong>%s</p>', get_the_date('Y')); ?>
		<?php $author = get_post( $post->ID ); ?>
		<?php printf('<p><strong>By:</strong>%s</p>', get_the_author_meta('user_nicename', $author->post_author)); ?>
		<p><strong>Category:</strong><?php echo get_the_category_list( __( ', ', 'tvelements' ) ); ?></p>
	</div>
</div>

<div id="primary" class="col-sm-8 col-sm-offset-1 col-md-7 content-area">
	<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'video' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->
</div><!-- #primary -->