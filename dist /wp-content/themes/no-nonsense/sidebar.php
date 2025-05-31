<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */
?>
<ul class='sidebar'>
<?php if( is_active_sidebar('sidebar') ) : ?>
<?php dynamic_sidebar( 'sidebar' ) ?>
<?php else : ?>


<li class="widget widget_search">
	<h3><?php _e( 'Search', 'no-nonsense' ) ?></h3>
	<?php get_search_form(); ?>
</li>


<li class="widget widget_archive">
	<h3><?php _e( 'Archives', 'no-nonsense' ) ?></h3>
	<ul>
	<?php wp_get_archives( 'type=monthly' ); ?>
	</ul>
</li>

<li class="widget widget_meta">
	<h3><?php _e( 'Meta', 'no-nonsense' ) ?></h3>
	<ul>
		<li><?php wp_loginout(); ?></li>
		<li><a href='<?php bloginfo( 'rss2_url' ) ?>'><?php _e( 'Entries RSS', 'no-nonsense' ) ?></a></li>
		<li><a href='<?php bloginfo( 'rss2_url' ) ?>'><?php _e( 'Entries RSS', 'no-nonsense' ) ?></a></li>		
		<li><a href='http://wordpress.org'><?php _e( 'WordPress.org', 'no-nonsense' ) ?></a></li>		
	</ul>
</li>


<?php endif ?>






</ul>