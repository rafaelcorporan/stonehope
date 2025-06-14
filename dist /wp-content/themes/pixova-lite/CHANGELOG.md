### v1.40.1
  - Has been added current version of WordPress theme on wp_enqueue_style/ wp_enqueue_script functions.

### v1.40.0
  - Has been added field in customizer for team section from front page.
  - Has been added OWL Carousel for Latest News section from front page.
  - Has been added couple of fields in customizer for WooCommerce plugin.
  - Has been added breakline CTA section from front page.
  - Has been fixed CTA button color fields.
  - Has been added support for custom logo. This feature will appear on WordPress v4.5.0.
  - Has been updated Theme Documentation link in customizer.
  - Has been removed "How many posts to show on homepage..." field from front page.

==========================================================================================
            V 1.39    -   28 January, 2016
==========================================================================================
  * Fixed #26 ( WooCommerce product tabs not working )
  * Fixed #28 ( Add email field to team members )
  * Optimized images using Kraken
  * Fixed #30
  * Implemented live update for certain fields
  * Removed Textarea Custom Control - WP now supports this by default in the Customizer
  * Made the text fields in the Pie Chart & Testimonials Section accept certain HTML characters such as: img, em, br, a and italics
  * Added pixova_lite_get_customizer_image_by_url in extras.php L668.
  * Fixed an annoying bug where the project images were not being resized properly, making it difficult to upload proper images in the recent works section.
  * Fixed an annoying bug where the team images were not being resized properly,  making it difficult to upload proper images in the team section.
  * Removed 2 unused image sizes (widget project logo & small testimonial thumbnail - we can use the actual thumbnail for this)
  * Added button to get theme support directly in the customizer
  * Center aligned the content in the about section - was the only section that wasn't center aligned
  * Re-worked the footer widget layout. We now feature 3 width restricted widget areas (footer-sidebar-1, 2 & 3). The fourth sidebar has been converted to a full width sidebar.
  * Introduced a new widget importer function. Allows for cleaner widget placement.
      Instead of using and if/else statement checking if the sidebar is empty and displaying a widget, we're now actually importing widgets with content in their corresponding sidebars. Executes on theme activation.
  * Made the removing of the copyright message in the footer as an easy as a click on checkbox :)
  * Moved the contact details panel inside the Contact Section. Was previously placed in 'General Options'
  * Made the related posts box be removable from single posts
  * Made the content navigation links box (prev/next posts) be removable from single posts

V 1.38.1
    * Fixed a JS bug.

V 1.38
    * Added WordPress credit

V 1.37.1:
    * Added image logo field
    * Updated theme documentation link in Customizer
    * Slight CSS improvements to the upsell badges
    * Slightly reworked the CSS for blog posts
    * Updated team images
    * Slightly reworked the spacing logic in the team section. By default, we're now showing 4 team member images instead of 5.
    * Updated testimonial images
    * Updated readme.txt with proper links for updated images

V 1.37:
    * Improvment: W3C Valid.
    * Improvment: HTML5.

V 1.36.1:
    * Fixed WooCommerce Tabs: Description and Reviews.
    * Fixed WooCommers rating.
    * Fixed responsive footer.

