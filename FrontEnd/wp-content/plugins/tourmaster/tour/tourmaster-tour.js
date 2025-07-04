(function($){
	"use strict";

	// Detect Screen
	var tourmaster_display = 'desktop';
	if( typeof(window.matchMedia) == 'function' ){
		$(window).on('resize tourmaster-set-display', function(){
			if( window.matchMedia('(max-width: 419px)').matches ){
				tourmaster_display = 'mobile-portrait';
			}else if( window.matchMedia('(max-width: 767px)').matches ){
				tourmaster_display = 'mobile-landscape'
			}else if( window.matchMedia('(max-width: 999px)').matches ){
				tourmaster_display = 'tablet'
			}else{
				tourmaster_display = 'desktop';
			}
		});
		$(window).trigger('tourmaster-set-display');
	}else{
		$(window).on('resize tourmaster-set-display', function(){
			if( $(window).innerWidth() <= 419 ){
				tourmaster_display = 'mobile-portrait';
			}else if( $(window).innerWidth() <= 767 ){
				tourmaster_display = 'mobile-landscape'
			}else if( $(window).innerWidth() <= 999 ){
				tourmaster_display = 'tablet'
			}else{
				tourmaster_display = 'desktop';
			}
		});
		$(window).trigger('tourmaster-set-display');
	}	

    // datepicker
	$.fn.tourmaster_datepicker = function(){

		$(this).each(function(){
			var date_input = $(this);
			var datepicker_wrap = $(this).closest('.tourmaster-datepicker-wrap');
			var alternate_field = $(this).siblings('.tourmaster-datepicker-alt');
			var date_format = $(this).attr('data-date-format');

			if( !$(this).attr('data-tour-date') ){
				if( date_input.val() ){
					datepicker_wrap.addClass('tourmaster-with-date');
				}

				$(this).datepicker({
					dateFormat: date_format,
					altFormat: 'yy-mm-dd',
					altField: alternate_field,
					changeMonth: true,
					changeYear: true,
					minDate: new Date(),
					onSelect: function(){
						datepicker_wrap.addClass('tourmaster-with-date');
					}
				});

				datepicker_wrap.on('click', '.tourmaster-clear-date', function(){
					date_input.val('');
					alternate_field.val('');
					datepicker_wrap.removeClass('tourmaster-with-date');
				});
			}else{
				var date_range = $(this).attr('data-tour-range');
				var available_date = JSON.parse($(this).attr('data-tour-date'));	
				var current_date = $(this).val();
				var selected_date = current_date;

				$(this).datepicker({
					dateFormat: date_format,
					altFormat: 'yy-mm-dd',
					altField: alternate_field,
					changeMonth: true,
					changeYear: true,
					minDate: new Date(available_date[0]),
					maxDate: new Date(available_date[ available_date.length - 1 ]),

					// determine selectable date
					beforeShowDay: function( date ){
						current_date  = date.getFullYear() + '-';
						current_date += ('0' +(date.getMonth() + 1)).slice(-2) + '-';
						current_date += ('0' + date.getDate()).slice(-2);

						var extra_class = '';
						var date_diff = tourmaster_date_diff(selected_date, current_date);
						if( date_diff >= 0 && date_diff < date_range ){
							extra_class = 'tourmaster-highlight';
						}

						if( available_date.indexOf(current_date) >= 0 ){
							return [true, extra_class, ''];
						}else{
							return [false, extra_class, ''];
						}
					},

					// for date range
					onSelect: function( dateText, inst ){
						selected_date  = inst.selectedYear + '-';
						selected_date += ('0' +(inst.selectedMonth + 1)).slice(-2) + '-';
						selected_date += ('0' + inst.selectedDay).slice(-2);

						alternate_field.trigger('change');
					},

					// datepicker position right
				 	beforeShow: function(input, inst){
				        var widget = $(inst).datepicker('widget');
				        if( $("body").hasClass("rtl") ){
							widget.css('margin-left', widget.outerWidth() - $(input).outerWidth() );
						}else{
							widget.css('margin-left', $(input).outerWidth() - widget.outerWidth());
						}
				        widget.css('margin-top', -2);
				    },

					// for localization
					closeText: TMi18n.closeText,
					currentText: TMi18n.currentText,
					monthNames: TMi18n.monthNames,
					monthNamesShort: TMi18n.monthNamesShort,
					dayNames: TMi18n.dayNames,
					dayNamesShort: TMi18n.dayNamesShort,
					dayNamesMin: TMi18n.dayNamesMin,
					firstDay: TMi18n.firstDay
				});
				
				var initial_date = new Date(current_date + 'T00:00:00+00:00');
				initial_date = new Date(initial_date.getTime() + (initial_date.getTimezoneOffset() * 60000));
				$(this).datepicker('setDate', initial_date);
			}
		});

	} // tourmaster_datepicker

    function tourmaster_date_diff(date1, date2){
		var dt1 = new Date(date1);
		var dt2 = new Date(date2);
		return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
	}

	// tour booking bar
	function tourmaster_tour_booking_ajax( ajax_url, ajax_settings, ajax_data ){

		var ajax_settings = $.extend({
			beforeSend: function( jqXHR, settings ){},
			error: function( jqXHR, textStatus, errorThrown ){

				// print error message for debug purpose
				console.log(jqXHR, textStatus, errorThrown);
			},
			success: function( data ){ 
				// console.log('success', data); 
			}
		}, ajax_settings);

		var ajax_data = $.extend({
			action: 'tourmaster_tour_booking',
		}, ajax_data);

		$.ajax({
			type: 'POST',
			url: ajax_url,
			data: ajax_data,
			dataType: 'json',
			beforeSend: ajax_settings.beforeSend,
			error: ajax_settings.error,
			success: ajax_settings.success
		});
	}
	function tourmaster_tour_input( form ){
		var ret = {};

		form.find('input[name], select[name], textarea[name]').each(function(){
			var key = $(this).attr('name');
			if( (key.lastIndexOf('[]') == (key.length - 2)) ){
				key = key.substr(0, key.length - 2);
				if( typeof(ret[key]) != 'object' ){
					ret[key] = []
				}

				ret[key].push($(this).val());
			}else{	
				ret[key] = $(this).val();
			}
		});

		return ret;
	}
	function tourmaster_get_booking_detail( form ){
		var booking_detail = {};

		form.find('input[name], select[name], textarea[name]').each(function(){
			var key = $(this).attr('name');
			var value;

			if( $(this).is('[type="checkbox"]') ){
				var value = $(this).is(':checked')? $(this).val(): 0;
			}else if( $(this).is('[type="radio"]') ){
				if( $(this).is(':checked') ){
					var value = $(this).val();
				}else{
					return;
				}
			}else{
				var value = $(this).val();
			}

			if( (key.lastIndexOf('[]') == (key.length - 2)) ){
				key = key.substr(0, key.length - 2);
				if( typeof(booking_detail[key]) != 'object' ){
					booking_detail[key] = []
				}

				booking_detail[key].push(value);
			}else{	
				booking_detail[$(this).attr('name')] = value;
			}
		});	

		// console.log(booking_detail);

		return booking_detail;
	}
	$.fn.tourmaster_tour_booking = function(){

		var form = $(this);
		var ajax_url = $(this).attr('data-ajax-url');

		// step 1
		$(this).on('change', 'input[name="tour-date"], select[name="tour-date"]', function(){

			var sent_data = tourmaster_tour_input(form);
			sent_data['step'] = 1;

			// remove unrelated input
			form.find('[data-step]').each(function(){
				if( $(this).attr('data-step') > 1 ){
					$(this).slideUp(200, function(){ $(this).remove(); });
				}
			});

			// get new input
			tourmaster_tour_booking_ajax(ajax_url, {
				success: function( data ){
					if( typeof(data.content) != 'undefined' ){

						// remove unrelated input once again
						form.find('[data-step]').each(function(){
							if( $(this).attr('data-step') > 1 ){
								$(this).slideUp(200, function(){ $(this).remove(); });
							}
						});

						var content = $(data.content).hide();
						form.append(content);
						content.find('.tourmaster-datepicker').tourmaster_datepicker();
						content.slideDown(200);
					}
				}
			}, {
				data: sent_data
			});
		});

		// step 2
		$(this).on('change', 'input[name="package"]', function(){

			var sent_data = tourmaster_tour_input(form);
			sent_data['step'] = 2;

			// remove unrelated input
			form.find('[data-step]').each(function(){
				if( $(this).attr('data-step') > 2 ){
					$(this).slideUp(200, function(){ $(this).remove(); });
				}
			});

			// get new input
			tourmaster_tour_booking_ajax(ajax_url, {
				success: function( data ){
					if( typeof(data.content) != 'undefined' ){
						var content = $(data.content).hide();
						form.append(content);
						content.find('.tourmaster-datepicker').tourmaster_datepicker();
						content.slideDown(200);

						// update header price
						content.find('select').first().trigger('change');
					}
				}
			}, {
				data: sent_data
			});
		});

		// step 3
		$(this).on('change', 'select[name="tour-room"]', function(){
			var wrap = $(this).closest('.tourmaster-tour-booking-room');
			var template = wrap.siblings('.tourmaster-tour-booking-room-template').children();
			var container = wrap.siblings('.tourmaster-tour-booking-people-container');
			var container_animate = false;

			if( $(this).val() && container.length == 0 ){
				var container = $('<div class="tourmaster-tour-booking-people-container" data-step="999" ></div>').hide();
				container.insertAfter(wrap);
				container_animate = true;
			}

			if( $(this).val() ){
				var count = parseInt($(this).val()) - container.children().length;

				// add template fields
				if( count > 0 ){
					for( var i = 0; i < count; i++ ){
						var clone = template.clone();
						clone.attr('data-step', 4);
						clone.find('.tourmaster-tour-booking-room-text > span').html((container.children().length + 1));

						container.append(clone);
						if( !container_animate ){
							clone.hide();
							clone.slideDown(200);
						}
					} 

				// remove excess fields
				}else if( count < 0 ){
					container.children('div').slice(count).slideUp(200, function(){ $(this).remove(); });	
				}

				if( container_animate ){
					container.slideDown(200);
				}
			
			}else{
				// remove container out
				if( container.length > 0 ){
					container.slideUp(200, function(){ $(this).remove(); });
				}
			}
		});
		// $(this).find('select[name="tour-room"]').trigger('change');

		// for updating the head price
		var orig_price = '';
		if( $(this).hasClass('tourmaster-update-header-price') ){
			$(this).on('change', 'input, select', function(){

				var header_price = $('.tourmaster-header-price');
				var booking_data = tourmaster_get_booking_detail(form);
				if( !orig_price ){
					orig_price  = header_price.html();
				}
				
				// if( $(this).is('[name="package"]') ){
				// 	booking_data['tour-people'] = 0;
				// 	booking_data['tour-adult'] = 0;
				// 	booking_data['tour-male'] = 0;
				// 	booking_data['tour-female'] = 0;
				// 	booking_data['tour-children'] = 0;
				// 	booking_data['tour-student'] = 0;
				// 	booking_data['tour-infant'] = 0;
				// }
				
				tourmaster_tour_booking_ajax(ajax_url, {
					success: function( data ){
						
						if( typeof(data.price) != 'undefined' ){
							header_price.data('original-price', header_price.html());
							header_price.find('.tourmaster-tour-discount-price').remove();
							header_price.find('.tourmaster-tour-price-wrap').removeClass('tourmaster-discount');
							header_price.addClass('tourmaster-price-updated').find('.tourmaster-tour-price .tourmaster-tail').html(data.price);
							$(window).trigger('resize');
						}else if( orig_price ){
							header_price.html(orig_price).removeClass('tourmaster-price-updated');
							if( $(document.body).hasClass("rtl") ){
								header_price.find('[data-rel=tipsy]').tipsy({fade: true, gravity: 'sw'});
							}else {
								header_price.find('[data-rel=tipsy]').tipsy({fade: true, gravity: 'se'});
							}
						}
					}
				}, {
					action: 'tourmaster_update_head_price',
					data: booking_data
				});
			});		
		}

		// validate input before submitting
		$(this).on('click', 'input[type="submit"]', function(){

			var submit_button = $(this);
			var error_message = $(this).siblings('.tourmaster-tour-booking-submit-error');

			// validate extra fields
			var validate = true;
			form.find('input[data-required], select[data-required], textarea[data-required]').each(function(){
				if( !$(this).val() ){
					validate = false;
				}
			});
			if( !validate ){
				error_message.slideDown(200);
				return false;
			}
			
			var extra_booking_info = {};
			form.find('.tourmaster-extra-booking-field').find('input, select, textarea').each(function(){
				extra_booking_info[$(this).attr('name')] = $(this).val();
			});

			// validate booking fields
			var submit = true;
			var tour_package = '';
			var traveller_amount = 0;
			var adult_amount = 0;
			var male_amount = 0;
			var female_amount = 0;
			var max_traveller_per_room = 0;
			error_message.filter('.tourmaster-temp').slideUp(200, function(){ $(this).remove() });

			form.find('[data-step]').each(function(){
				var step = $(this).attr('data-step');
				if( step == 1 || step == 2 || step == 3 ){
					$(this).find('input[name], select[name]').each(function(){
						if( $(this).val() == "" ){
							submit = false;
						}else if( $(this).attr('name') == 'package' ){
							tour_package = $(this).val();
						}
					});
				}else if( step == 4 ){
					var num_people = 0;
					var room_people = 0;
					$(this).find('select[name], input[name]').each(function(){
						if( $(this).attr('name') == 'group' ){
							traveller_amount = 'group';
							adult_amount = 'group';
						}else if( $(this).val() != "" ){
							room_people += parseInt($(this).val());

							if( $(this).is('[name^="tour-adult"], [name^="tour-people"]') ){
								adult_amount += room_people;
							}else if( $(this).is('[name^="tour-male"]') ){
								male_amount += room_people;
								adult_amount += room_people;
							}else if( $(this).is('[name^="tour-female"]') ){
								female_amount += room_people;
								adult_amount += room_people;
							}
						}
					});

					num_people += room_people;
					if( room_people > max_traveller_per_room ){
						max_traveller_per_room = room_people;
					}

					if( traveller_amount != 'group' ){
						if( num_people <= 0 ){
							submit = false;
						}else{
							traveller_amount += num_people;
						}
					}
				}
			});

			if( !submit ){
				error_message.slideDown(200);
			}else{
				error_message.slideUp(200);

				submit_button.animate({ opacity: 0.5 });
				tourmaster_tour_booking_ajax(ajax_url, {
					success: function( data ){
						
						if( data.status == 'success' ){
							if( submit && submit_button.attr('data-ask-login') ){
								
								// get lightbox content
								var content = submit_button.siblings('[data-tmlb-id="' + submit_button.attr('data-ask-login') + '"]');
								if( content.length == 0 ){
									content = form.closest('form').siblings('[data-tmlb-id="' + submit_button.attr('data-ask-login') + '"]');
								}
								var lb_content = content.clone();
								
								// check for social login plugin
								if( lb_content.find('.nsl-container-block').length > 0 ){
									lb_content.find('.nsl-container-block').replaceWith(content.find('.nsl-container-block').clone(true));
								}
								
								tourmaster_lightbox(lb_content);

								var booking_detail = tourmaster_get_booking_detail(form);
								tourmaster_set_cookie('tourmaster-booking-detail', JSON.stringify(booking_detail), 0);
							}else{
								var booking_detail = tourmaster_get_booking_detail(form);
								tourmaster_set_cookie('tourmaster-booking-detail', JSON.stringify(booking_detail), 0);
								
								form.submit();
							}
						}else if( typeof(data.message) != 'undefined' ){
							var temp_error = $('<div class="tourmaster-tour-booking-submit-error tourmaster-temp" ></div>').html(data.message);
							temp_error.insertAfter(submit_button);
							temp_error.slideDown(200);
						}
						submit_button.animate({ opacity: 1 });
					}
				}, {
					action: 'tourmaster_tour_booking_amount_check',
					tid: form.find('[name="tid"]').val(),
					tour_id: form.find('[name="tour-id"]').val(),
					tour_date: form.find('[name="tour-date"]').val(),
					traveller: traveller_amount,
					'adult_amount': adult_amount,
					'male_amount': male_amount,
					'female_amount': female_amount,
					'package': tour_package,
					'max_traveller_per_room': max_traveller_per_room,
					'extra_booking_info': extra_booking_info
				});
			}

			return false;
		});
		
	}

	$.fn.tourmaster_tour_booking_sticky = function(){

		// animate sidebar
		$(this).each(function(){
			var page_wrap = $(this).closest('.tourmaster-page-wrapper');
			var template_wrap = page_wrap.children('.tourmaster-template-wrapper');
			var booking_bar_wrap = $(this);
			var booking_bar_anchor = $(this).siblings('.tourmaster-tour-booking-bar-anchor');
			var top_offset = parseInt($('html').css('margin-top'));
			var left_offset = parseInt(booking_bar_anchor.css('margin-left'));
			var right_offset = parseInt(booking_bar_anchor.css('margin-right'));

			// hide header price and replace with header price in the booking bar
			if( page_wrap.hasClass('tourmaster-tour-style-1') ){ 
				$(this).addClass('tourmaster-start-script');
				page_wrap.siblings('.tourmaster-single-header').addClass('tourmaster-start-script');
				
				var header_price = $(this).children('.tourmaster-tour-booking-bar-outer').children('.tourmaster-header-price');
				booking_bar_wrap.css('margin-top', -header_price.outerHeight());
				booking_bar_anchor.css('margin-top', -header_price.outerHeight());
				page_wrap.css('min-height', booking_bar_wrap.height() - header_price.outerHeight());
				$(window).resize(function(){
					booking_bar_wrap.css('margin-top', -header_price.outerHeight());
					booking_bar_anchor.css('margin-top', -header_price.outerHeight());
					page_wrap.css('min-height', booking_bar_wrap.height() - header_price.outerHeight())

					if( $("body").hasClass("rtl") ){
						booking_bar_wrap.css({ 
							'position': '', 
							'top': '', 
							'right': '',
							'margin-top': booking_bar_anchor.css('margin-top')
						});
					}else {
						booking_bar_wrap.css({ 
							'position': '', 
							'top': '', 
							'left': '',
							'margin-top': booking_bar_anchor.css('margin-top')
						});
					}
					booking_bar_wrap.removeClass('tourmaster-fixed tourmaster-top tourmaster-bottom tourmaster-lock');
				}); 
			}

			// scroll action
			var top_padding = 0;
			var prev_scroll = 0;
			$(window).on('scroll resize', function(){
				if( !booking_bar_anchor.length ) return;

				var animate_on_scroll = true;
				if( tourmaster_display == 'mobile-landscape' || tourmaster_display == 'mobile-portrait' || tourmaster_display == 'tablet' ){
					animate_on_scroll = false;
				}

				var scroll_direction = (prev_scroll > $(window).scrollTop())? 'up': 'down';
				prev_scroll = $(window).scrollTop();

				// fixed nav bar
				if( animate_on_scroll && $(window).scrollTop() + top_offset + top_padding > booking_bar_anchor.offset().top ){

					// bar smaller than screensize
					if( $(window).height() > booking_bar_wrap.outerHeight() + top_padding ){
						
						if( $(window).scrollTop() + booking_bar_wrap.outerHeight() + top_offset + (top_padding * 2) > page_wrap.offset().top + page_wrap.outerHeight() ){
								
								if( !booking_bar_wrap.hasClass('tourmaster-fixed-lock') ){
									if( $("body").hasClass("rtl") ){
										booking_bar_wrap.css({
											'position': 'absolute',
											'top': template_wrap.outerHeight() - booking_bar_wrap.outerHeight() - top_padding,
											'right': 'auto',
											'margin-top': 0
										});
									}else{
										booking_bar_wrap.css({
											'position': 'absolute',
											'top': template_wrap.outerHeight() - booking_bar_wrap.outerHeight() - top_padding,
											'left': 'auto',
											'margin-top': 0
										});
									}

									booking_bar_wrap.removeClass('tourmaster-fixed');
									booking_bar_wrap.addClass('tourmaster-fixed-lock');
								}
							
						}else if( !booking_bar_wrap.hasClass('tourmaster-fixed') ){
							if( $("body").hasClass("rtl") ){
								booking_bar_wrap.css({ 
									'position': 'fixed', 
									'top': top_padding + top_offset, 
									'right': $(window).width() - (booking_bar_anchor.offset().left + booking_bar_anchor.outerWidth() ) - right_offset, 
									'margin-top': 0 
								});		
							}else {
								booking_bar_wrap.css({ 
									'position': 'fixed', 
									'top': top_padding + top_offset, 
									'left': booking_bar_anchor.offset().left - left_offset, 
									'margin-top': 0 
								});
							}

							booking_bar_wrap.removeClass('tourmaster-fixed-lock');
							booking_bar_wrap.addClass('tourmaster-fixed');
						}else{
							if( booking_bar_wrap.hasClass('tourmaster-fixed') ){
								if( $("body").hasClass("rtl") ){
									booking_bar_wrap.css({ 
										'right': $(window).width() - (booking_bar_anchor.offset().left + booking_bar_anchor.outerWidth() ) - right_offset, 
									});		
								}else {
									booking_bar_wrap.css({ 
										'left': booking_bar_anchor.offset().left - left_offset, 
									});
								}
							}	
						}

					// bar larger than screensize
					}else{

						// scroll down
						if( scroll_direction == 'down' ){
							
							if( booking_bar_wrap.hasClass('tourmaster-top') ){
								if( $("body").hasClass("rtl") ){
									booking_bar_wrap.css({
										'position': 'absolute',
										'top': $(window).scrollTop() + top_padding + top_offset - booking_bar_wrap.parent().offset().top,
										'right': 'auto',
										'margin-top': 0
									});	
								}else {
									booking_bar_wrap.css({
										'position': 'absolute',
										'top': $(window).scrollTop() + top_padding + top_offset - booking_bar_wrap.parent().offset().top,
										'left': 'auto',
										'margin-top': 0
									});
								}

								booking_bar_wrap.removeClass('tourmaster-top');
								booking_bar_wrap.addClass('tourmaster-lock');
							
							}else if( $(window).scrollTop() + $(window).height() > page_wrap.offset().top + page_wrap.outerHeight() ){

								if( !booking_bar_wrap.hasClass('tourmaster-lock') ){
									if( $("body").hasClass("rtl") ){ 
										booking_bar_wrap.css({
											'position': 'absolute',
											'top': template_wrap.outerHeight() - booking_bar_wrap.outerHeight(),
											'right': 'auto',
											'margin-top': 0
										});
									}else {
										booking_bar_wrap.css({
											'position': 'absolute',
											'top': template_wrap.outerHeight() - booking_bar_wrap.outerHeight(),
											'left': 'auto',
											'margin-top': 0
										});
									}

									booking_bar_wrap.removeClass('tourmaster-bottom');
									booking_bar_wrap.addClass('tourmaster-lock');
								}
							
							}else if( $(window).scrollTop() + $(window).height() > booking_bar_wrap.offset().top + booking_bar_wrap.outerHeight() ){	
								if( !booking_bar_wrap.hasClass('tourmaster-bottom') ){
									if( $("body").hasClass("rtl") ){
										booking_bar_wrap.css({ 
											'position': 'fixed', 
											'top': $(window).height() - booking_bar_wrap.outerHeight(),
											'right': $(window).width() - (booking_bar_anchor.offset().left + booking_bar_anchor.outerWidth() ) - right_offset, 
											'margin-top': 0 
										});
									}else {
										booking_bar_wrap.css({ 
											'position': 'fixed', 
											'top': $(window).height() - booking_bar_wrap.outerHeight(),
											'left': booking_bar_anchor.offset().left - left_offset, 
											'margin-top': 0 
										});
									}

									booking_bar_wrap.removeClass('tourmaster-top tourmaster-lock');
									booking_bar_wrap.addClass('tourmaster-bottom');
								}
							}else{
								if( booking_bar_wrap.hasClass('tourmaster-bottom') ){
									if( $("body").hasClass("rtl") ){
										booking_bar_wrap.css({ 
											'right': $(window).width() - (booking_bar_anchor.offset().left + booking_bar_anchor.outerWidth() ) - right_offset, 
										});
									}else{
										booking_bar_wrap.css({ 
											'left': booking_bar_anchor.offset().left - left_offset
										});
									}
								}
							}

						// scroll up
						}else{
							if( booking_bar_wrap.hasClass('tourmaster-bottom') ){
								if( $("body").hasClass("rtl") ){
									booking_bar_wrap.css({
										'position': 'absolute',
										'top': $(window).scrollTop() + $(window).height() - booking_bar_wrap.outerHeight() - booking_bar_wrap.parent().offset().top,
										'right': 'auto',
										'margin-top': 0
									});
								}else {
									booking_bar_wrap.css({
										'position': 'absolute',
										'top': $(window).scrollTop() + $(window).height() - booking_bar_wrap.outerHeight() - booking_bar_wrap.parent().offset().top,
										'left': 'auto',
										'margin-top': 0
									});
								}

								booking_bar_wrap.removeClass('tourmaster-bottom');
								booking_bar_wrap.addClass('tourmaster-lock');
							}else if( booking_bar_wrap.hasClass('tourmaster-lock') && $(window).scrollTop() + top_offset + top_padding < booking_bar_wrap.offset().top ){
								if( $("body").hasClass("rtl") ){ 
									booking_bar_wrap.css({ 
										'position': 'fixed', 
										'top': top_padding + top_offset,
										'right': $(window).width() - (booking_bar_anchor.offset().left + booking_bar_anchor.outerWidth() ) - right_offset, 
										'margin-top': 0 
									});
								}else {
									booking_bar_wrap.css({ 
										'position': 'fixed', 
										'top': top_padding + top_offset,
										'left': booking_bar_anchor.offset().left - left_offset, 
										'margin-top': 0 
									});
								}

								booking_bar_wrap.removeClass('tourmaster-bottom tourmaster-lock');
								booking_bar_wrap.addClass('tourmaster-top');
							}
						}
					}

				// retun nav bar to original position
				}else{

					if( booking_bar_wrap.hasClass('tourmaster-fixed') || booking_bar_wrap.hasClass('tourmaster-top') ||
						booking_bar_wrap.hasClass('tourmaster-bottom') ||booking_bar_wrap.hasClass('tourmaster-lock') ){

						if( $("body").hasClass("rtl") ){
							booking_bar_wrap.css({ 
								'position': '', 
								'top': '', 
								'right': '',
								'margin-top': booking_bar_anchor.css('margin-top')
							});
						}else {
							booking_bar_wrap.css({ 
								'position': '', 
								'top': '', 
								'left': '',
								'margin-top': booking_bar_anchor.css('margin-top')
							});
						}
						booking_bar_wrap.removeClass('tourmaster-fixed tourmaster-top tourmaster-bottom tourmaster-lock');
					}
				}

			});
		});

	} // tourmaster_tour_booking_sticky 

    var tourmaster_payment_template = function(){

		var t = this;
		t.form = $('#tourmaster-payment-template-wrapper');
		t.sidebar = t.form.find('#tourmaster-tour-booking-bar-inner');
		t.content = t.form.find('#tourmaster-tour-payment-content');

		t.payment_step = $('#tourmaster-payment-step-wrap');
		t.payment_template = $('#tourmaster-page-wrapper');
		t.init();
	}
	tourmaster_payment_template.prototype = {

		init: function(){
			
			var t = this;

			t.bind_script();
			t.bind_script_recurring();

			// bind the next state button
			t.form.on('click', '.tourmaster-payment-step', function(){
				
				var booking_detail_data = t.get_booking_detail();
				if( $(this).attr('data-name') ){
					booking_detail_data[$(this).attr('data-name')] = $(this).attr('data-value');
				}
				if( $(this).attr('data-step') ){
					booking_detail_data['step'] = $(this).attr('data-step');
				}

				if( t.check_required_field(booking_detail_data['step']) ){
					t.change_step({
						booking_detail: booking_detail_data
					});
				}
				
			});

			// bind the change state button
			t.payment_step.on('click', '.tourmaster-payment-step-item', function(){
				if( $(this).hasClass('tourmaster-enable') ){
					var booking_detail_data = t.get_booking_detail();
					if( $(this).attr('data-step') ){
						booking_detail_data['step'] = $(this).attr('data-step');
					}

					if( t.check_required_field(booking_detail_data['step']) ){
						t.change_step({
							booking_detail: booking_detail_data
						});
					}
				}
			});

			// additional service ajax
			t.form.on('change input', '.tourmaster-payment-service-form-wrap input', tourmaster_debounce(function(e){
				if( e.type == 'change' && $(e.target).is('input[type="text"]') ) return;

				var booking_detail_data = t.get_booking_detail();

				if( $(this).attr('data-step') ){
					booking_detail_data['step'] = 3;
				}

				t.change_step({
					booking_detail: booking_detail_data,
					sub_action: 'update_sidebar'
				});

			}, 1000));

			// bind the deposit button
			t.form.on('change', 'input[name="payment-type"]', function(){

				var total_price_wrap = $(this).closest('.tourmaster-tour-booking-bar-total-price-wrap');
				var deposit_price_wrap = total_price_wrap.siblings('.tourmaster-tour-booking-bar-deposit-text');

				if( deposit_price_wrap.length == 0 ){
					deposit_price_wrap = total_price_wrap.children('.tourmaster-tour-booking-bar-deposit-text');
				}
				
				if( $(this).is(':checked') ){
					if( $(this).val() == 'full' ){
						total_price_wrap.removeClass('tourmaster-deposit');
						deposit_price_wrap.slideUp(200);
						if( typeof(window.tourmaster_payment_type) !== 'undefined' ){
							window.tourmaster_payment_type = 'full';
							window.tourmaster_paypal_pay_amount = window.tourmaster_paypal_full_amount;
						}
					}else if( $(this).val() == 'partial' ){
						total_price_wrap.addClass('tourmaster-deposit');
						deposit_price_wrap.slideDown(200);
						if( typeof(window.tourmaster_payment_type) !== 'undefined' ){
							window.tourmaster_payment_type = 'partial';
							window.tourmaster_paypal_pay_amount = window.tourmaster_paypal_deposit_amount;
						}
					}
				}
				
			});

		},

		animate_content: function(element, content){

			var orig_height = element.outerHeight();
			element.html(content);
			var new_height = element.outerHeight();

			// animate
			element.css({height: orig_height});
			element.animate({height: new_height}, function(){
				element.css({height: 'auto'}, 1000)
			});
		},

		// bind general script
		bind_script_recurring: function(){

			var t = this;

			// or divider
			t.content.find('#tourmaster-payment-method-or').each(function(){
				var divider_width = ($(this).width() - $(this).children('.tourmaster-middle').width() - 40) / 2;
				$(this).children('.tourmaster-left, .tourmaster-right').css('width', divider_width);
			});
			$(window).resize(function(){
				t.content.find('#tourmaster-payment-method-or').each(function(){
					var divider_width = ($(this).width() - $(this).children('.tourmaster-middle').width() - 40) / 2;
					$(this).children('.tourmaster-left, .tourmaster-right').css('width', divider_width);
				});
			});

			// paypal button
			t.paypal_jssdk_payment();

		}, 

		bind_script: function(){

			var t = this;

			// max unit
			t.form.on('change input', '[data-max-unit]', function(){
				if( parseInt($(this).val()) > parseInt($(this).attr('data-max-unit')) ){
					$(this).val($(this).attr('data-max-unit'));
				}

			});

			// view price breakdown
			t.sidebar.on('click', '#tourmaster-tour-booking-bar-price-breakdown-link', function(){
				$(this).siblings('.tourmaster-price-breakdown').slideToggle(200);
			});

			// edit date
			t.sidebar.on('click', '.tourmaster-tour-booking-bar-date-edit', function(){
				var temp_form = $(this).siblings('form');
				var booking_detail = t.get_booking_detail();
				temp_form.append($('<input name="tour_temp" />').val(JSON.stringify(booking_detail)));
				temp_form.submit();
			});

			// coupon
			t.sidebar.on('click', '.tourmaster-tour-booking-bar-coupon-validate', function(){

				var coupon_code = $(this).siblings('[name="coupon-code"]');
				var coupon_message = $(this).siblings('.tourmaster-tour-booking-coupon-message');

				$.ajax({
					type: 'POST',
					url: $(this).attr('data-ajax-url'),
					data: { 'coupon_code': coupon_code.val(), 'tour_id': $(this).attr('data-tour-id'), 'action': 'tourmaster_validate_coupon_code', 'tid': $(this).attr('data-tid') },
					dataType: 'json',
					beforeSend: function(){
						coupon_code.animate({opacity: 0.3});
						coupon_message.slideUp(150);
						coupon_message.removeClass('tourmaster-success tourmaster-failed');
					},
					error: function( jqXHR, textStatus, errorThrown ){

						// print error message for debug purpose
						console.log(jqXHR, textStatus, errorThrown);
					},
					success: function( data ){
						coupon_code.animate({opacity: 1});

						if( data.status == 'success' ){
							var booking_detail_data = t.get_booking_detail();
							t.change_step({ booking_detail: booking_detail_data, sub_action: 'update_sidebar' });
						}else{
							coupon_message.addClass('tourmaster-' + data.status);
							coupon_message.html(data.message);
							coupon_message.slideDown(150);
						}
					}
				});
				

			});

			// payment billing
			t.content.on('click', '#tourmaster-payment-billing-copy', function(){
				if( $(this).is(':checked') ){
					var billing_info = $(this).closest('.tourmaster-payment-billing-wrap');
					var contact_info = billing_info.siblings('.tourmaster-payment-contact-wrap');

					billing_info.find('[data-contact-detail]').each(function(){
						var contact_field = contact_info.find('[name="' + $(this).attr('data-contact-detail') + '"]');
						$(this).val(contact_field.val());
					});
				}
			});

			// lightbox popup
			t.content.on('click', '[data-tmlb]', function(){
				var lb_content = $(this).siblings('[data-tmlb-id="' + $(this).attr('data-tmlb') + '"]');
				tourmaster_lightbox(lb_content.clone());
			});

			// payment button
			t.content.on('click', '[data-method]', function(){
				if( t.check_required_field(4) ){
					var action = $(this).attr('data-action');
					var type = $(this).attr('data-action-type');

					if( $(this).attr('data-method') == 'ajax' ){
						var booking_detail_data = t.get_booking_detail();
						t.change_step({
							'action': action, 
							'type': type, 
							'booking_detail': booking_detail_data
						});
					}
				}
			});
			t.content.on('click', '.goodlayers-payment-plugin-complete', function(){
				t.change_step({
					'action': 'tourmaster_payment_plugin_complete',
					'step': 4
				});
			});
			
			// payment style 2
			t.sidebar.on('click', '.tourmaster-pay-now, .tourmaster-pay-woocommerce', function(){
				if( t.check_required_field(4) ){
					var action = 'tourmaster_payment_selected';

					if( $(this).is('.tourmaster-pay-now') ){
						var type = $(this).closest('.tourmaster-tour-booking-side-payment-wrap').find('.tourmaster-payment-selection').val();
					}else{
						var type = 'woocommerce';
					}
					
					var booking_detail_data = t.get_booking_detail();
					t.change_step({
						'action': action, 
						'type': type, 
						'booking_detail': booking_detail_data
					});
				}
			});
		},

		// paypal jssdk
		paypal_jssdk_payment: function(){
			
			var t = this;

			var paypal_container = $('#paypal-button-container').empty();
			
			if( paypal_container.length && typeof(paypal) !== 'undefined' ){		
				paypal.Buttons({
					createOrder: (data, actions) => {
						if( t.check_required_field(4) ){
							return actions.order.create({
								purchase_units: [{
									amount: {
										currency_code: window.tourmaster_paypal_currency_code,
										value: window.tourmaster_paypal_pay_amount
									}
								}]
							});
						}
						return false;
					},
					onApprove: (data, actions) => {
						return actions.order.capture().then(function(orderData) {
							t.change_step({
								'action': 'tourmaster_payment_selected', 
								'type': 'paypal', 
								'paypal_type': 'js-sdk',
								'order_data': orderData,
								'booking_detail': t.get_booking_detail()
							},{
								complete: function(data){
									// console.log(data, actions);
								}
							});
						});
					}
				}).render('#paypal-button-container');
			}

		},

		// check required input field
		check_required_field: function(step){

			var t = this;
			var error = false;

			var error_box = t.form.find('.tourmaster-tour-booking-required-error');
			if( error_box.length ){
				error_box.slideUp(200);

				if( step == 3 ){
					t.form.find('input[data-required], select[data-required], textarea[data-required]').each(function(){
						if( !$(this).val() ){ 	
							$(this).addClass('tourmaster-validate-error');
							error = 'default';
						}else if( $(this).is('[type="email"]') ){
							var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    						if( !re.test($(this).val().toLowerCase()) ){
    							$(this).addClass('tourmaster-validate-error');
    							error = 'email';
    						}
						}else if( $(this).is('[name="phone"], [name="billing_phone"]') ){
							var re = /^[\d\+\-\s\(\)\.]*$/;
    						if( !re.test($(this).val().toLowerCase()) ){
    							$(this).addClass('tourmaster-validate-error');
    							error = 'phone';
    						}
						}

						if( !error ){
							$(this).removeClass('tourmaster-validate-error');
						}
					});
					if( error ){
						error_box.html(error_box.data(error));
						error_box.slideDown(200);

						var scrollPos = error_box.offset().top - $(window).height() + 200;
						if( scrollPos > 0 ){
							$('html, body').animate({scrollTop: scrollPos}, 600, 'easeOutQuad');
						}
					}
				}

				if( step == 4 ){
					t.form.find('[name="term-and-service"]').each(function(){
						if( !$(this).prop('checked') ){
							error = 'default'; 
							error_box.html(error_box.data(error));
							error_box.slideDown(200);
						}
					});
				}
			}
			
			return (error === false);
		},

		// get the input field
		get_booking_detail: function(){
			var t = this;
			var booking_detail = {};
			if( t.form.attr('data-booking-detail') ){
				booking_detail = JSON.parse(t.form.attr('data-booking-detail'));
			}

			var booking_detail_new = tourmaster_get_booking_detail(t.form);

			// assign value back
			for( var slug in booking_detail_new ){ booking_detail[slug] = booking_detail_new[slug]; }
			t.form.attr('data-booking-detail', JSON.stringify(booking_detail));

			return booking_detail;
		},

		change_step: function(ajax_data, ajax_settings){

			var t = this;

			var ajax_data = $.extend({
				action: 'tourmaster_payment_template',
			}, ajax_data);

			var ajax_settings = $.extend({
				beforeSend: function(){

					// loading animation
					if( typeof(ajax_data.sub_action) == 'undefined' || ajax_data.sub_action != 'update_sidebar' ){
						t.content.animate({opacity: 0.1});

						// animate to the top
						$('html, body').animate({scrollTop: t.payment_template.offset().top}, 600, 'easeOutQuad');
					}

					t.sidebar.animate({opacity: 0.1});

				},
				error: function( jqXHR, textStatus, errorThrown ){

					// print error message for debug purpose
					console.log(jqXHR, textStatus, errorThrown);
				},
				success: function( data ){

					// assign content
					if( typeof(data.content) != 'undefined' ){
						t.animate_content(t.content, data.content);
					}

					// assign sidebar
					if( typeof(data.sidebar) != 'undefined' ){
						t.animate_content(t.sidebar, data.sidebar);
					}

					// update cookie
					if( typeof(data.cookie) != 'undefined' ){
						var new_booking_detail = JSON.stringify(data.cookie);
						tourmaster_set_cookie('tourmaster-booking-detail', new_booking_detail, 0);
						t.form.attr('data-booking-detail', new_booking_detail);
					}

					// set the step bar
					if( typeof(ajax_data.booking_detail) != 'undefined' || typeof(ajax_data.step) != 'undefined' ){
						if( typeof(ajax_data.step) != 'undefined' ){
							var booking_step = ajax_data.step;
						}else{
							var booking_step = ajax_data.booking_detail.step;
						}

						t.payment_step.find('.tourmaster-payment-step-item').each(function(){
							if( booking_step == 4 ){
								$(this).addClass('tourmaster-checked').removeClass('tourmaster-current tourmaster-enable')
							}else{
								if( $(this).attr('data-step') == 1 ){
									$(this).addClass('tourmaster-checked').removeClass('tourmaster-current tourmaster-enable');
								}else if( $(this).attr('data-step') == booking_step ){
									$(this).addClass('tourmaster-current').removeClass('tourmaster-checked tourmaster-enable');
								}else if( $(this).attr('data-step') < booking_step ){
									$(this).addClass('tourmaster-enable').removeClass('tourmaster-checked tourmaster-current');
								}else{
									$(this).removeClass('tourmaster-checked tourmaster-current tourmaster-enable');
								}
							}
						});
					}

					t.content.animate({opacity: 1});
					t.sidebar.animate({opacity: 1});

					t.bind_script_recurring();

					if( typeof(ajax_settings.complete) == 'function' ){
						ajax_settings.complete(data);
					}
				}
			}, ajax_settings);

			$.ajax({
				type: 'POST',
				url: t.form.attr('data-ajax-url'),
				data: ajax_data,
				dataType: 'json',
				beforeSend: ajax_settings.beforeSend,
				error: ajax_settings.error,
				success: ajax_settings.success
			});
		},
	};

    // single review
    $.fn.tourmaster_single_review = function(){
        var review_section = $(this);
        var review_filter = $(this).find('#tourmaster-single-review-filter');
        var review_content = $(this).find('#tourmaster-single-review-content');

        // bind the filter
        var sort_by = review_filter.find('[data-sort-by]');
        var filter_by = review_filter.find('#tourmaster-filter-by');

        sort_by.on('click', function(){
            if( $(this).hasClass('tourmaster-active') ) return false;

            $(this).addClass('tourmaster-active').siblings('[data-sort-by]').removeClass('tourmaster-active');
            tourmaster_get_review_ajax({
                'action': 'get_single_tour_review',
                'tour_id': review_content.attr('data-tour-id'),
                'sort_by': $(this).attr('data-sort-by'),
                'filter_by': filter_by.val()
            }, review_content);
        });
        filter_by.on('change', function(){
            tourmaster_get_review_ajax({
                'action': 'get_single_tour_review',
                'tour_id': review_content.attr('data-tour-id'),
                'sort_by': sort_by.filter('.tourmaster-active').attr('data-sort-by'),
                'filter_by': $(this).val()
            }, review_content);
        });

        review_content.on('click', '[data-paged]', function(){
            tourmaster_get_review_ajax({
                'action': 'get_single_tour_review',
                'tour_id': review_content.attr('data-tour-id'),
                'paged': $(this).attr('data-paged'),
                'sort_by': sort_by.filter('.tourmaster-active').attr('data-sort-by'),
                'filter_by': filter_by.val()
            }, review_content, review_section);
        });

    }
    function tourmaster_get_review_ajax( ajax_data, content_section, scroll_to = null ){
        content_section.animate({opacity: 0.2}, 200);

        $.ajax({
            type: 'POST',
            url: content_section.attr('data-ajax-url'),
            data: ajax_data,
            dataType: 'json',
            error: function( jqXHR, textStatus, errorThrown ){

                content_section.animate({opacity: 1}, 200);

                // print error message for debug purpose
                console.log(jqXHR, textStatus, errorThrown);
            },
            success: function( data ){

                if( typeof(data.content) != 'undefined' ){
                    var old_height = content_section.outerHeight();
                    content_section.html(data.content);

                    var new_height = content_section.outerHeight();
                    content_section.css({'height': old_height});
                    content_section.animate({height: new_height}, 200 , function(){
                        content_section.css({height: 'auto'});
                    });
                }	

                content_section.animate({opacity: 1}, 200);

                if( scroll_to != null ){
                    $('body, html').animate({'scrollTop': scroll_to.offset().top - 150 });
                }

            }
        });
    }	

	// on document ready
	$(document).ready(function(){

        var body = $('body');

		body.find('.tourmaster-tour-search-filter-clear').on('click', function(){

			var form = $(this).closest('form');
			form.find('.tourmaster-rating-select[data-rating-score="0"]').trigger('click');
			form.find('input[type="text"], select, input[name="rating"], input[type="hidden"]').val('');
			form.find('input[type="checkbox"]').removeAttr('checked');

			return false;
		});

        // tipsy
		if( body.hasClass("rtl") ){
			$('[data-rel=tipsy]').tipsy({fade: true, gravity: 'sw'});
		}else {
			$('[data-rel=tipsy]').tipsy({fade: true, gravity: 'se'});
		}

        // sync grid content height
		new gdlr_core_sync_height( $('body'), $('.tourmaster-tour-content-wrap.gdlr-core-js') );
		/*
		$('.tourmaster-tour-item-style-grid').each(function(){
			var max_height = 0;
			var default_padding = 8;
			var sync_item = $(this).find('.tourmaster-tour-grid.tourmaster-tour-frame .tourmaster-tour-content-wrap');
			
			sync_item.each(function(){
				if( $(this).outerHeight() > max_height ){	
					max_height = $(this).outerHeight();
				}
			});
			sync_item.each(function(){
				var bottom_padding = max_height - $(this).outerHeight() + parseInt($(this).css('padding-bottom'));
				$(this).css('padding-bottom', bottom_padding);
			});


			$(window).resize(function(){
				max_height = 0;
				sync_item.css('padding-bottom', default_padding);
				sync_item.each(function(){
					if( $(this).outerHeight() > max_height ){	
						max_height = $(this).outerHeight();
					}
				});
				sync_item.each(function(){
					var bottom_padding = max_height - $(this).outerHeight() + parseInt($(this).css('padding-bottom'));
					$(this).css('padding-bottom', bottom_padding);
				});
			});
		});
		*/

		// center right content
		$('.tourmaster-center-tour-content').each(function(){
			var left_height = $(this).siblings('.tourmaster-content-left').outerHeight();
			$(this).css({'padding-top': 0, 'padding-bottom': 0});
			var padding = (left_height - $(this).outerHeight()) / 2;
			padding = (padding > 0)? padding: 0;
			$(this).css({'padding-top': padding, 'padding-bottom': padding });

			$(window).resize(function(){
				var left_height = $(this).siblings('.tourmaster-content-left').outerHeight();
				$(this).css({'padding-top': 0, 'padding-bottom': 0});
				var padding = (left_height - $(this).outerHeight()) / 2;
				padding = (padding > 0)? padding: 0;
				$(this).css({'padding-top': padding, 'padding-bottom': padding });
			});
		});

        // search rating
		var search_item = $('.tourmaster-tour-search-item');
		if( search_item.length ){
			tourmaster_rating(search_item);

			search_item.find('.tourmaster-type-filter-title i').click(function(){
				var filter_content = $(this).parent().siblings('.tourmaster-type-filter-item-wrap');

				if( $(this).hasClass('tourmaster-active') ){
					$(this).removeClass('tourmaster-active');
					filter_content.slideUp(200);
				}else{
					$(this).addClass('tourmaster-active');
					filter_content.slideDown(200);
				}
			});
		}

		// trigger the datepicker
		$('.tourmaster-datepicker').tourmaster_datepicker();

        // on user template
		if( body.hasClass('single-tour')){

			// read more content button
			$('.tourmaster-single-tour-read-more-wrap .tourmaster-button').on('click', function(){
				var scrollPos = $(window).scrollTop();

				$(this).hide();
				$(this).parent().parent().siblings('.tourmaster-single-tour-read-more-gradient').hide();
				$(this).closest('.tourmaster-single-tour-content-wrap').css({'max-height': 'none', 'margin-bottom': 0});

				$('html, body').scrollTop(scrollPos);

				return false;
			});

			// tour booking bar
			$('#tourmaster-single-tour-booking-fields').tourmaster_tour_booking();
			$('#tourmaster-tour-booking-bar-wrap').tourmaster_tour_booking_sticky();

			// submit booking form
			$('#tourmaster-enquiry-form').find('input[type="submit"]').click(function(){
				if( $(this).hasClass('tourmaster-now-loading') ){ return false; }

				var form = $(this).closest('form');
				var form_button = $(this);
				var message_box = form.find('.tourmaster-enquiry-form-message').not('.tourmaster-enquiry-term-message');

				var condition_accepted_input = form.find('[name="tourmaster-require-acceptance"]');
                if( condition_accepted_input.length && !condition_accepted_input.is(':checked') ){
                    condition_accepted_input.siblings('.tourmaster-enquiry-form-message').slideDown(150);
                    return false;
                }else{
                    condition_accepted_input.siblings('.tourmaster-enquiry-form-message').slideUp(150);
                }

				var validate = true;
				form.find('input[data-required], select[data-required], textarea[data-required]').each(function(){
					if( !$(this).val() ){
						validate = false;
					}
				});

				if( !validate ){
					if( form.attr('data-validate-error') ){
						message_box.removeClass('tourmaster-success').addClass('tourmaster-failed');
						message_box.html(form.attr('data-validate-error'));
						message_box.slideDown(300);
					}
				}else{

					message_box.slideUp(300);
					form_button.addClass('tourmaster-now-loading');

					$.ajax({
						type: 'POST',
						url: form.attr('data-ajax-url'),
						data: { action: form.attr('data-action'), data: tourmaster_get_booking_detail(form) },
						dataType: 'json',
						error: function( jqXHR, textStatus, errorThrown ){
							// print error message for debug purpose
							console.log(jqXHR, textStatus, errorThrown);
						},
						success: function( data ){
							if( typeof(grecaptcha) != 'undefined' ){
								form.find('#g-recaptcha-response').val('gdlr-verfied');
							}
							
							form_button.removeClass('tourmaster-now-loading');

							if( typeof(data.message) != 'undefined' ){
								if( data.status == 'success' ){
									form.find('input[name], textarea[name], select[name]').not('[name="tour-id"]').val('');
									message_box.removeClass('tourmaster-failed').addClass('tourmaster-success');
								}else{
									message_box.removeClass('tourmaster-success').addClass('tourmaster-failed');
								}

								message_box.html(data.message);
								message_box.slideDown(300);
							}
							
						}
					});
				}

				return false;
			});

			// save wishlist
			$('#tourmaster-save-wish-list').click(function(){
				if( $(this).hasClass('tourmaster-active') ) return;
				$(this).addClass('tourmaster-active');
				
				$.ajax({
					type: 'POST',
					url: $(this).attr('data-ajax-url'),
					data: { action: 'tourmaster_add_wish_list', 'tour-id': $(this).attr('data-tour-id') },
					dataType: 'json'
				});		
			});

			// single review
			$('#tourmaster-single-review').tourmaster_single_review();

			// urgency message
			$('#tourmaster-urgency-message').click(function(){
				var expire_time = $(this).attr('data-expire');
				if( !expire_time ){ expire_time = 3600; }
				tourmaster_set_cookie('tourmaster-urgency-message', '1', expire_time);

				$(this).fadeOut(200, function(){ $(this).remove(); });
			});

			// combobox list
			$('.tourmaster-single-tour-booking-fields').on('click', '.tourmaster-combobox-list-display', function(){
				$(this).siblings('ul').fadeToggle(200);
			});
			$('.tourmaster-single-tour-booking-fields').on('click', '.tourmaster-combobox-list-wrap ul li', function(){
				var value = $(this).attr('data-value');

				$(this).closest('ul').fadeOut(200);
				$(this).closest('ul').siblings('input').val(value).trigger('change');
				$(this).closest('ul').siblings('.tourmaster-combobox-list-display').children('span').html(value);
			});
			$(document).mouseup(function(e){
			    var container = $('.tourmaster-combobox-list-wrap');

			    // if the target of the click isn't the container nor a descendant of the container
			    if( container.length && !container.is(e.target) && container.has(e.target).length === 0 ) {
			        container.find('ul').fadeOut(200);
			    }
			});

			// booking form tab
			$('#tourmaster-booking-tab-title').children().click(function(){
				if( $(this).hasClass('tourmaster-active') ){
					return false;
				}else{
					$(this).addClass('tourmaster-active').siblings().removeClass('tourmaster-active');
				}

				var selected_tab = $(this).attr('data-tourmaster-tab');
				$(this).parent().siblings('.tourmaster-booking-tab-content').each(function(){
					if( $(this).is('[data-tourmaster-tab="' + selected_tab + '"]') ){
						$(this).fadeIn(200, function(){ $(this).addClass('tourmaster-active'); });
					}else{
						$(this).removeClass('tourmaster-active').hide();
					}
				});
			});

		// on payment template
		}else if( body.hasClass('tourmaster-template-payment') ){

			new tourmaster_payment_template();

		}

    });

    $(window).on('load', function(){

        var body = $('body');

        // content navigation
		var content_nav = $('#tourmaster-content-navigation-item-outer');

		if( !body.is('.wp-admin') && content_nav.length ){
            
			window.traveltour_anchor_offset	= content_nav.height();

			var content_nav_container = content_nav.parent();
			var offset = parseInt($('html').css('margin-top'));

			// slidebar
			var slidebar = content_nav.find('.tourmaster-content-navigation-slider');
			content_nav.find('.tourmaster-active').each(function(){
				slidebar.css({width: $(this).outerWidth(), left: $(this).position().left});
			});
			content_nav.on('tourmaster-change', function(){
				var active_slidebar = $(this).find('.tourmaster-active');
				if( !active_slidebar.hasClass('tourmaster-slidebar-active') ){
					active_slidebar.addClass('tourmaster-slidebar-active');
					slidebar.animate({width: active_slidebar.outerWidth(), left: active_slidebar.position().left}, { queue: false, duration: 200 });
				}
			});
			$(window).resize(function(){ content_nav.trigger('tourmaster-change'); });
			content_nav.each(function(){
				$(this).find('.tourmaster-content-navigation-tab').hover(function(){
					slidebar.animate({ width: $(this).outerWidth(), left: $(this).position().left }, { queue: false, duration: 150 });
				}, function(){
					var active_slidebar = $(this).parent().children('.tourmaster-slidebar-active');
					if( active_slidebar.length ){
						slidebar.animate({ width: active_slidebar.outerWidth(), left: active_slidebar.position().left }, { queue: false, duration: 150 });
					}
				});
			});

			// sticky scroll
			$(window).scroll(function(){
				if( tourmaster_display == 'mobile-landscape' || tourmaster_display == 'mobile-portrait' || tourmaster_display == 'tablet' ) return;

				if( $(this).scrollTop() + offset > content_nav_container.offset().top ){
					if( !content_nav.hasClass('tourmaster-fixed') ){
						content_nav.parent().css('height', content_nav.parent().height());
						content_nav.addClass('tourmaster-fixed');

						window.traveltour_anchor_offset	= content_nav.height();
					}
				}else{
					if( content_nav.hasClass('tourmaster-fixed') ){
						content_nav.parent().css('height', 'auto');
						content_nav.removeClass('tourmaster-fixed');
					}

				}
			});
		}
        
    });

})(jQuery);

