<?php
/**
 * Featured media content at top of pages
 *
 * @package tvelements
 */

?>

<div class="section textarea padding-xs-60">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

				<?php
				$post = get_tvelements_option('featured_post');
				$wp_query = new WP_Query(
					array(
						'post_type' => 'post',
						'posts_per_page' => 1,
						'post__in' => array( $post )
					)
				);
				?>
				<?php if( $wp_query->have_posts() ) : ?>
					
					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<h6><?php the_title(); ?></h6>
						<p class="large playfair italic"><?php echo get_the_excerpt(); ?></p>
					<?php endwhile; ?>

				<?php else : ?>

					<h6><?php _e('TV Elements', 'tvelements'); ?></h6>
					<p class="large playfair italic">
						<?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'tvelements' ), esc_url( admin_url( 'post-new.php' ) ) ); ?>
					</p>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
