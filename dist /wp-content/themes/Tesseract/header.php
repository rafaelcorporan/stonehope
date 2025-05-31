<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Tesseract
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

<div id="google_language_translator">
    <div class="skiptranslate goog-te-gadget" dir="ltr">
        <option value="en">English</option>
        <option value="af">Afrikaans</option>
        <option value="sq">Albanian</option>
        <option value="ar">Arabic</option>
        <option value="hy">Armenian</option>
        <option value="az">Azerbaijani</option>
        <option value="eu">Basque</option>
        <option value="be">Belarusian</option>
        <option value="bn">Bengali</option>
        <option value="bs">Bosnian</option>
        <option value="bg">Bulgarian</option>
        <option value="ca">Catalan</option>
        <option value="ceb">Cebuano</option>
        <option value="ny">Chichewa</option>
        <option value="zh-CN">Chinese (Simplified)</option>
        <option value="zh-TW">Chinese (Traditional)</option>
        <option value="hr">Croatian</option>
        <option value="cs">Czech</option>
        <option value="da">Danish</option>
        <option value="nl">Dutch</option>
        <option value="eo">Esperanto</option>
        <option value="et">Estonian</option>
        <option value="tl">Filipino</option>
        <option value="fi">Finnish</option>
        <option value="fr">French</option>
        <option value="gl">Galician</option>
        <option value="ka">Georgian</option>
        <option value="de">German</option>
        <option value="el">Greek</option>
        <option value="gu">Gujarati</option>
        <option value="ht">Haitian Creole</option>
        <option value="ha">Hausa</option>
        <option value="iw">Hebrew</option>
        <option value="hi">Hindi</option>
        <option value="hmn">Hmong</option>
        <option value="hu">Hungarian</option>
        <option value="is">Icelandic</option>
        <option value="ig">Igbo</option>
        <option value="id">Indonesian</option>
        <option value="ga">Irish</option>
        <option value="it">Italian</option>
        <option value="ja">Japanese</option>
        <option value="jw">Javanese</option>
        <option value="kn">Kannada</option>
        <option value="kk">Kazakh</option>
        <option value="km">Khmer</option>
        <option value="ko">Korean</option>
        <option value="lo">Lao</option>
        <option value="la">Latin</option>
        <option value="lv">Latvian</option>
        <option value="lt">Lithuanian</option>
        <option value="mk">Macedonian</option>
        <option value="mg">Malagasy</option>
        <option value="ms">Malay</option>
        <option value="ml">Malayalam</option>
        <option value="mt">Maltese</option>
        <option value="mi">Maori</option>
        <option value="mr">Marathi</option>
        <option value="mn">Mongolian</option>
        <option value="my">Myanmar (Burmese)</option>
        <option value="ne">Nepali</option>
        <option value="no">Norwegian</option>
        <option value="fa">Persian</option>
        <option value="pl">Polish</option>
        <option value="pt">Portuguese</option>
        <option value="pa">Punjabi</option>
        <option value="ro">Romanian</option>
        <option value="ru">Russian</option>
        <option value="sr">Serbian</option>
        <option value="st">Sesotho</option>
        <option value="si">Sinhala</option>
        <option value="sk">Slovak</option>
        <option value="sl">Slovenian</option>
        <option value="so">Somali</option>
        <option value="su">Sundanese</option>
        <option value="sw">Swahili</option>
        <option value="sv">Swedish</option>
        <option value="tg">Tajik</option>
        <option value="ta">Tamil</option>
        <option value="te">Telugu</option>
        <option value="th">Thai</option>
        <option value="tr">Turkish</option>
        <option value="uk">Ukrainian</option>
        <option value="ur">Urdu</option>
        <option value="uz">Uzbek</option>
        <option value="vi">Vietnamese</option>
        <option value="cy">Welsh</option>
        <option value="yi">Yiddish</option>
        <option value="yo">Yoruba</option>
        <option value="zu">Zulu</option>
    </div>
</div>

</head>
<?php // Additional body classes
$bodyClass = ( version_compare($wp_version, '4.0.0', '>') && is_customize_preview() ) ? 'backend' : 'frontend';
if ( (is_page()) && (has_post_thumbnail()) ) $bodyClass .= ' tesseract-featured';
$opValue = get_theme_mod('tesseract_tho_header_colors_bck_color_opacity');
$header_bckOpacity = is_numeric($opValue) ? TRUE : FALSE;
if ( is_front_page() && ( $header_bckOpacity && ( intval($opValue) < 100 ) ) ) $bodyClass .= ' transparent-header';	?>

