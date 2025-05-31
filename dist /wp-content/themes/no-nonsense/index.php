<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */

get_header(); ?>

<div class='row'>
	<div <?php nn_content_class() ?> id='siteContent'>
		<?php
			if( have_posts() ) {
				echo '<div class="post-list">';
				while( have_posts() ) {
					the_post();
					get_template_part( 'layouts/post', 'list' );
				}
				nn_pagination();
				echo '</div>';
			}
			else {
				echo '<div class="user-content">';
				echo '<h2>' . __( 'No Posts Found', 'no-nonsense' ) . '</h2>' ;
				if( is_search() ) {
					echo '<p>' . __( 'Unfortunately there were no posts found for your search, please try again.', 'no-nonsense' ) . '</p>';
				}
				else {
					echo '<p>' . __( 'There are no posts here, sorry for the inconvenience! Try going back to the home page!', 'no-nonsense' ) . '</p>';
				}
				echo '</div>';
			}
		?>
	</div>

	<div <?php nn_sidebar_class() ?> id='siteSidebar'>
		<?php get_sidebar() ?>
	</div>

</div>


<?php get_footer() ?>
