<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #contentContainer and #page div elements.
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */
?>

</div>
	<footer id='footer'>
		<div id='footerBar'>
			<div class='row'><div class='small-12 columns'>

				<div id='footerLogo'>
					<h2><?php bloginfo( 'name' ) ?></h2>
				</div>

				<div class='nav-menu' id='footerMenu'>
				<?php 
					$args = array(
						'theme_location'  => 'footer_menu',
						'container'       => 'div',
						'fallback_cb'     => 'nn_nav_menu'
					);
					wp_nav_menu( $args );
				?>
				</div>

			</div></div>
 		</div>

	</footer>
</div>

<?php wp_footer() ?>
</body>
</html>