V 1.36
    * Fixed CSS layout problems introduced in Customizer by WP 4.4
    * Fixed broken  documentation link (now leads to the proper resource)
    * Fixed footer links from social media widget (now they're displaying color white instead of blue)
    * Removed 'Our Skills' text from pie chart area
    * Fixed hover bug on 'see our project'
    * Fixed border under 'what we do' * opacity was too low
    * Removed 'Rate us' from customizer (rarely used by anyone)
    * Added footer heart icon
    * Added proper anchors for widget: quick nav
    * Removed (old) screenshot.png

V 1.35
    * Removed a debugging function
    * Added a debugging function; pixova_lite_nice_debug

V 1.34.19
    * Added Pirate Forms in Contact Section.

V 1.34.18
    * Added logo image field in customizer.
    * Added Related Posts section in single content.
    * Has been removed WP Title support for old WP versions.
    * Removed Uber Recaptcha as recommended pluginh
    * Added possibility to insert image logo in header
    * Added Related Posts Functionality

V 1.34.17
    * Updated theme default header BG
    * Updated readme.txt
    * Updated documentation link

V 1.34.16
    * Updated theme screenshot

V 1.34.15
   * Minor customizer up-sell tweaks.

V 1.34.14
   * Added Uber reCaptcha as a recommended plugin

V 1.34.13
   * Resolves #8 ( Check to see if there any more discounted links )

V 1.34.12
   * Resolves #6 ( Latest news section -> option in customizer to change text on button )
   * Resolves #7 ( Issues reported by GlotPress team )
   * Removed Pirate Forms plugin recommendation
   * Resolved #9 ( No option to disable parallax header effect in Customizer )

V 1.34.11
    * Removes the 2nd link to Macho Themes homepage from the footer (only 1 link allowed in the footer as per #TRT guidelines)

V 1.34.10
  * Fixes a problem where testimonials wouldn't show up if images weren't set.
  * Fixes a problem where team members wouldn't show up if images weren't set.

V 1.34.9
  * Fixes missing images problem on archive post types (was using apply_filters on the_content instead of the_excerpt for manipulating the character number).

V 1.34.8
  * Fixed customizer up-sell buttons. Now they're not overlaying with customizer panels

V 1.34.7
  * Reverted image sizing fix for section-works.php; was causing more problems
  * Added lock indicator on customizer * PRO sections (better UX)

V 1.34.6
  * Fixed some image sizing problems with the testimonials image size

V 1.34.5
  * Fixed some image sizing problems with the project image size

V 1.34.4
  * Removed some broken links
  * Details about theme now send to LITE version instead of PRO one

V 1.34.3
  * Updated up-sell link, sending now to theme details page instead of check-out.
  * Updated section-news.php so that thumbnails now link to the post.
  * Removed instructions.txt, link to documentation is available in the customizer back-end.
  * Updated up-sell CSS to have hover effects on all up-sell related buttons.

V 1.34.2
  * Replaced plugin recommendation: Login Customizer with Pirate Forms

V 1.34.1
  * Updated documentation link

V 1.34
  * Replaced our custom Parallax JS code with Parallax.js * a dedicated JS library for Parallax effects
  * Small tweak to the "Rate us text " -> changed from "If you like it, rate it ! (it will help us)" to "If you like it, rate it !"
  * Rebuilt POT file
  * Fixed a few CSS quirks

V 1.33.5
  * Fixed a small bug with the 'read more link' (was showing up twice)

V 1.33.4
   * Fixed upsell link

V 1.33.3
   * Updated screenshot

V 1.33.2
    * Replaced apply_filters on the_content with the_excerpt()
    * Added custom filters for the_excerpt() to limit the content length as well as add a custom 'read more' button
    * Fixed a small CSS bug with featured images in blog posts
    * Added blog default images (can be disabled from the customizer).
    * Replaced our custom Parallax Code with Parallax.js library; better support, more stable & advanced
    * Localized scripts / plugins .js
        * Option to disable parallax header text effect
        * Option to completely disable section animations
        * If animations are turned off, no more site breaking.
    * Applied the Parallax Text Fade Out Effect only on devices with a resolution of > 800px in height && !isMobile() && only IF animations if effect is enabled from the customizer
    * Animated the pie charts

V 1.33.1
    * Fixed a small bug in section-news
    * Fixed a mark-up bug on blog archive
    * Introduced a function that gets the ID of a page using a certain page template
    * Moved some code from functions.php to inc/extras.php

V 1.33
    * Fixed a bug that prevented the user to access the Customizer on IIS Servers
    * Added front-page text / image fade-out effect
    * Slightly re-worked the up-sell feature in the Customizer
    * Remove some un-used code throughout the theme files
    * Different theme screenshot

V 1.32
    * Fixed a PHP 5.4 BUG that affected sites who were running older versions of PHP
    * Fixed a bug where the "Contact Details tab" wasn't being displayed in the customizer
    * Moved content-single.php, content-search.php, content.php & content-none.php in /template-parts/ folder
    * Moved the featured image (on blog posts), above the tags.
    * Increased the content width on blog posts (from 8 -> 9 cols)


V 1.31
    * Added "More Themes" sub-page in Appearance
    * Fixed a CSS bug that affected the "See Project" button, on hover
    * Added possibility to disable animations from the Customizer
    * Fixed a CSS bug that didn't allow small text testimonials to be centered
    * Fixed a CSS bug where (if) the team img logo was too big, it didn't scale down


V 1.30
    * Removed link from WordPress.org in footer, added link to theme page
    * Replaced QueryLoader2 with Pace JS
    * Fixed a small CSS bug on the nav menu
    * Updated up-sell discount from 10% to 20%
    * Updated theme description
    * Re-worked the up-sell links & banner position
    * Re-named the "About Section" -> "Pie Chart Section"
    * Re-named the "Intro Section" -> "Main CTA Section"
    * Changed Opacity on Intro BG image
    * Added link to "Review us on WordPress.org"
    * Updated Screenshot


V 1.29
    * Added QueryLoader2 JS files (missing from a borked build-archive Grunt JS task)
    * Added plugin recommendation: Login Customizer (great for styling the login experience.)

V 1.28
    * Updated screenshot.
    * Removed GitHub Updater Class (apparently, not allowed on WordPress.org).
    * Fixed a few errors that were being thrown by an update to Theme Check plugin.
    * Translated all strings from TGMPA to our theme domain.
    * Fixed the upsell link being wrong.
    * Removed blog-template.php


V 1.27
    * Updated screenshot
    * Added GitHub updater class
    * Fixed some small bugs with the theme customizer

V 1.26
  * Fixed "About" section not showing up in the customizer
  * Moved some WP Default panels to the 'Theme Options' Panel.

V 1.25
    * Fixed translation issues in search.php
    * Updated Grunt process for building .POT files to include POEedit headers in our .POT file as well as add team translator support links

V 1.24
   * Fixed preloader script from loading in the customizer window (black screen of death should be gone now)
   * Updated languages/*.pot file
   * Fixed two more non-internationalized strings in search.php
   * Re-generated all .min & .min.js.map files with & added banner type comments
   * Updated Gruntfile.js with more tasks (you can get this from the mirror GitHub account)

V 1.23
    * Removed from inc/custom-header.php the fallback get_custom_header(); it's not needed since WordPress 3.4 (it's in core)
    * Properly prefixed widgets/*.php with {theme_slug}
    * Added wp_reset_postdata() && wp_reset_query() to widgets/widget-latest-posts.php
    * Fixed a small bug that was affecting certain PHP files; sprintf function was missing the %s in 2 cases.
    * get_template_part('sections/section', 'header'); was missing from 404.php * added it now
    * Changed the way the shop link is added by the pixova_lite_fallback_cb(); It only gets added now IF WooCommerce is already active (as a plugin).

V 1.22
    * Increased number of possible testimonials from 2 -> 5
    * Increased number of possible team members from 2 -> 5
    * Added function to fix responsive videos
    * Replaced in-lined comments fetching code with function; visible in inc/extras.php (pixova_lite_get_number_of_comments)
    * Renamed customizer panel from General Options to Theme Options
    * Found two more non-internationalized strings

V 1.21
    * Two strings weren't translated.

V 1.20
	* Made all strings translatable in the theme
	* Fixed a few strings that weren't available for translation.

V 1.19
    * Made TGMPA plugin install notices to be dismissable
    * Updated QueryLoader2 jQuery plugin from v2.0 to v.3.0.16
    * Fixed a small JS error
    * Fallback widget titles are now translatable
    * Fixed a few strings that were hardcoded and not available for translation
    * Header was missing from author.php archive
    * Prefixed panel names in inc/customizer.php with {theme_slug}

V 1.18
	* Moved wp_footer() before </body> tag
	* Added comments form on pages

V 1.17
    * Removed /plugins/ folder; now CF7 is installed through TGMPA from WP repo
    * Added proper link to documentation
    * Removed FlickR widget because it's plugin territory.
    * Removed customizer setting that allowed an user to set how many posts should be displayed in the latest-news.php section, bypassing the core get_option('posts_per_page') option
    * Replaced all images with CC0 GPL ones
    * Updated readme.txt
    * Added editor-style.min.css

V 1.16
    * Removed Oxygen Google Fonts (was only being used on some headings)
    * Added editor styles for certain elements (headings, paragraphs & blockquotes)
    * Added Custom Google Fonts in Editor
    * Created a new folder -> /accesibility/; Laying the ground work for making this theme accesibility-ready
    * Added some backwards compatibility functions (functions taken directly from twentyfifteen) that won't allow the customizer to run OR the theme to be activated IF the WP version installed is < 4.1
    * Fixed a small bug by which Google Fonts weren't protocol less
    * Added doc-block PHP comments
    * Added a function to dequeue the site preloader when we're in the customizer

V 1.15
    * Fixed a small bug where the page title might not show up if WooCommerce wasn't installed
    * Fixed a even smaller bug with a typo in a variable.
    * Updated search template

V 1.14
    * Updated readme.txt with link to header image & attribution
    * Removed up-selling messages on the homepage (up-sell is now only done in the admin area)
    * Removed some unused image sizes
    * Prefixed EVERYTHING
    * Minified CSS
    * Optimised images
    * Minified JS
    * Added active_callback in the customizer for the CF7 section (section isn't displayed anymore if the plugin isn't active); The user can choose to NOT display the contact area.

V 1.13
	* Updated Screenshot

V 1.12
    * Added author info box (end of the post)
    * Added author archive type (author.php)
    * Fixed a few CSS bugs
    * Updated readme
    * Linked the author name with the author archive

V 1.11
    * Added sanitization callbacks for custom controls used in the front-end (files affected: sections/* && widgets/*)
    * Fixed a small bug in inc/customizer.php that was causing the pie chart headings to display all in one panel (instead of each in their own panels)
    * Fixed a small bug with: pixova_lite_child_manage_woocommerce_styles() * now it only fires IF WooCommerce is installed & active
    * Moved the WooCommerce stylesheet rules into it's own stylesheet (layout/css/pixova-woocommerce.css); only gets loaded if WooCommerce is installed & active
    * Added /shop/ link to the pixova_lite_fallback_cb function
    * Made translatable a handful of hard-coded text strings

V 1.10
    * Updated text strings to advertise the inclusion of WooCommerce Support
        * affected files: customizer.php & sections/section-intro.php
    * Updated all links to the premium version of the theme to include the 10% discount coupon.
    * Updated changelog for previous version; forgot to mention the addition of two new page templates: left / right sidebar pages

V 1.0.9
    * Changed text domain from macho-lite to pixova-lite.
    * Updated /languages/pixova-lite.pot & /languages/pixova-lite.mo to include all strings.
    * Updated theme screenshot * using a better cropped version.
    * Added blank index.html files in each theme folder ( to prevent direct access ).
    * Added CSS comments in rtl.css.
    * Updated readme with Google Fonts licensing.
    * Updated layout/scripts.js to add animations for team, news & about sections.
    * Updated layout/scripts.js with isMobile() function.
    * Updated layout/scripts.js * parallax is now enabled only when user is not visiting from a mobile device.
    * Updated sections/section-about.php * depending on the number of charts displayed, the mark-up changes to always have the pie charts centered.
    * Updated sections/section-works.php * depending on the number of projects displayed, the mark-up changes to always have the projects centered.
    * Updated sections/section-news.php * depending on the number of news displayed, the mark-up changes to always have the news centered.
    * Updated sections/section-testimonials.php * depending on the number of testimonials, the mark-up changes. If there's only one testimonial, we're not adding the mark-up required for the carousel (the JS script that builds the carousel, first looks for the css class * if it finds it, it fires).
    * Added fall-back for the quick nav widget (footer.php).
    * Pagination was missing from archive.php
    * Replaced code that was outputting only category name with WP default code that outputs the category list elements & links to them.
    * Updated sections/header-single.php and replaced old code that was only displaying category name / number of comments with links on them; now they're linked properly.
    * Added default fall-back for blog sidebar widgets, in case there's no widgets added to it (initial WP / theme install)
    * Updated widgets/widget-about-sm, widgets/widget-flickr, widgets/widget-latest-posts & widgets-widget-social-icons with new PHP 5 constructs.
    * Updated widgets/widget-latest-posts code (removed unused variables / calls); added proper styling in style.css.
    * Updated HTML mark-up & added proper closing comments (comments for closing mark-up tags: divs, spans, p, etc).
    * Added single post navigation: you can now navigate between posts directly from the single view.
    * Searched & Replaced all text-domains strings -> from 'macho' to -> 'pixova-lite'.
    * Added sanitization / escaping functions to bundled widgets (all widgets have been affected by this change).
    * Added WooCommerce Support.
    * Updated instructions.txt with WooCommerce support.
    * Added left-sidebar / right-sidebar page-templates

V 1.0.8
    * Removed some extra code from customizer.php (some files were being loaded for nothing).
    * Renamed pixova_lite_registers to pixova_lite_customizer_js_load.
    * Moved & improved the title_tag fallback function (from functions.php to extras.php).
    * Split-up the sections/section-header.php into two different files: section-header.php & section-intro.php, now when the visibility for section intro is turned off, you still get to keep your nav menu.
    * Fixed a bug with the nav menu not showing up on select pages.
    * Fixed a bug where the logo wasn't linking properly & the image logo string wasn't present in all header files.
    * Added pagination for index.php, search.pgp & tag.php files.
    * Updated content.php mark-up.
    * Updated customizer.php with improver up-selling controls.
    * Updated "upgrade now" link to feature a 10% discount on theme purchase.
    * Added pixova-pro.css for customizer styling (file in enqueued in customizer.php * end of file).
    * Updated TGMPA from 2.5.1 to 2.5.2.
    * Removed template-tags.php and moved functions to inc/extras.php

V 1.0.7
    * Changed header-bg.jpg image to match WordPress.org theme license image usage (all images must be CC0 licensed)
    * Changed layout/images/team/ images for the same reason as above.
    * Changed layout/images/testimonials/ images for the same reason as above.
    * Changed layout/images/recent-works/recent-works-2-270x426.jpg for the same reason as above
    * Renamed layout/images/recent-works/ images to recent-works-1, 2, 3 & 4
        * Affected files by this change: customizer.php & sections/section-works.php
    * Updated readme.txt with proper image licenses


V 1.0.6
    * Added pagination on home.php (don't know how this got uploaded without pagination)
    * Removed some variables from functions.php that were left there from the premium version of the theme.
    * Removed some functions from scripts.php that belonged to the premium version of the theme.
    * Added fallback for wp_nav_menu.
    * Added fallback in case theme doesn't have support for title_tag.
    * Fixed some conditionals in functions.php that prevented the smooth scroll & wow JS scripts to be loaded.
    * Prefixed all functions with pixova_lite
    * Prefixed all custom control classes with MT_
    * Wrapped all custom control classes in if clauses checking if classes already exists (class_exists).
    * Re-enabled title_tag & static front page sections in customizer (previous version had them disabled).
    * Removed favicon, since WP 4.3 is getting support for site icons.
    * Added license.txt
    * Updated screenshot.png to account for HiDPI screens (was 600 x 450, now it's 880 x 660).
    * Updated search.php to include sidebar & featured post image.
    * Updated tag.php to include sidebar & featured post image.
    * Added changelog.md
    * Removed RSS feed link from /widgets/widget-social-icons.php
    * Created a new header for pages.
    * Styled the 404.php page.
    * Minified main stylesheet (style.min.css) * for development version, check style.css
    * Added missing comments for functions / classes
    * Renamed readme.txt to instructions.txt
    * Added proper theme readme.txt
    * Removed fonts/glyphicons & linea fonts
    * Added JetPack support

V 1.0.5
    * Added default text for logo in customizer.php (text_logo variable).
    * Added default widgets in the footer using the_widget (replacement for old code that was importing & placing widgets in the sidebar by reading a JSON config file).
    * Added conditionals so that mark-up isn't displayed unless strings have values in them (example: blockquote on the front page).
    * Added Theme links in the footer as well as to WordPress.org :)
    * Updated CF7 plugin to version 4.2.1 from 4.2.0.
    * Fixed a bug with the randomized header images that prevented images uploaded to actually be randomly displayed.
    * Updated readme.txt.
    * Fixed a few typos in the changelog :)

V 1.0.4
    * Re-worked how TGMPA works; instead of forcing activation of the CF7 plugin, it's now recommending it.
    * Re-worked how the custom CF7 control works, if the plugin isn't installed a message is shown instructing the user to install it.
    * Added defaults for about section (title / sub-title).
    * Removed widget importer functions / classes.
    * Removed /demo-content/ since it's not allowed to import content upon theme activation (will re-work this in a future plugin).
    * Added default fallback for testimonial images, in case the client doesn't add any.

V 1.0.3
  	* Updated TGMPA plugin from 2.4.1 to 2.5.0
  	* Changed the way front-page.php handles the content display.
  	* Replaced include with require_once.
  	* Updated the widget importer code to run only once. A theme mod setting is now set, after the demo-content/widgets.json file has been parsed successfully and the widgets have been imported.
  	* Fixed image alignments and added margin-top/bottom of 10px for better aesthetics.
  	* Styled image captions.
  	* Fixed an overflow issue on single post pages.
  	* Added featured images to blog posts.
  	* Added sidebar to single blog posts.

V 1.0.2
  	* Fixed some strings that had non-printable characters in them.
  	* Fixed some translatable strings that had links hard-coded in them.

V 1.0.1
  	* Updated screenshot
  	* Updated Theme / Author URI in style.css
  	* Updated CSS styling for sticky posts.

V 1.0.0
	 * Initial release.
