<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	// register skin option slug
	add_filter('gdlr_core_skin_option_slug', 'zurf_gdlr_core_skin_option_slug');
	if( !function_exists('zurf_gdlr_core_skin_option_slug') ){
		function zurf_gdlr_core_skin_option_slug( $option = '' ){
			return array('zurf_color', 'skin');
		}
	}

	// register skin options
	add_filter('gdlr_core_skin_options', 'zurf_gdlr_core_skin_options');
	if( !function_exists('zurf_gdlr_core_skin_options') ){
		function zurf_gdlr_core_skin_options( $options = array() ){

			$options = array_merge($options, array(
				'section-typography' => array(
					'title' => esc_html__('Typography', 'zurf'),
					'type' => 'title'
				),
				'title' => array(
					'title' => esc_html__('Title Color', 'zurf'),
					'selector' => '#gdlr-core-skin# h1, #gdlr-core-skin# h2, #gdlr-core-skin# h3, #gdlr-core-skin# h4, #gdlr-core-skin# h5, #gdlr-core-skin# h6, #gdlr-core-skin# .gdlr-core-skin-title, #gdlr-core-skin# .gdlr-core-skin-title a{ color: #gdlr# }'
				),
				'title-hover' => array(
					'title' => esc_html__('Title (Link) Hover Color', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-skin-title a:hover{ color: #gdlr# }'
				),
				'caption' => array(
					'title' => esc_html__('Caption Color', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-skin-caption, #gdlr-core-skin# .gdlr-core-skin-caption a, #gdlr-core-skin# .gdlr-core-skin-caption a:hover{ color: #gdlr# }' .
						'#gdlr-core-skin#  span.wpcf7-not-valid-tip{ color: #gdlr#; }'
				),
				'content' => array(
					'title' => esc_html__('Content Color', 'zurf'),
					'selector' => '#gdlr-core-skin#, #gdlr-core-skin# .gdlr-core-skin-content{ color: #gdlr# }'
				),
				'icon' => array(
					'title' => esc_html__('Icon Color', 'zurf'),
					'selector' => '#gdlr-core-skin# i, #gdlr-core-skin# .gdlr-core-skin-icon, #gdlr-core-skin# .gdlr-core-skin-icon:before, #gdlr-core-skin# .zurf-widget ul li:before{ color: #gdlr# }' . 
						'#gdlr-core-skin# .gdlr-core-blog-modern.gdlr-core-with-image .gdlr-core-blog-info-wrapper i{ color: #gdlr#; }' . 
						'#gdlr-core-skin# .gdlr-core-flexslider-nav.gdlr-core-plain-circle-style li a{ border-color: #gdlr#; }'
				),
				'link' => array(
					'title' => esc_html__('Link Color', 'zurf'),
					'selector' => '#gdlr-core-skin# a, #gdlr-core-skin# .gdlr-core-skin-link{ color: #gdlr# }'
				),
				'link-hover' => array(
					'title' => esc_html__('Link Hover Color', 'zurf'),
					'selector' => '#gdlr-core-skin# a:hover, #gdlr-core-skin# .gdlr-core-skin-link:hover{ color: #gdlr# }' . 
						'#gdlr-core-skin# .gdlr-core-blog-item .gdlr-core-excerpt-read-more.gdlr-core-plain-text.gdlr-core-hover-border:hover{ border-color: #gdlr# !important }'
				),
				'section-divider' => array(
					'title' => esc_html__('Divider & Elements', 'zurf'),
					'type' => 'title'
				),
				'divider' => array(
					'title' => esc_html__('Divider Color', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-skin-divider{ border-color: #gdlr#; column-rule-color: #gdlr#; -moz-column-rule-color: #gdlr#; -webkit-column-rule-color: #gdlr#; }' . 
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-nav-style-middle-large .flex-direction-nav li a{ border-color: #gdlr# }'
				),
				'border' => array(
					'title' => esc_html__('Border Color', 'zurf'),
					'selector' => '#gdlr-core-skin# *, #gdlr-core-skin# select, #gdlr-core-skin# .gdlr-core-skin-border{ border-color: #gdlr# }' . 
						'#gdlr-core-skin# input:not([type="button"]):not([type="submit"]):not([type="reset"]){ border-color: #gdlr#; }' .
						'#gdlr-core-skin# .gdlr-core-product-grid-4:hover .gdlr-core-product-title{ border-color: #gdlr#; }'
				),
				'element-background' => array(
					'title' => esc_html__('Element Background Color', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-skin-e-background{ background-color: #gdlr# }' . 
						'#gdlr-core-skin# .gdlr-core-flexslider-nav.gdlr-core-round-style li a, ' . 
						'#gdlr-core-skin# .gdlr-core-flexslider-nav.gdlr-core-rectangle-style li a{ background-color: #gdlr#; }' .
						//'#gdlr-core-skin# .gdlr-core-flexslider .flex-control-nav li a{ border-color: #gdlr#; }'.
						//'#gdlr-core-skin# .gdlr-core-flexslider .flex-control-nav li a.flex-active{ background-color: #gdlr#; }' . 
						'#gdlr-core-skin# input:not([type="button"]):not([type="submit"]):not([type="reset"]), #gdlr-core-skin# textarea, #gdlr-core-skin# select{ background-color: #gdlr#; }'  . 
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-bottom-nav-1 .flex-direction-nav li a{ background-color: #gdlr#; }'
				),
				'element-content' => array(
					'title' => esc_html__('Element Content Color', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-skin-e-content{ color: #gdlr# }'  . 
						'#gdlr-core-skin# .gdlr-core-flexslider-nav.gdlr-core-round-style li a i, ' . 
						'#gdlr-core-skin# .gdlr-core-flexslider-nav.gdlr-core-rectangle-style li a i{ color: #gdlr#; }' .
						'#gdlr-core-skin# input:not([type="button"]):not([type="submit"]):not([type="reset"]), #gdlr-core-skin# textarea, #gdlr-core-skin# select{ color: #gdlr#; }' .
						'#gdlr-core-skin# ::-webkit-input-placeholder{ color: #gdlr#; }' .
						'#gdlr-core-skin# ::-moz-placeholder{ color: #gdlr#; }' .
						'#gdlr-core-skin# :-ms-input-placeholder{ color: #gdlr#; }' .
						'#gdlr-core-skin# :-moz-placeholder{ color: #gdlr#; }' . 
						'#gdlr-core-skin#  .gdlr-core-flexslider.gdlr-core-bottom-nav-1 .flex-direction-nav li a{ color: #gdlr#; }'
				),
				'carousel-bullet-background' => array(
					'title' => esc_html__('Carousel Bullet Background', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-color-bullet .flex-control-nav li a,' . 
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-bullet-style-cylinder .flex-control-nav li a,' . 
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-bullet-style-cylinder-left .flex-control-nav li a{ background-color: #gdlr#; }' . 
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-border-color-bullet .flex-control-nav li a{ border-color: #gdlr#; }' . 
						'#gdlr-core-skin# ul.gdlr-core-sly-nav li{ background: #gdlr#; }'
				),
				'carousel-bullet-active-background' => array(
					'title' => esc_html__('Carousel Bullet Active Background', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-flexslider .flex-control-nav li a{ border-color: #gdlr#; }' .
						'#gdlr-core-skin# .gdlr-core-flexslider .flex-control-nav li a.flex-active{ background-color: #gdlr#; }' .
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-color-bullet .flex-control-nav li a.flex-active,' . 
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-bullet-style-cylinder .flex-control-nav li a.flex-active,' . 
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-bullet-style-cylinder-left .flex-control-nav li a.flex-active{ background-color: #gdlr#; }' . 
						'#gdlr-core-skin# .gdlr-core-flexslider.gdlr-core-border-color-bullet .flex-control-nav li a.flex-active{ border-color: #gdlr#; }'  . 
						'#gdlr-core-skin# ul.gdlr-core-sly-nav li.active{ background: #gdlr#; }'
				),
				'section-button' => array(
					'title' => esc_html__('Button', 'zurf'),
					'type' => 'title'
				),
				'button-text' => array(
					'title' => esc_html__('Button Text', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-button, #gdlr-core-skin# .gdlr-core-button-color{ color: #gdlr# }' .
						'#gdlr-core-skin# input[type="button"], #gdlr-core-skin# input[type="submit"]{ color: #gdlr#; }' .
					 	'#gdlr-core-skin# .gdlr-core-pagination a{ color: #gdlr# }'
				),
				'button-text-hover' => array(
					'title' => esc_html__('Button Text Hover', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-button:hover, #gdlr-core-skin# .gdlr-core-button-color:hover, #gdlr-core-skin# .gdlr-core-button-color.gdlr-core-active{ color: #gdlr# }' .
					 	'#gdlr-core-skin# input[type="button"]:hover, #gdlr-core-skin# input[type="submit"]:hover{ color: #gdlr#; }' .
					 	'#gdlr-core-skin# .gdlr-core-pagination a:hover, #gdlr-core-skin# .gdlr-core-pagination a.gdlr-core-active, #gdlr-core-skin# .gdlr-core-pagination span{ color: #gdlr# }'
				),
				'button-background' => array(
					'title' => esc_html__('Button Background', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-button, #gdlr-core-skin# .gdlr-core-button-color{ background-color: #gdlr# }'  .
					 	'#gdlr-core-skin# input[type="button"], #gdlr-core-skin# input[type="submit"]{ background-color: #gdlr#; }' .
					 	'#gdlr-core-skin# .gdlr-core-pagination a{ background-color: #gdlr# }'
				),
				'button-background-hover' => array(
					'title' => esc_html__('Button Bg Hover / Gradient', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-button:hover, #gdlr-core-skin# .gdlr-core-button-color:hover, #gdlr-core-skin# .gdlr-core-button-color.gdlr-core-active{ background-color: #gdlr# }' .
					 	'#gdlr-core-skin# input[type="button"]:hover, #gdlr-core-skin# input[type="submit"]:hover{ background-color: #gdlr#; }' .
					 	'#gdlr-core-skin# .gdlr-core-pagination a:hover, #gdlr-core-skin# .gdlr-core-pagination a.gdlr-core-active, #gdlr-core-skin# .gdlr-core-pagination span{ background-color: #gdlr# }'
				),
				'button-border-color' => array(
					'title' => esc_html__('Button Border', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-button, #gdlr-core-skin# .gdlr-core-button-color{ border-color: #gdlr# }' . 
						'#gdlr-core-skin# .gdlr-core-pagination a{ border-color: #gdlr# }'
				),
				'button-border-hover-color' => array(
					'title' => esc_html__('Button Border Hover', 'zurf'),
					'selector' => '#gdlr-core-skin# .gdlr-core-button:hover, #gdlr-core-skin# .gdlr-core-button-color:hover, #gdlr-core-skin# .gdlr-core-button-color.gdlr-core-active{ border-color: #gdlr# }' .
			 			'#gdlr-core-skin# .gdlr-core-pagination a:hover, #gdlr-core-skin# .gdlr-core-pagination a.gdlr-core-active, #gdlr-core-skin# .gdlr-core-pagination span{ border-color: #gdlr# }'  .
			 			'#gdlr-core-skin# .gdlr-core-button-with-border:hover{ border-color: #gdlr#; }'
				),

			));

			return $options;
		}
	}

	// for advance skin settings
	add_filter('gdlr_core_skin_css', 'zurf_gdlr_core_skin_css', 10, 2);
	if( !function_exists('zurf_gdlr_core_skin_css') ){
		function zurf_gdlr_core_skin_css( $css, $skins ){
			$extra_css = '';

			foreach( $skins as $skin ){
				if( !empty($skin['name']) && !empty($skin['button-background']) && !empty($skin['button-background-hover']) ){
					$extra_css .= '.gdlr-core-page-builder-body [data-skin="' . $skin['name'] . '"] .gdlr-core-button.gdlr-core-button-gradient{ ' .
					    'background: -webkit-linear-gradient(' . $skin['button-background'] . ', ' . $skin['button-background-hover'] . '); ' . 
					    'background: -o-linear-gradient(' . $skin['button-background'] . ', ' . $skin['button-background-hover'] . ');  ' . 
					    'background: -moz-linear-gradient(' . $skin['button-background'] . ', ' . $skin['button-background-hover'] . '); ' . 
						'background: linear-gradient(' . $skin['button-background'] . ', ' . $skin['button-background-hover'] . '); } ';
					$extra_css .= "\n";
						
					$extra_css .= '.gdlr-core-page-builder-body [data-skin="' . $skin['name'] . '"] .gdlr-core-button.gdlr-core-button-gradient-v{ ' .
					    'background: -webkit-linear-gradient(to right, ' . $skin['button-background'] . ', ' . $skin['button-background-hover'] . '); ' . 
					    'background: -o-linear-gradient(to right, ' . $skin['button-background'] . ', ' . $skin['button-background-hover'] . ');  ' . 
					    'background: -moz-linear-gradient(to right, ' . $skin['button-background'] . ', ' . $skin['button-background-hover'] . '); ' . 
						'background: linear-gradient(to right, ' . $skin['button-background'] . ', ' . $skin['button-background-hover'] . '); } ';
					$extra_css .= "\n";
				}
			}
			return $css . $extra_css;
		}
	}
	
	$zurf_admin_option->add_element(apply_filters('zurf_color_options',array(
	
		// color head section
		'title' => esc_html__('Color', 'zurf'),
		'slug' => 'zurf_color',
		'icon' => get_template_directory_uri() . '/include/options/images/color.png',
		'options' => array(
		
			// starting the subnav
			'skin' => array(
				'title' => esc_html__('Skin', 'zurf'),
				'customizer' => false,
				'options' => array(
				
					'skin' => array(
						'title' => esc_html__('Skin Settings', 'zurf'),
						'type' => 'custom',
						'item-type' => 'skin-settings',
						'wrapper-class' => 'gdlr-core-fullsize',
						'options' => apply_filters('gdlr_core_skin_options', array())
					),		
					
				) // skin-options
			), // skin-nav

			'header-color' => zurf_header_color_options(), 

			'navigation-menu-color' => zurf_navigation_color_options(), 		
			
			'navigation-right-color' => zurf_navigation_right_color_options(),

			'body-color' => array(
				'title' => esc_html__('Body', 'zurf'),
				'options' => array(
				
					'page-preload-background-color' => array(
						'title' => esc_html__('Page Preload Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-page-preload{ background-color: #gdlr#; }'
					),
					'body-background-color' => array(
						'title' => esc_html__('Body Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-body-outer-wrapper, body.zurf-full .zurf-body-wrapper{ background-color: #gdlr#; }'
					),
					'container-background-color' => array(
						'title' => esc_html__('Container Background Color ( For Boxed Layout )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => 'body.zurf-boxed .zurf-body-wrapper, ' .
							'.gdlr-core-page-builder .gdlr-core-page-builder-body.gdlr-core-pb-livemode{ background-color: #gdlr#; }'
					),
					'page-title-color' => array(
						'title' => esc_html__('Page Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-page-title-wrap .zurf-page-title{ color: #gdlr#; }'
					),
					'page-caption-color' => array(
						'title' => esc_html__('Page Caption Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-page-title-wrap .zurf-page-caption{ color: #gdlr#; }' .
							'.zurf-page-title-wrap .zurf-page-caption .woocommerce-breadcrumb, .zurf-page-title-wrap .zurf-page-caption .woocommerce-breadcrumb a,' .
							'.zurf-page-title-wrap .zurf-page-title-event-time, ' . 
							'.zurf-page-title-wrap .zurf-page-title-event-link a, .zurf-page-title-wrap .zurf-page-title-event-link a:hover{ color: #gdlr#; }'
					),
					'page-title-background-color' => array(
						'title' => esc_html__('Page Title Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector' => '.zurf-page-title-wrap, .zurf-blog-title-wrap{ background-color: #gdlr#; }'
					),
					'page-title-background-overlay-color' => array(
						'title' => esc_html__('Page Title Background Overlay Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector' => '.zurf-page-title-wrap .zurf-page-title-overlay{ background-color: #gdlr#; }'
					),
					'page-title-background-gradient-max-opacity' => array(
						'title' => esc_html__('Page Title Background Gradient Max Opacity', 'zurf'),
						'type' => 'text',
						'default' => '1',
						'description' => esc_html__('Fill the number between 0.01 to 1', 'zurf')
					),
					'page-title-background-gradient-color' => array(
						'title' => esc_html__('Page Title Background Gradient Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'selector-extra' => true,
						'selector' => '.zurf-page-title-wrap .zurf-page-title-top-gradient{ ' .
							'background: -webkit-linear-gradient(to top, rgba(#gdlra#, 0), rgba(#gdlra#, <page-title-background-gradient-max-opacity>t)); ' . 
							'background: -o-linear-gradient(to top, rgba(#gdlra#, 0), rgba(#gdlra#, <page-title-background-gradient-max-opacity>t)); ' . 
							'background: -moz-linear-gradient(to top, rgba(#gdlra#, 0), rgba(#gdlra#, <page-title-background-gradient-max-opacity>t)); ' . 
							'background: linear-gradient(to top, rgba(#gdlra#, 0), rgba(#gdlra#, <page-title-background-gradient-max-opacity>t)); }' .
							'.zurf-page-title-wrap .zurf-page-title-bottom-gradient{ ' .
							'background: -webkit-linear-gradient(to bottom, rgba(#gdlra#, 0), rgba(#gdlra#, <page-title-background-gradient-max-opacity>t)); ' . 
							'background: -o-linear-gradient(to bottom, rgba(#gdlra#, 0), rgba(#gdlra#, <page-title-background-gradient-max-opacity>t)); ' . 
							'background: -moz-linear-gradient(to bottom, rgba(#gdlra#, 0), rgba(#gdlra#, <page-title-background-gradient-max-opacity>t)); ' . 
							'background: linear-gradient(to bottom, rgba(#gdlra#, 0), rgba(#gdlra#, <page-title-background-gradient-max-opacity>t)); }',
						'default' => '#000',
					),		
					'body-content-color' => array(
						'title' => esc_html__('Body Content Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#9b9b9b',
						'selector' => '.zurf-body, .zurf-body span.wpcf7-not-valid-tip{ color: #gdlr#; }'
					),				
					'heading-color' => array(
						'title' => esc_html__('Heading Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector' => '.zurf-body h1, .zurf-body h2, .zurf-body h3, ' . 
							'.zurf-body h4, .zurf-body h5, .zurf-body h6{ color: #gdlr#; }' . 
							'.woocommerce table.shop_attributes th, .woocommerce table.shop_table th, ' . 
							'.single-product.woocommerce div.product .product_meta .zurf-head{ color: #gdlr#; }'
					),				
					'link-color' => array(
						'title' => esc_html__('Link Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#545454',
						'selector' => '.zurf-body a{ color: #gdlr#; }'  . 
							'.zurf-blog-style-3 .zurf-comments-area .comment-reply a, .zurf-blog-style-3 .zurf-comments-area .comment-reply a:hover,' .
							'.zurf-blog-style-5 .zurf-comments-area .comment-reply a, .zurf-blog-style-5 .zurf-comments-area .comment-reply a:hover{ color: #gdlr#; }' .
							'.woocommerce ul.products li.product .gdlr-core-product-default .button{ color: #gdlr#; }'
					),				
					'link-hover-color' => array(
						'title' => esc_html__('Link Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector' => '.zurf-body a:hover{ color: #gdlr#; }' . 
							'.gdlr-core-blog-item .gdlr-core-excerpt-read-more.gdlr-core-plain-text.gdlr-core-hover-border:hover{ border-color: #gdlr# !important; }' .
							'.woocommerce ul.products li.product .gdlr-core-product-default .button:hover{ color: #gdlr#; }'
					),
					'divider-color' => array(
						'title' => esc_html__('Divider Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e6e6e6',
						'selector' => '.zurf-body *{ border-color: #gdlr#; }' . 
							'.zurf-body .gdlr-core-portfolio-single-nav-wrap{ border-color: #gdlr#; }' .
							'.gdlr-core-product-grid-4:hover .gdlr-core-product-title{ border-color: #gdlr#; }' .
							'.gdlr-core-columnize-item .gdlr-core-columnize-item-content{ column-rule-color: #gdlr#; -moz-column-rule-color: #gdlr#; -webkit-column-rule-color: #gdlr#; }'
					),
					'input-box-background-color' => array(
						'title' => esc_html__('Input Box Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-body input, ' .  
							'.zurf-body textarea, .zurf-body select, .woocommerce form .select2-selection{ background-color: #gdlr#; }'
					),
					'input-box-border-color' => array(
						'title' => esc_html__('Input Box (Style 1) Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#d7d7d7',
						'selector' => '.zurf-body input, ' .  
							'.zurf-body textarea, .zurf-body select, .woocommerce form .select2-selection{ border-color: #gdlr#; }'
					),
					'input-box-text-color' => array(
						'title' => esc_html__('Input Box Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#4e4e4e',
						'selector' => '.zurf-body input, ' .  
							'.zurf-body textarea, .zurf-body select, .woocommerce form .select2-selection{ color: #gdlr#; }'
					),
					'input-box-placeholder-color' => array(
						'title' => esc_html__('Input Box Placeholder Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#4e4e4e',
						'selector' => '.zurf-body ::-webkit-input-placeholder{  color: #gdlr#; }' .
							'.zurf-body ::-moz-placeholder{  color: #gdlr#; }' .
							'.zurf-body :-ms-input-placeholder{  color: #gdlr#; }' .
							'.zurf-body :-moz-placeholder{  color: #gdlr#; }'
					),
					'round-checkbox-background-color' => array(
						'title' => esc_html__('Round Checkbox Background Color (CF7)', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#686868',
						'selector' => '.gdlr-core-round-checkbox .wpcf7-list-item-label{ background: #gdlr#; }'
					),
					'round-checkbox-active-color' => array(
						'title' => esc_html__('Round Checkbox Active Color (CF7)', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#4f00ff',
						'selector' => '.gdlr-core-round-checkbox label input[type="checkbox"]:checked + .wpcf7-list-item-label:before{ background: #gdlr#; }'
					),
					'float-social-color' => array(
						'title' => esc_html__('Float Social Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-float-social, .zurf-float-social .zurf-float-social-icon{ color: #gdlr#; }' . 
							'.zurf-float-social .zurf-divider{ border-color: #gdlr#; }'
					),
					'float-social-hover-color' => array(
						'title' => esc_html__('Float Social Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-float-social .zurf-float-social-icon:hover{ color: #gdlr#; }'
					),
					'float-social-footer-color' => array(
						'title' => esc_html__('Float Social Footer Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-float-social[data-section="footer"], .zurf-float-social[data-section="footer"] .zurf-float-social-icon{ color: #gdlr#; }'  . 
							'.zurf-float-social[data-section="footer"] .zurf-divider{ border-color: #gdlr#; }'
					),
					'float-social-footer-hover-color' => array(
						'title' => esc_html__('Float Social Footer Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-float-social[data-section="footer"] .zurf-float-social-icon:hover{ color: #gdlr#; }'
					)
					
				) // body-options
			), // body-nav	
					
			'404-color' => array(
				'title' => esc_html__('404 Page', 'zurf'),
				'options' => array(		

					'404-content-background-color' => array(
						'title' => esc_html__('404 Content Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#23618e',
						'selector' => '.zurf-not-found-wrap{ background-color: #gdlr#; }'
					),
					'404-head-color' => array(
						'title' => esc_html__('404 Head Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-not-found-wrap .zurf-not-found-head{ color: #gdlr#; }'
					),
					'404-title-color' => array(
						'title' => esc_html__('404 Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-not-found-wrap .zurf-not-found-title{ color: #gdlr#; }'
					),
					'404-caption-color' => array(
						'title' => esc_html__('404 Caption Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#c3e7ff',
						'selector' => '.zurf-not-found-wrap .zurf-not-found-caption{ color: #gdlr#; }'
					),
					'404-input-background-color' => array(
						'title' => esc_html__('404 Input Background Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector' => '.zurf-not-found-wrap form.search-form input.search-field{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.4) }'
					),
					'404-input-text-color' => array(
						'title' => esc_html__('404 Input Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-not-found-wrap form.search-form input.search-field, ' . 
							'.zurf-not-found-wrap .zurf-top-search-submit{ color: #gdlr#; } ' . 
							'.zurf-not-found-wrap input::-webkit-input-placeholder { color: #gdlr#; } ' . 
							'.zurf-not-found-wrap input:-moz-placeholder{ color: #gdlr#; } ' . 
							'.zurf-not-found-wrap input::-moz-placeholder{ color: #gdlr#; } ' . 
							'.zurf-not-found-wrap input:-ms-input-placeholder{ color: #gdlr#; }'
					),
					'404-back-to-home-color' => array(
						'title' => esc_html__('404 Back To Home', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-not-found-wrap .zurf-not-found-back-to-home a, .zurf-not-found-wrap .zurf-not-found-back-to-home a:hover{ color: #gdlr#; }'
					),

				)
			),

			'sidebar-color' => array(
				'title' => esc_html__('Sidebar / Widget', 'zurf'),
				'options' => array(	

					'sidebar-title-color' => array(
						'title' => esc_html__('Sidebar Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector' => '.zurf-sidebar-area .zurf-widget-title{ color: #gdlr#; }'
					),
					'sidebar-link-color' => array(
						'title' => esc_html__('Sidebar Link Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#484848',
						'selector' => '.zurf-sidebar-area a{ color: #gdlr#; }' . 
						 	'.widget_recent_entries ul li:before, .widget_recent_comments ul li:before, ' .
						 	'.widget_pages ul li:before, .widget_rss ul li:before, ' .
						 	'.widget_archive ul li:before, .widget_categories ul li:before, .widget_nav_menu ul li:before, ' .
						 	'.widget_meta ul li:before{ color: #gdlr#; }'
					),
					'sidebar-link-hover-color' => array(
						'title' => esc_html__('Sidebar Link Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#323232',
						'selector' => '.zurf-sidebar-area a:hover, .zurf-sidebar-area .current-menu-item > a{ color: #gdlr#; }'
					),
					'recent-post-widget-info-icon-color' => array(
						'title' => esc_html__('Recent Post Widget Info Icon', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#9c9c9c',
						'selector' => '.gdlr-core-recent-post-widget .gdlr-core-blog-info i{ color: #gdlr#; }'
					),
					'recent-post-widget-info-link-color' => array(
						'title' => esc_html__('Recent Post Widget Info Link', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#a0a0a0',
						'selector' => '.gdlr-core-recent-post-widget .gdlr-core-blog-info, ' .
							'.gdlr-core-recent-post-widget .gdlr-core-blog-info a, ' .
							'.gdlr-core-recent-post-widget .gdlr-core-blog-info a:hover{ color: #gdlr#; }'
					),
					'post-slider-widget-title-color' => array(
						'title' => esc_html__('Post Slider Widget Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-post-slider-widget-overlay .gdlr-core-post-slider-widget-title{ color: #gdlr#; }'
					),
					'post-slider-widget-info-color' => array(
						'title' => esc_html__('Post Slider Widget Info', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#9c9c9c',
						'selector' => '.gdlr-core-post-slider-widget-overlay .gdlr-core-blog-info, ' .
							'.gdlr-core-post-slider-widget-overlay .gdlr-core-blog-info i, ' .
							'.gdlr-core-post-slider-widget-overlay .gdlr-core-blog-info a, ' .
							'.gdlr-core-post-slider-widget-overlay .gdlr-core-blog-info a:hover{ color: #gdlr#; }'
					),
					'search-box-text-color' => array(
						'title' => esc_html__('Search Box Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b5b5b5',
						'selector' => '.widget_search input.search-field, .wp-block-search .wp-block-search__input, .widget_archive select, .widget_categories select, .widget_text select{ color: #gdlr#; }' .
							'.widget_search input::-webkit-input-placeholder { color: #gdlr#; }' . 
							'.widget_search input:-moz-placeholder{ color: #gdlr#; }' . 
							'.widget_search input::-moz-placeholder{ color: #gdlr#; }' . 
							'.widget_search input:-ms-input-placeholder{ color: #gdlr#; }'
					),
					'search-box-border-color' => array(
						'title' => esc_html__('Search Box Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e0e0e0',
						'selector' => '.widget_search input.search-field, .wp-block-search .wp-block-search__input, .widget_archive select, .widget_categories select, .widget_text select{ border-color: #gdlr#; }'
					),
					'search-box-icon-color' => array(
						'title' => esc_html__('Search Box Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#c7c7c7',
						'selector' => '.widget_search form:after{ border-color: #gdlr#; }'
					),
					'tag-cloud-text-color' => array(
						'title' => esc_html__('Tag Cloud Text Color', 'zurf'),
						'type' => 'colorpicker',
						'selector' => '.zurf-body .tagcloud a{ color: #gdlr#; }'
					),
					'tag-cloud-text-hover-color' => array(
						'title' => esc_html__('Tag Cloud Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'selector' => '.zurf-body .tagcloud a:hover{ color: #gdlr#; }'
					),
					'tag-cloud-background-color' => array(
						'title' => esc_html__('Tag Cloud Background Color', 'zurf'),
						'type' => 'colorpicker',
						'selector' => '.zurf-body .tagcloud a{ background-color: #gdlr#; }'
					),
					'tag-cloud-border-color' => array(
						'title' => esc_html__('Tag Cloud Border Color', 'zurf'),
						'type' => 'colorpicker',
						'selector' => '.zurf-body .tagcloud a{ border-color: #gdlr#; }'
					),
					'twitter-widget-icon-color' => array(
						'title' => esc_html__('Twitter Widget Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#303030',
						'selector' => 'ul.gdlr-core-twitter-widget-wrap li:before{ color: #gdlr#; }'
					),
					'twitter-widget-date-color' => array(
						'title' => esc_html__('Twitter Widget Date Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b5b5b5',
						'selector' => 'ul.gdlr-core-twitter-widget-wrap li .gdlr-core-twitter-widget-date a, ul.gdlr-core-twitter-widget-wrap li .gdlr-core-twitter-widget-date a:hover{ color: #gdlr#; }'
					),
					'custom-menu-widget-list-style-link' => array(
						'title' => esc_html__('Custom Menu Widget List Style Link Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#6774a2',
						'selector' => 'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list li a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list2 li a{ color: #gdlr#; }'
					),
					'custom-menu-widget-list-style-link-hover' => array(
						'title' => esc_html__('Custom Menu Widget List Style Link Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#1c3375',
						'selector' => 'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list li a:hover,' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list li.current-menu-item a,' .
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list li.current-menu-ancestor a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list2 li.current-menu-item a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list2 li.current-menu-item a:before,' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list2 li.current-menu-ancestor a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list2 li.current-menu-ancestor a:before,' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list2 li a:hover, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list2 li a:hover:before{ color: #gdlr#; }'
					),
					'custom-menu-widget-list-style-border' => array(
						'title' => esc_html__('Custom Menu Widget List Style Border', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#233c85',
						'selector' => 'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list li a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list2 li a:hover{ border-color: #gdlr#; }' .
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-list li a:before{ color: #gdlr#; }' 
					),
					'custom-menu-widget-box-style-text' => array(
						'title' => esc_html__('Custom Menu Widget Box Style Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#474747',
						'selector' => 'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box li a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2 li a{ color: #gdlr#; }'
					),
					'custom-menu-widget-box-style-background' => array(
						'title' => esc_html__('Custom Menu Widget Box Style Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => 'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box li a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2 li a{ background-color: #gdlr#; }'
					),
					'custom-menu-widget-box-style-text-active' => array(
						'title' => esc_html__('Custom Menu Widget Box Style Text Active', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => 'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box li a:hover, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box li.current-menu-item a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box li.current-menu-ancestor a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2 li a:hover, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2 li.current-menu-item a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2 li.current-menu-ancestor a{ color: #gdlr#; }' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2:after{ border-color: #gdlr#; }'
					),
					'custom-menu-widget-box-style-background-active' => array(
						'title' => esc_html__('Custom Menu Widget Box Style Background Active', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#143369',
						'selector' => 'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box li a:hover, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box li.current-menu-item a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box li.current-menu-ancestor a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2 li a:hover, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2 li.current-menu-item a, ' . 
							'ul.gdlr-core-custom-menu-widget.gdlr-core-menu-style-box2 li.current-menu-ancestor a{ background-color: #gdlr#; }'
					),
				) // body-options
			), // body-nav	
			
			'footer-copyright-color' => array(
				'title' => esc_html__('Footer/Copyright', 'zurf'),
				'options' => array(
				
					'footer-background-color' => array(
						'title' => esc_html__('Footer Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#202020',
						'selector' => '.zurf-footer-wrapper{ background-color: #gdlr#; }'
					),
					'footer-title-color' => array(
						'title' => esc_html__('Footer Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-footer-wrapper .zurf-widget-title{ color: #gdlr#; }' . 
							'.zurf-footer-wrapper h1, .zurf-footer-wrapper h2, .zurf-footer-wrapper h3, ' . 
							'.zurf-footer-wrapper h4, .zurf-footer-wrapper h5, .zurf-footer-wrapper h6{ color: #gdlr#; } ' 
					),
					'footer-content-color' => array(
						'title' => esc_html__('Footer Content Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ababab',
						'selector' => '.zurf-footer-wrapper{ color: #gdlr#; }' . 
							'.zurf-footer-wrapper .widget_recent_entries ul li:before, .zurf-footer-wrapper .widget_recent_comments ul li:before, ' .
						 	'.zurf-footer-wrapper .widget_pages ul li:before, .zurf-footer-wrapper .widget_rss ul li:before, ' .
						 	'.zurf-footer-wrapper .widget_archive ul li:before, .zurf-footer-wrapper .widget_categories ul li:before, .widget_nav_menu ul li:before, ' .
						 	'.zurf-footer-wrapper .widget_meta ul li:before{ color: #gdlr#; }'
					),
					'footer-link-color' => array(
						'title' => esc_html__('Footer Link Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-footer-wrapper a{ color: #gdlr#; }'
					),
					'footer-link-hover-color' => array(
						'title' => esc_html__('Footer Link Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-footer-wrapper a:hover{ color: #gdlr#; }'
					),
					'footer-divider-color' => array(
						'title' => esc_html__('Footer Divider Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#303030',
						'selector' => '.zurf-footer-wrapper, .zurf-footer-wrapper *{ border-color: #gdlr#; }'
					),
					
					'copyright-background-color' => array(
						'title' => esc_html__('Copyright Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#181818',
						'selector' => '.zurf-copyright-wrapper{ background-color: #gdlr#; }'
					),
					'copyright-text-color' => array(
						'title' => esc_html__('Copyright Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#838383',
						'selector' => '.zurf-copyright-wrapper{ color: #gdlr#; }'
					),
					'copyright-link-color' => array(
						'title' => esc_html__('Copyright Link Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#838383',
						'selector' => '.zurf-copyright-wrapper a{ color: #gdlr#; }'
					),
					'copyright-link-hover-color' => array(
						'title' => esc_html__('Copyright Link Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#838383',
						'selector' => '.zurf-copyright-wrapper a:hover{ color: #gdlr#; }'
					),
					'back-to-top-background-color' => array(
						'title' => esc_html__('Back To Top Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#dbdbdb',
						'selector' => '.zurf-footer-back-to-top-button{ background-color: #gdlr#; }'
					),
					'back-to-top-text-color' => array(
						'title' => esc_html__('Back To Top Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#313131',
						'selector' => '.zurf-body .zurf-footer-back-to-top-button, .zurf-body .zurf-footer-back-to-top-button:hover{ color: #gdlr#; }'
					),
					
				) // footer-copyright-options
			), // footer-copyright-nav
		
			'single-blog' => array(
				'title' => esc_html__('Single Blog', 'zurf'),
				'options' => array(		

					'single-blog-title-color' => array(
						'title' => esc_html__('Single Blog ( Main Title ) Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-body .zurf-blog-title-wrap .zurf-single-article-title{ color: #gdlr#; }'
					),
					'single-blog-info-color' => array(
						'title' => esc_html__('Single Blog ( Main Title )  Info Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-blog-title-wrap .zurf-blog-info-wrapper, .zurf-blog-title-wrap .zurf-blog-info-wrapper a, ' . 
							'.zurf-blog-title-wrap .zurf-blog-info-wrapper a:hover, .zurf-blog-title-wrap .zurf-blog-info-wrapper i{ color: #gdlr#; }'
					),
					'single-blog-date-day-color' => array(
						'title' => esc_html__('Single Blog ( Main Title )  Date Day Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-blog-title-wrap .zurf-single-article-date-day{ color: #gdlr#; }'
					),
					'single-blog-date-month-color' => array(
						'title' => esc_html__('Single Blog ( Main Title )  Date Month Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b1b1b1',
						'selector' => '.zurf-blog-title-wrap .zurf-single-article-date-month, .zurf-single-article-date-wrapper .zurf-single-article-date-year{ color: #gdlr#; }'
					),
					'single-blog-divider-color' => array(
						'title' => esc_html__('Single Blog ( Main Title ) Date Divider Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-blog-title-wrap .zurf-single-article-date-wrapper{ border-color: #gdlr#; }'
					),
					'single-blog-title-background-overlay-color' => array(
						'title' => esc_html__('Single Blog ( Main Title ) Background Overlay Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector' => '.zurf-blog-title-wrap .zurf-blog-title-overlay{ background-color: #gdlr#; }'
					),
					'single-blog-title-background-gradient-max-opacity' => array(
						'title' => esc_html__('Single Blog ( Main Title ) Background Gradient Max Opacity', 'zurf'),
						'type' => 'text',
						'default' => '1',
						'description' => esc_html__('Fill the number between 0.01 to 1', 'zurf')
					),
					'single-blog-title-background-gradient-color' => array(
						'title' => esc_html__('Single Blog ( Main Title ) Background Gradient Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'selector-extra' => true,
						'selector' => '.zurf-blog-title-wrap.zurf-feature-image .zurf-blog-title-top-overlay{ ' .
							'background: -webkit-linear-gradient(to top, rgba(#gdlra#, 0), rgba(#gdlra#, <single-blog-title-background-gradient-max-opacity>t)); ' . 
							'background: -o-linear-gradient(to top, rgba(#gdlra#, 0), rgba(#gdlra#, <single-blog-title-background-gradient-max-opacity>t)); ' . 
							'background: -moz-linear-gradient(to top, rgba(#gdlra#, 0), rgba(#gdlra#, <single-blog-title-background-gradient-max-opacity>t)); ' . 
							'background: linear-gradient(to top, rgba(#gdlra#, 0), rgba(#gdlra#, <single-blog-title-background-gradient-max-opacity>t)); }' .
							'.zurf-blog-title-wrap.zurf-feature-image .zurf-blog-title-bottom-overlay{ ' .
							'background: -webkit-linear-gradient(to bottom, rgba(#gdlra#, 0), rgba(#gdlra#, <single-blog-title-background-gradient-max-opacity>t)); ' . 
							'background: -o-linear-gradient(to bottom, rgba(#gdlra#, 0), rgba(#gdlra#, <single-blog-title-background-gradient-max-opacity>t)); ' . 
							'background: -moz-linear-gradient(to bottom, rgba(#gdlra#, 0), rgba(#gdlra#, <single-blog-title-background-gradient-max-opacity>t)); ' . 
							'background: linear-gradient(to bottom, rgba(#gdlra#, 0), rgba(#gdlra#, <single-blog-title-background-gradient-max-opacity>t)); }',
						'default' => '#000',
					),
					'single-blog-author-title-color' => array(
						'title' => esc_html__('Single Blog Author Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#464646',
						'selector' => '.zurf-single-author .zurf-single-author-title a, .zurf-single-author .zurf-single-author-title a:hover{ color: #gdlr#; }'
					),
					'single-blog-author-caption-color' => array(
						'title' => esc_html__('Single Blog Author Caption', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b1b1b1',
						'selector' => '.zurf-single-author .zurf-single-author-caption{ color: #gdlr#; }'
					),
					'single-blog-style-2-tags-color' => array(
						'title' => esc_html__('Single Blog Style 2 Tags Border/Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#343de9',
						'selector' => '.zurf-single-author-tags a, .zurf-single-author-tags a:hover{ color: #gdlr#; border-color: #gdlr#; }'
					),
					'single-blog-navigation-color' => array(
						'title' => esc_html__('Single Blog Navigation Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#bcbcbc',
						'selector' => '.zurf-single-nav a, .zurf-single-nav a:hover, .zurf-blog-style-3 .zurf-single-nav .zurf-text{ color: #gdlr#; }'
					),
					'single-blog-navigation2-left-overlay' => array(
						'title' => esc_html__('Single Blog Style 2 Navigation Left Overlay', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#343de9',
						'selector' => '.zurf-blog-style-2 .zurf-single-nav-area-left .zurf-single-nav-area-overlay{ background-color: #gdlr#; }'
					),
					'single-blog-navigation2-overlay' => array(
						'title' => esc_html__('Single Blog Style 2 Navigation Right Overlay', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#343de9',
						'selector' => '.zurf-blog-style-2 .zurf-single-nav-area-right .zurf-single-nav-area-overlay{ background-color: #gdlr#; }'
					),
					'single-blog-2-related-post-background' => array(
						'title' => esc_html__('Single Blog Style 2 Related Post Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f5f5f5',
						'selector' => '.zurf-blog-style-2 .zurf-single-related-post-wrap{ background-color: #gdlr#; }'
					),
					'single-blog-5-navigation-head-color' => array(
						'title' => esc_html__('Single Blog Style 5 Navigation Head Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#9e9e9e',
						'selector' => '.zurf-blog-style-5 .zurf-single-nav .zurf-text{ color: #gdlr#; }'
					),
					'single-blog-magazine-tags-text' => array(
						'title' => esc_html__('Single Blog Magazine Tags Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#272727',
						'selector' => '.zurf-single-magazine-author-tags a, .zurf-single-magazine-author-tags a:hover{ color: #gdlr#; }'
					),
					'single-blog-magazine-tags-background' => array(
						'title' => esc_html__('Single Blog Magazine Tags Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f2f2f2',
						'selector' => '.zurf-single-magazine-author-tags a{ background-color: #gdlr#; }'
					),
					'single-blog-magazine-author-background' => array(
						'title' => esc_html__('Single Blog Magazine Author Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f7f7f7',
						'selector' => '.zurf-blog-magazine .zurf-single-author{ background-color: #gdlr#; }'
					),
					'single-blog-comment-title-color' => array(
						'title' => esc_html__('Single Blog Comment Form Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#464646',
						'selector' => '.zurf-comments-area .zurf-comments-title, ' . 
							'.zurf-comments-area .comment-reply-title, .zurf-single-related-post-wrap .zurf-single-related-post-title{ color: #gdlr#; }'
					),
					'single-blog-comment-background-color' => array(
						'title' => esc_html__('Single Blog Comment Form Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f9f9f9',
						'selector' => '.zurf-comments-area .comment-respond{ background-color: #gdlr#; }'
					),
					'single-blog-comment-reply-color' => array(
						'title' => esc_html__('Single Comment Reply Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#bcbcbc',
						'selector' => '.zurf-comments-area .comment-reply a, .zurf-comments-area .comment-reply a:hover{ color: #gdlr#; }'
					),
					'single-blog-comment-time-color' => array(
						'title' => esc_html__('Single Comment Time Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b1b1b1',
						'selector' => '.zurf-comments-area .comment-time a, .zurf-comments-area .comment-time a:hover{ color: #gdlr#; }'
					),

				)
			), // single-blog

			'blog-color' => array(
				'title' => esc_html__('Blog / Pagination', 'zurf'),
				'options' => array(

					'blog-title-color' => array(
						'title' => esc_html__('Blog Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#343434',
						'selector' => '.gdlr-core-blog-title a, .zurf-body .zurf-single-article-title, .zurf-body .zurf-single-article-title a{ color: #gdlr#; }'
					),
					'blog-title-hover-color' => array(
						'title' => esc_html__('Blog Title Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#343434',
						'selector' => '.gdlr-core-blog-title a:hover, .zurf-body .zurf-single-article-title a:hover{ color: #gdlr#; }'
					),
					'blog-sticky-banner-color' => array(
						'title' => esc_html__('Blog Sticky Banner Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#444444',
						'selector' => '.gdlr-core-sticky-banner, .zurf-sticky-banner{ color: #gdlr#; }'
					),
					'blog-sticky-banner-background' => array(
						'title' => esc_html__('Blog Sticky Banner Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.gdlr-core-sticky-banner, .zurf-sticky-banner{ background-color: #gdlr#; }'
					),
					'blog-info-color' => array(
						'title' => esc_html__('Blog Info Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#959595',
						'selector' => '.zurf-single-article .zurf-blog-info-wrapper, .zurf-single-article .zurf-blog-info-wrapper a, ' . 
							'.zurf-single-article .zurf-blog-info-wrapper a:hover, .zurf-single-article .zurf-blog-info-wrapper i, ' .
							'.gdlr-core-blog-info-wrapper, .gdlr-core-blog-info-wrapper a, .gdlr-core-blog-info-wrapper a:hover, .gdlr-core-blog-info-wrapper i, ' .
							'.gdlr-core-blog-grid .gdlr-core-blog-info-date a{ color: #gdlr#; }'
					),
					'blog-date-day-color' => array(
						'title' => esc_html__('Blog Date Day Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#353535',
						'selector' => '.gdlr-core-blog-date-wrapper .gdlr-core-blog-date-day, .zurf-single-article .zurf-single-article-date-day{ color: #gdlr#; }'
					),
					'blog-date-month-color' => array(
						'title' => esc_html__('Blog Date Month Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#8a8a8a',
						'selector' => '.gdlr-core-blog-date-wrapper .gdlr-core-blog-date-month, .zurf-single-article .zurf-single-article-date-month{ color: #gdlr#; }'
					),
					'blog-frame-background-color' => array(
						'title' => esc_html__('Blog Frame Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f9f9f9',
						'selector' => '.gdlr-core-blog-grid.gdlr-core-blog-grid-with-frame, .gdlr-core-blog-full-frame, .gdlr-core-blog-list-frame, ' . 
							'.gdlr-core-blog-link-format, .gdlr-core-blog-column-hover-background{ background-color: #gdlr#; }'
					),
					'blog-modern-hover-background-color' => array(
						'title' => esc_html__('Blog Thumbnail ( Opacity ) Hover Background Color', 'zurf'),
						'type' => 'colorpicker', 
						'default' => '#000',
						'selector' => '.gdlr-core-opacity-on-hover{ background: #gdlr#; }'
					),
					'blog-thumbnail-category-background' => array(
						'title' => esc_html__('Blog Thumbnail Category Background Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#343de2',
						'selector' => '.gdlr-core-style-2 .gdlr-core-blog-thumbnail .gdlr-core-blog-info-category, ' .
							'.gdlr-core-blog-full.gdlr-core-style-3 .gdlr-core-blog-info-category, .gdlr-core-blog-grid.gdlr-core-style-3 .gdlr-core-blog-info-category{ background: #gdlr#; }' .
							'.gdlr-core-blog-feature .gdlr-core-blog-info-category{ background: #gdlr#; }'  . 
							'.gdlr-core-recent-post-widget-thumbnail .gdlr-core-blog-info-category{ background: #gdlr#; }'
					),
					'blog-thumbnail-date-background' => array(
						'title' => esc_html__('Blog Thumbnail Date Background Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#efefef',
						'selector' => '.gdlr-core-blog-full.gdlr-core-style-2-date .gdlr-core-blog-info-date,' . 
							'.gdlr-core-blog-grid.gdlr-core-style-2-date .gdlr-core-blog-info-date,' . 
							'.gdlr-core-blog-grid.gdlr-core-style-3-date.gdlr-core-with-thumbnail .gdlr-core-blog-info-date{ background-color: #gdlr#; }'
					),
					'blog-thumbnail-date-text' => array(
						'title' => esc_html__('Blog Thumbnail Date Text Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#3dbca8',
						'selector' => '.gdlr-core-blog-full.gdlr-core-style-2-date .gdlr-core-blog-info-date a,' .
							'.gdlr-core-blog-grid.gdlr-core-style-2-date .gdlr-core-blog-info-date a,' .
							'.gdlr-core-blog-grid.gdlr-core-style-3-date.gdlr-core-with-thumbnail .gdlr-core-blog-info-date a{ color: #gdlr#; }'
					),
					'blog-modern-text-color' => array(
						'title' => esc_html__('Blog Modern/Metro Overlay Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-blog-modern.gdlr-core-with-image .gdlr-core-blog-info-wrapper, ' .
							'.gdlr-core-blog-modern.gdlr-core-with-image .gdlr-core-blog-info-wrapper a, ' .
							'.gdlr-core-blog-modern.gdlr-core-with-image .gdlr-core-blog-info-wrapper i, ' .
							'.gdlr-core-blog-modern.gdlr-core-with-image .gdlr-core-blog-title a{ color: #gdlr#; } ' . 
							'.gdlr-core-blog-modern.gdlr-core-with-image .gdlr-core-blog-content{ color: #gdlr#; }' .
							'.gdlr-core-blog-metro.gdlr-core-with-image .gdlr-core-blog-info-wrapper, ' .
							'.gdlr-core-blog-metro.gdlr-core-with-image .gdlr-core-blog-info-wrapper a, ' .
							'.gdlr-core-blog-metro.gdlr-core-with-image .gdlr-core-blog-info-wrapper i, ' .
							'.gdlr-core-blog-metro.gdlr-core-with-image .gdlr-core-blog-title a{ color: #gdlr#; }'
					),
					'blog-aside-background-color' => array(
						'title' => esc_html__('Blog Quote / Aside Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2d9bea',
						'selector' => '.zurf-blog-aside-format .zurf-single-article-content, ' . 
							'.gdlr-core-blog-aside-format{ background-color: #gdlr#; }' . 
							'.zurf-blog-quote-format .zurf-single-article-content, ' . 
							'.gdlr-core-blog-quote-format{ background-color: #gdlr#; }'
					),
					'blog-aside-text-color' => array(
						'title' => esc_html__('Blog Quote / Aside Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-blog-aside-format .zurf-single-article-content, ' . 
							'.gdlr-core-blog-aside-format .gdlr-core-blog-content{ color: #gdlr#; }' . 
							'.zurf-blog-quote-format .zurf-single-article-content blockquote, ' . 
							'.zurf-blog-quote-format .zurf-single-article-content blockquote a, ' . 
							'.zurf-blog-quote-format .zurf-single-article-content q, ' . 
							'.zurf-blog-quote-format .zurf-single-article-content, ' . 
							'.gdlr-core-blog-quote-format .gdlr-core-blog-content blockquote,' .
							'.gdlr-core-blog-quote-format .gdlr-core-blog-content blockquote a,' .
							'.gdlr-core-blog-quote-format .gdlr-core-blog-content q,' .
							'.gdlr-core-blog-quote-format .gdlr-core-blog-content{ color: #gdlr#; }'
					),
					'pagination-background-color' => array(
						'title' => esc_html__('Pagination Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f0f0f0',
						'selector' => '.gdlr-core-pagination a{ background-color: #gdlr#; }' .
							'body .page-links > a, body .page-links > span.screen-reader-text, body .nav-links > a, body .nav-links > span.dots, body .page-links > span.page-links-title{ background-color: #gdlr#; }' .
							'.woocommerce nav.woocommerce-pagination ul li a{ background-color: #gdlr#; }'
					),
					'pagination-text-color' => array(
						'title' => esc_html__('Pagination Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#929292',
						'selector' => '.gdlr-core-pagination a{ color: #gdlr#; }' .
							'body .page-links > a, body .page-links > span.screen-reader-text, body .nav-links > a, body .nav-links > span.dots, body .page-links > span.page-links-title{ color: #gdlr#; }' . 
							'.woocommerce nav.woocommerce-pagination ul li a{ color: #gdlr#; }'
					),
					'pagination-background-hover-color' => array(
						'title' => esc_html__('Pagination Background Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2f9cea',
						'selector' => '.gdlr-core-pagination a:hover, .gdlr-core-pagination a.gdlr-core-active, .gdlr-core-pagination span{ background-color: #gdlr#; }' .
							'body .page-links > span, body .page-links > a:hover, body .nav-links > span.current, body .nav-links > a:hover{ background-color: #gdlr#; }' .
							'.woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover{ background-color: #gdlr#; }'
					),
					'pagination-text-hover-color' => array(
						'title' => esc_html__('Pagination Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-pagination a:hover, .gdlr-core-pagination a.gdlr-core-active, .gdlr-core-pagination span{ color: #gdlr#; }' .
							'body .page-links > span, body .page-links > a:hover, body .nav-links > span.current, body .nav-links > a:hover{ color: #gdlr#; }' .
							'.woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover{ color: #gdlr#; }'
					),
					'pagination-plain-color' => array(
						'title' => esc_html__('Pagination ( Border / Plain ) Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b4b4b4',
						'selector' => '.gdlr-core-pagination.gdlr-core-with-border a{ color: #gdlr#; border-color: #gdlr#; }' . 
							'.gdlr-core-pagination.gdlr-core-style-plain a, .gdlr-core-pagination.gdlr-core-style-plain a:before, .gdlr-core-pagination.gdlr-core-style-plain span:before{ color: #gdlr#; }'
					),
					'pagination-plain-hover-color' => array(
						'title' => esc_html__('Pagination ( Border / Plain ) Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#424242',
						'selector' => '.gdlr-core-pagination.gdlr-core-with-border a:hover, .gdlr-core-pagination.gdlr-core-with-border a.gdlr-core-active, .gdlr-core-pagination.gdlr-core-with-border span{ color: #gdlr#; border-color: #gdlr#; }' . 
							'.gdlr-core-pagination.gdlr-core-style-plain a:hover, .gdlr-core-pagination.gdlr-core-style-plain a.gdlr-core-active, .gdlr-core-pagination.gdlr-core-style-plain span{ color: #gdlr#; }'
					),

				) // footer-copyright-options
			), // footer-copyright-nav
	
			'event-color' => array(
				'title' => esc_html__('Event Color', 'zurf'),
				'options' => array(
					'event-item-date-color' => array(
						'title' => esc_html__('Event Item Date Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#50bd77',
						'selector' => '.gdlr-core-type-start-date-month .gdlr-core-date{ color: #gdlr#; }' . 
							'.gdlr-core-event-item-info.gdlr-core-type-start-date-month{ border-color: #gdlr#; }'
					),
					'event-item-month-color' => array(
						'title' => esc_html__('Event Item Date Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#152647',
						'selector' => '.gdlr-core-type-start-date-month .gdlr-core-month{ color: #gdlr#; }'
					),
					'event-item-title-color' => array(
						'title' => esc_html__('Event Item Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#182847',
						'selector' => '.gdlr-core-event-item-list .gdlr-core-event-item-title a, .gdlr-core-event-item-list .gdlr-core-event-item-title a:hover{ color: #gdlr#; }'
					),
					'event-item-info-color' => array(
						'title' => esc_html__('Event Item Info Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#50bd77',
						'selector' => '.gdlr-core-event-item .gdlr-core-event-item-info-wrap{ color: #gdlr#; }'
					),
				)
			),
			
			'port-color' => array(
				'title' => esc_html__('Portfolio Color', 'zurf'),
				'options' => array(
				
					'single-portfolio-nav-color' => array(
						'title' => esc_html__('Single Portfolio Navigation Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#bcbcbc',
						'selector' => '.gdlr-core-portfolio-single-nav, .gdlr-core-portfolio-single-nav a, .gdlr-core-portfolio-single-nav a:hover, ' . 
							'.gdlr-core-portfolio-single-nav-wrap.gdlr-core-style-2 .gdlr-core-portfolio-single-nav-middle i{ color: #gdlr#; }'
					),
					'single-portfolio-nav-icon' => array(
						'title' => esc_html__('Single Portfolio Navigation Icon (Style 2)', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#4275dc',
						'selector' => '.gdlr-core-portfolio-single-nav-wrap.gdlr-core-style-2 .gdlr-core-portfolio-single-nav i{ color: #gdlr#; }'
					),
					'single-portfolio-nav-background' => array(
						'title' => esc_html__('Single Portfolio Navigation Background (Style 2)', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.gdlr-core-portfolio-single-nav-wrap.gdlr-core-style-2 .gdlr-core-portfolio-single-nav i, ' . 
							'.gdlr-core-portfolio-single-nav-wrap.gdlr-core-style-2 .gdlr-core-portfolio-single-nav-middle{ background-color: #gdlr#; }'
					),
					'portfolio-frame-background-color' => array(
						'title' => esc_html__('Portfolio Frame Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f5f5f5',
						'selector' => '.gdlr-core-portfolio-grid.gdlr-core-style-with-frame .gdlr-core-portfolio-grid-frame, ' . 
							'.gdlr-core-portfolio-grid2{ background-color: #gdlr#; }'
					),
					'portfolio-title-color' => array(
						'title' => esc_html__('Portfolio Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-portfolio-content-wrap .gdlr-core-portfolio-title a{ color: #gdlr#; }'
					),
					'portfolio-title-hover-color' => array(
						'title' => esc_html__('Portfolio Title Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'selector' => '.gdlr-core-portfolio-content-wrap .gdlr-core-portfolio-title a:hover{ color: #gdlr#; }'
					),
					'portfolio-info-head-color' => array(
						'title' => esc_html__('Port Info Head Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#343434',
						'selector' => '.gdlr-core-port-info-item .gdlr-core-port-info-key, .gdlr-core-port-info2 .gdlr-core-port-info2-key{ color: #gdlr#; }'
					),
					'portfolio-info-color' => array(
						'title' => esc_html__('Portfolio Info Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b1b1b1',
						'selector' => '.gdlr-core-portfolio-content-wrap .gdlr-core-portfolio-info, ' .
							'.gdlr-core-portfolio-content-wrap .gdlr-core-portfolio-info a, ' .
							'.gdlr-core-portfolio-content-wrap .gdlr-core-portfolio-info a:hover{ color: #gdlr#; }'
					),
					'portfolio-medium-feature-content-bg-color' => array(
						'title' => esc_html__('Portfolio Medium Feature Content Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2653e3',
						'selector' => '.gdlr-core-portfolio-medium-feature .gdlr-core-portfolio-content-wrap{ background-color: #gdlr#; }'
					),
					'portfolio-medium-feature-title-color' => array(
						'title' => esc_html__('Portfolio Medium Feature Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-portfolio-medium-feature .gdlr-core-portfolio-title a, .gdlr-core-portfolio-medium-feature .gdlr-core-portfolio-title a:hover{ color: #gdlr#; }'
					),
					'portfolio-medium-feature-tag-color' => array(
						'title' => esc_html__('Portfolio Medium Feature Tag Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#abbfff',
						'selector' => '.gdlr-core-portfolio-medium-feature .gdlr-core-portfolio-info, .gdlr-core-portfolio-medium-feature .gdlr-core-portfolio-info a, .gdlr-core-portfolio-medium-feature .gdlr-core-portfolio-info a:hover{ color: #gdlr#; }'
					),
					'portfolio-grid2-tag-background' => array(
						'title' => esc_html__('Portfolio Grid2 Tag Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#3d3ac2',
						'selector' => '.gdlr-core-portfolio-grid2 .gdlr-core-portfolio-content-wrap .gdlr-core-portfolio-info{ background-color: #gdlr#; }'
					),
					'portfolio-badge-text-color' => array(
						'title' => esc_html__('Portfolio Badge Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-portfolio-badge{ color: #gdlr#; }'
					),
					'portfolio-badge-background-color' => array(
						'title' => esc_html__('Portfolio Badge Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e24a3b',
						'selector' => '.gdlr-core-portfolio-badge{ background-color: #gdlr#; }'
					),
					'portfolio-thumbnail-title-color' => array(
						'title' => esc_html__('Portfolio Thumbnail Title/Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-icon, ' .
							'.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-title a, ' .
							'.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-title a:hover{ color: #gdlr#; }'
					),
					'portfolio-thumbnail-info-color' => array(
						'title' => esc_html__('Portfolio Thumbnail Info Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#cecece',
						'selector' => '.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-info, ' .
							'.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-info a, ' .
							'.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-info a:hover{ color: #gdlr#; }'
					),
					'portfolio-text-filter-color' => array(
						'title' => esc_html__('Portfolio Filter Text Color( Text Style ) ', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#aaaaaa',
						'selector' => '.gdlr-core-filterer-wrap.gdlr-core-style-text a{ color: #gdlr#; }'
					),
					'portfolio-text-filter-active-color' => array(
						'title' => esc_html__('Portfolio Filter Text Active Color( Text Style ) ', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#747474',
						'selector' => '.gdlr-core-filterer-wrap.gdlr-core-style-text a:hover, .gdlr-core-filterer-wrap.gdlr-core-style-text a.gdlr-core-active{ color: #gdlr#; }' . 
							'.gdlr-core-filterer-wrap.gdlr-core-style-text .gdlr-core-filterer-slide-bar{ border-bottom-color: #gdlr#; }' .
							'.gdlr-core-filterer-wrap.gdlr-core-round-slide-bar .gdlr-core-filterer-slide-bar:before{ background-color: #gdlr#; }'
					),
					'portfolio-button-filter-text-color' => array(
						'title' => esc_html__('Portfolio Filter Button Text Color ( Button Style ) ', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#838383',
						'selector' => '.gdlr-core-filterer-wrap.gdlr-core-style-button a{ color: #gdlr#; }'
					),
					'portfolio-button-filter-background-color' => array(
						'title' => esc_html__('Portfolio Filter Button Background Color ( Button Style ) ', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f1f1f1',
						'selector' => '.gdlr-core-filterer-wrap.gdlr-core-style-button a{ background-color: #gdlr#; }'
					),
					'portfolio-button-filter-text-active-color' => array(
						'title' => esc_html__('Portfolio Filter Button Text Active Color ( Button Style ) ', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-filterer-wrap.gdlr-core-style-button a:hover, .gdlr-core-filterer-wrap.gdlr-core-style-button a.gdlr-core-active{ color: #gdlr#; }'
					),
					'portfolio-button-filter-background-active-color' => array(
						'title' => esc_html__('Portfolio Filter Button Background Active Color ( Button Style ) ', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2f9cea',
						'selector' => '.gdlr-core-filterer-wrap.gdlr-core-style-button a:hover, .gdlr-core-filterer-wrap.gdlr-core-style-button a.gdlr-core-active{ background-color: #gdlr#; }'
					),

				) // options
			), // port-color

			'price-table-color' => array(
				'title' => esc_html__('Price Table', 'zurf'),
				'options' => array(

					'price-table-background-color' => array(
						'title' => esc_html__('Price Table Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f8f8f8',
						'selector' => '.gdlr-core-price-table-item .gdlr-core-price-table{ background-color: #gdlr#; }'
					),					
					'price-table-head-color' => array(
						'title' => esc_html__('Price Table Head', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#3e3e3e',
						'selector-extra' => true,
						'selector' => '.gdlr-core-price-table .gdlr-core-price-table-head{ background-color: #gdlr#; ' .
							'background: -webkit-linear-gradient(<price-table-head-top-gradient-color>, #gdlr#); ' . 
							'background: -o-linear-gradient(<price-table-head-top-gradient-color>, #gdlr#); ' . 
							'background: -moz-linear-gradient(<price-table-head-top-gradient-color>, #gdlr#); ' . 
							'background: linear-gradient(<price-table-head-top-gradient-color>, #gdlr#); }'
					),					
					'price-table-head-top-gradient-color' => array(
						'title' => esc_html__('Price Table Head Top Gradient', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#525252'
					),					
					'price-table-icon-color' => array(
						'title' => esc_html__('Price Table Icon', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-price-table .gdlr-core-price-table-icon{ color: #gdlr#; }'
					),					
					'price-table-title-color' => array(
						'title' => esc_html__('Price Table Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-price-table .gdlr-core-price-table-title{ color: #gdlr#; }'
					),					
					'price-table-caption-color' => array(
						'title' => esc_html__('Price Table Caption', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#acacac',
						'selector' => '.gdlr-core-price-table .gdlr-core-price-table-caption{ color: #gdlr#; }'
					),					
					'price-table-price-background-color' => array(
						'title' => esc_html__('Price Table Price Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ebebeb',
						'selector' => '.gdlr-core-price-table .gdlr-core-price-table-price{ background-color: #gdlr#; }'
					),					
					'price-table-price-color' => array(
						'title' => esc_html__('Price Table Price Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#323232',
						'selector' => '.gdlr-core-price-table .gdlr-core-price-table-price-number, .gdlr-core-price-table .gdlr-core-price-prefix{ color: #gdlr#; }'
					),					
					'price-table-price-suffix-color' => array(
						'title' => esc_html__('Price Table Price Suffix', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#acacac',
						'selector' => '.gdlr-core-price-table .gdlr-core-price-suffix{ color: #gdlr#; }'
					),
					'price-table-price-button-color' => array(
						'title' => esc_html__('Price Table Button Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => 'body .gdlr-core-price-table .gdlr-core-price-table-button, body .gdlr-core-price-table .gdlr-core-price-table-button:hover{ color: #gdlr#; }'
					),
					'price-table-button-background-color' => array(
						'title' => esc_html__('Price Table Button Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#575757',
						'selector-extra' => true,
						'selector' => 'body .gdlr-core-price-table .gdlr-core-price-table-button, body .gdlr-core-price-table .gdlr-core-price-table-button:hover{ background-color: #gdlr#; ' .
							'background: -webkit-linear-gradient(<price-table-button-background-top-gradient-color>, #gdlr#); ' . 
							'background: -o-linear-gradient(<price-table-button-background-top-gradient-color>, #gdlr#); ' . 
							'background: -moz-linear-gradient(<price-table-button-background-top-gradient-color>, #gdlr#); ' . 
							'background: linear-gradient(<price-table-button-background-top-gradient-color>, #gdlr#); }'
					),
					'price-table-button-background-top-gradient-color' => array(
						'title' => esc_html__('Price Table Button Background Top Gradient', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#414141',
					),
					'price-table-list-border-color' => array(
						'title' => esc_html__('Price Table List Border', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e5e5e5',
						'selector' => '.gdlr-core-price-table .gdlr-core-price-table-content *{ border-color: #gdlr#; }'
					),
					'price-table-active-head-color' => array(
						'title' => esc_html__('Price Table Head', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#329eec',
						'selector-extra' => true,
						'selector' => '.gdlr-core-price-table.gdlr-core-active .gdlr-core-price-table-head{ background-color: #gdlr#; ' .
							'background: -webkit-linear-gradient(<price-table-active-head-top-gradient-color>, #gdlr#); ' . 
							'background: -o-linear-gradient(<price-table-active-head-top-gradient-color>, #gdlr#); ' . 
							'background: -moz-linear-gradient(<price-table-active-head-top-gradient-color>, #gdlr#); ' . 
							'background: linear-gradient(<price-table-active-head-top-gradient-color>, #gdlr#); }'
					),					
					'price-table-active-head-top-gradient-color' => array(
						'title' => esc_html__('Price Table Head Top Gradient', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#59b9fe'
					),
					'price-table-active-icon-color' => array(
						'title' => esc_html__('Price Table Icon', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-price-table.gdlr-core-active .gdlr-core-price-table-icon{ color: #gdlr#; }'
					),					
					'price-table-active-title-color' => array(
						'title' => esc_html__('Price Table Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-price-table.gdlr-core-active .gdlr-core-price-table-title{ color: #gdlr#; }'
					),					
					'price-table-active-caption-color' => array(
						'title' => esc_html__('Price Table Caption', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b1d8f5',
						'selector' => '.gdlr-core-price-table.gdlr-core-active .gdlr-core-price-table-caption{ color: #gdlr#; }'
					),
					'price-table-active-price-background-color' => array(
						'title' => esc_html__('Price Table Price Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-price-table.gdlr-core-active .gdlr-core-price-table-price{ background-color: #gdlr#; }'
					),					
					'price-table-active-price-color' => array(
						'title' => esc_html__('Price Table Price Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#323232',
						'selector' => '.gdlr-core-price-table.gdlr-core-active .gdlr-core-price-table-price-number, .gdlr-core-price-table .gdlr-core-price-prefix{ color: #gdlr#; }'
					),					
					'price-table-active-price-suffix-color' => array(
						'title' => esc_html__('Price Table Price Suffix', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#acacac',
						'selector' => '.gdlr-core-price-table.gdlr-core-active .gdlr-core-price-suffix{ color: #gdlr#; }'
					),
					'price-table-active-price-button-color' => array(
						'title' => esc_html__('Price Table Button Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => 'body .gdlr-core-price-table.gdlr-core-active .gdlr-core-price-table-button, body .gdlr-core-price-table .gdlr-core-price-table-button:hover{ color: #gdlr#; }'
					),
					'price-table-active-button-background-color' => array(
						'title' => esc_html__('Price Table Button Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#319dea',
						'selector-extra' => true,
						'selector' => 'body .gdlr-core-price-table.gdlr-core-active .gdlr-core-price-table-button, body .gdlr-core-price-table .gdlr-core-price-table-button:hover{ background-color: #gdlr#; ' .
							'background: -webkit-linear-gradient(<price-table-active-button-background-top-gradient-color>, #gdlr#); ' . 
							'background: -o-linear-gradient(<price-table-active-button-background-top-gradient-color>, #gdlr#); ' . 
							'background: -moz-linear-gradient(<price-table-active-button-background-top-gradient-color>, #gdlr#); ' . 
							'background: linear-gradient(<price-table-active-button-background-top-gradient-color>, #gdlr#); }'
					),
					'price-table-active-button-background-top-gradient-color' => array(
						'title' => esc_html__('Price Table Button Background Top Gradient', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#52aae9',
					),					

				)
			), // price table

			'element-1-color' => array(
				'title' => esc_html__('Element A,B', 'zurf'),
				'options' => array(
				
					'accordion-normal-icon-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-accordion-style-icon .gdlr-core-accordion-item-icon, ' .
							'.gdlr-core-accordion-style-box-icon .gdlr-core-accordion-item-icon, ' .
							'.gdlr-core-toggle-box-style-icon .gdlr-core-toggle-box-item-icon, ' .
							'.gdlr-core-toggle-box-style-box-icon .gdlr-core-toggle-box-item-icon{ color: #gdlr#; }'
					),
					'accordion-normal-title-head-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Title Head Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-accordion-style-icon .gdlr-core-accordion-item-title .gdlr-core-head, ' . 
							'.gdlr-core-accordion-style-box-icon .gdlr-core-accordion-item-title .gdlr-core-head, ' . 
							'.gdlr-core-toggle-box-style-icon .gdlr-core-toggle-box-item-title .gdlr-core-head, ' . 
							'.gdlr-core-toggle-box-style-box-icon .gdlr-core-toggle-box-item-title .gdlr-core-head{ color: #gdlr#; }'
					),
					'accordion-normal-title-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-accordion-style-icon .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-accordion-style-box-icon .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-toggle-box-style-icon .gdlr-core-toggle-box-item-title, ' .
							'.gdlr-core-toggle-box-style-box-icon .gdlr-core-toggle-box-item-title{ color: #gdlr#; }'
					),
					'accordion-normal-icon-background-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Icon Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.gdlr-core-accordion-style-box-icon .gdlr-core-accordion-item-icon, ' . 
							'.gdlr-core-toggle-box-style-box-icon .gdlr-core-toggle-box-item-icon{ background-color: #gdlr#; }' . 
							'.gdlr-core-accordion-style-box-icon .gdlr-core-accordion-item-icon, ' .
							'.gdlr-core-toggle-box-style-box-icon .gdlr-core-toggle-box-item-icon{ border-color: #gdlr#; }'
					),

					'accordion-icon-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Icon Color ( Background Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-accordion-style-background-title-icon .gdlr-core-accordion-item-title:before, ' .
							'.gdlr-core-toggle-box-style-background-title-icon .gdlr-core-accordion-item-title:before{ color: #gdlr#; }' .
							'.gdlr-core-accordion-style-box-background .gdlr-core-accordion-item-title:before, ' .
							'.gdlr-core-toggle-box-style-box-background .gdlr-core-accordion-item-title:before{ color: #gdlr#; } '

					),
					'accordion-title-head-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Title Head Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-accordion-style-background-title .gdlr-core-accordion-item-title .gdlr-core-head, ' . 
							'.gdlr-core-accordion-style-background-title-icon .gdlr-core-accordion-item-title .gdlr-core-head, ' . 
							'.gdlr-core-toggle-box-style-background-title .gdlr-core-toggle-box-item-title .gdlr-core-head, ' . 
							'.gdlr-core-toggle-box-style-background-title-icon .gdlr-core-toggle-box-item-title .gdlr-core-head{ color: #gdlr#; }'  .
							'.gdlr-core-accordion-style-box-background .gdlr-core-accordion-item-title .gdlr-core-head, ' .
							'.gdlr-core-toggle-box-style-box-background .gdlr-core-toggle-box-item-title .gdlr-core-head{ color: #gdlr#; } '
					),
					'accordion-title-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Title Color ( Background Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-accordion-style-background-title .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-accordion-style-background-title-icon .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-toggle-box-style-background-title .gdlr-core-toggle-box-item-title, ' .
							'.gdlr-core-toggle-box-style-background-title-icon .gdlr-core-toggle-box-item-title{ color: #gdlr#; }' . 
							'.gdlr-core-accordion-style-box-background .gdlr-core-accordion-item-title, ' .
							'.gdlr-core-toggle-box-style-box-background .gdlr-core-toggle-box-item-title{ color: #gdlr#; } '
					),
					'accordion-title-background-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Title Background Color ( Background Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.gdlr-core-accordion-style-background-title .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-accordion-style-background-title-icon .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-toggle-box-style-background-title .gdlr-core-toggle-box-item-title, ' .
							'.gdlr-core-toggle-box-style-background-title-icon .gdlr-core-toggle-box-item-title{ background-color: #gdlr#; }' . 
							'.gdlr-core-accordion-style-box-background .gdlr-core-accordion-item-title, ' .
							'.gdlr-core-toggle-box-style-box-background .gdlr-core-toggle-box-item-title{ background-color: #gdlr#; }'
					),				
					'accordion-icon-active-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Icon Active Color ( Background Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-accordion-style-background-title-icon .gdlr-core-active .gdlr-core-accordion-item-title:before, ' . 
							'.gdlr-core-toggle-box-style-background-title-icon .gdlr-core-active .gdlr-core-accordion-item-title:before{ color: #gdlr#; }' . 
							'.gdlr-core-accordion-style-box-background .gdlr-core-active .gdlr-core-accordion-item-title:before, ' . 
							'.gdlr-core-toggle-box-style-box-background .gdlr-core-active .gdlr-core-accordion-item-title:before{ color: #gdlr#; }'
					),
					'accordion-title-active-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Title Text Active Color ( Background Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-accordion-style-background-title .gdlr-core-active .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-accordion-style-background-title-icon .gdlr-core-active .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-toggle-box-style-background-title .gdlr-core-active .gdlr-core-toggle-box-item-title, ' .
							'.gdlr-core-toggle-box-style-background-title-icon .gdlr-core-active .gdlr-core-toggle-box-item-title{ color: #gdlr#; }' . 
							'.gdlr-core-accordion-style-box-background .gdlr-core-active .gdlr-core-accordion-item-title, ' .
							'.gdlr-core-toggle-box-style-box-background .gdlr-core-active .gdlr-core-toggle-box-item-title{ color: #gdlr#; } '
					),
					'accordion-title-background-active-color' => array(
						'title' => esc_html__('Accordion / Toggle Box Title Background Active Color ( Background Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.gdlr-core-accordion-style-background-title .gdlr-core-active .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-accordion-style-background-title-icon .gdlr-core-active .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-toggle-box-style-background-title .gdlr-core-active .gdlr-core-toggle-box-item-title, ' .
							'.gdlr-core-toggle-box-style-background-title-icon .gdlr-core-active .gdlr-core-toggle-box-item-title{ background-color: #gdlr#; }' .
							'.gdlr-core-accordion-style-box-background .gdlr-core-active .gdlr-core-accordion-item-title, ' . 
							'.gdlr-core-toggle-box-style-box-background .gdlr-core-active .gdlr-core-toggle-box-item-title{ background-color: #gdlr#; }'
					),
					'audio-background-color' => array(
						'title' => esc_html__('Audio Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e7e7e7',
						'selector' => '.gdlr-core-audio, .gdlr-core-audio .mejs-container .mejs-controls{ background-color: #gdlr#; }'
					),
					'audio-text-color' => array(
						'title' => esc_html__('Audio Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#202020',
						'selector' => '.gdlr-core-audio .mejs-container .mejs-controls .mejs-volume-button:before, ' . 
							'.gdlr-core-audio .mejs-container .mejs-controls .mejs-playpause-button:before, ' . 
							'.gdlr-core-audio .mejs-container .mejs-controls .mejs-time{ color: #gdlr#; }'
					),
					'audio-content-background-color' => array(
						'title' => esc_html__('Audio Content Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#afafaf',
						'selector' => '.gdlr-core-audio .mejs-controls .mejs-time-rail .mejs-time-total, ' .
							'.gdlr-core-audio .mejs-controls .mejs-time-rail .mejs-time-loaded{ background-color: #gdlr#; }'
					),
					'audio-content-progress-color' => array(
						'title' => esc_html__('Audio Content Progress Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2d9bea',
						'selector' => '.gdlr-core-audio .mejs-controls .mejs-time-rail .mejs-time-current{ background-color: #gdlr#; }'
					),
					'audio-volume-background-color' => array(
						'title' => esc_html__('Audio Volume Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#afafaf',
						'selector' => '.gdlr-core-audio .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total{ background-color: #gdlr#; }'
					),
					'audio-volume-progress-color' => array(
						'title' => esc_html__('Audio Volume Progress Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#646464',
						'selector' => '.gdlr-core-audio .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{ background-color: #gdlr#; }'
					),
					'alert-box-item-background-color' => array(
						'title' => esc_html__('Alert Box Item Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ef5e68',
						'selector' => '.gdlr-core-alert-box-item .gdlr-core-alert-box-item-inner{ background-color: #gdlr#; }'
					),				
					'alert-box-item-border-color' => array(
						'title' => esc_html__('Alert Box Item Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#cd515a',
						'selector' => '.gdlr-core-alert-box-item .gdlr-core-alert-box-item-inner{ border-color: #gdlr#; }'
					),				
					'alert-box-item-content-color' => array(
						'title' => esc_html__('Alert Box Item Content Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-alert-box-item .gdlr-core-alert-box-item-inner{ color: #gdlr#; }'
					),				
					'alert-box-item-title-color' => array(
						'title' => esc_html__('Alert Box Item Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-alert-box-item .gdlr-core-alert-box-item-title{ color: #gdlr#; }'
					),	
					'blockquote-text-color' => array(
						'title' => esc_html__('Blockquote Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#777777',
						'selector' => 'blockquote, q{ color: #gdlr#; }'
					),	
					'blockquote-background-color' => array(
						'title' => esc_html__('Blockquote Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f5f5f5',
						'selector' => 'blockquote, q, pre{ background-color: #gdlr#; }'
					),	
					'blockquote-border-color' => array(
						'title' => esc_html__('Blockquote Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e2e2e2',
						'selector' => '.zurf-body blockquote, .zurf-body q{ border-color: #gdlr#; }'
					),	
					'blockquote-item-icon-color' => array(
						'title' => esc_html__('Blockquote Item Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#4e4e4e',
						'selector' => '.gdlr-core-blockquote-item-quote{ color: #gdlr#; }'
					),		
					'blockquote-item-content-color' => array(
						'title' => esc_html__('Blockquote Item Content Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#4e4e4e',
						'selector' => '.gdlr-core-blockquote-item-content, .gdlr-core-blockquote-item-author, pre{ color: #gdlr#; }'
					),

				) // options
			), // element-1-color

			'element-2-color' => array(
				'title' => esc_html__('Element B,C,D', 'zurf'),
				'options' => array(

					'button-text-color' => array(
						'title' => esc_html__('Button Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-body .gdlr-core-load-more, .gdlr-core-body .gdlr-core-button, .zurf-body .zurf-button, ' .
							'.zurf-body input[type="button"], .zurf-body input[type="submit"]{ color: #gdlr#; }'
					),
					'button-text-hover-color' => array(
						'title' => esc_html__('Button Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-body .gdlr-core-load-more:hover, .gdlr-core-body .gdlr-core-button:hover, .zurf-body .zurf-button:hover{ color: #gdlr#; }'
					),
					'button-background-color' => array(
						'title' => esc_html__('Button Background Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#2F2F2F',
						'selector' => '.gdlr-core-body .gdlr-core-load-more, .gdlr-core-body .gdlr-core-button, .zurf-body .zurf-button, ' .
							'.zurf-body input[type="button"], .zurf-body input[type="submit"]{ background-color: #gdlr#; }' .
							'.zurf-blog-style-4 .zurf-comments-area .form-submit input[type="submit"]{ box-shadow: 5px 5px 20px rgba(#gdlra#, 0.4); -webkit-box-shadow: 5px 5px 20px rgba(#gdlra#, 0.4); -moz-box-shadow: 5px 5px 20px rgba(#gdlra#, 0.4); }'
					),
					'button-background-hover-color' => array(
						'title' => esc_html__('Button Background Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2F2F2F',
						'selector' => '.gdlr-core-body .gdlr-core-load-more:hover, .gdlr-core-body .gdlr-core-button:hover{ background-color: #gdlr#; }'
					),
					'button-border-color' => array(
						'title' => esc_html__('Button Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector' => '.gdlr-core-body .gdlr-core-button-with-border{ border-color: #gdlr#; } ' .
							'.gdlr-core-body .gdlr-core-button-with-border.gdlr-core-button-transparent{ color: #gdlr#; }'
					),
					'button-border-hover-color' => array(
						'title' => esc_html__('Button Border Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector' => '.gdlr-core-body .gdlr-core-button-with-border:hover{ border-color: #gdlr#; }' . 
							'.gdlr-core-body .gdlr-core-button-with-border.gdlr-core-button-transparent:hover{ color: #gdlr#; }'
					),
					'button-gradient-background-color' => array(
						'title' => esc_html__('Button ( Gradient Style ) Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#309cea',
						'selector-extra' => true,
						'selector' => '.gdlr-core-body .gdlr-core-button.gdlr-core-button-gradient{ background-color: #gdlr#; ' .
    						'background: -webkit-linear-gradient(<button-top-gradient-background-color>, #gdlr#); ' .
    						'background: -o-linear-gradient(<button-top-gradient-background-color>, #gdlr#); ' .
    						'background: -moz-linear-gradient(<button-top-gradient-background-color>, #gdlr#); ' .
							'background: linear-gradient(<button-top-gradient-background-color>, #gdlr#); }' . 
							'.gdlr-core-body .gdlr-core-button.gdlr-core-button-gradient-v{ background-color: #gdlr#; ' .
    						'background: -webkit-linear-gradient(to right, <button-top-gradient-background-color>, #gdlr#); ' .
    						'background: -o-linear-gradient(to right, <button-top-gradient-background-color>, #gdlr#); ' .
    						'background: -moz-linear-gradient(to right, <button-top-gradient-background-color>, #gdlr#); ' .
							'background: linear-gradient(to right, <button-top-gradient-background-color>, #gdlr#); }'
					),
					'button-top-gradient-background-color' => array(
						'title' => esc_html__('Button ( Gradient Style ) Top Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#52aae9'
					),
					'call-to-action-title-color' => array(
						'title' => esc_html__('Call To Action Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2c2c2c',
						'selector' => '.gdlr-core-call-to-action-item-title{ color: #gdlr#; }'
					),			
					'call-to-action-caption-color' => array(
						'title' => esc_html__('Call To Action Caption Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#535353',
						'selector' => '.gdlr-core-call-to-action-item-caption{ color: #gdlr#; }'
					),
					'counter-item-top-text-color' => array(
						'title' => esc_html__('Counter Item Top Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#828282',
						'selector' => '.gdlr-core-counter-item-top-text{ color: #gdlr#; }'
					),		
					'counter-item-top-icon-color' => array(
						'title' => esc_html__('Counter Item Top Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#393939',
						'selector' => '.gdlr-core-counter-item-top-icon{ color: #gdlr#; }'
					),		
					'counter-item-number-color' => array(
						'title' => esc_html__('Counter Item Number Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#393939',
						'selector' => '.gdlr-core-counter-item-number{ color: #gdlr#; }'
					),		
					'counter-item-divider-color' => array(
						'title' => esc_html__('Counter Item Divider Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#393939',
						'selector' => '.gdlr-core-counter-item-divider{ border-color: #gdlr#; }'
					),		
					'counter-item-bottom-text-color' => array(
						'title' => esc_html__('Counter Item Bottom Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#393939',
						'selector' => '.gdlr-core-counter-item-bottom-text{ color: #gdlr#; }'
					),
					'column-service-icon-color' => array(
						'title' => esc_html__('Column Service Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#9d9d9d',
						'selector' => '.gdlr-core-column-service-item .gdlr-core-column-service-icon{ color: #gdlr#; }'
					),
					'column-service-icon-background' => array(
						'title' => esc_html__('Column Service Icon Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.gdlr-core-column-service-item .gdlr-core-icon-style-round i{ background-color: #gdlr#; }'
					),
					'column-service-title-color' => array(
						'title' => esc_html__('Column Service Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector' => '.gdlr-core-column-service-item .gdlr-core-column-service-title{ color: #gdlr#; }'
					),
					'column-service-caption-color' => array(
						'title' => esc_html__('Column Service Caption Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#747474',
						'selector' => '.gdlr-core-column-service-item .gdlr-core-column-service-caption{ color: #gdlr#; }'
					),
					'dropdown-tab-head-background' => array(
						'title' => esc_html__('Dropdown Tab Head Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f7c02e',
						'selector' => '.gdlr-core-dropdown-tab .gdlr-core-dropdown-tab-title, ' .
							'.gdlr-core-dropdown-tab .gdlr-core-dropdown-tab-head-wrap{ background-color: #gdlr#; }'
					),
					'dropdown-tab-head-text' => array(
						'title' => esc_html__('Dropdown Tab Head Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#252525',
						'selector' => '.gdlr-core-dropdown-tab .gdlr-core-dropdown-tab-title{ color: #gdlr#; }'
					),

				) // options
			), // element-2-color

			'element-3-color' => array(
				'title' => esc_html__('Element F,G,I,O,P', 'zurf'),
				'options' => array(

					'flipbox-background-color' => array(
						'title' => esc_html__('Flipbox / Feature Box Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2d9bea',
						'selector' => '.gdlr-core-flipbox-item .gdlr-core-flipbox-front, ' .
							'.gdlr-core-flipbox-item .gdlr-core-flipbox-back, ' .
							'.gdlr-core-feature-box-item .gdlr-core-feature-box{ background-color: #gdlr#; }'
					),
					'flipbox-border-color' => array(
						'title' => esc_html__('Flipbox / Feature Box Border', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2a80be',
						'selector' => '.gdlr-core-flipbox-item .gdlr-core-flipbox-front, ' .
							'.gdlr-core-flipbox-item .gdlr-core-flipbox-back, ' .
							'.gdlr-core-flipbox-item .gdlr-core-flipbox-frame, ' .
							'.gdlr-core-feature-box-item .gdlr-core-feature-box, ' .
							'.gdlr-core-feature-box-item .gdlr-core-feature-box-frame{ border-color: #gdlr#; }'
					),
					'flipbox-icon-color' => array(
						'title' => esc_html__('Flipbox / Feature Box Icon', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-flipbox-item .gdlr-core-flipbox-item-icon, .gdlr-core-feature-box-item .gdlr-core-feature-box-item-icon{ color: #gdlr#; }'
					),
					'flipbox-title-color' => array(
						'title' => esc_html__('Flipbox / Feature Box Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-flipbox-item .gdlr-core-flipbox-item-title, .gdlr-core-feature-box-item .gdlr-core-feature-box-item-title{ color: #gdlr#; }'
					),
					'flipbox-caption-color' => array(
						'title' => esc_html__('Flipbox / Feature Box Caption', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-flipbox-item .gdlr-core-flipbox-item-caption, .gdlr-core-feature-box-item .gdlr-core-feature-box-item-caption{ color: #gdlr#; }'
					),
					'flipbox-content-color' => array(
						'title' => esc_html__('Flipbox / Feature Box Content', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-flipbox-item .gdlr-core-flipbox-item-content, .gdlr-core-feature-box-item .gdlr-core-feature-box-item-content{ color: #gdlr#; }'
					),
					'gallery-overlay-title' => array(
						'title' => esc_html__('Gallery Overlay Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-image-overlay.gdlr-core-gallery-image-overlay .gdlr-core-image-overlay-title{ color: #gdlr#; }'
					),
					'gallery-overlay-caption' => array(
						'title' => esc_html__('Gallery Overlay Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#cecece',
						'selector' => '.gdlr-core-image-overlay.gdlr-core-gallery-image-overlay .gdlr-core-image-overlay-caption{ color: #gdlr#; }'
					),
					'image-overlay-background-color' => array(
						'title' => esc_html__('Image Overlay Background', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector' => '.gdlr-core-image-overlay{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.6); }'
					),
					'image-overlay-icon-color' => array(
						'title' => esc_html__('Image Overlay Icon', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-image-overlay-content, .gdlr-core-image-overlay-content a, .gdlr-core-image-overlay-icon{ color: #gdlr#; }' .
							'.gdlr-core-page-builder-body [data-skin] .gdlr-core-image-overlay-icon, ' .
							'.gdlr-core-page-builder-body .gdlr-core-pbf-column[data-skin] .gdlr-core-image-overlay-icon{ color: #gdlr#; }'
					),
					'image-overlay-icon-background' => array(
						'title' => esc_html__('Image Overlay Icon Background ( Round Icon Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-image-overlay.gdlr-core-round-icon .gdlr-core-image-overlay-icon{ background-color: #gdlr#; }'
					),
					'image-item-border-color' => array(
						'title' => esc_html__('Image Item Border', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector' => '.gdlr-core-body .gdlr-core-image-item-wrap{ border-color: #gdlr#; }'
					),
					'item-title-color' => array(
						'title' => esc_html__('Item\'s Title Color ( Blog / Portfolio / ... )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#343434',
						'selector' => '.gdlr-core-block-item-title-wrap .gdlr-core-block-item-title{ color: #gdlr#; }'
					),
					'item-title-caption-color' => array(
						'title' => esc_html__('Item\'s Title Caption Color ( Blog / Portfolio / ... )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#747474',
						'selector' => '.gdlr-core-block-item-title-wrap .gdlr-core-block-item-caption{ color: #gdlr#; }'
					),
					'item-title-link-color' => array(
						'title' => esc_html__('Item\'s Title Link Color ( Blog / Portfolio / ... )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#747474',
						'selector' => '.gdlr-core-block-item-title-wrap a, .gdlr-core-block-item-title-wrap a:hover{ color: #gdlr#; }'
					),
					'icon-list-item-icon-color' => array(
						'title' => esc_html__('Icon List Item Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#222222',
						'selector' => '.gdlr-core-icon-list-item i{ color: #gdlr#; }'
					),
					'icon-list-item-icon-background-color' => array(
						'title' => esc_html__('Icon List Item Icon Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.gdlr-core-icon-list-with-background-round .gdlr-core-icon-list-icon-wrap, ' .
							'.gdlr-core-icon-list-with-background-circle .gdlr-core-icon-list-icon-wrap{ color: #gdlr#; }'
					),
					'opening-hour-day-color' => array(
						'title' => esc_html__('Opening Hour Day Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#a5a5a5',
						'selector' => '.gdlr-core-opening-hour-item .gdlr-core-opening-hour-day{ color: #gdlr#; }'
					),
					'opening-hour-open-color' => array(
						'title' => esc_html__('Opening Hour Open Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#262626',
						'selector' => '.gdlr-core-opening-hour-item .gdlr-core-opening-hour-open{ color: #gdlr#; }'
					),
					'opening-hour-close-color' => array(
						'title' => esc_html__('Opening Hour Close Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#c8c8c8',
						'selector' => '.gdlr-core-opening-hour-item .gdlr-core-opening-hour-close{ color: #gdlr#; }'
					),
					'opening-hour-icon-color' => array(
						'title' => esc_html__('Opening Hour Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#8a8989',
						'selector' => '.gdlr-core-opening-hour-item .gdlr-core-opening-hour-time i{ color: #gdlr#; }'
					),
					'opening-hour-divider-color' => array(
						'title' => esc_html__('Opening Hour Divider Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#a6a6a6',
						'selector' => '.gdlr-core-opening-hour-item .gdlr-core-opening-hour-list-item{ border-color: #gdlr#; }'
					),
					'personnel-grid-title-color' => array(
						'title' => esc_html__('Personnel Grid Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector' => '.gdlr-core-personnel-style-grid .gdlr-core-personnel-list-title, .gdlr-core-personnel-style-grid .gdlr-core-personnel-list-title a{ color: #gdlr#; }'
					),
					'personnel-grid-position-color' => array(
						'title' => esc_html__('Personnel Grid Position', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#888888',
						'selector' => '.gdlr-core-personnel-style-grid .gdlr-core-personnel-list-position{ color: #gdlr#; }'
					),
					'personnel-grid-divider-color' => array(
						'title' => esc_html__('Personnel Grid Divider', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#cecece',
						'selector' => '.gdlr-core-personnel-style-grid .gdlr-core-personnel-list-divider{ color: #gdlr#; }'
					),
					'personnel-grid-frame-color' => array(
						'title' => esc_html__('Personnel Grid Frame Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f9f9f9',
						'selector' => '.gdlr-core-personnel-style-grid.gdlr-core-with-background .gdlr-core-personnel-list-content-wrap{ background-color: #gdlr#; }'
					),
					'personnel-modern-title-color' => array(
						'title' => esc_html__('Personnel Modern Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-personnel-style-modern .gdlr-core-personnel-list-title, .gdlr-core-personnel-style-modern .gdlr-core-personnel-list-title a{ color: #gdlr#; }'
					),
					'personnel-modern-position-color' => array(
						'title' => esc_html__('Personnel Modern Position/Social', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-personnel-style-modern .gdlr-core-personnel-list-position{ color: #gdlr#; }' . 
							'.gdlr-core-personnel-style-modern .gdlr-core-social-network-item a{ color: #gdlr#; }'
					),

				)
			),

			'element-4-color' => array(
				'title' => esc_html__('Element P,R,S,T', 'zurf'),
				'options' => array(
	
					'promo-box-item-title-color' => array(
						'title' => esc_html__('Promo Box Item Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector' => '.gdlr-core-promo-box-item .gdlr-core-promo-box-item-title{ color: #gdlr#; }'
					),
					'promo-box-content-border-color' => array(
						'title' => esc_html__('Promo Box Content Border', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e8e7e7',
						'selector' => '.gdlr-core-promo-box-item .gdlr-core-promo-box-content-wrap{ border-color: #gdlr#; }'
					),
					'post-slider-title-color' => array(
						'title' => esc_html__('Post Slider Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-post-slider-item .gdlr-core-post-slider-title a{ color: #gdlr#; }'
					),
					'post-slider-info-color' => array(
						'title' => esc_html__('Post Slider Info Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#c5c5c5',
						'selector' => '.gdlr-core-post-slider-item .gdlr-core-blog-info, .gdlr-core-post-slider-item .gdlr-core-blog-info a{ color: #gdlr#; }'
					),
					'roadmap-title-color' => array(
						'title' => esc_html__('Roadmap Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#a6aafb',
						'selector' => '.gdlr-core-roadmap-item .gdlr-core-roadmap-item-head-title{ color: #gdlr#; }'
					),
					'roadmap-title-active-color' => array(
						'title' => esc_html__('Roadmap Title Active Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-roadmap-item-head.gdlr-core-active .gdlr-core-roadmap-item-head-title{ color: #gdlr#; }'
					),
					'roadmap-caption-color' => array(
						'title' => esc_html__('Roadmap Caption Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#c1caf6',
						'selector' => '.gdlr-core-roadmap-item .gdlr-core-roadmap-item-head-caption{ color: #gdlr#; }'
					),
					'roadmap-number-text' => array(
						'title' => esc_html__('Roadmap Number Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#c5c5c5',
						'selector' => '.gdlr-core-roadmap-item .gdlr-core-roadmap-item-head-count{ color: #gdlr#; }'
					),
					'roadmap-number-background' => array(
						'title' => esc_html__('Roadmap Number Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#223077',
						'selector' => '.gdlr-core-roadmap-item .gdlr-core-roadmap-item-head-count{ background-color: #gdlr#; }'
					),
					'roadmap-number-active-text' => array(
						'title' => esc_html__('Roadmap Number Active Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#223077',
						'selector' => '.gdlr-core-roadmap-item-head.gdlr-core-active .gdlr-core-roadmap-item-head-count{ color: #gdlr#; }'
					),
					'roadmap-number-active-background' => array(
						'title' => esc_html__('Roadmap Number Active Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-roadmap-item-head.gdlr-core-active .gdlr-core-roadmap-item-head-count{ color: #gdlr#; }'
					),
					'roadmap-number-divider' => array(
						'title' => esc_html__('Roadmap Number Divider', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-roadmap-item .gdlr-core-roadmap-item-head-divider{ border-color: #gdlr#; }'
					),
					'roadmap-content-title' => array(
						'title' => esc_html__('Roadmap Content Title', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-roadmap-item .gdlr-core-roadmap-item-content-title{ color: #gdlr#; }'
					),
					'roadmap-content-caption' => array(
						'title' => esc_html__('Roadmap Content Caption', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#c1caf6',
						'selector' => '.gdlr-core-roadmap-item .gdlr-core-roadmap-item-content-caption{ color: #gdlr#; }'
					),
					'roadmap-content-color' => array(
						'title' => esc_html__('Roadmap Content Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#babdff',
						'selector' => '.gdlr-core-roadmap-item .gdlr-core-roadmap-item-content{ color: #gdlr#; }'
					),
					'skill-bar-title-color' => array(
						'title' => esc_html__('Skill Bar Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#505050',
						'selector' => '.gdlr-core-skill-bar-item .gdlr-core-skill-bar-title, .gdlr-core-skill-bar-item .gdlr-core-skill-bar-right{ color: #gdlr#; }'
					),
					'skill-bar-icon-color' => array(
						'title' => esc_html__('Skill Bar Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#616161',
						'selector' => '.gdlr-core-skill-bar-item .gdlr-core-skill-bar-icon{ color: #gdlr#; }'
					),
					'skill-bar-background-color' => array(
						'title' => esc_html__('Skill Bar Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.gdlr-core-skill-bar-item .gdlr-core-skill-bar-progress{ background-color: #gdlr#; }'
					),
					'skill-bar-progress-color' => array(
						'title' => esc_html__('Skill Bar Progress Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2d9bea',
						'selector' => '.gdlr-core-skill-bar-item .gdlr-core-skill-bar-filled, .gdlr-core-skill-bar-item .gdlr-core-skill-bar-filled-indicator{ background-color: #gdlr#; }'
					),
					'custom-slider-navigation-color' => array(
						'title' => esc_html__('Custom Slider Navigation Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#a7a7a7',
						'selector' => '.gdlr-core-flexslider-custom-nav i{ color: #gdlr#; }'
					),
					'custom-slider-navigation-hover-color' => array(
						'title' => esc_html__('Custom Slider Navigation Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#a7a7a7',
						'selector' => '.gdlr-core-flexslider-custom-nav i:hover{ color: #gdlr#; }'
					),
					'slider-outer-navigation-color' => array(
						'title' => esc_html__('Slider Outer Navigation Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#a7a7a7',
						'selector' => '.gdlr-core-flexslider-nav .flex-direction-nav li a, ' .
							'.gdlr-core-flexslider.gdlr-core-nav-style-middle-large .flex-direction-nav li a,'  .
							'.gdlr-core-flexslider.gdlr-core-nav-style-middle-plain .flex-direction-nav li a{ color: #gdlr#; border-color: #gdlr#; }'  .
							'.gdlr-core-flexslider.gdlr-core-bottom-nav-1 .flex-direction-nav li a, ' . 
							'.gdlr-core-flexslider[data-nav="navigation-outer-plain-round"] .flex-direction-nav li a{ color: #gdlr#; border-color: #gdlr#; }'
					),
					'slider-outer-navigation-background-color' => array(
						'title' => esc_html__('Slider Outer Navigation Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f1f1f1',
						'selector' => '.gdlr-core-flexslider-nav.gdlr-core-round-style li a, .gdlr-core-flexslider-nav.gdlr-core-rectangle-style li a{ background-color: #gdlr#; }'  .
							'.gdlr-core-flexslider.gdlr-core-bottom-nav-1 .flex-direction-nav li a{ background-color: #gdlr#; }'
					),
					'slider-control-navigation-color' => array(
						'title' => esc_html__('Slider Bullet Active Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#8a8a8a',
						'selector' => '.gdlr-core-flexslider .flex-control-nav li a{ border-color: #gdlr#; }' .
							'.gdlr-core-flexslider .flex-control-nav li a.flex-active{ background-color: #gdlr#; }' .
							'.gdlr-core-flexslider.gdlr-core-color-bullet .flex-control-nav li a.flex-active,' . 
							'.gdlr-core-flexslider.gdlr-core-bullet-style-cylinder .flex-control-nav li a.flex-active,' . 
							'.gdlr-core-flexslider.gdlr-core-bullet-style-cylinder-left .flex-control-nav li a.flex-active{ background-color: #gdlr#; }' . 
							'.gdlr-core-flexslider.gdlr-core-border-color-bullet .flex-control-nav li a.flex-active{ border-color: #gdlr#; }'  . 
							'ul.gdlr-core-sly-nav li{ background: #gdlr#; }'
					),
					'slider-control-navigation-background-color' => array(
						'title' => esc_html__('Slider Bullet Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#dfdfdf',
						'selector' => '.gdlr-core-flexslider.gdlr-core-color-bullet .flex-control-nav li a,' . 
							'.gdlr-core-flexslider.gdlr-core-bullet-style-cylinder .flex-control-nav li a,' . 
							'.gdlr-core-flexslider.gdlr-core-bullet-style-cylinder-left .flex-control-nav li a{ background-color: #gdlr#; }' . 
							'.gdlr-core-flexslider.gdlr-core-border-color-bullet .flex-control-nav li a{ border-color: #gdlr#; }' . 
							'ul.gdlr-core-sly-nav li.active{ background: #gdlr#; }'
					),
					'social-share-icon-color' => array(
						'title' => esc_html__('Social Share Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#202020',
						'selector' => '.gdlr-core-social-share-item a{ color: #gdlr#; }' . 
							'.gdlr-core-social-share-item.gdlr-core-style-round a, ' . 
							'.gdlr-core-social-share-item.gdlr-core-style-round a:hover{ background-color: #gdlr#; }'
					),
					'social-share-divider-color' => array(
						'title' => esc_html__('Social Share Divider Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e5e5e5',
						'selector' => '.gdlr-core-social-share-item .gdlr-core-divider{ border-color: #gdlr#; }'
					),
					'social-share-text-color' => array(
						'title' => esc_html__('Social Share Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#202020',
						'selector' => '.gdlr-core-social-share-item .gdlr-core-social-share-count{ color: #gdlr#; }'
					),
					'stunning-text-title-color' => array(
						'title' => esc_html__('Stunning Text Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#747474',
						'selector' => '.gdlr-core-stunning-text-item-caption{ color: #gdlr#; }'
					),
					'stunning-text-caption-color' => array(
						'title' => esc_html__('Stunning Text Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector' => '.gdlr-core-stunning-text-item-title{ color: #gdlr#; }'
					),
					'tab-title-color' => array(
						'title' => esc_html__('Tab Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#8d8d8d',
						'selector' => '.gdlr-core-tab-item-title{ color: #gdlr#; }'
					),
					'tab-title-background-color' => array(
						'title' => esc_html__('Tab Title Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f7f7f7',
						'selector' => '.gdlr-core-tab-style1-horizontal .gdlr-core-tab-item-title, ' .
							'.gdlr-core-tab-style1-vertical .gdlr-core-tab-item-title{ background-color: #gdlr#; }'
					),
					'tab-title-border-color' => array(
						'title' => esc_html__('Tab Title Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ebebeb',
						'selector' => '.gdlr-core-tab-item-title-wrap, .gdlr-core-tab-item-content-wrap, .gdlr-core-tab-item-title{ border-color: #gdlr#; }'
					),	
					'tab-title-hover-bar-color' => array(
						'title' => esc_html__('Tab Title Hover Bar Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2d9bea',
						'selector' => '.gdlr-core-tab-item-title-line{ border-color: #gdlr#; color: #gdlr#; }'
					),
					'tab-title-active-color' => array(
						'title' => esc_html__('Tab Title Active Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#464646',
						'selector' => '.gdlr-core-tab-item-title.gdlr-core-active{ color: #gdlr#; }'
					),
					'tab-title-active-background-color' => array(
						'title' => esc_html__('Tab Title Active Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-tab-style1-horizontal .gdlr-core-tab-item-title.gdlr-core-active, ' .
							'.gdlr-core-tab-style1-vertical .gdlr-core-tab-item-title.gdlr-core-active{ background-color: #gdlr#; }'
					),
					'table-head-background-color' => array(
						'title' => esc_html__('Table Head Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#36bddb',
						'selector'=> 'table tr th{ background-color: #gdlr#; }'
					),			
					'table-head-text-color' => array(
						'title' => esc_html__('Table Head Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> 'table tr th, .zurf-body table tr th a, .zurf-body table tr th a:hover{ color: #gdlr#; }'
					),	
					'table-odd-background-color' => array(
						'title' => esc_html__('Table Odd Row Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f9f9f9',
						'selector'=> 'table tr:nth-child(odd){ background-color: #gdlr#; }'
					),			
					'table-odd-text-color' => array(
						'title' => esc_html__('Table Odd Row Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#949494',
						'selector'=> 'table tr:nth-child(odd){ color: #gdlr#; }'
					),
					'table-even-background' => array(
						'title' => esc_html__('Table Even Row Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector'=> 'table tr:nth-child(even){ background-color: #gdlr#; }'
					),			
					'table-even-text' => array(
						'title' => esc_html__('Table Even Row Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#949494',
						'selector'=> 'table tr:nth-child(even){ color: #gdlr#; }'
					),		
					'testimonial-title-color' => array(
						'title' => esc_html__('Testimonial Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#232323',
						'selector'=> '.gdlr-core-testimonial-item .gdlr-core-testimonial-item-title{ color: #gdlr#; }'
					),		
					'testimonial-content-color' => array(
						'title' => esc_html__('Testimonial Content Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#707070',
						'selector'=> '.gdlr-core-testimonial-item .gdlr-core-testimonial-content{ color: #gdlr#; }'
					),		
					'testimonial-author-color' => array(
						'title' => esc_html__('Testimonial Author Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#3b3b3b',
						'selector'=> '.gdlr-core-testimonial-item .gdlr-core-testimonial-title{ color: #gdlr#; }'
					),		
					'testimonial-rating-color' => array(
						'title' => esc_html__('Testimonial Rating Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffa127',
						'selector'=> '.gdlr-core-testimonial-item .gdlr-core-rating i{ color: #gdlr#; }'
					),
					'testimonial-position-color' => array(
						'title' => esc_html__('Testimonial Position Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#3b3b3b',
						'selector'=> '.gdlr-core-testimonial-item .gdlr-core-testimonial-position{ color: #gdlr#; }'
					),		
					'testimonial-quote-color' => array(
						'title' => esc_html__('Testimonial Quote Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#282828',
						'selector'=> '.gdlr-core-testimonial-item .gdlr-core-testimonial-quote{ color: #gdlr#; }'
					),		
					'testimonial-frame-background-color' => array(
						'title' => esc_html__('Testimonial Frame Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.gdlr-core-testimonial-item .gdlr-core-testimonial-frame{ background-color: #gdlr#; }'
					),		
					'title-item-title-color' => array(
						'title' => esc_html__('Title Item\'s Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector'=> '.gdlr-core-title-item .gdlr-core-title-item-title, .gdlr-core-title-item .gdlr-core-title-item-title a{ color: #gdlr#; }'
					),		
					'title-item-caption-color' => array(
						'title' => esc_html__('Title Item\'s Caption Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#747474',
						'selector'=> '.gdlr-core-title-item .gdlr-core-title-item-caption{ color: #gdlr#; }'
					),

				)
			) , // element-3-color
			
			'product-color' => array(
				'title' => esc_html__('Woocommerce', 'zurf'),
				'options' => array(
				
					'woocommerce-theme-color' => array(
						'title' => esc_html__('Woocommerce Theme Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#bd584e',
						'selector' => '.woocommerce .star-rating span, .single-product.woocommerce #review_form #respond p.stars a, ' . 
							'.gdlr-core-product-item .gdlr-core-product-att .gdlr-tail, ' .
							'.single-product.woocommerce div.product .product_meta, .single-product.woocommerce div.product .product_meta a{ color: #gdlr#; }' . 
							'.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, ' .
							'.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, html .woocommerce input.button, html .woocommerce span.onsale{ background-color: #gdlr#; }'
					),
					'woocommerce-price-color' => array(
						'title' => esc_html__('Woocommerce Price Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#bd584e',
						'selector' => 'span.woocommerce-Price-amount.amount{ color: #gdlr#; }' .
							'.zurf-top-cart-content-wrap .zurf-highlight, .zurf-top-cart-item-wrap .zurf-top-cart-price-wrap .woocommerce-Price-amount.amount{ color: #gdlr#; }'
					),
					'woocommerce-price-linethrough-color' => array(
						'title' => esc_html__('Woocommerce Price Line Through Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#949494',
						'selector' => '.woocommerce .price del, .gdlr-core-product-price del, del span.woocommerce-Price-amount.amount{ color: #gdlr#; }'
					),
					'woocommerce-button-background-hover-color' => array(
						'title' => esc_html__('Woocommerce Button Background Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#d4786e',
						'selector' => '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, ' .
							'.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover{ background-color: #gdlr#; }'
					),
					'woocommerce-button-text-color' => array(
						'title' => esc_html__('Woocommerce Button Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, ' .
							'.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, ' .
							'.woocommerce #respond input#submit.disabled, .woocommerce #respond input#submit:disabled, .woocommerce #respond input#submit:disabled[disabled], ' .
							'.woocommerce a.button.disabled, .woocommerce a.button:disabled, .woocommerce a.button:disabled[disabled], .woocommerce button.button.disabled, ' .
							'.woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled], .woocommerce input.button.disabled, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled]{ color: #gdlr#; }'
					),
					'woocommerce-button-text-hover-color' => array(
						'title' => esc_html__('Woocommerce Button Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, ' .
							'.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover{ color: #gdlr#; }'
					),
					'woocommerce-input-background-color' => array(
						'title' => esc_html__('Woocommerce Input Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f3f3f3',
						'selector' => '.single-product.woocommerce div.product .quantity .qty, #add_payment_method #payment, .woocommerce-checkout #payment, ' . 
							'.single-product.woocommerce #reviews #comments ol.commentlist li{ background-color: #gdlr#; }'
					),
					
					'product-item-title-color' => array(
						'title' => esc_html__('Product Item Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#191919',
						'selector' => '.gdlr-core-product-grid .gdlr-core-product-title a, .gdlr-core-product-grid-3 .gdlr-core-product-title a{ color: #gdlr#; }'
					),
					'product-item-title-hover-color' => array(
						'title' => esc_html__('Product Item Title Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#434343',
						'selector' => '.gdlr-core-product-grid .gdlr-core-product-title a:hover, .gdlr-core-product-grid-3 .gdlr-core-product-title a:hover{ color: #gdlr#; }'
					),
					'view-detail-text-color' => array(
						'title' => esc_html__('Product Item View Detail Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-product-thumbnail .gdlr-core-product-view-detail, ' .
							'.gdlr-core-product-thumbnail .gdlr-core-product-view-detail:hover{ color: #gdlr#; }'
					),
					'view-detail-background-color' => array(
						'title' => esc_html__('Product Item View Detail Background', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector' => '.gdlr-core-product-thumbnail .gdlr-core-product-view-detail{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.9); }'
					),
					'add-to-cart-text-color' => array(
						'title' => esc_html__('Product Item Add To Cart Text', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.gdlr-core-product-thumbnail .added_to_cart, ' . 
							'.gdlr-core-product-thumbnail .added_to_cart:hover, ' . 
							'.gdlr-core-product-thumbnail .gdlr-core-product-add-to-cart, ' . 
							'.gdlr-core-product-thumbnail .gdlr-core-product-add-to-cart:hover{ color: #gdlr#; }'
					),
					'add-to-cart-background-color' => array(
						'title' => esc_html__('Product Item Add To Cart Background', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#bd584e',
						'selector' => '.gdlr-core-product-thumbnail .added_to_cart, ' .
							'.gdlr-core-product-thumbnail .gdlr-core-product-add-to-cart{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.9); }'
					),

					'widget-price-filter-bar-background-color' => array(
						'title' => esc_html__('Widget Price Filter Bar Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e6e6e6',
						'selector' => '.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content{ background-color: #gdlr#; }' . 
							'.wc-block-components-price-slider__range-input-wrapper{ background-color: #gdlr#; }'
					),
					'widget-price-filter-range-color' => array(
						'title' => esc_html__('Widget Price Filter Range Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#824141',
						'selector' => '.woocommerce .widget_price_filter .ui-slider .ui-slider-range{ background-color: #gdlr#; }' .
							'.wc-block-components-price-slider__range-input-progress { --range-color: #gdlr#; }' 
					),
					'widget-price-filter-handle-color' => array(
						'title' => esc_html__('Widget Price Filter Handle Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#b3564e',
						'selector' => '.woocommerce .widget_price_filter .ui-slider .ui-slider-handle{ background-color: #gdlr#; }' . 
							'.wc-block-components-price-slider__range-input::-webkit-slider-thumb{ background: #gdlr#; }'
					),

					'single-product-style-2-title-color' => array(
						'title' => esc_html__('Single Product Style 2 Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector' => '.zurf-single-product-style-2.single-product.woocommerce div.product .product_meta a, .zurf-single-product-style-2.single-product.woocommerce div.product .product_meta .sku{ color: #gdlr#; }' . 
							'.zurf-single-product-style-2.single-product.woocommerce div.product form.cart .variations label{ color: #gdlr#; }' .
							'.zurf-single-product-style-2.single-product.woocommerce div.product form.cart table.variations select{ border-color: #gdlr#; }' . 
							'.zurf-single-product-style-2.single-product.woocommerce a.add_to_wishlist{ color: #gdlr#; }' . 
							'.zurf-single-product-style-2.single-product.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta .woocommerce-review__author,' .
							'.zurf-single-product-style-2.single-product.woocommerce #reviews .comment-reply-title{ color: #gdlr#; }'
					),
					'single-product-style-2-info-color' => array(
						'title' => esc_html__('Single Product Style 2 Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#9a9a9a',
						'selector' => '.zurf-single-product-style-2.single-product.woocommerce a.woocommerce-review-link, .zurf-single-product-style-2.single-product.woocommerce a.woocommerce-review-link:hover{ color: #gdlr#; }' . 
							'.zurf-single-product-style-2.single-product.woocommerce div.product .product_meta{ color: #gdlr#; }'
					),
					'single-product-style-2-number-box-background' => array(
						'title' => esc_html__('Single Product Style 2 Number Box Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f6f6f6',
						'selector' => '.zurf-single-product-style-2.single-product.woocommerce div.product .quantity .qty{ background-color: #gdlr#; }'
					),



				)
			),

		) // color-options
		
	)), 6);	