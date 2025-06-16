<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	// add custom css for theme option
	add_filter('gdlr_core_theme_option_top_file_write', 'zurf_gdlr_core_theme_option_top_file_write', 10, 2);
	if( !function_exists('zurf_gdlr_core_theme_option_top_file_write') ){
		function zurf_gdlr_core_theme_option_top_file_write( $css, $option_slug ){
			if( $option_slug != 'goodlayers_main_menu' ) return;

			ob_start();
?>
.zurf-body h1, .zurf-body h2, .zurf-body h3, .zurf-body h4, .zurf-body h5, .zurf-body h6{ margin-top: 0px; margin-bottom: 20px; line-height: 1.2; font-weight: 700; }
#poststuff .gdlr-core-page-builder-body h2{ padding: 0px; margin-bottom: 20px; line-height: 1.2; font-weight: 700; }
#poststuff .gdlr-core-page-builder-body h1{ padding: 0px; font-weight: 700; }

.gdlr-core-flexslider.gdlr-core-bullet-style-cylinder .flex-control-nav li a{ width: 27px; height: 7px; }
.gdlr-core-newsletter-item.gdlr-core-style-rectangle .gdlr-core-newsletter-email input[type="email"]{ line-height: 17px; padding: 30px 20px; height: 65px; }
.gdlr-core-newsletter-item.gdlr-core-style-rectangle .gdlr-core-newsletter-submit input[type="submit"]{ height: 65px; font-size: 13px; }

/* custom */
.gdlr-core-blog-grid .gdlr-core-blog-title { font-weight: 600; }
.gdlr-core-testimonial-style-left-2 .gdlr-core-testimonial-author-image { width: 95px; }
.gdlr-core-testimonial-item .gdlr-core-testimonial-frame { padding: 60px 45px 60px; }

.gdlr-core-newsletter-item.gdlr-core-style-curve3 .gdlr-core-newsletter-email input[type="email"] { height: 76px; }
.gdlr-core-newsletter-item.gdlr-core-style-curve3 .gdlr-core-newsletter-email input[type="email"], 
.gdlr-core-newsletter-item.gdlr-core-style-curve3 .gdlr-core-newsletter-submit input[type="submit"] { border-radius: 20px; -moz-border-radius: 20px; -webkit-border-radius: 20px; }
.gdlr-core-newsletter-item.gdlr-core-style-curve3 .gdlr-core-newsletter-submit input[type="submit"] { height: 76px; width: 76px; }
.gdlr-core-newsletter-item.gdlr-core-style-curve3 .gdlr-core-newsletter-email input[type="email"]{ box-shadow: 0 10px 45px rgb(0 0 0 / 10%); -webkit-box-shadow: 0 10px 45px rgba(0, 0, 0, 0.1) -moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); }
.gdlr-core-newsletter-item.gdlr-core-style-curve3 .gdlr-core-newsletter-email input[type="email"] { font-size: 17px; padding: 6px 25px; }
.gdlr-core-newsletter-item.gdlr-core-style-curve3 .gdlr-core-newsletter-form { max-width: 480px; }
.gdlr-core-newsletter-item.gdlr-core-style-curve3 .gdlr-core-newsletter-email { padding-right: 87px;}
.gdlr-core-testimonial-style-center-4.gdlr-core-testimonial-item .gdlr-core-testimonial-author-image { width: 80px; }
.gdlr-core-testimonial-style-center-4 .gdlr-core-testimonial-quote { font-size: 240px; }
.gdlr-core-newsletter-item.gdlr-core-style-curve .gdlr-core-newsletter-submit input[type="submit"]{ font-weight: 500; }
.gdlr-core-image-overlay.gdlr-core-gallery-image-overlay .gdlr-core-image-overlay-title { font-size: 18px; display: block; letter-spacing: 0px; text-transform: none; font-weight: 500; }
.gdlr-core-image-overlay.gdlr-core-gallery-image-overlay .gdlr-core-image-overlay-content { bottom: 35px; }
.gdlr-core-blog-aside-format.gdlr-core-small .gdlr-core-blog-content { padding: 40px 45px; }

.tourmaster-form-field input[type="text"], 
.tourmaster-form-field input[type="email"], 
.tourmaster-form-field input[type="password"], 
.tourmaster-form-field textarea, 
.tourmaster-form-field select{ border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; font-size: 16px; }
.tourmaster-register-form .tourmaster-register-message { font-size: 16px; }
.tourmaster-register-form .tourmaster-register-term{ font-size: 15px; }

.gdlr-core-blog-grid .gdlr-core-blog-grid-date .gdlr-core-blog-info-date{ text-transform: none; font-size: 13px; letter-spacing: 0; }
.gdlr-core-testimonial-item .gdlr-core-testimonial-position .gdlr-core-rating{ margin-right: 0px; display: block; }
.tourmaster-tour-grid-style-3.tourmaster-price-right-title.tourmaster-tour-frame .tourmaster-tour-price-wrap{ bottom: 44px; }
.tourmaster-tour-grid-style-3.tourmaster-tour-frame .tourmaster-tour-rating{ margin-bottom: 20px; }

.gdlr-core-toggle-box-style-box-background .gdlr-core-toggle-box-item-title{ padding: 28px 25px 28px; }
.gdlr-core-toggle-box-style-box-background .gdlr-core-toggle-box-item-title:before{ font-size: 23px; }
.tourmaster-tour-rating i{ margin-left: 6px; }
.tourmaster-tour-search-item.tourmaster-style-column.tourmaster-column-count-4 .tourmaster-tour-search-submit{ border-radius: 5px; }
.gdlr-core-blog-grid .gdlr-core-blog-grid-date .gdlr-core-blog-info-date{ font-size: 15px; font-weight: 500; }
.gdlr-core-blog-grid.gdlr-core-style-2 .gdlr-core-blog-info-wrapper .gdlr-core-blog-info{ font-size: 15px; font-weight: 500; }
.tourmaster-form-field.tourmaster-with-border input[type="text"], 
.tourmaster-form-field.tourmaster-with-border input[type="email"], 
.tourmaster-form-field.tourmaster-with-border input[type="password"], 
.tourmaster-form-field.tourmaster-with-border textarea, 
.tourmaster-form-field.tourmaster-with-border select{ border-width: 1px; }
.tourmaster-tour-grid-style-5 .tourmaster-tour-read-more-wrap{ font-weight: 500; }
.gdlr-core-blog-full .gdlr-core-blog-thumbnail{ margin-bottom: 35px; }
.gdlr-core-style-4 .gdlr-core-recent-post-widget-info{ margin-top: -7px; }
.gdlr-core-input-wrap input, .gdlr-core-input-wrap textarea, .gdlr-core-input-wrap select{ border-width: 1px 1px 1px 1px; }
.gdlr-core-input-wrap input[type="button"], 
.gdlr-core-input-wrap input[type="submit"], 
.gdlr-core-input-wrap input[type="reset"]{ font-size: 15px; text-transform: none; letter-spacing: 0; padding: 19px 33px; border-radius: 7px; }
.gdlr-core-input-wrap.gdlr-core-full-width input:not([type="button"]):not([type="reset"]):not([type="submit"]):not([type="file"]):not([type="checkbox"]):not([type="radio"]), 
.gdlr-core-input-wrap.gdlr-core-full-width textarea, 
.gdlr-core-input-wrap.gdlr-core-full-width select{ border-radius: 7px; -webkit-border-radius: 7px; -moz-border-radius: 7px; }
.gdlr-core-blog-full .gdlr-core-excerpt-read-more.gdlr-core-plain-text{ font-size: 16px; font-weight: 500; }
.gdlr-core-blog-full{ margin-bottom: 50px; }
.gdlr-core-blog-info-wrapper .gdlr-core-blog-info{ font-size: 14px; font-weight: 500; letter-spacing: 0px; text-transform: none; }
.gdlr-core-blog-grid.gdlr-core-style-3 .gdlr-core-blog-info-wrapper .gdlr-core-blog-info{ font-weight: 500; font-size: 14px; }

.gdlr-core-personnel-style-grid .gdlr-core-personnel-list-content-wrap { padding-top: 30px; }
.tourmaster-tour-search-item.tourmaster-style-column.tourmaster-column-count-4 .tourmaster-tour-search-submit { letter-spacing: 0; font-weight: 500; }
.gdlr-core-blog-info-wrapper .gdlr-core-head i { font-size: 16px; padding-left: 1px; }
.tourmaster-tour-info-wrap .tourmaster-tour-info { font-size: 16px; }
.tourmaster-tour-info-wrap .tourmaster-tour-info i { margin-right: 9px; }
.tourmaster-tour-full .tourmaster-content-right { border-left-width: 1px; }
.tourmaster-tour-full .tourmaster-tour-view-more { font-size: 13px; padding: 13px 22px; font-weight: 500; text-transform: none; border-radius: 7px; }
.tourmaster-tour-full.tourmaster-tour-frame { margin-bottom: 50px; }
.tourmaster-tour-widget .tourmaster-tour-title { font-size: 17px; margin-bottom: 5px; font-weight: 600; }
.tourmaster-tour-widget .tourmaster-tour-thumbnail { max-width: 60px; border-radius: 30px; }
.tourmaster-tour-widget .tourmaster-tour-widget-inner { padding-top: 17px; border-top-width: 0px; }
.tourmaster-tour-grid-style-3 .tourmaster-tour-info-wrap { margin-bottom: 20px; margin-top: 14px; }
.tourmaster-tour-medium .tourmaster-content-right { border-left-width: 1px; }
.tourmaster-tour-medium .tourmaster-tour-view-more { font-size: 13px; padding: 12px 15px; font-weight: 600; text-transform: none; border-radius: 7px; }
.tourmaster-tour-grid .tourmaster-tour-info-wrap { margin-bottom: 15px; }
.tourmaster-tour-search-wrap .tourmaster-tour-search-submit { font-size: 15px; font-weight: 600; text-transform: none; letter-spacing: 0; border-radius: 7px; }
.tourmaster-user-template-style-2 .tourmaster-user-navigation .tourmaster-user-navigation-item a { border-radius: 7px; }
.tourmaster-user-template-style-2 .tourmaster-dashboard-profile-wrapper { border-radius: 10px; }
.tourmaster-user-template-style-2 .tourmaster-user-navigation .tourmaster-user-navigation-head { font-size: 20px; }
.tourmaster-wish-list-item .tourmaster-wish-list-item-title { font-size: 17px; font-weight: 700; }
.tourmaster-user-template-style-2 .tourmaster-user-navigation .tourmaster-user-navigation-item { font-size: 16px; }
.tourmaster-login-form2 .tourmaster-login-title { font-size: 17px; text-transform: none; font-weight: 700; }
.tourmaster-login2-right .tourmaster-login2-right-title { font-size: 17px; text-transform: none; font-weight: 700; }
p.tourmaster-login-lost-password { font-size: 15px; }
.tourmaster-login2-right .tourmaster-login2-right-description { font-size: 14px; }
input.tourmaster-register-submit.tourmaster-button { font-size: 16px; letter-spacing: 0; text-transform: none; }
.tourmaster-tour-booking-bar-deposit-option label { cursor: pointer; margin-right: 20px; }
.tourmaster-page-wrapper.tourmaster-payment-style-2 .tourmaster-tour-booking-bar-deposit-option { font-weight: 600; }
.tourmaster-tour-booking-side-payment-wrap .tourmaster-button { border-radius: 7px; }
.tourmaster-user-template-style-2 .tourmaster-my-profile-info { font-size: 16px; }
.tourmaster-user-template-style-2 .tourmaster-user-content-block .tourmaster-user-content-title { font-size: 20px; font-weight: 600; }
.tourmaster-user-template-style-2 .tourmaster-user-content-block .tourmaster-user-content-title-link { font-size: 16px; }
.tourmaster-my-booking-single-sidebar .tourmaster-button { border-radius: 7px; }
.tourmaster-payment-billing-copy-text{ font-size: 15px; }
.goodlayers-payment-form form button#card-button{ border: 0; font-size: 15px; letter-spacing: 0; font-weight: 600; text-transform: none; }
.tourmaster-page-wrapper.tourmaster-payment-style-2 .tourmaster-tour-booking-bar-total-price-wrap{ margin-bottom: 28px; }
<?php
			$css .= ob_get_contents();
			ob_end_clean(); 

			return $css;
		}
	}
	add_filter('gdlr_core_theme_option_bottom_file_write', 'zurf_gdlr_core_theme_option_bottom_file_write', 10, 2);
	if( !function_exists('zurf_gdlr_core_theme_option_bottom_file_write') ){
		function zurf_gdlr_core_theme_option_bottom_file_write( $css, $option_slug ){
			if( $option_slug != 'goodlayers_main_menu' ) return;

			$general = get_option('zurf_general');

			if( !empty($general['enable-fixed-navigation-slide-bar']) && $general['enable-fixed-navigation-slide-bar'] == 'disable' ){
				$css .= '.zurf-fixed-navigation .zurf-navigation .zurf-navigation-slide-bar{ display: none !important; }';
			}

			if( !empty($general['item-padding']) ){
				$margin = 2 * intval(str_replace('px', '', $general['item-padding']));
				if( !empty($margin) && is_numeric($margin) ){
					$css .= '.zurf-item-mgb, .gdlr-core-item-mgb{ margin-bottom: ' . $margin . 'px; }';

					$margin -= 1;
					$css .= '.zurf-body .gdlr-core-testimonial-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .gdlr-core-feature-content-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .gdlr-core-personnel-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .gdlr-core-hover-box-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport,'; 
					$css .= '.zurf-body .gdlr-core-portfolio-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .gdlr-core-product-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .gdlr-core-product-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .gdlr-core-blog-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .tourmaster-tour-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .tourmaster-room-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .gdlr-core-page-list-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.zurf-body .zurf-lp-course-list-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport{ '; 
					$css .= 'padding-top: ' . $margin . 'px; margin-top: -' . $margin . 'px; padding-right: ' . $margin . 'px; margin-right: -' . $margin . 'px; ';
					$css .= 'padding-left: ' . $margin . 'px; margin-left: -' . $margin . 'px; padding-bottom: ' . $margin . 'px; margin-bottom: -' . $margin . 'px; ';
					$css .= '}';
				}
			}

			if( !empty($general['mobile-logo-position']) && $general['mobile-logo-position'] == 'logo-right' ){
				$css .= '.zurf-mobile-header .zurf-logo-inner{ margin-right: 0px; margin-left: 80px; float: right; }';	
				$css .= '.zurf-mobile-header .zurf-mobile-menu-right{ left: 30px; right: auto; }';	
				$css .= '.zurf-mobile-header .zurf-main-menu-search{ float: right; margin-left: 0px; margin-right: 25px; }';	
				$css .= '.zurf-mobile-header .zurf-mobile-menu{ float: right; margin-left: 0px; margin-right: 30px; }';	
				$css .= '.zurf-mobile-header .zurf-main-menu-cart{ float: right; margin-left: 0px; margin-right: 20px; padding-left: 0px; padding-right: 5px; }';	
				$css .= '.zurf-mobile-header .zurf-top-cart-content-wrap{ left: 0px; }';
			}

			return $css;
		}
	}

	$zurf_admin_option->add_element(array(
	
		// general head section
		'title' => esc_html__('General', 'zurf'),
		'slug' => 'zurf_general',
		'icon' => get_template_directory_uri() . '/include/options/images/general.png',
		'options' => array(
		
			'layout' => array(
				'title' => esc_html__('Layout', 'zurf'),
				'options' => array(
					'custom-header' => array(
						'title' => esc_html__('Select Custom Header As Default Header', 'zurf'),
						'type' => 'combobox',
						'single' => 'gdlr_core_custom_header_id',
						'options' => array('' => esc_html__('None', 'zurf')) + gdlr_core_get_post_list('gdlr_core_header'),
						'description' => esc_html__('Any settings you set at the theme option will be ignored', 'zurf')
					),
					'layout' => array(
						'title' => esc_html__('Layout', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'full' => esc_html__('Full', 'zurf'),
							'boxed' => esc_html__('Boxed', 'zurf'),
						)
					),
					'boxed-layout-top-margin' => array(
						'title' => esc_html__('Box Layout Top/Bottom Margin', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '150',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => 'body.zurf-boxed .zurf-body-wrapper{ margin-top: #gdlr#; margin-bottom: #gdlr#; }',
						'condition' => array( 'layout' => 'boxed' ) 
					),
					'body-margin' => array(
						'title' => esc_html__('Body Margin ( Frame Spaces )', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => '.zurf-body-wrapper.zurf-with-frame, body.zurf-full .zurf-fixed-footer{ margin: #gdlr#; }',
						'condition' => array( 'layout' => 'full' ),
						'description' => esc_html__('This value will be automatically omitted for side header style.', 'zurf'),
					),
					'background-type' => array(
						'title' => esc_html__('Background Type', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'color' => esc_html__('Color', 'zurf'),
							'image' => esc_html__('Image', 'zurf'),
							'pattern' => esc_html__('Pattern', 'zurf'),
						),
						'condition' => array( 'layout' => 'boxed' )
					),
					'background-image' => array(
						'title' => esc_html__('Background Image', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file', 
						'selector' => '.zurf-body-background{ background-image: url(#gdlr#); }',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'image' )
					),
					'background-image-opacity' => array(
						'title' => esc_html__('Background Image Opacity', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '100',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'image' ),
						'selector' => '.zurf-body-background{ opacity: #gdlr#; }'
					),
					'background-pattern' => array(
						'title' => esc_html__('Background Type', 'zurf'),
						'type' => 'radioimage',
						'data-type' => 'text',
						'options' => 'pattern', 
						'selector' => '.zurf-background-pattern .zurf-body-outer-wrapper{ background-image: url(' . GDLR_CORE_URL . '/include/images/pattern/#gdlr#.png); }',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'pattern' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'enable-boxed-border' => array(
						'title' => esc_html__('Enable Boxed Border', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'pattern' ),
					),
					'item-padding' => array(
						'title' => esc_html__('Item Left/Right Spaces', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '40',
						'data-type' => 'pixel',
						'default' => '15px',
						'description' => 'Space between each page items',
						'selector' => '.zurf-item-pdlr, .gdlr-core-item-pdlr{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.zurf-mobile-header .zurf-logo.zurf-item-pdlr{ padding-left: #gdlr#; }' .
							'.zurf-item-rvpdlr, .gdlr-core-item-rvpdlr{ margin-left: -#gdlr#; margin-right: -#gdlr#; }' .
							'.gdlr-core-metro-rvpdlr{ margin-top: -#gdlr#; margin-right: -#gdlr#; margin-bottom: -#gdlr#; margin-left: -#gdlr#; }' .
							'.zurf-item-mglr, .gdlr-core-item-mglr, .zurf-navigation .sf-menu > .zurf-mega-menu .sf-mega,' . 
							'.sf-menu.zurf-top-bar-menu > .zurf-mega-menu .sf-mega{ margin-left: #gdlr#; margin-right: #gdlr#; }' .
							'.gdlr-core-pbf-wrapper-container-inner{ width: calc(100% - #gdlr# - #gdlr#); }'
					
					),
					'container-width' => array(
						'title' => esc_html__('Container Width', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '1180px',
						'selector' => '.zurf-container, .gdlr-core-container, body.zurf-boxed .zurf-body-wrapper, ' . 
							'body.zurf-boxed .zurf-fixed-footer .zurf-footer-wrapper, body.zurf-boxed .zurf-fixed-footer .zurf-copyright-wrapper{ max-width: #gdlr#; }' 
					),
					'container-padding' => array(
						'title' => esc_html__('Container Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.zurf-body-front .gdlr-core-container, .zurf-body-front .zurf-container{ padding-left: #gdlr#; padding-right: #gdlr#; }'  . 
							'.zurf-body-front .zurf-container .zurf-container, .zurf-body-front .zurf-container .gdlr-core-container, '.
							'.zurf-body-front .gdlr-core-container .gdlr-core-container{ padding-left: 0px; padding-right: 0px; }' .
							'.zurf-navigation-header-style-bar.zurf-style-2 .zurf-navigation-background{ left: #gdlr#; right: #gdlr#; }'
					),
					'sidebar-title-divider' => array(
						'title' => esc_html__('Sidebar Title Divider', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'sidebar-heading-tag' => array(
						'title' => esc_html__('Sidebar Heading Tag', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'h1' => esc_html__('H1', 'zurf'),
							'h2' => esc_html__('H2', 'zurf'),
							'h3' => esc_html__('H3', 'zurf'),
							'h4' => esc_html__('H4', 'zurf'),
							'h5' => esc_html__('H5', 'zurf'),
							'h6' => esc_html__('H6', 'zurf'),
						),
						'default' => 'h3'
					),
					'sidebar-width' => array(
						'title' => esc_html__('Sidebar Width', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'30' => '50%', '20' => '33.33%', '15' => '25%', '12' => '20%', '10' => '16.67%'
						),
						'default' => 20,
					),
					'both-sidebar-width' => array(
						'title' => esc_html__('Both Sidebar Width', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'30' => '50%', '20' => '33.33%', '15' => '25%', '12' => '20%', '10' => '16.67%'
						),
						'default' => 15,
					),
					
				) // header-options
			), // header-nav	
			
			'top-bar' => zurf_top_bar_options(),

			'top-bar-social' => zurf_top_bar_social_options(),			

			'header' => zurf_header_options(),
			
			'logo' => zurf_logo_options(),

			'navigation' => zurf_navigation_options(), 
			
			'fixed-navigation' => zurf_fixed_navigation_options(),

			'float-social' => array(
				'title' => esc_html__('Float Social', 'zurf'),
				'options' => array(
					'enable-float-social' => array(
						'title' => esc_html__('Enable Float Social', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'display-float-social-after-page-title' => array(
						'title' => esc_html__('Display Float Social After Page Title', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'float-social-delicious' => array(
						'title' => esc_html__('Float Social Delicious Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-email' => array(
						'title' => esc_html__('Float Social Email Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-deviantart' => array(
						'title' => esc_html__('Float Social Deviantart Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-digg' => array(
						'title' => esc_html__('Float Social Digg Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-facebook' => array(
						'title' => esc_html__('Float Social Facebook Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-flickr' => array(
						'title' => esc_html__('Float Social Flickr Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-lastfm' => array(
						'title' => esc_html__('Float Social Lastfm Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-linkedin' => array(
						'title' => esc_html__('Float Social Linkedin Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-pinterest' => array(
						'title' => esc_html__('Float Social Pinterest Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-rss' => array(
						'title' => esc_html__('Float Social RSS Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-skype' => array(
						'title' => esc_html__('Float Social Skype Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-stumbleupon' => array(
						'title' => esc_html__('Float Social Stumbleupon Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-tumblr' => array(
						'title' => esc_html__('Float Social Tumblr Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-twitter' => array(
						'title' => esc_html__('Float Social Twitter Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-vimeo' => array(
						'title' => esc_html__('Float Social Vimeo Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-youtube' => array(
						'title' => esc_html__('Float Social Youtube Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-instagram' => array(
						'title' => esc_html__('Float Social Instagram Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-snapchat' => array(
						'title' => esc_html__('Float Social Snapchat Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
				)
			),

			'title-style' => array(
				'title' => esc_html__('Page Title Style', 'zurf'),
				'options' => array(

					'default-title-style' => array(
						'title' => esc_html__('Default Page Title Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'zurf'),
							'medium' => esc_html__('Medium', 'zurf'),
							'large' => esc_html__('Large', 'zurf'),
							'custom' => esc_html__('Custom', 'zurf'),
						),
						'default' => 'small'
					),
					'default-title-align' => array(
						'title' => esc_html__('Default Page Title Alignment', 'zurf'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left'
					),
					'default-title-top-padding' => array(
						'title' => esc_html__('Default Page Title Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '350',
						'default' => '93px',
						'selector' => '.zurf-page-title-wrap.zurf-style-custom .zurf-page-title-content{ padding-top: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-bottom-padding' => array(
						'title' => esc_html__('Default Page Title Bottom Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '350',
						'default' => '87px',
						'selector' => '.zurf-page-title-wrap.zurf-style-custom .zurf-page-title-content{ padding-bottom: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-page-caption-top-margin' => array(
						'title' => esc_html__('Default Page Caption Top Margin', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '13px',						
						'selector' => '.zurf-page-title-wrap.zurf-style-custom .zurf-page-caption{ margin-top: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-font-transform' => array(
						'title' => esc_html__('Default Page Title Font Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'' => esc_html__('Default', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
						),
						'default' => 'default',
						'selector' => '.zurf-page-title-wrap .zurf-page-title{ text-transform: #gdlr#; }'
					),
					'default-title-font-size' => array(
						'title' => esc_html__('Default Page Title Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '37px',
						'selector' => '.zurf-page-title-wrap.zurf-style-custom .zurf-page-title{ font-size: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-font-weight' => array(
						'title' => esc_html__('Default Page Title Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-page-title-wrap .zurf-page-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (700).', 'zurf')					
					),
					'default-title-letter-spacing' => array(
						'title' => esc_html__('Default Page Title Letter Spacing', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '20',
						'default' => '0px',
						'selector' => '.zurf-page-title-wrap.zurf-style-custom .zurf-page-title{ letter-spacing: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-caption-font-transform' => array(
						'title' => esc_html__('Default Page Caption Font Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'' => esc_html__('Default', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
						),
						'default' => 'default',
						'selector' => '.zurf-page-title-wrap .zurf-page-caption{ text-transform: #gdlr#; }'
					),
					'default-caption-font-size' => array(
						'title' => esc_html__('Default Page Caption Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '16px',
						'selector' => '.zurf-page-title-wrap.zurf-style-custom .zurf-page-caption{ font-size: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-caption-font-weight' => array(
						'title' => esc_html__('Default Page Caption Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-page-title-wrap .zurf-page-caption{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (400).', 'zurf')					
					),
					'default-caption-letter-spacing' => array(
						'title' => esc_html__('Default Page Caption Letter Spacing', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '20',
						'default' => '0px',
						'selector' => '.zurf-page-title-wrap.zurf-style-custom .zurf-page-caption{ letter-spacing: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'page-title-top-bottom-gradient' => array(
						'title' => esc_html__('Default Page Title Top/Bottom Gradient', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'both' => esc_html__('Both', 'zurf'),
							'top' => esc_html__('Top', 'zurf'),
							'bottom' => esc_html__('Bottom', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'none',
					),
					'page-title-top-gradient-size' => array(
						'title' => esc_html__('Default Page Title Top Gradient Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '1000',
 						'default' => '413px',
						'selector' => '.zurf-page-title-wrap .zurf-page-title-top-gradient{ height: #gdlr#; }',
					),
					'page-title-bottom-gradient-size' => array(
						'title' => esc_html__('Default Page Title Bottom Gradient Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '1000',
 						'default' => '413px',
						'selector' => '.zurf-page-title-wrap .zurf-page-title-bottom-gradient{ height: #gdlr#; }',
					),
					'default-title-background-overlay-opacity' => array(
						'title' => esc_html__('Default Page Title Background Overlay Opacity', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '80',
						'selector' => '.zurf-page-title-wrap .zurf-page-title-overlay{ opacity: #gdlr#; }'
					),
				) 
			), // title style

			'title-background' => array(
				'title' => esc_html__('Page Title Background', 'zurf'),
				'options' => array(

					'default-title-background' => array(
						'title' => esc_html__('Default Page Title Background', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.zurf-page-title-wrap{ background-image: url(#gdlr#); }' . 
							'body.single-product .zurf-header-background-transparent{ background-image: url(#gdlr#); background-position: center; background-size: cover; }'
					),
					'page-title-background-radius' => array(
						'title' => esc_html__('Default Page Title Background Radius', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-page-title-wrap, body.single-product .zurf-header-background-transparent{ border-radius: #gdlr#; -moz-border-radius: #gdlr#; -webkit-border-radius: #gdlr#; }'
					),
					'default-portfolio-title-background' => array(
						'title' => esc_html__('Default Portfolio Title Background', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.single-portfolio .zurf-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-personnel-title-background' => array(
						'title' => esc_html__('Default Personnel Title Background', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.single-personnel .zurf-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-search-title-background' => array(
						'title' => esc_html__('Default Search Title Background', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.search .zurf-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-archive-title-background' => array(
						'title' => esc_html__('Default Archive Title Background', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.archive .zurf-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-404-background' => array(
						'title' => esc_html__('Default 404 Background', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.zurf-not-found-wrap .zurf-not-found-background{ background-image: url(#gdlr#); }'
					),
					'default-404-background-opacity' => array(
						'title' => esc_html__('Default 404 Background Opacity', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '27',
						'selector' => '.zurf-not-found-wrap .zurf-not-found-background{ opacity: #gdlr#; }'
					),

				) 
			), // title background

			'blog-title-style' => array(
				'title' => esc_html__('Blog Title Style', 'zurf'),
				'options' => array(

					'default-blog-title-style' => array(
						'title' => esc_html__('Default Blog Title Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'zurf'),
							'large' => esc_html__('Large', 'zurf'),
							'custom' => esc_html__('Custom', 'zurf'),
							'inside-content' => esc_html__('Inside Content', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'small'
					),
					'default-blog-title-top-padding' => array(
						'title' => esc_html__('Default Blog Title Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '400',
						'default' => '93px',
						'selector' => '.zurf-blog-title-wrap.zurf-style-custom .zurf-blog-title-content{ padding-top: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => 'custom' )
					),
					'default-blog-title-bottom-padding' => array(
						'title' => esc_html__('Default Blog Title Bottom Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '400',
						'default' => '87px',
						'selector' => '.zurf-blog-title-wrap.zurf-style-custom .zurf-blog-title-content{ padding-bottom: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => 'custom' )
					),
					'default-blog-feature-image' => array(
						'title' => esc_html__('Default Blog Feature Image Location', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'content' => esc_html__('Inside Content', 'zurf'),
							'title-background' => esc_html__('Title Background', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'content',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),
					'default-blog-title-background-image' => array(
						'title' => esc_html__('Default Blog Title Background Image', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.zurf-blog-title-wrap{ background-image: url(#gdlr#); }',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),
					'blog-title-background-radius' => array(
						'title' => esc_html__('Default Blog Title Background Radius', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-blog-title-wrap{ border-radius: #gdlr#; -webkit-border-radius: #gdlr#; -moz-border-radius: #gdlr#; }'
					),
					'default-blog-title-font-size' => array(
						'title' => esc_html__('Default Blog Title Font Size', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.zurf-blog-title-wrap .zurf-single-article-title, .zurf-single-article .zurf-single-article-title{ font-size: #gdlr#; }'
					),
					'default-blog-title-font-weight' => array(
						'title' => esc_html__('Default Blog Title Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-blog-title-wrap .zurf-single-article-title, .zurf-single-article .zurf-single-article-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (700).', 'zurf')					
					),
					'default-blog-title-letter-spacing' => array(
						'title' => esc_html__('Default Blog Title Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.zurf-blog-title-wrap .zurf-single-article-title, .zurf-single-article .zurf-single-article-title{ letter-spacing: #gdlr#; }',
					),
					'default-blog-title-text-transform' => array(
						'title' => esc_html__('Default Blog Title Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'' => esc_html__('Default', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
						),
						'selector' => '.zurf-blog-title-wrap .zurf-single-article-title, .zurf-single-article .zurf-single-article-title{ text-transform: #gdlr#; }'
					),
					'default-blog-caption-font-size' => array(
						'title' => esc_html__('Default Blog Caption Font Size', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.zurf-blog-title-wrap .zurf-blog-info-wrapper .zurf-blog-info, .zurf-single-article .zurf-blog-info-wrapper .zurf-blog-info{ font-size: #gdlr#; }'
					),
					'default-blog-caption-font-weight' => array(
						'title' => esc_html__('Default Blog Caption Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-blog-title-wrap .zurf-blog-info-wrapper .zurf-blog-info, .zurf-single-article .zurf-blog-info-wrapper .zurf-blog-info{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (700).', 'zurf')					
					),
					'default-blog-caption-letter-spacing' => array(
						'title' => esc_html__('Default Blog Caption Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.zurf-blog-title-wrap .zurf-blog-info-wrapper .zurf-blog-info, .zurf-single-article .zurf-blog-info-wrapper .zurf-blog-info{ letter-spacing: #gdlr#; }',
					),
					'default-blog-caption-text-transform' => array(
						'title' => esc_html__('Default Blog Caption Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'' => esc_html__('Default', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
						),
						'selector' => '.zurf-blog-title-wrap .zurf-blog-info-wrapper .zurf-blog-info, .zurf-single-article .zurf-blog-info-wrapper .zurf-blog-info{ text-transform: #gdlr#; }'
					),
					'default-blog-top-bottom-gradient' => array(
						'title' => esc_html__('Default Blog ( Feature Image ) Title Top/Bottom Gradient', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'enable' => esc_html__('Both', 'zurf'),
							'top' => esc_html__('Top', 'zurf'),
							'bottom' => esc_html__('Bottom', 'zurf'),
							'disable' => esc_html__('None', 'zurf'),
						),
						'default' => 'enable',
					),
					'single-blog-title-top-gradient-size' => array(
						'title' => esc_html__('Single Blog Title Top Gradient Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '1000',
 						'default' => '413px',
						'selector' => '.zurf-blog-title-wrap.zurf-feature-image .zurf-blog-title-top-overlay{ height: #gdlr#; }',
					),
					'single-blog-title-bottom-gradient-size' => array(
						'title' => esc_html__('Single Blog Title Bottom Gradient Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '1000',
 						'default' => '413px',
						'selector' => '.zurf-blog-title-wrap.zurf-feature-image .zurf-blog-title-bottom-overlay{ height: #gdlr#; }',
					),
					'default-blog-title-background-overlay-opacity' => array(
						'title' => esc_html__('Default Blog Title Background Overlay Opacity', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '80',
						'selector' => '.zurf-blog-title-wrap .zurf-blog-title-overlay{ opacity: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),

				) 
			), // post title style			

			'blog-style' => array(
				'title' => esc_html__('Blog Style', 'zurf'),
				'options' => array(
					'blog-style' => array(
						'title' => esc_html__('Single Blog Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf'),
							'style-3' => esc_html__('Style 3', 'zurf'),
							'style-4' => esc_html__('Style 4', 'zurf'),
							'style-5' => esc_html__('Style 5', 'zurf'),
							'magazine' => esc_html__('Magazine', 'zurf')
						),
						'default' => 'style-1'
					),
					'blog-title-style' => array(
						'title' => esc_html__('Single Blog Title Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'' => esc_html__('Default', 'zurf'),
							'style-1' => esc_html__('Style 1', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf'),
							'style-4' => esc_html__('Style 4', 'zurf')
						)
					),
					'blog-date-feature' => array(
						'title' => esc_html__('Enable Blog Date Feature', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'blog-title-style' => 'style-1' )
					),
					'blog-date-feature-year' => array(
						'title' => esc_html__('Enable Year on Blog Date Feature', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable',
						'condition' => array( 'blog-title-style' => 'style-1', 'blog-date-feature' => 'enable' )
					),
					'blockquote-style' => array(
						'title' => esc_html__('Blockquote Style ( <blockquote> tag )', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf'),
							'style-3' => esc_html__('Style 3', 'zurf')
						),
						'default' => 'style-1'
					),
					'blog-sidebar' => array(
						'title' => esc_html__('Single Blog Sidebar ( Default )', 'zurf'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'none',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'blog-sidebar-left' => array(
						'title' => esc_html__('Single Blog Sidebar Left ( Default )', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'blog-sidebar'=>array('left', 'both') )
					),
					'blog-sidebar-right' => array(
						'title' => esc_html__('Single Blog Sidebar Right ( Default )', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'blog-sidebar'=>array('right', 'both') )
					),
					'blog-max-content-width' => array(
						'title' => esc_html__('Single Blog Max Content Width ( No sidebar layout )', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'data-input-type' => 'pixel',
						'default' => '900px',
						'selector' => 'body.single-post .zurf-sidebar-style-none, body.blog .zurf-sidebar-style-none, ' . 
							'.zurf-blog-style-2 .zurf-comment-content{ max-width: #gdlr#; }'
					),
					'blog-thumbnail-size' => array(
						'title' => esc_html__('Single Blog Thumbnail Size', 'zurf'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
					'meta-option' => array(
						'title' => esc_html__('Meta Option', 'zurf'),
						'type' => 'multi-combobox',
						'options' => array( 
							'date' => esc_html__('Date', 'zurf'),
							'author' => esc_html__('Author', 'zurf'),
							'category' => esc_html__('Category', 'zurf'),
							'tag' => esc_html__('Tag', 'zurf'),
							'comment' => esc_html__('Comment', 'zurf'),
							'comment-number' => esc_html__('Comment Number', 'zurf'),
						),
						'default' => array('author', 'category', 'tag', 'comment-number')
					),
					'blog-author' => array(
						'title' => esc_html__('Enable Single Blog Author', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-navigation' => array(
						'title' => esc_html__('Enable Single Blog Navigation', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'pagination-style' => array(
						'title' => esc_html__('Pagination Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'plain' => esc_html__('Plain', 'zurf'),
							'rectangle' => esc_html__('Rectangle', 'zurf'),
							'rectangle-border' => esc_html__('Rectangle Border', 'zurf'),
							'round' => esc_html__('Round', 'zurf'),
							'round-border' => esc_html__('Round Border', 'zurf'),
							'circle' => esc_html__('Circle', 'zurf'),
							'circle-border' => esc_html__('Circle Border', 'zurf'),
						),
						'default' => 'round'
					),
					'pagination-align' => array(
						'title' => esc_html__('Pagination Alignment', 'zurf'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'right'
					),
					'enable-related-post' => array(
						'title' => esc_html__('Enable Related Post', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'related-post-blog-style' => array(
						'title' => esc_html__('Related Post Blog Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'blog-column' => esc_html__('Blog Column', 'zurf'), 
							'blog-column-with-frame' => esc_html__('Blog Column With Frame', 'zurf'), 
						),
						'default' => 'blog-column-with-frame',
					),
					'related-post-blog-column-style' => array(
						'title' => esc_html__('Related Post Blog Column Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'zurf'), 
							'style-2' => esc_html__('Style 2', 'zurf'), 
							'style-3' => esc_html__('Style 3', 'zurf'), 
						),
						'default' => 'blog-column-with-frame',
					),
					'related-post-column-size' => array(
						'title' => esc_html__('Related Post Column Size', 'zurf'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
						'default' => '20',
					),
					'related-post-meta-option' => array(
						'title' => esc_html__('Related Post Meta Option', 'zurf'),
						'type' => 'multi-combobox',
						'options' => array(
							'date' => esc_html__('Date', 'zurf'),
							'author' => esc_html__('Author', 'zurf'),
							'category' => esc_html__('Category', 'zurf'),
							'tag' => esc_html__('Tag', 'zurf'),
							'comment' => esc_html__('Comment', 'zurf'),
							'comment-number' => esc_html__('Comment Number', 'zurf'),
						),
						'default' => array('date', 'author', 'category', 'comment-number'),
					),
					'related-post-thumbnail-size' => array(
						'title' => esc_html__('Related Post Blog Thumbnail Size', 'zurf'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full',
					),
					'related-post-num-fetch' => array(
						'title' => esc_html__('Related Post Num Fetch', 'zurf'),
						'type' => 'text',
						'default' => '3',
					),
					'related-post-excerpt-number' => array(
						'title' => esc_html__('Related Post Excerpt Number', 'zurf'),
						'type' => 'text',
						'default' => '0',
					),
				) // blog-style-options
			), // blog-style-nav

			'blog-social-share' => array(
				'title' => esc_html__('Blog Social Share', 'zurf'),
				'options' => array(
					'blog-social-share' => array(
						'title' => esc_html__('Enable Single Blog Share', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-social-share-count' => array(
						'title' => esc_html__('Enable Single Blog Share Count', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-social-facebook' => array(
						'title' => esc_html__('Facebook', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-facebook-access-token' => array(
						'title' => esc_html__('Facebook Access Token', 'zurf'),
						'type' => 'text',
					),	
					'blog-social-linkedin' => array(
						'title' => esc_html__('Linkedin', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),			
					'blog-social-pinterest' => array(
						'title' => esc_html__('Pinterest', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),			
					'blog-social-stumbleupon' => array(
						'title' => esc_html__('Stumbleupon', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),			
					'blog-social-twitter' => array(
						'title' => esc_html__('Twitter', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),			
					'blog-social-email' => array(
						'title' => esc_html__('Email', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
				) // blog-style-options
			), // blog-style-nav
			
			'event' => array(
				'title' => esc_html__('Event', 'zurf'),
				'options' => array(
					'default-event-title-background' => array(
						'title' => esc_html__('Default Event Title Background', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.single-event .zurf-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-event-sidebar' => array(
						'title' => esc_html__('Default Event Sidebar', 'zurf'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'none',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'default-event-sidebar-left' => array(
						'title' => esc_html__('Default Event Sidebar Left', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'default-event-sidebar'=>array('left', 'both') )
					),
					'default-event-sidebar-right' => array(
						'title' => esc_html__('Default Event Sidebar Right', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'default-event-sidebar'=>array('right', 'both') )
					),
				)
			),
			
			'search-archive' => array(
				'title' => esc_html__('Search/Archive', 'zurf'),
				'options' => array(
					'archive-blog-sidebar' => array(
						'title' => esc_html__('Archive Blog Sidebar', 'zurf'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'right',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-blog-sidebar-left' => array(
						'title' => esc_html__('Archive Blog Sidebar Left', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-blog-sidebar'=>array('left', 'both') )
					),
					'archive-blog-sidebar-right' => array(
						'title' => esc_html__('Archive Blog Sidebar Right', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-blog-sidebar'=>array('right', 'both') )
					),
					'archive-blog-style' => array(
						'title' => esc_html__('Archive Blog Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'blog-full' => GDLR_CORE_URL . '/include/images/blog-style/blog-full.png',
							'blog-full-with-frame' => GDLR_CORE_URL . '/include/images/blog-style/blog-full-with-frame.png',
							'blog-column' => GDLR_CORE_URL . '/include/images/blog-style/blog-column.png',
							'blog-column-with-frame' => GDLR_CORE_URL . '/include/images/blog-style/blog-column-with-frame.png',
							'blog-column-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-column-no-space.png',
							'blog-image' => GDLR_CORE_URL . '/include/images/blog-style/blog-image.png',
							'blog-image-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-image-no-space.png',
							'blog-left-thumbnail' => GDLR_CORE_URL . '/include/images/blog-style/blog-left-thumbnail.png',
							'blog-right-thumbnail' => GDLR_CORE_URL . '/include/images/blog-style/blog-right-thumbnail.png',
						),
						'default' => 'blog-full',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-blog-full-style' => array(
						'title' => esc_html__('Blog Full Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf'),
						),
						'condition' => array( 'archive-blog-style'=>array('blog-full', 'blog-full-with-frame') )
					),
					'archive-blog-side-thumbnail-style' => array(
						'title' => esc_html__('Blog Side Thumbnail Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'zurf'),
							'style-1-large' => esc_html__('Style 1 Large Thumbnail', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf'),
							'style-2-large' => esc_html__('Style 2 Large Thumbnail', 'zurf'),
						),
						'condition' => array( 'archive-blog-style'=>array('blog-left-thumbnail', 'blog-right-thumbnail') )
					),
					'archive-blog-column-style' => array(
						'title' => esc_html__('Blog Column Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf'),
						),
						'condition' => array( 'archive-blog-style'=>array('blog-column', 'blog-column-with-frame', 'blog-column-no-space') )
					),
					'archive-blog-image-style' => array(
						'title' => esc_html__('Blog Image Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf'),
						),
						'condition' => array( 'archive-blog-style'=>array('blog-image', 'blog-image-no-space') )
					),
					'archive-blog-full-alignment' => array(
						'title' => esc_html__('Archive Blog Full Alignment', 'zurf'),
						'type' => 'combobox',
						'default' => 'enable',
						'options' => array(
							'left' => esc_html__('Left', 'zurf'),
							'center' => esc_html__('Center', 'zurf'),
						),
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame') )
					),
					'archive-thumbnail-size' => array(
						'title' => esc_html__('Archive Thumbnail Size', 'zurf'),
						'type' => 'combobox',
						'options' => 'thumbnail-size'
					),
					'archive-show-thumbnail' => array(
						'title' => esc_html__('Archive Show Thumbnail', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail') )
					),
					'archive-column-size' => array(
						'title' => esc_html__('Archive Column Size', 'zurf'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
						'default' => 20,
						'condition' => array( 'archive-blog-style' => array('blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space') )
					),
					'archive-excerpt' => array(
						'title' => esc_html__('Archive Excerpt Type', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'specify-number' => esc_html__('Specify Number', 'zurf'),
							'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'zurf'),
						),
						'default' => 'specify-number',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail'))
					),
					'archive-excerpt-number' => array(
						'title' => esc_html__('Archive Excerpt Number', 'zurf'),
						'type' => 'text',
						'default' => 55,
						'data-input-type' => 'number',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail'), 'archive-excerpt' => 'specify-number')
					),
					'archive-date-feature' => array(
						'title' => esc_html__('Enable Blog Date Feature', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail') )
					),
					'archive-meta-option' => array(
						'title' => esc_html__('Archive Meta Option', 'zurf'),
						'type' => 'multi-combobox',
						'options' => array( 
							'date' => esc_html__('Date', 'zurf'),
							'author' => esc_html__('Author', 'zurf'),
							'category' => esc_html__('Category', 'zurf'),
							'tag' => esc_html__('Tag', 'zurf'),
							'comment' => esc_html__('Comment', 'zurf'),
							'comment-number' => esc_html__('Comment Number', 'zurf'),
						),
						'default' => array('date', 'author', 'category')
					),
					'archive-show-read-more' => array(
						'title' => esc_html__('Archive Show Read More Button', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail'),)
					),
					'archive-blog-title-font-size' => array(
						'title' => esc_html__('Blog Title Font Size', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
					),
					'archive-blog-title-font-weight' => array(
						'title' => esc_html__('Blog Title Font Weight', 'zurf'),
						'type' => 'text',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),
					'archive-blog-title-letter-spacing' => array(
						'title' => esc_html__('Blog Title Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
					),
					'archive-blog-title-text-transform' => array(
						'title' => esc_html__('Blog Title Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'none' => esc_html__('None', 'zurf'),
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
						),
						'default' => 'none'
					),
				)
			),

			'woocommerce-style' => array(
				'title' => esc_html__('Woocommerce Style', 'zurf'),
				'options' => array(

					'woocommerce-single-product-style' => array(
						'title' => esc_html__('Woocommerce Single Product Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf')
						)
					),
					'woocommerce-archive-sidebar' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar', 'zurf'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'right',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'woocommerce-archive-sidebar-left' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar Left', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'woocommerce-archive-sidebar'=>array('left', 'both') )
					),
					'woocommerce-archive-sidebar-right' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar Right', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'woocommerce-archive-sidebar'=>array('right', 'both') )
					),
					'woocommerce-archive-product-style' => array(
						'title' => esc_html__('Woocommerce Archive Product Style', 'zurf'),
						'type' => 'combobox',
						'options' => array( 
							'grid' => esc_html__('Grid', 'zurf'),
							'grid-2' => esc_html__('Grid 2', 'zurf'),
							'grid-3' => esc_html__('Grid 3', 'zurf'),
							'grid-3-with-border' => esc_html__('Grid 3 With Border', 'zurf'),
							'grid-3-without-frame' => esc_html__('Grid 3 Without Frame', 'zurf'),
							'grid-4' => esc_html__('Grid 4', 'zurf'),
							'grid-5' => esc_html__('Grid 5', 'zurf'),
							'grid-6' => esc_html__('Grid 6', 'zurf'),
						),
						'default' => 'grid'
					),
					'woocommerce-archive-product-amount' => array(
						'title' => esc_html__('Woocommerce Archive Product Amount', 'zurf'),
						'type' => 'text',
					),
					'woocommerce-archive-column-size' => array(
						'title' => esc_html__('Woocommerce Archive Column Size', 'zurf'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15
					),
					'woocommerce-archive-thumbnail' => array(
						'title' => esc_html__('Woocommerce Archive Thumbnail Size', 'zurf'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
					'woocommerce-related-product-column-size' => array(
						'title' => esc_html__('Woocommerce Related Product Column Size', 'zurf'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15
					),
					'woocommerce-related-product-num-fetch' => array(
						'title' => esc_html__('Woocommerce Related Product Num Fetch', 'zurf'),
						'type' => 'text',
						'default' => 4,
						'data-input-type' => 'number'
					),
					'woocommerce-related-product-thumbnail' => array(
						'title' => esc_html__('Woocommerce Related Product Thumbnail Size', 'zurf'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
				)
			),

			'portfolio-style' => array(
				'title' => esc_html__('Portfolio Style', 'zurf'),
				'options' => array(
					'portfolio-slug' => array(
						'title' => esc_html__('Portfolio Slug (Permalink)', 'zurf'),
						'type' => 'text',
						'default' => 'portfolio',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'zurf')
					),
					'portfolio-category-slug' => array(
						'title' => esc_html__('Portfolio Category Slug (Permalink)', 'zurf'),
						'type' => 'text',
						'default' => 'portfolio_category',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'zurf')
					),
					'portfolio-tag-slug' => array(
						'title' => esc_html__('Portfolio Tag Slug (Permalink)', 'zurf'),
						'type' => 'text',
						'default' => 'portfolio_tag',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'zurf')
					),
					'enable-single-portfolio-navigation' => array(
						'title' => esc_html__('Enable Single Portfolio Navigation', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'disable' => esc_html__('Disable', 'zurf'),
							'enable' => esc_html__('Style 1', 'zurf'),
							'style-2' => esc_html__('Style 2', 'zurf'),
						),
						'default' => 'enable'
					),
					'enable-single-portfolio-navigation-in-same-tag' => array(
						'title' => esc_html__('Enable Single Portfolio Navigation Within Same Tag', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'enable-single-portfolio-navigation' => array('enable', 'style-2') )
					),
					'single-portfolio-navigation-middle-link' => array(
						'title' => esc_html__('Single Portfolio Navigation Middle Link', 'zurf'),
						'type' => 'text',
						'default' => '#',
						'condition' => array( 'enable-single-portfolio-navigation' => 'style-2' )
					),
					'portfolio-icon-hover-link' => array(
						'title' => esc_html__('Portfolio Hover Icon (Link)', 'zurf'),
						'type' => 'radioimage',
						'options' => 'hover-icon-link',
						'default' => 'icon_link_alt'
					),
					'portfolio-icon-hover-video' => array(
						'title' => esc_html__('Portfolio Hover Icon (Video)', 'zurf'),
						'type' => 'radioimage',
						'options' => 'hover-icon-video',
						'default' => 'icon_film'
					),
					'portfolio-icon-hover-image' => array(
						'title' => esc_html__('Portfolio Hover Icon (Image)', 'zurf'),
						'type' => 'radioimage',
						'options' => 'hover-icon-image',
						'default' => 'icon_zoom-in_alt'
					),
					'portfolio-icon-hover-size' => array(
						'title' => esc_html__('Portfolio Hover Icon Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '22px',
						'selector' => '.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-icon{ font-size: #gdlr#; }' 
					),
					'enable-related-portfolio' => array(
						'title' => esc_html__('Enable Related Portfolio', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'related-portfolio-style' => array(
						'title' => esc_html__('Related Portfolio Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'grid' => esc_html__('Grid', 'zurf'),
							'modern' => esc_html__('Modern', 'zurf'),
						),
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-column-size' => array(
						'title' => esc_html__('Related Portfolio Column Size', 'zurf'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15,
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-num-fetch' => array(
						'title' => esc_html__('Related Portfolio Num Fetch', 'zurf'),
						'type' => 'text',
						'default' => 4,
						'data-input-type' => 'number',
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-thumbnail-size' => array(
						'title' => esc_html__('Related Portfolio Thumbnail Size', 'zurf'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'condition' => array('enable-related-portfolio'=>'enable'),
						'default' => 'medium'
					),
					'related-portfolio-num-excerpt' => array(
						'title' => esc_html__('Related Portfolio Num Excerpt', 'zurf'),
						'type' => 'text',
						'default' => 20,
						'data-input-type' => 'number',
						'condition' => array('enable-related-portfolio'=>'enable', 'related-portfolio-style'=>'grid')
					),
				)
			),

			'portfolio-archive' => array(
				'title' => esc_html__('Portfolio Archive', 'zurf'),
				'options' => array(
					'archive-portfolio-sidebar' => array(
						'title' => esc_html__('Archive Portfolio Sidebar', 'zurf'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'none',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-sidebar-left' => array(
						'title' => esc_html__('Archive Portfolio Sidebar Left', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-portfolio-sidebar'=>array('left', 'both') )
					),
					'archive-portfolio-sidebar-right' => array(
						'title' => esc_html__('Archive Portfolio Sidebar Right', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-portfolio-sidebar'=>array('right', 'both') )
					),
					'archive-portfolio-style' => array(
						'title' => esc_html__('Archive Portfolio Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'modern' => get_template_directory_uri() . '/include/options/images/portfolio/modern.png',
							'modern-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/modern-no-space.png',
							'grid' => get_template_directory_uri() . '/include/options/images/portfolio/grid.png',
							'grid-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/grid-no-space.png',
							'modern-desc' => get_template_directory_uri() . '/include/options/images/portfolio/modern-desc.png',
							'modern-desc-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/modern-desc-no-space.png',
							'medium' => get_template_directory_uri() . '/include/options/images/portfolio/medium.png',
						),
						'default' => 'medium',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-thumbnail-size' => array(
						'title' => esc_html__('Archive Portfolio Thumbnail Size', 'zurf'),
						'type' => 'combobox',
						'options' => 'thumbnail-size'
					),
					'archive-portfolio-grid-text-align' => array(
						'title' => esc_html__('Archive Portfolio Grid Text Align', 'zurf'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space' ) )
					),
					'archive-portfolio-grid-style' => array(
						'title' => esc_html__('Archive Portfolio Grid Content Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'normal' => esc_html__('Normal', 'zurf'),
							'with-frame' => esc_html__('With Frame', 'zurf'),
							'with-bottom-border' => esc_html__('With Bottom Border', 'zurf'),
						),
						'default' => 'normal',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space' ) )
					),
					'archive-enable-portfolio-tag' => array(
						'title' => esc_html__('Archive Enable Portfolio Tag', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ) )
					),
					'archive-portfolio-medium-size' => array(
						'title' => esc_html__('Archive Portfolio Medium Thumbnail Size', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'zurf'),
							'large' => esc_html__('Large', 'zurf'),
						),
						'condition' => array( 'archive-portfolio-style' => 'medium' )
					),
					'archive-portfolio-medium-style' => array(
						'title' => esc_html__('Archive Portfolio Medium Thumbnail Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left', 'zurf'),
							'right' => esc_html__('Right', 'zurf'),
							'switch' => esc_html__('Switch ( Between Left and Right )', 'zurf'),
						),
						'default' => 'switch',
						'condition' => array( 'archive-portfolio-style' => 'medium' )
					),
					'archive-portfolio-hover' => array(
						'title' => esc_html__('Archive Portfolio Hover Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'title' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title.png',
							'title-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title-icon.png',
							'title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title-tag.png',
							'icon-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/icon-title-tag.png',
							'icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/icon.png',
							'margin-title' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title.png',
							'margin-title-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title-icon.png',
							'margin-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title-tag.png',
							'margin-icon-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-icon-title-tag.png',
							'margin-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-icon.png',
							'none' => get_template_directory_uri() . '/include/options/images/portfolio/hover/none.png',
						),
						'default' => 'icon',
						'max-width' => '100px',
						'condition' => array( 'archive-portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'medium') ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-column-size' => array(
						'title' => esc_html__('Archive Portfolio Column Size', 'zurf'),
						'type' => 'combobox',
						'options' => array( 60=>1, 30=>2, 20=>3, 15=>4, 12=>5 ),
						'default' => 20,
						'condition' => array( 'archive-portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space') )
					),
					'archive-portfolio-excerpt' => array(
						'title' => esc_html__('Archive Portfolio Excerpt Type', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'specify-number' => esc_html__('Specify Number', 'zurf'),
							'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'zurf'),
							'none' => esc_html__('Disable Exceprt', 'zurf'),
						),
						'default' => 'specify-number',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ) )
					),
					'archive-portfolio-excerpt-number' => array(
						'title' => esc_html__('Archive Portfolio Excerpt Number', 'zurf'),
						'type' => 'text',
						'default' => 55,
						'data-input-type' => 'number',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ), 'archive-portfolio-excerpt' => 'specify-number' )
					),

				)
			),

			'personnel-style' => array(
				'title' => esc_html__('Personnel Style', 'zurf'),
				'options' => array(
					'personnel-slug' => array(
						'title' => esc_html__('Personnel Slug (Permalink)', 'zurf'),
						'type' => 'text',
						'default' => 'personnel',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'zurf')
					),
					'personnel-category-slug' => array(
						'title' => esc_html__('Personnel Category Slug (Permalink)', 'zurf'),
						'type' => 'text',
						'default' => 'personnel_category',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'zurf')
					),
				)
			),

			'footer' => array(
				'title' => esc_html__('Footer/Copyright', 'zurf'),
				'options' => array(

					'fixed-footer' => array(
						'title' => esc_html__('Fixed Footer', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'enable-footer' => array(
						'title' => esc_html__('Enable Footer', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'footer-background' => array(
						'title' => esc_html__('Footer Background', 'zurf'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.zurf-footer-wrapper{ background-image: url(#gdlr#); background-size: cover; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-border-radius' => array(
						'title' => esc_html__('Footer Border Radius', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'condition' => array( 'enable-footer' => 'enable' ),
						'selector' => 'footer{ overflow: hidden; border-radius: #gdlr#; -moz-border-radius: #gdlr#; -webkit-border-radius: #gdlr#; }'
					),
					'enable-footer-column-divider' => array(
						'title' => esc_html__('Enable Footer Column Divider', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-top-padding' => array(
						'title' => esc_html__('Footer Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '70px',
						'selector' => '.zurf-footer-wrapper{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-bottom-padding' => array(
						'title' => esc_html__('Footer Bottom Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '50px',
						'selector' => '.zurf-footer-wrapper{ padding-bottom: #gdlr#; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-style' => array(
						'title' => esc_html__('Footer Style', 'zurf'),
						'type' => 'radioimage',
						'wrapper-class' => 'gdlr-core-fullsize',
						'options' => array(
							'footer-1' => get_template_directory_uri() . '/include/options/images/footer-style1.png',
							'footer-2' => get_template_directory_uri() . '/include/options/images/footer-style2.png',
							'footer-3' => get_template_directory_uri() . '/include/options/images/footer-style3.png',
							'footer-4' => get_template_directory_uri() . '/include/options/images/footer-style4.png',
							'footer-5' => get_template_directory_uri() . '/include/options/images/footer-style5.png',
							'footer-6' => get_template_directory_uri() . '/include/options/images/footer-style6.png',
							'footer-7' => get_template_directory_uri() . '/include/options/images/footer-style7.png',
						),
						'default' => 'footer-2',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'enable-copyright' => array(
						'title' => esc_html__('Enable Copyright', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'copyright-style' => array(
						'title' => esc_html__('Copyright Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'center' => esc_html__('Center', 'zurf'),
							'left-right' => esc_html__('Left & Right', 'zurf'),
						),
						'condition' => array( 'enable-copyright' => 'enable' )
					),
					'copyright-top-padding' => array(
						'title' => esc_html__('Copyright Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '38px',
						'selector' => '.zurf-copyright-container{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-copyright' => 'enable' )
					),
					'copyright-bottom-padding' => array(
						'title' => esc_html__('Copyright Bottom Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '38px',
						'selector' => '.zurf-copyright-container{ padding-bottom: #gdlr#; }',
						'condition' => array( 'enable-copyright' => 'enable' )
					),	
					'copyright-text' => array(
						'title' => esc_html__('Copyright Text', 'zurf'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'condition' => array( 'enable-copyright' => 'enable', 'copyright-style' => 'center' )
					),
					'copyright-left' => array(
						'title' => esc_html__('Copyright Left', 'zurf'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'condition' => array( 'enable-copyright' => 'enable', 'copyright-style' => 'left-right' )
					),
					'copyright-right' => array(
						'title' => esc_html__('Copyright Right', 'zurf'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'condition' => array( 'enable-copyright' => 'enable', 'copyright-style' => 'left-right' )
					),
					'enable-back-to-top' => array(
						'title' => esc_html__('Enable Back To Top Button', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
				) // footer-options
			), // footer-nav	
		
		) // general-options
		
	), 2);