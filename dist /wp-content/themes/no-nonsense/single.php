<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */

get_header(); ?>
<div class='row'>
	<div class='columns small-12 medium-8 large-9 medium-push-4 large-push-3' id='siteContent'>
		<?php 
			echo '<div class="post-list">';
			while( have_posts() ) {
				the_post();
				get_template_part( 'layouts/post', 'single' );
			}
			echo '</div>';
		?>
	</div>
	<div class='columns small-12 medium-4 large-3 medium-pull-8 large-pull-9' id='siteSidebar'>
		<?php get_sidebar() ?>
	</div>

</div>


<?php get_footer() ?>