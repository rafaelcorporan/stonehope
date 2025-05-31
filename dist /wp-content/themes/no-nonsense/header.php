<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till the end of the #header element
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link type="text/plain" rel="author" href="<?php echo get_template_directory_uri() ?>/humans.txt" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div id='contentContainer'>
	<header id='header'>
		<div id='headerBar'>
			<div class='row'><div class='small-12 columns'>

				<div id='headerLogo'>
					<h2><a href='<?php echo esc_url( home_url() ) ?>'><?php bloginfo( 'name' ) ?></a></h2>
				</div>

				<div class='nav-menu' id='headerMenu'>
				<?php
					$args = array(
						'theme_location'  => 'header_menu',
						'container'       => 'div',
						'fallback_cb'     => 'nn_nav_menu'
					);
					wp_nav_menu( $args );
				?>
				</div>

			</div></div>
 		</div>

		<?php
			if ( get_header_image() AND !is_404() ) :

			global $wp_query;
			if( is_category() ) {
				$nn_header_title = single_cat_title( '', false );
				$category_id = $wp_query->query_vars['cat'];
				$category = get_category( $category_id );
				if( !empty( $category ) ) {
					$nn_header_text = $category->description;
				}
			}
			elseif( is_tag() ) {
				$nn_header_title = single_cat_title( '', false );
				$tag_id = $wp_query->query_vars['tag_id'];
				$tag = get_tag( $tag_id );
				if( !empty( $tag ) ) {
					$nn_header_text = $tag->description;
				}
			}
			elseif( is_year() ) {
				$nn_header_title = get_the_time( 'Y' );
			}
			elseif( is_month() ) {
				$nn_header_title = get_the_time( 'F Y' );
			}
			elseif( is_day() ) {
				$nn_header_title = get_the_time( get_option('data_format') );
			}
			else {
				$nn_header_title = esc_html( get_theme_mod( 'header_title' ) );
				$nn_header_text = esc_html( get_theme_mod( 'header_text' ) );
			}

		?>
		<div id="site-header" style="height: <?php echo get_custom_header()->height; ?>px; background-image: url( '<?php header_image(); ?>' )">
			<?php if( !empty( $nn_header_text ) ) : ?>
			<div id='headerLargeText'>
				<div class='inner'>
					<h2><?php echo $nn_header_title ?></h2>
					<h3><?php echo $nn_header_text ?></h3>
				</div>
			</div>
			<?php else : ?>
			<div id='headerText'>
				<h2><?php echo $nn_header_title ?></h2>
			</div>
			<?php endif ?>
		</div>
		<?php endif; ?>

		<div id='headerSeparator'></div>

	</header>
