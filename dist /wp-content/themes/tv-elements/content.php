<?php
/**
 * @package tvelements
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
	
	<?php if( has_post_thumbnail() ) : ?>
		<div class="entry-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('featured-lg'); ?>
			</a>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_title( '<h4 class="entry-title">', '</h4>' ); ?>
		</a>
	</header><!-- .entry-header -->

	<div class="entry-meta">
		<?php the_time('F j, Y'); ?> // <a href="<?php comments_link(); ?>"><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></a>
	</div>

	<div class="entry-content">
		<?php echo wpe_excerpt('tvelements_excerpt_blog', 'tvelements_new_excerpt_readmore'); ?>

		<a class="btn btn-primary" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e('Read More &raquo;', 'tvelements'); ?></a>
	</div><!-- .entry-content -->
</article><!-- #post-## -->