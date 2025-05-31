<?php 
/**
 * The full width page template file.
 *
 * Template Name: Portfolio
 *
 * @package tvelement
 */
$featuredCat = get_tvelements_option('portfolio_cat');
 
get_header(); ?>

<?php get_template_part( 'parts/part', 'featured-media' ); ?>

<?php
$args = array(
	'paged' => $paged,
	'post_type' => 'post',
	'posts_per_page' => ( $featuredCat > 0 ? -1 : get_option('posts_per_page') ),
);

if($featuredCat > 0) {
	$args['category__in'] = array( $featuredCat );
}
$wp_query = new WP_Query($args);
?>
<?php if( $wp_query->have_posts() ) : ?>
	<div class="section posts padding-sm-60">
		<div class="container">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">			
					<?php echo '<h6>'. ( ($featuredCat > 0) ? 'Filter ' .get_cat_name($featuredCat) : 'Latest Posts' ) . '</h6>'; ?>
				</div>
				<?php if($featuredCat > 0) : ?>
					<div class="item-filter col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
						<ul>
							<?php 
							$categories = get_categories('child_of='.$featuredCat); 
							$option = '<li><a class="filterBtn" data-filter=".item"><h5>All</h5></a></li>';
							foreach ($categories as $category) {
								$option .= '<li>&mdash;</li>';
								$option .= '<li><a class="filterBtn" data-filter=".'.$category->slug.'"><h5>';
								$option .= $category->cat_name;
								$option .= '</h5></a></li>';
							}
							echo $option;
							?>
						</ul>
					</div>
				<?php endif; ?>
				<div class="portfolio-wrapper item-wrapper">
					<?php $index = 1; ?>
					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						
						<?php get_template_part( 'parts/part', 'post-item' ); ?>
					
					<?php $index++; ?>
					<?php endwhile; // end of the loop. ?>
				</div>
				
				<?php echo tvelements_paginate(); ?>
			</div>
		</div>
	</div>
<?php endif; wp_reset_query(); ?>

<?php get_footer(); ?>