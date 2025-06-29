(function($){
	"use strict";

	var zurf_display = 'desktop';
	if( typeof(window.matchMedia) == 'function' ){
		$(window).on('resize zurf-set-display', function(){
			if( window.matchMedia('(max-width: 419px)').matches ){
				zurf_display = 'mobile-portrait';
			}else if( window.matchMedia('(max-width: 767px)').matches ){
				zurf_display = 'mobile-landscape'
			}else if( window.matchMedia('(max-width: 959px)').matches ){
				zurf_display = 'tablet'
			}else{
				zurf_display = 'desktop';
			}
		});
		$(window).trigger('zurf-set-display');
	}else{
		$(window).on('resize zurf-set-display', function(){
			if( $(window).innerWidth() <= 419 ){
				zurf_display = 'mobile-portrait';
			}else if( $(window).innerWidth() <= 767 ){
				zurf_display = 'mobile-landscape'
			}else if( $(window).innerWidth() <= 959 ){
				zurf_display = 'tablet'
			}else{
				zurf_display = 'desktop';
			}
		});
		$(window).trigger('zurf-set-display');
	}

	// ref : http://unscriptable.com/2009/03/20/debouncing-javascript-methods/
	// ensure 1 is fired
	var zurf_debounce = function(func, threshold, execAsap){
		
		var timeout;

		return function debounced(){
			
			var obj = this, args = arguments;
			
			function delayed(){
				if( !execAsap ){
					func.apply(obj, args);
				}
				timeout = null;
			};

			if( timeout ){
				clearTimeout(timeout);
			}else if( execAsap ){
				func.apply(obj, args);
			}
			timeout = setTimeout(delayed, threshold);
		};
	}	
	
	// reduce the event occurance
	var zurf_throttling = function(func, threshold){
		
		var timeout;

		return function throttled(){
			var obj = this, args = arguments;
			
			function delayed(){
				func.apply(obj, args);
				timeout = null;
			};

			if( !timeout ){
				timeout = setTimeout(delayed, threshold);
			}
		};
	}	

	/////////////////////////
	// menu handle function
	/////////////////////////
	var zurf_sf_menu = function( menu ){

		if( menu.length == 0 ) return;

		this.main_menu = menu;

		this.slide_bar = this.main_menu.children('.zurf-navigation-slide-bar');
		this.slide_bar_val = { width: 0, left: 0 };
		this.slide_bar_offset = '15';
		if( this.slide_bar.attr('data-size-offset') ){
			this.slide_bar_offset = parseInt(this.slide_bar.attr('data-size-offset'));
		}

		this.slide_bar_width = 0;
		if( this.slide_bar.attr('data-width') ){
			this.slide_bar_width = parseInt(this.slide_bar.attr('data-width'));
		}

		this.current_menu = this.main_menu.children('.sf-menu').children('.current-menu-item, .current-menu-ancestor').children('a');
		
		this.init();
		
	} // zurf_sf_menu

	zurf_sf_menu.prototype = {
		
		init: function(){
			
			var t = this;
			
			// sf menu mod
			t.sf_menu_mod();
			
			// init superfish menu
			if(typeof($.fn.superfish) == 'function'){
				t.main_menu.superfish({ delay: 400, speed: 'fast' });	
				
				t.sf_menu_position();
				$(window).resize(zurf_debounce(function(){
					t.sf_menu_position();
				}, 300));
			}
			
			// init the slidebar
			if( t.slide_bar.length > 0 ){
				t.init_slidebar();
			}
			
		}, // init
		
		sf_menu_mod: function(){
			
			// create the mega menu script
			this.main_menu.find('.sf-mega > ul').each(function(){	
				var mega_content = $('<div></div>');
				var mega_row = $('<div class="sf-mega-section-wrap" ></div>');
				var mega_column_size = 0;
				
				$(this).children('li').each(function(){
					var column_size = parseInt($(this).attr('data-size'));
					if( mega_column_size + column_size  <= 60 ){
						mega_column_size += column_size;
					}else{	
						mega_column_size = column_size;
						mega_content.append(mega_row);
						mega_row = $('<div class="sf-mega-section-wrap" ></div>');
					}
					
					mega_row.append( $('<div class="sf-mega-section" ></div>')
						.addClass('zurf-column-' + column_size)
						.html( $('<div class="sf-mega-section-inner" ></div>')
							.addClass($(this).attr('class'))
							.attr('id', $(this).attr('id'))
							.html($(this).html())
						)
					);
				});
				
				mega_content.append(mega_row);
				$(this).replaceWith(mega_content.html());
			});
			
		}, // sf_menu_mod
		
		sf_menu_position: function(){

			if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ) return;

			// submenu of normal menu
			var body_wrapper = $('.zurf-body-wrapper');
			var sub_normal_menu = this.main_menu.find('.sf-menu > li.zurf-normal-menu .sub-menu');
			
			sub_normal_menu.css({display: 'block'}).removeClass('sub-menu-right sub-menu-left');
			sub_normal_menu.each(function(){
				if( $(this).offset().left + $(this).width() > body_wrapper.outerWidth() ){
					$(this).addClass('sub-menu-right');
				}else if( $(this).offset().left < 0 ){
					$(this).addClass('sub-menu-left');
				}
			});
			sub_normal_menu.css({display: 'none'});
			
			// submenu of mega menu
			this.main_menu.find('.sf-menu > li.zurf-mega-menu .sf-mega').each(function(){
				if( !$(this).hasClass('sf-mega-full') ){
					
					$(this).css({ display: 'block' });
					
					// set the position
					$(this).css({ right: '', 'margin-left': -(($(this).width() - $(this).parent().outerWidth()) / 2) });
					
					// if exceed the screen
					if( $(this).offset().left < 0  ){
						$(this).css({ left: 0, 'margin-left': '' });
					}else if( $(this).offset().left + $(this).width() > $(window).width() ){
						$(this).css({ right: 0, 'margin-left': '' });
					}
					
					$(this).css({ display: 'none' });
				}
				
			});
			
		}, // sf_menu_position
		
		init_slidebar: function(){
			
			var t = this;
			
			t.init_slidebar_pos();
			$(window).on('load', function(){ t.init_slidebar_pos(); });
			
			// animate slidebar 
			t.main_menu.children('.sf-menu').children('li').on({
				mouseenter: function(){
					var nav_element = $(this).children('a');

					if( nav_element.length > 0 ){

						if( t.slide_bar_width > 0 ){
							var sbw = t.slide_bar_width;
							if( t.slide_bar.hasClass('zurf-left') ){
								var sbl = nav_element.position().left - t.slide_bar_offset;
							}else{
								var sbl = nav_element.position().left + ((nav_element.outerWidth() - sbw)/2) - t.slide_bar_offset;
							}
						}else{
							var sbw = nav_element.outerWidth() + (2 * t.slide_bar_offset);
							var sbl = nav_element.position().left - t.slide_bar_offset;
						}

						t.slide_bar.animate({ width: sbw, left: sbl }, { queue: false, duration: 250 });
					}
				}, 
				mouseleave: function(){
					t.slide_bar.animate({ width: t.slide_bar_val.width, left: t.slide_bar_val.left }, { queue: false, duration: 250 });
				}
			});
			
			// window resize event
			$(window).on('resize', function(){ t.init_slidebar_pos(); });
			$(window).on('zurf-navigation-slider-bar-init', function(){ 
				t.current_menu = t.main_menu.children('.sf-menu').children('.current-menu-item, .current-menu-ancestor').children('a');
				t.animate_slidebar_pos(); 
			});
			$(window).on('zurf-navigation-slider-bar-animate', function(){ t.animate_slidebar_pos(); });
			
		}, // init_slidebar
		
		init_slidebar_pos: function(){

			if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ) return;

			var t = this;

			if( t.current_menu.length > 0 ){
				if( t.slide_bar_width > 0 ){
					var sbw = t.slide_bar_width;
					if( t.slide_bar.hasClass('zurf-left') ){
						var sbl = t.current_menu.position().left - t.slide_bar_offset;
					}else{
						var sbl = t.current_menu.position().left + ((t.current_menu.outerWidth() - sbw)/2) - t.slide_bar_offset;
					}
				}else{
					var sbw = t.current_menu.outerWidth() + (2 * t.slide_bar_offset);
					var sbl = t.current_menu.position().left - t.slide_bar_offset;
				}
				t.slide_bar_val = { width: sbw, left: sbl };
			}else{
				t.slide_bar_val = { width: 0 }

				var first_child =  t.main_menu.children('ul').children('li:first-child');
				if( typeof(first_child.position()) != 'undefined' ){
					t.slide_bar_val.left = first_child.position().left;
				}else{
					t.slide_bar_val.left = 0;
				}
			}
			t.slide_bar.css({ width: t.slide_bar_val.width, left: t.slide_bar_val.left, display: 'block' });

		}, // set_slidebar_pos	
		animate_slidebar_pos: function(){

			if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ) return;

			var t = this;

			if( t.current_menu.length > 0 ){
				if( t.slide_bar_width > 0 ){
					var sbw = t.slide_bar_width;
					if( t.slide_bar.hasClass('zurf-left') ){
						var sbl = t.current_menu.position().left - t.slide_bar_offset;
					}else{
						var sbl = t.current_menu.position().left + ((t.current_menu.outerWidth() - sbw)/2) - t.slide_bar_offset ;
					}
				}else{
					var sbw = t.current_menu.outerWidth() + (2 * t.slide_bar_offset);
					var sbl = t.current_menu.position().left - t.slide_bar_offset;
				}
				t.slide_bar_val = { width: sbw, left: sbl };
			}else{
				t.slide_bar_val = { width: 0 }

				var first_child =  t.main_menu.children('ul').children('li:first-child');
				if( typeof(first_child.position()) != 'undefined' ){
					t.slide_bar_val.left = first_child.position().left;
				}else{
					t.slide_bar_val.left = 0;
				}
			}
			t.slide_bar.animate({ width: t.slide_bar_val.width, left: t.slide_bar_val.left }, { queue: false, duration: 250 });

		} // set_slidebar_pos
		
	}; // zurf_sf_menu.prototype
	
	/////////////////////////
	// mobile menu
	/////////////////////////
	$.fn.zurf_mobile_menu = function( args ){
		
		var menu_button = $(this).siblings('.zurf-mm-menu-button');
		var options = {
			navbar: { title: '<span class="mmenu-custom-close" ></span>' },
			extensions: [ 'pagedim-black' ],

		};
		var extensions = { 
			offCanvas: { pageNodetype: '.zurf-body-outer-wrapper' } 
		};

		// remove the wrap for submenu
		$(this).find('a[href="#"]').each(function(){
			var content = $(this).html();
			$('<span class="zurf-mm-menu-blank" ></span>').html(content).insertBefore($(this));
			$(this).remove();
		});
		
		if( $(this).attr('data-slide') ){
			var html_class = 'zurf-mmenu-' + $(this).attr('data-slide');
			$('html').addClass(html_class);

			options.offCanvas = { position : $(this).attr('data-slide') };
		}		
		
		$(this).mmenu(options, extensions);

		var menu_api = $(this).data('mmenu');
		$(this).find('a').not('.mm-next, .mm-prev').on('click', function(){
			menu_api.close();
		});
		$(this).find('.mmenu-custom-close').on('click', function(){
			menu_api.close();
		});
		$(window).resize(function(){
			menu_api.close();
		});

		// add class active to button
		menu_api.bind('open', function($panel){
			menu_button.addClass('zurf-active');
		});
		menu_api.bind('close', function($panel){
			menu_button.removeClass('zurf-active');
		});

	}	

	/////////////////////////
	// overlay menu
	/////////////////////////
	var zurf_overlay_menu = function( menu ){

		this.menu = menu;
		this.menu_button = menu.children('.zurf-overlay-menu-icon');
		this.menu_content = menu.children('.zurf-overlay-menu-content');
		this.menu_close = this.menu_content.children('.zurf-overlay-menu-close');

		this.init();
	}
	zurf_overlay_menu.prototype = {
		
		init: function(){

			var t = this;

			// add transition delay for each menu
			var delay_count = 0;
			t.menu_content.appendTo('body');
			t.menu_content.find('ul.menu > li').each(function(){
				$(this).css('transition-delay', (delay_count * 150) + 'ms');

				delay_count++;
			});

			// bind the menu button
			t.menu_button.on('click', function(){
				$(this).addClass('zurf-active');

				t.menu_content.fadeIn(200, function(){
					$(this).addClass('zurf-active');
				});

				return false;
			});

			// bind the menu close button
			t.menu_close.on('click', function(){
				t.menu_button.removeClass('zurf-active');

				t.menu_content.fadeOut(400, function(){
					$(this).removeClass('zurf-active');
				});
				t.menu_content.find('.sub-menu').slideUp(200).removeClass('zurf-active');

				return false;
			});

			// menu item click
			t.menu_content.find('a').on('click', function(e){ 
				var sub_menu = $(this).siblings('.sub-menu');
				if( sub_menu.length > 0 ){
					if( !sub_menu.hasClass('zurf-active') ){
						var prev_active = sub_menu.closest('li').siblings().find('.sub-menu.zurf-active');
						if( prev_active.length > 0 ){
							prev_active.removeClass('zurf-active').slideUp(150);
							sub_menu.delay(150).slideDown(400, 'easeOutQuart').addClass('zurf-active');
						}else{
							sub_menu.slideDown(400, 'easeOutQuart').addClass('zurf-active');
						}

						$(this).addClass('zurf-no-preload');
						return false;
					}else if( $(this).attr('href') == '#' ){
						sub_menu.removeClass('zurf-active').slideUp(150);
					}else{
						$(this).removeClass('zurf-no-preload');
					}
				}else{
					t.menu_close.trigger('click');
				}
			});

		}

	}; // zurf_overlay_menu.prototype

	/////////////////////////
	// header side navigation
	/////////////////////////
	var zurf_header_side_nav = function( side_nav ){

		if( side_nav.length == 0 ) return;

		this.prev_scroll = 0;

		this.side_nav = side_nav;
		this.side_nav_content = side_nav.children();

		this.init();

	} // zurf_header_side_nav

	zurf_header_side_nav.prototype = {

		init: function(){

			var t = this;

			t.init_nav_bar_element();

			$(window).resize(function(){ 
				t.init_nav_bar_element();
			});
			
			$(window).scroll(function(){

				if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ) return;

				// if content longer than screen height
				if( t.side_nav.hasClass('zurf-allow-slide') ){

					var admin_bar_height = parseInt($('html').css('margin-top'));
					var scroll_down = ($(window).scrollTop() > t.prev_scroll);
					t.prev_scroll = $(window).scrollTop();

					// if scroll down
					if( scroll_down ){

						if( !t.side_nav.hasClass('zurf-fix-bottom') ){
							if( t.side_nav.hasClass('zurf-fix-top') ){
								t.side_nav.css('top', t.side_nav.offset().top);
								t.side_nav.removeClass('zurf-fix-top');

							}else if( $(window).height() + $(window).scrollTop() > t.side_nav_content.offset().top + t.side_nav_content.outerHeight() ){ 
								if( !t.side_nav.hasClass('zurf-fix-bottom') ){
									t.side_nav.addClass('zurf-fix-bottom');
									t.side_nav.css('top', '');
								}
							}
						}

					// if scroll up
					}else{

						if( !t.side_nav.hasClass('zurf-fix-top') ){
							if( t.side_nav.hasClass('zurf-fix-bottom') ){
								var top_pos = $(window).scrollTop() + ($(window).height() - admin_bar_height) - t.side_nav_content.outerHeight();
								t.side_nav.css('top', top_pos);
								t.side_nav.removeClass('zurf-fix-bottom');

							}else if( $(window).scrollTop() + admin_bar_height < t.side_nav_content.offset().top ){ 
								if( !t.side_nav.hasClass('zurf-fix-top') ){
									t.side_nav.addClass('zurf-fix-top');
									t.side_nav.css('top', '');
								}
							}
						}
					
					}

				}
			});

		},

		init_nav_bar_element: function(){

			if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ) return;

			var t = this;
			var middle_pos = t.side_nav_content.children('.zurf-pos-middle').addClass('zurf-active');
			var bottom_pos = t.side_nav_content.children('.zurf-pos-bottom').addClass('zurf-active');

			// remove all additional space
			t.side_nav_content.children('.zurf-pre-spaces').remove();

			// add class depends on the screen size/content
			if( $(window).height() < t.side_nav_content.height() ){
				t.side_nav.addClass('zurf-allow-slide');
			}else{
				t.side_nav.removeClass('zurf-allow-slide zurf-fix-top zurf-fix-bottom').css('top', '');

				// set the middle position
				if( t.side_nav.hasClass('zurf-style-middle') ){
					middle_pos.each(function(){
						var top_padding = parseInt($(this).css('padding-top'));
						var prespace = ((t.side_nav.height() - (t.side_nav_content.height() - top_padding)) / 2) - top_padding;

						if( prespace > 0 ){
							$('<div class="zurf-pre-spaces" ></div>').css('height', prespace).insertBefore($(this));
						}
					});
				}

				// set the bottom position
				bottom_pos.each(function(){
					var prespace = t.side_nav.height() - t.side_nav_content.height();

					if( prespace > 0 ){
						$('<div class="zurf-pre-spaces" ></div>').css('height', prespace).insertBefore($(this));
					}
				});

			}
		}

	}; // zurf_sf_menu.prototype

	/////////////////////////
	// anchoring
	/////////////////////////	

	var zurf_anchor = function(){

		this.anchor_link = $('a[href*="#"]').not('[href="#"]').filter(function(){

			// for mm-menu plugin
			if( $(this).is('.zurf-mm-menu-button, .mm-next, .mm-prev, .mm-title, .gdlr-core-ilightbox') ){
				return false;
			}

			// for google review plugin
			if( $(this).is('') ){
				return false;
			}

			// for additional plugins
			if( $(this).is('.fbx-btn-transition, .ti-header') ){
				return false;
			}else if( $(this).parent('.clearButton').length ){
				return false;
			}

			// for woocommerce
			if( $(this).parent('.description_tab, .reviews_tab').length || $(this).not('[class^="zurf"]').closest('.woocommerce').length ){
				if( !$(this).closest('.menu-item').length ){
					return false;
				}
			}



			return true;
		});

		if( this.anchor_link.length || window.location.hash.length ){
			this.menu_anchor = $('#zurf-main-menu, #zurf-bullet-anchor');
			this.home_anchor = this.menu_anchor.find('ul.sf-menu > li.current-menu-item > a, ul.sf-menu > li.current-menu-ancestor > a, .zurf-bullet-anchor-link.current-menu-item');

			this.init();
		}
	}
	zurf_anchor.prototype = {

		init: function(){

			var t = this;

			t.animate_anchor();
			t.scroll_section();

			// init bullet anchor height
			t.menu_anchor.filter('#zurf-bullet-anchor').each(function(){
				$(this).css('margin-top', - t.menu_anchor.height() / 2).addClass('zurf-init');
			});

			// initialize if the page hash exists
			// wait for all element to initialize ( eg. flexslider )
			var url_hash = window.location.hash;
			if( url_hash ){
				setTimeout(function(){

					var current_menu = t.menu_anchor.find('a[href*="' + url_hash + '"]');
					if( !current_menu.is('.current-menu-item, .current-menu-ancestor') ){
						current_menu.addClass('current-menu-item').siblings().removeClass('current-menu-item current-menu-ancestor');

						$(window).trigger('zurf-navigation-slider-bar-init');
					}

					t.scroll_to(url_hash, false, 300);
				}, 500);
			}
	
		},

		animate_anchor: function(){

			var t = this;

			// home anchor
			t.home_anchor.on('click', function(){

				if( window.location.href == this.href ){
					$('html, body').animate({ scrollTop: 0 }, { duration: 1500, easing: 'easeOutQuart' });
					return false;
				}
				
			});

			// normal anchor
			t.anchor_link.on('click', function() {
				if( location.hostname == this.hostname && location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') ){
					if( $(this).closest('#zurf-main-menu').length ){
						$(this).parent().addClass('current-menu-item').siblings().removeClass('current-menu-item');
						$(window).trigger('zurf-navigation-slider-bar-init');
					}
					return t.scroll_to(this.hash, true);
				}
			});

		}, // animate anchor

		scroll_to: function( hash, redirect, duration ){

			// start scrolling
			if( hash == '#zurf-top-anchor' ){
				var scroll_position = 0;
			}else{
				
				var target = $(hash);

				if( target.length ){
					var scroll_position = target.offset().top;
				}
			}

			if( typeof(scroll_position) != 'undefined' ){

				// offset for wordpress admin bar
				scroll_position = scroll_position - parseInt($('html').css('margin-top'));

				// offset for fixed nav bar
				if( zurf_display == 'mobile-portrait' || zurf_display == 'mobile-landscape' ){
					scroll_position = scroll_position - 75;
				}else if( typeof(window.zurf_anchor_offset) != 'undefined' && !isNaN(window.zurf_anchor_offset) ){
					scroll_position = scroll_position - parseInt(window.zurf_anchor_offset);
				}

				if( scroll_position < 0 ) scroll_position = 0;

				$(window).trigger('zurf-anchor-animate');
				$('html, body').animate({ scrollTop: scroll_position }, { duration: 1500, easing: 'easeOutQuart', queue: false });

				return false;

			}else if( redirect ){

				window.location.href = $('body').attr('data-home-url') + hash;

				return false;
			}

		}, // scroll to

		scroll_section: function(){

			var t = this;

			// have anchor in anchor menu
			var menu_link_anchor = this.menu_anchor.find('a[href*="#"]').not('[href="#"]');
			if( !menu_link_anchor.length ){ return; }

			// get anchor section
			var home_anchor_section = $('#zurf-page-wrapper');
			var anchor_section = home_anchor_section.find('div[id], section[id]');
			if( !anchor_section.length ){ return; }

			// add data for faster query
			menu_link_anchor.each(function(){
				if( $(this).closest('.sub-menu').length == 0 && $(this.hash).length ){
					$(this).attr('data-anchor', this.hash);
				}
			});

			// check section on scroll event
			$(window).scroll(function(){

				if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ) return;
				
				if( t.home_anchor.length && $(window).scrollTop() <= home_anchor_section.offset().top ){

					t.home_anchor.each(function(){
						if( $(this).hasClass('zurf-bullet-anchor-link') ){
							$(this).addClass('current-menu-item').siblings().removeClass('current-menu-item');
							$(this).parent('.zurf-bullet-anchor').attr('data-anchor-section', 'zurf-home');
						}else if( !$(this).parent('.current-menu-item, .current-menu-ancestor').length ){
							$(this).parent().addClass('current-menu-item').siblings().removeClass('current-menu-item current-menu-ancestor');
							$(window).trigger('zurf-navigation-slider-bar-init');
						}			
					});

				}else{
					var section_position = $(window).scrollTop() + ($(window).height() / 2);

					anchor_section.each(function(){
						if( $(this).css('display') == 'none' ) return;
						
						var top_offset_pos = $(this).offset().top;

						if( (section_position > top_offset_pos) && (section_position <  top_offset_pos + $(this).outerHeight()) ){
							var section_id = $(this).attr('id');
							menu_link_anchor.filter('[data-anchor="#' +  section_id + '"]').each(function(){
								if( $(this).hasClass('zurf-bullet-anchor-link') ){
									$(this).addClass('current-menu-item').siblings().removeClass('current-menu-item');
									$(this).parent('.zurf-bullet-anchor').attr('data-anchor-section', section_id);
								}else if( $(this).parent('li.menu-item').length && !$(this).parent('li.menu-item').is('.current-menu-item, .current-menu-ancestor') ){
									$(this).parent('li.menu-item').addClass('current-menu-item').siblings().removeClass('current-menu-item current-menu-ancestor');
									$(window).trigger('zurf-navigation-slider-bar-init');
								}
							});
							
							return false;
						}

					});
				}

			});

		} // scroll section

	};

	var zurf_sticky_navigation = function(){

		var t = this;

		// get navigation
		t.sticky_nav = $('.zurf-with-sticky-navigation .zurf-sticky-navigation');
		t.mobile_menu = $('#zurf-mobile-header');

		// set the anchor offset
		if( t.sticky_nav.hasClass('zurf-sticky-navigation-height') ){
			window.zurf_anchor_offset = t.sticky_nav.outerHeight();
			$(window).resize(function(){
				window.zurf_anchor_offset = t.sticky_nav.outerHeight();
			});
		}else if( t.sticky_nav.attr('data-navigation-offset') ){
			window.zurf_anchor_offset = parseInt(t.sticky_nav.attr('data-navigation-offset'));
		}else if( t.sticky_nav.length ){
			window.zurf_anchor_offset = 75;
		}

		// init the sticky navigation
		if( t.sticky_nav.length ){
			t.init(); 
		}

		if( t.mobile_menu.hasClass('zurf-sticky-mobile-navigation') ){
			t.style_mobile_slide();
			$(window).trigger('zurf-set-sticky-mobile-navigation'); 
		}

	}
	zurf_sticky_navigation.prototype = {
		
		init: function(){

			var t = this;

			if( t.sticky_nav.hasClass('zurf-style-fixed') ){
				t.style_fixed();
			}else if( t.sticky_nav.hasClass('zurf-style-slide') ){
				t.style_slide();
			}

			$(window).trigger('zurf-set-sticky-navigation'); 
		},

		style_fixed: function(){

			var t = this;
			var placeholder = $('<div class="zurf-sticky-menu-placeholder" ></div>');

			$(window).on('scroll zurf-set-sticky-navigation', function(){

				if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ) return;

				var page_offset = parseInt($('html').css('margin-top'));

				if( !t.sticky_nav.hasClass('zurf-fixed-navigation') ){

					if( $(window).scrollTop() + page_offset > t.sticky_nav.offset().top ){
						if( !t.sticky_nav.hasClass('zurf-without-placeholder') ){
							placeholder.height(t.sticky_nav.outerHeight());
						}
						placeholder.insertAfter(t.sticky_nav);
						$('body').append(t.sticky_nav);
						t.sticky_nav.addClass('zurf-fixed-navigation');
						
						setTimeout(function(){ t.sticky_nav.addClass('zurf-animate-fixed-navigation'); }, 10);	
						setTimeout(function(){ 
							t.sticky_nav.css('height', ''); 
							$(window).trigger('zurf-navigation-slider-bar-animate');
						}, 200);
					}
				}else{

					if( $(window).scrollTop() + page_offset <= placeholder.offset().top ){
						if( !t.sticky_nav.hasClass('zurf-without-placeholder') ){
							t.sticky_nav.height(placeholder.height());
						}
						t.sticky_nav.insertBefore(placeholder);
						t.sticky_nav.removeClass('zurf-fixed-navigation');
						placeholder.remove();

						setTimeout(function(){ t.sticky_nav.removeClass('zurf-animate-fixed-navigation'); }, 10);	
						setTimeout(function(){ 
							t.sticky_nav.css('height', ''); 
							$(window).trigger('zurf-navigation-slider-bar-animate');
						}, 200);
					}
				}
			});

		}, // style_fixed

		style_slide: function(){

			var t = this;
			var placeholder = $('<div class="zurf-sticky-menu-placeholder" ></div>');

			$(window).on('scroll zurf-set-sticky-navigation', function(){

				if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ){ return; }

				var page_offset = parseInt($('html').css('margin-top'));

				if( !t.sticky_nav.hasClass('zurf-fixed-navigation') ){

					if( $(window).scrollTop() + page_offset > t.sticky_nav.offset().top + t.sticky_nav.outerHeight() + 200 ){
						
						if( !t.sticky_nav.hasClass('zurf-without-placeholder') ){
							placeholder.height(t.sticky_nav.outerHeight());
						}
						placeholder.insertAfter(t.sticky_nav);
						t.sticky_nav.css('display', 'none');

						$('body').append(t.sticky_nav);
						t.sticky_nav.addClass('zurf-fixed-navigation zurf-animate-fixed-navigation');
						t.sticky_nav.slideDown(200);
						$(window).trigger('zurf-navigation-slider-bar-animate');
					}
				}else{

					if( $(window).scrollTop() + page_offset <= placeholder.offset().top + placeholder.height() + 200 ){
						var clone = t.sticky_nav.clone();
						clone.insertAfter(t.sticky_nav);
						clone.slideUp(200, function(){ $(this).remove(); });

						t.sticky_nav.insertBefore(placeholder);
						placeholder.remove();
						t.sticky_nav.removeClass('zurf-fixed-navigation zurf-animate-fixed-navigation');
						t.sticky_nav.css('display', 'block');

						$(window).trigger('zurf-navigation-slider-bar-animate');
					}
				}
			});

		}, // style_slide		

		style_mobile_slide: function(){

			var t = this;
			var placeholder = $('<div class="zurf-sticky-mobile-placeholder" ></div>');

			$(window).on('scroll zurf-set-sticky-mobile-navigation', function(){

				if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' || zurf_display == 'tablet' ){

					var page_offset = parseInt($('html').css('margin-top'));

					if( !t.mobile_menu.hasClass('zurf-fixed-navigation') ){
						if( $(window).scrollTop() + page_offset > t.mobile_menu.offset().top + t.mobile_menu.outerHeight() + 200 ){
							placeholder.height(t.mobile_menu.outerHeight()).insertAfter(t.mobile_menu);
							$('body').append(t.mobile_menu);
							t.mobile_menu.addClass('zurf-fixed-navigation');
							t.mobile_menu.css('display', 'none').slideDown(200);
						}
					}else{
						if( $(window).scrollTop() + page_offset <= placeholder.offset().top + placeholder.height() + 200 ){
							var clone = t.mobile_menu.clone();
							clone.insertAfter(t.mobile_menu);
							clone.slideUp(200, function(){ $(this).remove(); });

							t.mobile_menu.insertBefore(placeholder);
							placeholder.remove();
							t.mobile_menu.removeClass('zurf-fixed-navigation');
							t.mobile_menu.css('display', 'block');
						}
					}
				}

			});

		}, // style_slide

	};

	var zurf_font_resize = function(){

		this.heading_font = $('h1, h2, h3, h4, h5, h6');

		this.init();

	}
	zurf_font_resize.prototype = {

		init: function(){

			var t = this;

			t.resize();
			$(window).on('resize', zurf_throttling(function(){
				t.resize();
			}, 100));

		},

		resize: function(){
			
			var t = this;

			if( zurf_display == 'mobile-landscape' || zurf_display == 'mobile-portrait' ){

				t.heading_font.each(function(){
					if( parseInt($(this).css('font-size')) > 40 ){
						if( !$(this).attr('data-orig-font') ){
							$(this).attr('data-orig-font', $(this).css('font-size')); 
						}

						$(this).css('font-size', '40px');
					}
				});

			// return font to normal
			}else{

				t.heading_font.filter('[data-orig-font]').each(function(){
					$(this).css('font-size', $(this).attr('data-orig-font'));
				});

			}
		}

	};

	// tourmaster lightbox
	function zurf_lightbox( content ){

		var lightbox_wrap = $('<div class="zurf-lightbox-wrapper" ></div>').hide();
		var lightbox_content_wrap = $('<div class="zurf-lightbox-content-cell" ></div>');
		lightbox_wrap.append(lightbox_content_wrap);
		lightbox_content_wrap.wrap($('<div class="zurf-lightbox-content-row" ></div>'));

		lightbox_content_wrap.append(content);

		var scrollPos = $(window).scrollTop();
		$('html').addClass('zurf-lightbox-on');
		$('body').append(lightbox_wrap);
		lightbox_wrap.fadeIn(300);

		// do a lightbox action
		lightbox_wrap.on('click', '.zurf-lightbox-close', function(){
			$('html').removeClass('zurf-lightbox-on');
			$(window).scrollTop(scrollPos);
			lightbox_wrap.fadeOut(300, function(){
				$(this).remove();
			});
		});

	} // zurf_lightbox

	////////////////////////////////
	// starting running the script
	////////////////////////////////
	$(document).ready(function(){
	
		// resize font on mobile
		new zurf_font_resize();

		// init main navigation menu
		$('#zurf-main-menu, #zurf-right-menu, #zurf-mobile-menu, #zurf-top-bar-menu').each(function(){
			if( $(this).hasClass('zurf-overlay-menu') ){
				new zurf_overlay_menu( $(this) );
			}else if( $(this).hasClass('zurf-mm-menu-wrap') ){
				$(this).zurf_mobile_menu();
			}else{
				new zurf_sf_menu( $(this) );
			}
		});

		$('#zurf-top-search, #zurf-mobile-top-search').each(function(){

			var search_wrap = $(this).siblings('.zurf-top-search-wrap');
			search_wrap.appendTo('body');

			// bind click button
			$(this).on('click', function(){
				search_wrap.fadeIn(200, function(){
					$(this).addClass('zurf-active');
				});
			});

			// bind close button
			search_wrap.find('.zurf-top-search-close').on('click', function(){
				search_wrap.fadeOut(200, function(){
					$(this).addClass('zurf-active');
				});
			});

			// bind search button
			search_wrap.find('.search-submit').on('click', function(){
				if( search_wrap.find('.search-field').val().length == 0 ){
					return false;
				}
			});
		});

		$('#zurf-main-menu-cart, #zurf-mobile-menu-cart').each(function(){
			
			$(this).on({
				mouseenter: function(){
					$(this).addClass('zurf-active zurf-animating');
				}, 
				mouseleave: function(){
					var menu_cart = $(this);
					menu_cart.removeClass('zurf-active');
					setTimeout(function(){
						menu_cart.removeClass('zurf-animating');
					}, 400)
				}
			});
		});

		// woocommerce top bar cart
		if( typeof(wc_add_to_cart_params) != 'undefined' ){
			$('body').on('added_to_cart', function(){
				$.ajax({
					type: 'POST',
					url: wc_add_to_cart_params.ajax_url,
					data: { 'action': 'top_bar_woocommerce_cart' },
					dataType: 'json',
					error: function(jqXHR, textStatus, errorThrown){
						console.log(jqXHR, textStatus, errorThrown);
					},
					success: function(data){
						if( typeof(data['title']) != 'undefined' ){
							$('.zurf-top-cart-title').replaceWith(data['title']);
						}
						if( typeof(data['cart-items']) != 'undefined' ){
							$('.zurf-top-cart-item-wrap').replaceWith(data['cart-items']);
						}
					}
				});
			});
		}
		

		// zurf
		$('#zurf-dropdown-zurf-flag').hover(function(){
			$(this).children('.zurf-dropdown-zurf-list').fadeIn(200);
		}, function(){
			$(this).children('.zurf-dropdown-zurf-list').fadeOut(200);
		});

		// additional space for header transparent
		$('.zurf-header-boxed-wrap, .zurf-header-background-transparent, .zurf-navigation-bar-wrap.zurf-style-transparent').each(function(){
			var header_transparent = $(this);
			var header_transparent_sub = $('.zurf-header-transparent-substitute');

			header_transparent_sub.height(header_transparent.outerHeight());
			$(window).on('load resize', function(){
				header_transparent_sub.height(header_transparent.outerHeight());
			});
		});

		// full screen for 404 not found
		$('body.error404, body.search-no-results').each(function(){

			var wrap = $(this).find('#zurf-full-no-header-wrap');
			var body_wrap_offset = parseInt($(this).children('.zurf-body-outer-wrapper').children('.zurf-body-wrapper').css('margin-bottom'));
			
			var padding = ($(window).height() - wrap.offset().top - wrap.outerHeight() - body_wrap_offset) / 2;
			if( padding > 0 ){
				wrap.css({ 'padding-top': padding, 'padding-bottom': padding });
			}

			$(window).on('load resize', function(){
				wrap.css({ 'padding-top': 0, 'padding-bottom': 0 });
				padding = ($(window).height() - wrap.offset().top - wrap.outerHeight() - body_wrap_offset) / 2;
				if( padding > 0 ){
					wrap.css({ 'padding-top': padding, 'padding-bottom': padding });
				}
			});
		});

		// back to top button
		var back_to_top = $('#zurf-footer-back-to-top-button');
		if( back_to_top.length ){ 
			$(window).on('scroll', function(){
				if( $(window).scrollTop() > 300 ){
					back_to_top.addClass('zurf-scrolled');
				}else{
					back_to_top.removeClass('zurf-scrolled');
				}
			});
		}

		// page preload
		$('body').children('#zurf-page-preload').each(function(){
			var page_preload = $(this);
			var animation_time = parseInt(page_preload.attr('data-animation-time'));
			
			$('a[href]').not('[href^="#"], [href^="mailto:"], [target="_blank"], .gdlr-core-js, .strip, .sf-with-ul, .remove, .ajax_add_to_cart, .comment-reply-link').on('click', function(e){
				if( e.which != 1 || $(this).hasClass('zurf-no-preload') || e.ctrlKey ) return;
				
				if( $(this).prop("hash") && $($(this).prop("hash")).length ) return;
				
				if( window.location.href != this.href ){
					page_preload.addClass('zurf-out').fadeIn(animation_time);
				}
			});
			
			$(window).on('load', function(){
				page_preload.fadeOut(animation_time);
			});
		});

		// single nav style 2 sync height
		$('body.zurf-blog-style-2 .zurf-single-nav-area').each(function(){
			var max_height;
			var single_nav_2 = $(this).children();

			max_height = 0;
			single_nav_2.css('min-height', '0px');
			single_nav_2.each(function(){
				if( max_height < $(this).outerHeight() ){
					max_height = $(this).outerHeight();
				}
			});
			single_nav_2.css('min-height', max_height);

			$(window).resize(function(){
				max_height = 0;
				single_nav_2.css('min-height', '0px');
				single_nav_2.each(function(){
					if( max_height < $(this).outerHeight() ){
						max_height = $(this).outerHeight();
					}
				});
				single_nav_2.css('min-height', max_height);
			});
		});

		// lightbox popup
		$('[data-zurf-lb]').click(function(){
			var lb_content = $(this).siblings('[data-zurf-lb-id="' + $(this).attr('data-zurf-lb') + '"]');
			zurf_lightbox(lb_content.clone());
		});

		// float social
		$('#zurf-float-social').each(function(){
			var float_social_item = $(this);
			var pb_body = $('.gdlr-core-page-builder-body');

			var footer = $('footer');
			var content_area = $('.zurf-page-wrapper');
			var content_offset = 0;
			content_offset += parseInt($('html').css('margin-top'));

			$(window).on('scroll float-social', function(){

				
				// display
				if( float_social_item.hasClass('zurf-display-after-title') ){
					var blog_offset = 0;
					content_area.children('.zurf-blog-title-wrap').each(function(){ blog_offset = $(this).outerHeight(); });

					if( float_social_item.offset().top >= content_area.offset().top + blog_offset - content_offset ){
						float_social_item.animate({'opacity': 1}, {duration: 100, queue: false});
					}else{
						float_social_item.animate({'opacity': 0}, {duration: 100, queue: false});
					}
				}

				// section
				var section = '';
				var fs_pos = $(window).scrollTop() + $(window).height() / 2; 

				if( fs_pos > footer.offset().top ){
					section = 'footer';
				}else{
					pb_body.children().each(function(){
						if( !$(this).attr('data-float-social') ) return;

						if( fs_pos > $(this).offset().top && fs_pos <  $(this).offset().top + $(this).outerHeight() ){
							section = $(this).attr('data-float-social');
						}
					});
				}

				float_social_item.attr('data-section', section);
			});
			$(window).on('load', function(){
				$(window).trigger('float-social');
			});
		});

		// side content menu
		$('#zurf-side-content-menu').each(function(){

			var side_content_menu = $(this);
			var menu_button = $('.zurf-side-content-menu-button');
			menu_button.on('click', function(){
				side_content_menu.fadeIn(300);
				side_content_menu.addClass('zurf-active');
			});
			side_content_menu.on('click', '.zurf-side-content-menu-close', function(){
				side_content_menu.removeClass('zurf-active');
				side_content_menu.fadeOut(300);
			});

		});
		
	});

	// fix back button for preload
	$(window).on('pageshow', function(event) {
        $('body').children('#zurf-page-preload').each(function(){
			$(this).fadeOut(400);
		});
	});

	$(window).on('load', function(){

		// fixed footer
		$('#zurf-fixed-footer').each(function(){
			var fixed_footer = $(this);
			var placeholder = $('<div class="zurf-fixed-footer-placeholder" ></div>');

			placeholder.insertBefore(fixed_footer);
			placeholder.height(fixed_footer.outerHeight());
			$('body').css('min-height', $(window).height() - parseInt($('html').css('margin-top'))); // for safari
			$(window).resize(function(){ 
				placeholder.height(fixed_footer.outerHeight()); 
				$('body').css('min-height', $(window).height() - parseInt($('html').css('margin-top')));
			});
		});

		// side navigation bar
		new zurf_header_side_nav( $('#zurf-header-side-nav') );

		// sticky navigation
		if( !$('body').hasClass('single-tour') && !$('body').hasClass('tourmaster-template-payment') ){
			new zurf_sticky_navigation();
		}

		// anchoring
		new zurf_anchor();

		// update woocommerce data
		$('body').not('.woocommerce-cart, .woocommerce-checkout').trigger('added_to_cart');
	});

})(jQuery);