<body <?php body_class( $bodyClass ); ?>>

<nav id="mobile-navigation" class="top-navigation" role="navigation">

	<?php $anyMenu = get_terms( 'nav_menu' ) ? true : false;
    	  $menuSelect = get_theme_mod('tesseract_tho_header_menu_select');

		if ( $anyMenu && ( ( $menuSelect ) && ( $menuSelect !== 'none' ) ) ) :
			wp_nav_menu( array( 'menu' => $menuSelect, 'container_class' => 'header-menu' ) );
		elseif ( $anyMenu && ( !$menuSelect || ( $menuSelect == 'none' ) ) ) :
			$menu = get_terms( 'nav_menu' );
			$menu_id = $menu[0]->term_id;
			wp_nav_menu( array( 'menu_id' => $menu_id ) );
		elseif ( !$anyMenu ) :
			wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) );
		endif; ?>

</nav><!-- #site-navigation -->
<div id="site-banner-right">
	<div id="header-button-container">
		<div id="header-button-container-inner">
</span>
		</div>
	</div>
</div>

</span>


<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tesseract' ); ?></a>

    <a class="menu-open dashicons dashicons-menu" href="#mobile-navigation"></a>
    <a class="menu-close dashicons dashicons-no" href="#"></a>


	<header id="masthead" class="site-header <?php echo get_header_image() ? 'is-header-image' : 'no-header-image'; ?>" role="banner">

    <?php $logoImg = get_theme_mod('tesseract_logo_image');
	$blogname = get_bloginfo('blogname');
	$headright_content = get_theme_mod('tesseract_tho_header_content_content');
	$headright_content_default_button = get_theme_mod('tesseract_tho_header_content_if_button');

	if ( !$logoImg && $blogname ) $brand_content = 'blogname';
	if ( $logoImg ) $brand_content = 'logo';
	if ( !$logoImg && !$blogname ) $brand_content = 'no-brand';

	?>

        <div id="site-banner" class="cf<?php echo ' ' . $headright_content . ' ' . $brand_content; echo ( ( $headright_content  ) && ( $headright_content !== 'nothing' ) ) ?  ' is-right' : ' no-right'; ?>">

            <div id="site-banner-left" class="<?php echo ( ( $headright_content  ) && ( $headright_content !== 'nothing' ) ) ?  'is-right' : 'no-right'; ?>">

                <?php if ( $logoImg || $blogname ) { ?>
                    <div class="site-branding">
                        <?php if ( $logoImg ) : ?>
                            <h1 class="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo $logoImg; ?>" alt="logo" /></a></h1>
                        <?php else : ?>
                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php endif; ?>
                    </div><!-- .site-branding -->
              	<?php } ?>

                <nav id="site-navigation" class="main-navigation top-navigation" role="navigation">

					<?php $anyMenu = get_terms( 'nav_menu' ) ? true : false;
                          $menuSelect = get_theme_mod('tesseract_tho_header_menu_select');

						if ( $anyMenu && ( ( $menuSelect ) && ( $menuSelect !== 'none' ) ) ) :
							wp_nav_menu( array( 'menu' => $menuSelect, 'container_class' => 'header-menu' ) );
						elseif ( $anyMenu && ( !$menuSelect || ( $menuSelect == 'none' ) ) ) :
							$menu = get_terms( 'nav_menu' );
							$menu_id = $menu[0]->term_id;
							wp_nav_menu( array( 'menu_id' => $menu_id ) );
						elseif ( !$anyMenu ) :
							wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) );
						endif; ?>

				</nav><!-- #site-navigation -->

            </div>

            <?php if ( $headright_content ) : ?>

               	<div id="site-banner-right">

					<?php tesseract_header_right_content($headright_content); ?>

             	</div>

			<?php elseif ( !$headright_content && $headright_content_default_button ) : ?>

            	<div id="site-banner-right">

                    <div id="header-button-container">
                        <div id="header-button-container-inner">
                            <?php echo $headright_content_default_button; ?>
                        </div>
                    </div>

               </div>

            <?php else : ?>


			<?php endif; ?>

        </div>

	</header><!-- #masthead -->

    <div id="content" class="cf site-content">