// https://github.com/jaz303/tipsy
!function(a){function b(a,b){return"function"==typeof a?a.call(b):a}function c(a){for(;a=a.parentNode;)if(a==document)return!0;return!1}function d(b,c){this.$element=a(b),this.options=c,this.enabled=!0,this.fixTitle()}d.prototype={show:function(){var c=this.getTitle();if(c&&this.enabled){var d=this.tip();d.find(".tipsy-inner")[this.options.html?"html":"text"](c),d[0].className="tipsy",d.remove().css({top:0,left:0,visibility:"hidden",display:"block"}).prependTo(document.body);var i,e=a.extend({},this.$element.offset(),{width:this.$element[0].offsetWidth,height:this.$element[0].offsetHeight}),f=d[0].offsetWidth,g=d[0].offsetHeight,h=b(this.options.gravity,this.$element[0]);switch(h.charAt(0)){case"n":i={top:e.top+e.height+this.options.offset,left:e.left+e.width/2-f/2};break;case"s":i={top:e.top-g-this.options.offset,left:e.left+e.width/2-f/2};break;case"e":i={top:e.top+e.height/2-g/2,left:e.left-f-this.options.offset};break;case"w":i={top:e.top+e.height/2-g/2,left:e.left+e.width+this.options.offset}}2==h.length&&("w"==h.charAt(1)?i.left=e.left+e.width/2-15:i.left=e.left+e.width/2-f+15),d.css(i).addClass("tipsy-"+h),d.find(".tipsy-arrow")[0].className="tipsy-arrow tipsy-arrow-"+h.charAt(0),this.options.className&&d.addClass(b(this.options.className,this.$element[0])),this.options.fade?d.stop().css({opacity:0,display:"block",visibility:"visible"}).animate({opacity:this.options.opacity}):d.css({visibility:"visible",opacity:this.options.opacity})}},hide:function(){this.options.fade?this.tip().stop().fadeOut(function(){a(this).remove()}):this.tip().remove()},fixTitle:function(){var a=this.$element;(a.attr("title")||"string"!=typeof a.attr("original-title"))&&a.attr("original-title",a.attr("title")||"").removeAttr("title")},getTitle:function(){var a,b=this.$element,c=this.options;this.fixTitle();var a,c=this.options;return"string"==typeof c.title?a=b.attr("title"==c.title?"original-title":c.title):"function"==typeof c.title&&(a=c.title.call(b[0])),a=(""+a).replace(/(^\s*|\s*$)/,""),a||c.fallback},tip:function(){return this.$tip||(this.$tip=a('<div class="tipsy"></div>').html('<div class="tipsy-arrow"></div><div class="tipsy-inner"></div>'),this.$tip.data("tipsy-pointee",this.$element[0])),this.$tip},validate:function(){this.$element[0].parentNode||(this.hide(),this.$element=null,this.options=null)},enable:function(){this.enabled=!0},disable:function(){this.enabled=!1},toggleEnabled:function(){this.enabled=!this.enabled}},a.fn.tipsy=function(b){function e(c){var e=a.data(c,"tipsy");return e||(e=new d(c,a.fn.tipsy.elementOptions(c,b)),a.data(c,"tipsy",e)),e}function f(){var a=e(this);a.hoverState="in",0==b.delayIn?a.show():(a.fixTitle(),setTimeout(function(){"in"==a.hoverState&&a.show()},b.delayIn))}function g(){var a=e(this);a.hoverState="out",0==b.delayOut?a.hide():setTimeout(function(){"out"==a.hoverState&&a.hide()},b.delayOut)}if(b===!0)return this.data("tipsy");if("string"==typeof b){var c=this.data("tipsy");return c&&c[b](),this}if(b=a.extend({},a.fn.tipsy.defaults,b),b.live||this.each(function(){e(this)}),"manual"!=b.trigger){var h=b.live?"live":"bind",i="hover"==b.trigger?"mouseenter":"focus",j="hover"==b.trigger?"mouseleave":"blur";this[h](i,f)[h](j,g)}return this},a.fn.tipsy.defaults={className:null,delayIn:0,delayOut:0,fade:!1,fallback:"",gravity:"n",html:!1,live:!1,offset:0,opacity:.8,title:"title",trigger:"hover"},a.fn.tipsy.revalidate=function(){a(".tipsy").each(function(){var b=a.data(this,"tipsy-pointee");b&&c(b)||a(this).remove()})},a.fn.tipsy.elementOptions=function(b,c){return a.metadata?a.extend({},c,a(b).metadata()):c},a.fn.tipsy.autoNS=function(){return a(this).offset().top>a(document).scrollTop()+a(window).height()/2?"s":"n"},a.fn.tipsy.autoWE=function(){return a(this).offset().left>a(document).scrollLeft()+a(window).width()/2?"e":"w"},a.fn.tipsy.autoBounds=function(b,c){return function(){var d={ns:c[0],ew:c.length>1&&c[1]},e=a(document).scrollTop()+b,f=a(document).scrollLeft()+b,g=a(this);return g.offset().top<e&&(d.ns="n"),g.offset().left<f&&(d.ew="w"),a(window).width()+a(document).scrollLeft()-g.offset().left<b&&(d.ew="e"),a(window).height()+a(document).scrollTop()-g.offset().top<b&&(d.ns="s"),d.ns+(d.ew?d.ew:"")}}}(jQuery);
