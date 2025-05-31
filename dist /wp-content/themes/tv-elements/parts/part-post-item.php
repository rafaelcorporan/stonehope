<?php
/**
 * Single post items view
 *
 * @package tvelements
 */

$categories = wp_get_post_categories( $post->ID );
$term_list = '';
foreach ($categories as $category) {
	$thisCat = get_category($category);
	$term_list .= $thisCat->slug .' ';
}
?>

<div class="section item col-xs-12 col-sm-6 col-md-4 <?php echo $term_list; ?>">			
	<div class="section-thumb">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail('featured'); ?>
			<?php if( 'video' === get_post_format() && has_post_thumbnail() ) : ?>
				<svg class="icon icon-play"><use xlink:href="#icon-play"></use></svg>
			<?php endif; ?>
			<div class="figure"></div>
		</a>
	</div>
	<div class="section-title">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</div>
	<div class="section-excerpt">
		<?php echo wpe_excerpt('tvelements_excerpt_boxed', 'wpe_excerpt_more'); ?>
	</div>	
</div>