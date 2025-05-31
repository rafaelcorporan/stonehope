<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package tvelements
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" type="image/x-icon">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php wp_head(); ?>
	<?php include('parts/icons.svg'); ?>
	
	<?php get_template_part( 'style', 'options' ); ?>

	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri() . '/assets/js/html5shiv.min.js';?>"></script>
		<script src="<?php echo get_template_directory_uri() . '/assets/js/respond.min.js';?>"></script>
	<![endif]-->
</head>
<?php $invert = get_tvelements_option('header_scheme'); ?>

<body <?php body_class(); ?>>

<nav id="site-navigation" class="main-navigation <?php echo ('dark' === $invert ? 'dark' : ''); ?>" role="navigation">
	<?php 
	wp_nav_menu( 
		array( 
			'theme_location' => 'main_menu', 
			'walker' => new TVElements_Walker_Nav_Menu()
		) 
	); 
	?>
</nav>

<div id="page" class="site">

	<header id="masthead" class="site-header <?php echo (!is_home() ? 'dark ' : ''); echo ( is_single() ? get_post_format() : '' ); ?> col-sm-12" role="banner">
		
		<div class="site-branding">
			<?php
			$blog_info = get_bloginfo( 'name' );
			$logo_url = get_custom_header()->url;
			$logo_alt = 'http://demos.press75.dev/wp400/tv-elements/wp-content/uploads/sites/2/2014/11/logo-alt.png';
			$site_title_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; 
			
			if($logo_url) :
			?>
	
			<<?php echo $site_title_tag; ?> class="image-title">
				<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( $blog_info ); ?>">
					<img src="<?php echo esc_url( ( 'dark' === $invert ? $logo_alt : $logo_url ) ); ?>" alt="<?php esc_attr_e( 'Logo', 'tvelements') ?>" />
				</a>
			</<?php echo $site_title_tag; ?>><!-- #site-title -->
			
			<?php else : ?>
			
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				
			<?php endif; ?>
		</div>
		
		<div class="navbar-header col-xs-4 pull-right <?php echo ('dark' === $invert ? '' : 'dark'); ?>">
	    	<a id="toggle" class="menu-toggle"><span></span></a>
	    </div>
		
	</header><!-- #masthead -->
	