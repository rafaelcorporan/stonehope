<?php
/**
 * @package tvelements
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h4 class="entry-title">', '</h4>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-meta">
		<?php the_time('F j, Y'); ?> // <?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?>
	</div>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'tvelements' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<div class="entry-footer-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list();

			if($category_list) {
				
				printf( __( 'This entry was posted in: %1$s', 'tvelements' ), $category_list );
			}

			printf( __( '<span class="upper">Bookmark the <a href="%1$s" rel="bookmark">permalink</a>.</span>', 'tvelements' ), get_permalink() );
		?>
		<?php edit_post_link( __( 'Edit', 'tvelements' ), '<span class="edit-link upper">', '</span>' ); ?>
		</div>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
