function nn_add_dynamic_style( id, styles ) {
	var css = '';
	var element_id = 'nn_' + id;
	jQuery.each( styles, function( i, style ) {
		css = css + style.selector + ' { ' + style.property + ':' + style.value + '; }';
	});
	jQuery( '#' . element_id ).remove();
	jQuery( 'body' ).append( '<style id="' + element_id + '">' + css + '</style>' );
}

( function( $ ) {

	// Update the site title in real time...
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '#headerLogo h2' ).html( newval );
		} );
	} );
	

	//Update site background color...
	wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {
			$('body').css('background-color', newval );
		} );
	} );
	
	wp.customize( 'header_background_color', function( value ) {
		value.bind( function( newval ) {
			$('#headerBar').css('background', newval );
			$('#headerMenu > div > ul > li > ul').css('background', $.xcolor.lighten( newval, 1, 8 ) );

			var nn_dynamic_styles = [];
			
			nn_dynamic_styles.push({
				selector : '#headerMenu > div > ul > li > ul li:hover, #headerMenu > div > ul > li > ul li.current-menu-item, #headerMenu > div > ul > li > ul li.current-menu-parent, #headerMenu > div > ul > li > ul li.current-menu-ancestor',
				property : 'background',
				value: newval
			});
			nn_dynamic_styles.push({
				selector : '#headerMenu > div > ul > li:hover > a, #headerMenu > div > ul > li.current-menu-item > a, #headerMenu > div > ul > li.current-menu-parent > a, #headerMenu > div > ul > li.current-menu-ancestor > a',
				property : 'background',
				value : $.xcolor.lighten( newval, 1, 8 )
			});

			nn_add_dynamic_style( 'header_background_color', nn_dynamic_styles );

		} );
	} );

	wp.customize( 'header_text_color', function( value ) {
		value.bind( function( newval ) {
			$('#headerMenu > div > ul > li a').css('color', newval );
		} );
	} );
	wp.customize( 'header_logo_color', function( value ) {
		value.bind( function( newval ) {
			$('#headerLogo h2').css('color', newval );
		} );
	} );

	wp.customize( 'header_logo_color', function( value ) {
		value.bind( function( newval ) {
			$('#headerLogo h2').css('color', newval );
		} );
	} );


	wp.customize( 'footer_background_color', function( value ) {
		value.bind( function( newval ) {
			$('#footerBar').css('background', newval );
			$('#footerMenu > div > ul > li > ul').css('background', $.xcolor.lighten( newval, 1, 8 ) );

			var nn_dynamic_styles = [];
			
			nn_dynamic_styles.push({
				selector : '#footerMenu > div > ul > li > ul li:hover, #footerMenu > div > ul > li > ul li.current-menu-item, #footerMenu > div > ul > li > ul li.current-menu-parent, #footerMenu > div > ul > li > ul li.current-menu-ancestor',
				property : 'background',
				value: newval
			});
			nn_dynamic_styles.push({
				selector : '#footerMenu > div > ul > li:hover > a, #footerMenu > div > ul > li.current-menu-item > a, #footerMenu > div > ul > li.current-menu-parent > a, #footerMenu > div > ul > li.current-menu-ancestor > a',
				property : 'background',
				value : $.xcolor.lighten( newval, 1, 8 )
			});

			nn_add_dynamic_style( 'footer_background_color', nn_dynamic_styles );

		} );
	} );

	wp.customize( 'footer_text_color', function( value ) {
		value.bind( function( newval ) {
			$('#footerMenu > div > ul > li a').css('color', newval );
		} );
	} );
	wp.customize( 'footer_logo_color', function( value ) {
		value.bind( function( newval ) {
			$('#footerLogo h2').css('color', newval );
		} );
	} );

	wp.customize( 'footer_logo_color', function( value ) {
		value.bind( function( newval ) {
			$('#footerLogo h2').css('color', newval );
		} );
	} );

	wp.customize( 'header_title', function( value ) {
		value.bind( function( newval ) {
			$('#site-header h2').html( newval );
		} );
	} );

	wp.customize( 'header_text', function( value ) {
		value.bind( function( newval ) {
			$('.home #site-header h3').html( newval );
		} );
	} );


	wp.customize( 'box_background_color', function( value ) {
		value.bind( function( newval ) {

			$('.box, .widget, .widget > ul li ul li, .widget_search form input[type="text"], .widget_categories .customSelect, .widget_archive .customSelect, .pagination .page-numbers').css('background', newval );
			
			$('.box .box-content').css('border-color', $.xcolor.darken( newval, 1, 6 ) );

			$('input[type="text"], .box footer, input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], textarea, .customSelect, .widget h3, .widget_calendar #prev, .widget_calendar #next, .widget_calendar tfood .pad').css('background', $.xcolor.darken( newval, 1, 4 ) );

			$('input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], textarea, .widget, .customSelect').css('border-color', $.xcolor.darken( newval, 1, 8 ) );

			$('.widget_rss ul li').css('border-color', $.xcolor.darken( newval, 1, 4 ) );


			var nn_dynamic_styles = [];
			nn_dynamic_styles.push({
				selector : '.widget > ul li:hover',
				property : 'background',
				value : $.xcolor.darken( newval, 1, 2 )
			});
			nn_dynamic_styles.push({
				selector : '.pagination .page-numbers:hover',
				property : 'background',
				value : $.xcolor.darken( newval, 1, 4 )
			});

			nn_add_dynamic_style( 'footer_background_color', nn_dynamic_styles );


		} );
	} );


	wp.customize( 'highlight_color', function( value ) {
		value.bind( function( newval ) {
			$('input[type="submit"], .pagination .page-numbers.current').css('background', newval );
			$('.widget h3').css('border-color', newval );
			$('a').not('.layout-post-list header h2 a').css('color', newval );

			var nn_dynamic_styles = [];
			nn_dynamic_styles.push({
				selector : '*:focus',
				property : 'outline-color',
				value : newval
			});

			nn_dynamic_styles.push({
				selector : '#headerLogo h2 a:hover',
				property : 'color',
				value : newval
			});
			nn_dynamic_styles.push({
				selector : 'input[type="subtmi"]:hover, .button:hover',
				property : 'background',
				value : $.xcolor.lighten( newval, 1, 6 )
			});

			nn_add_dynamic_style( 'highlight_color', nn_dynamic_styles );


		} );
	} );



	wp.customize( 'highlight_text_color', function( value ) {
		value.bind( function( newval ) {
			$('input[type="submit"], .pagination .page-numbers.current').css('color', newval );
		} );
	} );

	
} )( jQuery );