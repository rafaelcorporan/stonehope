<?php
/**
 * Featured media content at top of pages
 *
 * @package tvelements
 */

?>

<div class="featured-media">

	<?php if( 'image' === get_post_format() ) : ?>

		<div class="featured-thumb">
			<?php the_post_thumbnail('full'); ?>
		</div>	

	<?php elseif( is_archive() || is_category() || is_search() || is_404() ) : ?>	
		
		<?php $featured = get_tvelements_option('featured_image'); ?>
		<div <?php echo ( $featured['url'] ? 'class="featured-header" style="background: url('. $featured['url'] .') no-repeat center top; background-size: cover;"' : 'class="featured-header text"' ); ?>>
			<h1 class="entry-title"><?php tvelements_archives_title(); ?></h1>
		</div>

	<?php elseif( 'video' === get_post_format() ) : ?>	

		<?php // do nothing here ?>

	<?php elseif( !is_single() && has_post_thumbnail() ) : ?>	

		<?php
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src($image_id,'large', true);
		?>
		<div class="featured-header" <?php if( $image_url ) : ?>style="background: url(<?php echo $image_url[0]; ?>) no-repeat center top; background-size: cover;"<?php endif; ?>>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>	

	<?php elseif( is_page() ) : ?>	

		<div class="featured-header text">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>

	<?php else : ?>

		<div class="break"></div>

	<?php endif; ?>
	
</div>