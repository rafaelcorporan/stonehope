<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */

get_header(); ?>

	<div id='error_404_message'>
		<h1><?php echo get_theme_mod( '404_page_title', __( 'Page Not Found', 'no-nonsense' ) ) ?></h1>
		<div class='message'>
			<?php echo get_theme_mod( '404_page_text', __( 'It seems that the page you are looking for doesn\'t exist. Sorry for the inconveniense, try going back to the main page!', 'no-nonsense' ) ) ?>
		</div>
	</div>


<?php get_footer() ?>
