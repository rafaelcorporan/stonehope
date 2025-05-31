/**
 *  Custom JS Scripts
 *
 * @package tvelements
 */

// Initialize FluidVids
fluidvids.init({
	selector: ['iframe'],
	players: ['www.youtube.com', 'player.vimeo.com']
}); 

var elementsApp = (function() {

	return {

		/**
		 * Menu Toggle
		 */
		portfolioFilter: function() {
			var container = document.querySelector('.portfolio-wrapper'); 
			var iso;
			imagesLoaded( container, function() {
				iso = new Isotope( container, {
					layoutMode: 'fitRows',
				});
			});

			var filterBtn = document.querySelectorAll('.filterBtn');
			[].forEach.call(filterBtn, function(el) {
				el.addEventListener('click', function() {
					var filterValue = (this).getAttribute('data-filter');
					iso.arrange({ 
						filter: filterValue
					});
				});
			});
		},

		/**
		 * Menu Toggle
		 */
		mobileToggle: function() {
			var navMenu = document.querySelector('.main-navigation');
			var menuToggle = document.querySelector('.menu-toggle');
			var body = document.body;
			menuToggle.addEventListener('click', function() {
				menuToggle.classList.toggle('on');
				navMenu.classList.toggle('on');
				body.classList.toggle('on');
			});
		},

		/**
		 * Sub Menu Toggle
		 */
		subMenuToggle: function() {
			var navMenu = document.querySelectorAll('.sub-toggle');
			[].forEach.call(navMenu, function(el) {
				el.addEventListener('click', function() {
					(this).classList.toggle('on');
					(this).nextSibling.nextSibling.classList.toggle('on');
				});
			});
		},

		/**
		 * Format Videos Placement
		 *
		 * Get the first video embed in a Video post format and feature it
		 * in the post-media; above the content.
		 */
		videoFormat: function() {
			var entryVideo = document.querySelector('.fluidvids');
			var wpVideo = document.querySelector('.wp-video');
			var mediaContainer = document.querySelector('.featured-media');

			if( document.body.className.match('single-format-video') ) { 
				if( entryVideo ) {
					// Find the first oEmbed video
					entryVideo.classList.add('entry-video');
					entryVideo.remove();
					mediaContainer.insertBefore( entryVideo, mediaContainer.firstChild );
				}
			}
		}

	};

})(); // end albumApp


( function( $ ) {

	// Listen for menu toggle click
	elementsApp.mobileToggle();
	elementsApp.subMenuToggle();

	// Move video outside of main content on post format videos
	elementsApp.videoFormat();

	// Init Isotope
	if(document.body.classList.contains('page-template-templatestemplate-portfolio-php')) {
		elementsApp.portfolioFilter();
	}

})( jQuery );

