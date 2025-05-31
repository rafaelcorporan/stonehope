<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package tvelements
 */

get_header(); ?>
	
	<?php 
	$image = get_tvelements_option('video_image');
	$graphic = get_tvelements_option('video_graphic');
	$video_mp4 = get_tvelements_option('video_mp4');
	$video_ogv = get_tvelements_option('video_ogv');
	$video_webm = get_tvelements_option('video_webm');
	?>
	<?php if( $video_mp4 || $video_webm || $video_ogv ) : ?>
		<div class="banner" data-vide-bg="<?php echo ( $video_mp4 ? 'mp4: '.$video_mp4.',' : '' ); ?><?php echo ( $video_webm ? 'webm: '.$video_webm.',' : '' ); ?><?php echo ( $video_ogv ? 'ogv: '.$video_ogv.',' : '' ); ?>" data-vide-options="posterType: none, loop: true, muted: true, position: 50% 50%">
			<?php echo ($image ? '<img class="poster" src="'.$image['url'].'" />' : '' ); ?>
			<?php echo ($graphic ? '<div class="graphic-wrap"><img class="graphic" src="'.$graphic['url'].'" /></div>' : '' ); ?>
		</div>
	<?php else : ?>
		<div class="banner">
			<?php echo ($image ? '<img class="poster" src="'.$image['url'].'" />' : '' ); ?>
			<?php echo ($graphic ? '<div class="graphic-wrap"><img class="graphic" src="'.$graphic['url'].'" /></div>' : '' ); ?>
		</div>
	<?php endif; ?>

	<?php get_template_part( 'parts/part', 'featured-post' ); ?>

	<?php wp_reset_query(); ?>
	<?php 
	$homeCat = get_tvelements_option( 'home_category' ); 
	$featuredCat = get_cat_name( $homeCat );
	$featuredID = get_cat_ID( $featuredCat );
	?>
	<?php if( have_posts() ) : ?>
		<div class="section posts padding-sm-60">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 view-more">			
						<?php echo '<h6>' . ( $featuredCat ? $featuredCat : 'Latest Posts' ) . '</h6>'; ?>

						<?php if( $featuredID ) : ?>
							<?php printf( __( '<a class="more" href="%1$s" rel="bookmark">%2$s</a>', 'tvelements' ), esc_url( get_category_link( $featuredID ) ), 'View All' ); ?>
						<?php endif; ?>
					</div>
					<div class="item-wrapper">
						<?php $index = 1; ?>
						<?php while ( have_posts() ) : the_post(); ?>
							
							<?php get_template_part( 'parts/part', 'post-item' ); ?>
							
							<?php echo ( $index % 3 === 0 ? '<div class="clearfix visible-md visible-lg"></div>' : '' ); ?>
							<?php echo ( $index % 2 === 0 ? '<div class="clearfix visible-sm"></div>' : '' ); ?>
						
						<?php $index++; ?>
						<?php endwhile; // end of the loop. ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

<?php get_footer(); ?>
