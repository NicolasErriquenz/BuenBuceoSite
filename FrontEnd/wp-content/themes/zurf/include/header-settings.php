<?php

	add_filter('gdlr_core_enable_header_post_type', 'zurf_gdlr_core_enable_header_post_type');
	if( !function_exists('zurf_gdlr_core_enable_header_post_type') ){
		function zurf_gdlr_core_enable_header_post_type( $args ){
			return true;
		}
	}
	
	add_filter('gdlr_core_header_options', 'zurf_gdlr_core_header_options', 10, 2);
	if( !function_exists('zurf_gdlr_core_header_options') ){
		function zurf_gdlr_core_header_options( $options, $with_default = true ){

			// get option
			$options = array(
				'top-bar' => zurf_top_bar_options(),
				'top-bar-social' => zurf_top_bar_social_options(),			
				'header' => zurf_header_options(),
				'logo' => zurf_logo_options(),
				'navigation' => zurf_navigation_options(), 
				'fixed-navigation' => zurf_fixed_navigation_options(),
			);

			// set default
			if( $with_default ){
				foreach( $options as $slug => $option ){
					foreach( $option['options'] as $key => $value ){
						$options[$slug]['options'][$key]['default'] = zurf_get_option('general', $key);
					}
				}
			} 
			
			return $options;
		}
	}
	
	add_filter('gdlr_core_header_color_options', 'zurf_gdlr_core_header_color_options', 10, 2);
	if( !function_exists('zurf_gdlr_core_header_color_options') ){
		function zurf_gdlr_core_header_color_options( $options, $with_default = true ){

			$options = array(
				'header-color' => zurf_header_color_options(), 
				'navigation-menu-color' => zurf_navigation_color_options(), 		
				'navigation-right-color' => zurf_navigation_right_color_options(),
			);

			// set default
			if( $with_default ){
				foreach( $options as $slug => $option ){
					foreach( $option['options'] as $key => $value ){
						$options[$slug]['options'][$key]['default'] = zurf_get_option('color', $key);
					}
				}
			}

			return $options;
		}
	}

	add_action('wp_head', 'zurf_set_custom_header');
	if( !function_exists('zurf_set_custom_header') ){
		function zurf_set_custom_header(){
			zurf_get_option('general', 'layout', '');
			
			$header_id = get_post_meta(get_the_ID(), 'gdlr_core_custom_header_id', true);
			if( empty($header_id) ){
				$header_id = zurf_get_option('general', 'custom-header', '');
			}

			if( !empty($header_id) ){
				$option = 'zurf_general';

				if( empty($GLOBALS[$option]) ) return;
				
				$header_options = get_post_meta($header_id, 'gdlr-core-header-settings', true);

				if( !empty($header_options) ){
					foreach( $header_options as $key => $value ){
						$GLOBALS[$option][$key] = $value;
					}
				}

				$header_css = get_post_meta($header_id, 'gdlr-core-custom-header-css', true);
				if( !empty($header_css) ){
					if( get_post_type() == 'page' ){
						$header_css = str_replace('.gdlr-core-page-id', '.page-id-' . get_the_ID(), $header_css);
					}else{
						$header_css = str_replace('.gdlr-core-page-id', '.postid-' . get_the_ID(), $header_css);
					}
					echo '<style type="text/css" >' . $header_css . '</style>';
				}
				

			}
		} // zurf_set_custom_header
	}

	// override menu on page option
	add_filter('wp_nav_menu_args', 'zurf_wp_nav_menu_args');
	if( !function_exists('zurf_wp_nav_menu_args') ){
		function zurf_wp_nav_menu_args($args){

			$zurf_locations = array('main_menu', 'right_menu', 'top_bar_menu', 'mobile_menu');
			if( !empty($args['theme_location']) && in_array($args['theme_location'], $zurf_locations) ){
				$menu_id = get_post_meta(get_the_ID(), 'gdlr-core-location-' . $args['theme_location'], true);
				
				if( !empty($menu_id) ){
					$args['menu'] = $menu_id;
					$args['theme_location'] = '';
				}
			}

			return $args;
		}
	}

	if( !function_exists('zurf_top_bar_options') ){
		function zurf_top_bar_options(){
			return array(
				'title' => esc_html__('Top Bar', 'zurf'),
				'options' => array(

					'enable-top-bar' => array(
						'title' => esc_html__('Enable Top Bar', 'zurf'),
						'type' => 'checkbox',
					),
					'enable-top-bar-on-mobile' => array(
						'title' => esc_html__('Enable Top Bar On Mobile', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'top-bar-width' => array(
						'title' => esc_html__('Top Bar Width', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'boxed' => esc_html__('Boxed ( Within Container )', 'zurf'),
							'full' => esc_html__('Full', 'zurf'),
							'custom' => esc_html__('Custom', 'zurf'),
						),
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-width-pixel' => array(
						'title' => esc_html__('Top Bar Width Pixel', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'default' => '1140px',
						'condition' => array( 'enable-top-bar' => 'enable', 'top-bar-width' => 'custom' ),
						'selector' => '.zurf-top-bar-container.zurf-top-bar-custom-container{ max-width: #gdlr#; }'
					),
					'top-bar-full-side-padding' => array(
						'title' => esc_html__('Top Bar Full ( Left/Right ) Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.zurf-top-bar-container.zurf-top-bar-full{ padding-right: #gdlr#; padding-left: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable', 'top-bar-width' => 'full' )
					),
					'top-bar-menu-position' => array(
						'title' => esc_html__('Top Bar Menu Position', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'none' => esc_html__('None', 'zurf'),
							'left' => esc_html__('Left', 'zurf'),
							'right' => esc_html__('Right', 'zurf'),
						),
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-left-text' => array(
						'title' => esc_html__('Top Bar Left Text', 'zurf'),
						'type' => 'textarea',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-right-text' => array(
						'title' => esc_html__('Top Bar Right Text', 'zurf'),
						'type' => 'textarea',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-top-padding' => array(
						'title' => esc_html__('Top Bar Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
 						'default' => '10px',
						'selector' => '.zurf-top-bar{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-padding' => array(
						'title' => esc_html__('Top Bar Bottom Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '10px',
						'selector' => '.zurf-top-bar{ padding-bottom: #gdlr#; }' .
							'.zurf-top-bar .zurf-top-bar-menu > li > a{ padding-bottom: #gdlr#; }' .  
							'.sf-menu.zurf-top-bar-menu > .zurf-mega-menu .sf-mega, .sf-menu.zurf-top-bar-menu > .zurf-normal-menu ul{ margin-top: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-text-size' => array(
						'title' => esc_html__('Top Bar Text Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.zurf-top-bar{ font-size: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-border' => array(
						'title' => esc_html__('Top Bar Bottom Border', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '10',
						'default' => '0',
						'selector' => '.zurf-top-bar{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-border-style' => array(
						'title' => esc_html__('Top Bar Bottom Border Position', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'outer' => esc_html__('Outer', 'zurf'),
							'inner' => esc_html__('Inner', 'zurf')
						)
					),
					'top-bar-split-border' => array(
						'title' => esc_html__('Top Bar Split Border', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable' 
					),
					'top-bar-shadow-size' => array(
						'title' => esc_html__('Top Bar Shadow Size', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-shadow-color' => array(
						'title' => esc_html__('Top Bar Shadow Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector-extra' => true,
						'selector' => '.zurf-top-bar{ ' . 
							'box-shadow: 0px 0px <top-bar-shadow-size>t rgba(#gdlra#, 0.1); ' . 
							'-webkit-box-shadow: 0px 0px <top-bar-shadow-size>t rgba(#gdlra#, 0.1); ' . 
							'-moz-box-shadow: 0px 0px <top-bar-shadow-size>t rgba(#gdlra#, 0.1); }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					)

				)
			);
		}
	}

	if( !function_exists('zurf_top_bar_social_options') ){
		function zurf_top_bar_social_options(){
			return array(
				'title' => esc_html__('Top Bar Social', 'zurf'),
				'options' => array(
					'enable-top-bar-social' => array(
						'title' => esc_html__('Enable Top Bar Social', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'top-bar-social-icon-type' => array(
						'title' => esc_html__('Icon Type', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'font-awesome' => esc_html__('Font Awesome', 'zurf'),
							'font-awesome5' => esc_html__('Font Awesome 5', 'zurf'),
							'font-awesome6' => esc_html__('Font Awesome 6', 'zurf'),
						)
					),
					'top-bar-social-position' => array(
						'title' => esc_html__('Top Bar Social Position', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left', 'zurf'),
							'right' => esc_html__('Right', 'zurf'),
						),
						'default' => 'right',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-tiktok' => array(
						'title' => esc_html__('Top Bar Social Tiktok Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable', 'top-bar-social-icon-type' => 'font-awesome5' )
					),
					'top-bar-social-twitch' => array(
						'title' => esc_html__('Top Bar Social Twitch Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-discord' => array(
						'title' => esc_html__('Top Bar Social Discord Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable', 'top-bar-social-icon-type' => 'font-awesome5' )
					),
					'top-bar-social-delicious' => array(
						'title' => esc_html__('Top Bar Social Delicious Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-email' => array(
						'title' => esc_html__('Top Bar Social Email Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-deviantart' => array(
						'title' => esc_html__('Top Bar Social Deviantart Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-digg' => array(
						'title' => esc_html__('Top Bar Social Digg Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-facebook' => array(
						'title' => esc_html__('Top Bar Social Facebook Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-flickr' => array(
						'title' => esc_html__('Top Bar Social Flickr Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-lastfm' => array(
						'title' => esc_html__('Top Bar Social Lastfm Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-linkedin' => array(
						'title' => esc_html__('Top Bar Social Linkedin Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-pinterest' => array(
						'title' => esc_html__('Top Bar Social Pinterest Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-rss' => array(
						'title' => esc_html__('Top Bar Social RSS Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-skype' => array(
						'title' => esc_html__('Top Bar Social Skype Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-stumbleupon' => array(
						'title' => esc_html__('Top Bar Social Stumbleupon Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-tumblr' => array(
						'title' => esc_html__('Top Bar Social Tumblr Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-twitter' => array(
						'title' => esc_html__('Top Bar Social Twitter Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' ),
						'description' => esc_html__('Change \'Icon Type\' on the top to \'Font Awesome 6\' for new (X) icon', 'zurf')
					),
					'top-bar-social-vimeo' => array(
						'title' => esc_html__('Top Bar Social Vimeo Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-youtube' => array(
						'title' => esc_html__('Top Bar Social Youtube Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-instagram' => array(
						'title' => esc_html__('Top Bar Social Instagram Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-snapchat' => array(
						'title' => esc_html__('Top Bar Social Snapchat Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),

				)
			);
		}
	}

	if( !function_exists('zurf_header_options') ){
		function zurf_header_options(){
			return array(
				'title' => esc_html__('Header', 'zurf'),
				'options' => array(

					'header-style' => array(
						'title' => esc_html__('Header Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'plain' => esc_html__('Plain', 'zurf'),
							'bar' => esc_html__('Bar', 'zurf'),
							'bar2' => esc_html__('Navigation Boxed', 'zurf'),
							'boxed' => esc_html__('Boxed', 'zurf'),
							'side' => esc_html__('Side Menu', 'zurf'),
							'side-toggle' => esc_html__('Side Menu Toggle', 'zurf'),
						),
						'default' => 'plain',
					),
					'header-plain-style' => array(
						'title' => esc_html__('Header Plain Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'menu-left' => get_template_directory_uri() . '/images/header/plain-menu-left.jpg',
							'menu-right' => get_template_directory_uri() . '/images/header/plain-menu-right.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/plain-center-logo.jpg',
							'center-menu' => get_template_directory_uri() . '/images/header/plain-center-menu.jpg',
							'splitted-menu' => get_template_directory_uri() . '/images/header/plain-splitted-menu.jpg',
							'top-bar-logo' => get_template_directory_uri() . '/images/header/top-bar-logo.jpg',
						),
						'default' => 'menu-right',
						'condition' => array( 'header-style' => 'plain' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-top-bar-logo-top-margin' => array(
						'title' => esc_html__('Logo Top Margin', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.zurf-top-bar.zurf-middle-logo .zurf-logo{ margin-top: #gdlr#; }',
						'condition' => array('header-style' => 'plain', 'header-plain-style' => 'top-bar-logo')
					),
					'header-plain-bottom-border' => array(
						'title' => esc_html__('Plain Header Bottom Border', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '10',
						'default' => '0',
						'selector' => '.zurf-header-style-plain{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain') )
					),
					'header-bar-navigation-align' => array(
						'title' => esc_html__('Header Bar Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/bar-left.jpg',
							'center' => get_template_directory_uri() . '/images/header/bar-center.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/bar-center-logo.jpg',
						),
						'default' => 'center',
						'condition' => array( 'header-style' => 'bar' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-bar2-navigation-align' => array(
						'title' => esc_html__('Header Bar 2 Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/bar2-left.jpg',
							'center' => get_template_directory_uri() . '/images/header/bar2-center.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/bar2-center-logo.jpg',
						),
						'default' => 'center',
						'condition' => array( 'header-style' => 'bar2' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-background-style' => array(
						'title' => esc_html__('Header/Navigation Background Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'solid' => esc_html__('Solid', 'zurf'),
							'transparent' => esc_html__('Transparent', 'zurf'),
						),
						'default' => 'solid',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2') )
					),
					'top-bar-background-opacity' => array(
						'title' => esc_html__('Top Bar Background Opacity', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => 'plain', 'header-background-style' => 'transparent' ),
						'selector' => '.zurf-header-background-transparent .zurf-top-bar-background{ opacity: #gdlr#; }'
					),
					'header-background-opacity' => array(
						'title' => esc_html__('Header Background Opacity', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => array('plain', 'bar2'), 'header-background-style' => 'transparent' ),
						'selector' => '.zurf-header-background-transparent .zurf-header-background{ opacity: #gdlr#; }'
					),
					'navigation-background-opacity' => array(
						'title' => esc_html__('Navigation Background Opacity', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => array('bar', 'bar2'), 'header-background-style' => 'transparent' ),
						'selector' => '.zurf-navigation-bar-wrap.zurf-style-transparent .zurf-navigation-background{ opacity: #gdlr#; }'
					),
					'header-boxed-style' => array(
						'title' => esc_html__('Header Boxed Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'menu-right' => get_template_directory_uri() . '/images/header/boxed-menu-right.jpg',
							'center-menu' => get_template_directory_uri() . '/images/header/boxed-center-menu.jpg',
							'splitted-menu' => get_template_directory_uri() . '/images/header/boxed-splitted-menu.jpg',
						),
						'default' => 'menu-right',
						'condition' => array( 'header-style' => 'boxed' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'boxed-top-bar-background-opacity' => array(
						'title' => esc_html__('Top Bar Background Opacity', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '0',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.zurf-header-boxed-wrap .zurf-top-bar-background{ opacity: #gdlr#; }'
					),
					'boxed-top-bar-background-extend' => array(
						'title' => esc_html__('Top Bar Background Extend ( Bottom )', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0px',
						'data-max' => '200px',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.zurf-header-boxed-wrap .zurf-top-bar-background{ margin-bottom: -#gdlr#; }'
					),
					'boxed-header-top-margin' => array(
						'title' => esc_html__('Header Top Margin', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0px',
						'data-max' => '200px',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.zurf-header-style-boxed{ margin-top: #gdlr#; }'
					),
					'header-side-style' => array(
						'title' => esc_html__('Header Side Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'top-left' => get_template_directory_uri() . '/images/header/side-top-left.jpg',
							'middle-left' => get_template_directory_uri() . '/images/header/side-middle-left.jpg',
							'middle-left-2' => get_template_directory_uri() . '/images/header/side-middle-left-2.jpg',
							'top-right' => get_template_directory_uri() . '/images/header/side-top-right.jpg',
							'middle-right' => get_template_directory_uri() . '/images/header/side-middle-right.jpg',
							'middle-right-2' => get_template_directory_uri() . '/images/header/side-middle-right-2.jpg',
						),
						'default' => 'top-left',
						'condition' => array( 'header-style' => 'side' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-side-align' => array(
						'title' => esc_html__('Header Side Text Align', 'zurf'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left',
						'condition' => array( 'header-style' => 'side' )
					),
					'header-side-toggle-style' => array(
						'title' => esc_html__('Header Side Toggle Style', 'zurf'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/side-toggle-left.jpg',
							'right' => get_template_directory_uri() . '/images/header/side-toggle-right.jpg',
						),
						'default' => 'left',
						'condition' => array( 'header-style' => 'side-toggle' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-side-toggle-menu-type' => array(
						'title' => esc_html__('Header Side Toggle Menu Type', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left Slide Menu', 'zurf'),
							'right' => esc_html__('Right Slide Menu', 'zurf'),
							'overlay' => esc_html__('Overlay Menu', 'zurf'),
						),
						'default' => 'overlay',
						'condition' => array( 'header-style' => 'side-toggle' )
					),
					'header-side-toggle-display-logo' => array(
						'title' => esc_html__('Display Logo', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'header-style' => 'side-toggle' )
					),
					'header-width' => array(
						'title' => esc_html__('Header Width', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'boxed' => esc_html__('Boxed ( Within Container )', 'zurf'),
							'full' => esc_html__('Full', 'zurf'),
							'custom' => esc_html__('Custom', 'zurf'),
						),
						'condition' => array('header-style'=> array('plain', 'bar', 'bar2', 'boxed'))
					),
					'header-width-pixel' => array(
						'title' => esc_html__('Header Width Pixel', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'default' => '1140px',
						'condition' => array('header-style'=> array('plain', 'bar', 'bar2', 'boxed'), 'header-width' => 'custom'),
						'selector' => '.zurf-header-container.zurf-header-custom-container{ max-width: #gdlr#; }'
					),
					'header-full-side-padding' => array(
						'title' => esc_html__('Header Full ( Left/Right ) Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.zurf-header-container.zurf-header-full{ padding-right: #gdlr#; padding-left: #gdlr#; }',
						'condition' => array('header-style'=> array('plain', 'bar', 'bar2', 'boxed'), 'header-width'=>'full')
					),
					'boxed-header-frame-radius' => array(
						'title' => esc_html__('Header Frame Radius', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '3px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.zurf-header-boxed-wrap .zurf-header-background{ border-radius: #gdlr#; -moz-border-radius: #gdlr#; -webkit-border-radius: #gdlr#; }'
					),
					'boxed-header-content-padding' => array(
						'title' => esc_html__('Header Content ( Left/Right ) Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '30px',
						'selector' => '.zurf-header-style-boxed .zurf-header-container-item{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.zurf-navigation-right{ right: #gdlr#; } .zurf-navigation-left{ left: #gdlr#; }',
						'condition' => array( 'header-style' => 'boxed' )
					),
					'navigation-text-top-margin' => array(
						'title' => esc_html__('Navigation Text Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '0px',
						'condition' => array( 'header-style' => 'plain', 'header-plain-style' => 'splitted-menu' ),
						'selector' => '.zurf-header-style-plain.zurf-style-splitted-menu .zurf-navigation .sf-menu > li > a{ padding-top: #gdlr#; } ' .
							'.zurf-header-style-plain.zurf-style-splitted-menu .zurf-main-menu-left-wrap,' .
							'.zurf-header-style-plain.zurf-style-splitted-menu .zurf-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'navigation-text-top-margin-boxed' => array(
						'title' => esc_html__('Navigation Text Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed', 'header-boxed-style' => 'splitted-menu' ),
						'selector' => '.zurf-header-style-boxed.zurf-style-splitted-menu .zurf-navigation .sf-menu > li > a{ padding-top: #gdlr#; } ' .
							'.zurf-header-style-boxed.zurf-style-splitted-menu .zurf-main-menu-left-wrap,' .
							'.zurf-header-style-boxed.zurf-style-splitted-menu .zurf-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'navigation-text-side-spacing' => array(
						'title' => esc_html__('Navigation Text Side ( Left / Right ) Spaces', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '30',
						'data-type' => 'pixel',
						'default' => '13px',
						'selector' => '.zurf-navigation .sf-menu > li{ padding-left: #gdlr#; padding-right: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed') )
					),
					'navigation-left-offset' => array(
						'title' => esc_html__('Navigation Left Offset Spaces', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '0',
						'selector' => '.zurf-navigation .zurf-main-menu{ margin-left: #gdlr#; }'
					),
					'navigation-slide-bar' => array(
						'title' => esc_html__('Navigation Slide Bar', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'disable' => esc_html__('Disable', 'zurf'),
							'enable' => esc_html__('Bar With Triangle Style', 'zurf'),
							'style-2' => esc_html__('Bar Style', 'zurf'),
							'style-2-left' => esc_html__('Bar Style Left', 'zurf'),
							'style-dot' => esc_html__('Dot Style', 'zurf')
						),
						'default' => 'enable',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed') )
					),
					'navigation-slide-bar-width' => array(
						'title' => esc_html__('Navigation Slide Bar Width', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed'), 'navigation-slide-bar' => array('style-2', 'style-2-left') )
					),
					'navigation-slide-bar-height' => array(
						'title' => esc_html__('Navigation Slide Bar Height', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-navigation .zurf-navigation-slide-bar-style-2{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed'), 'navigation-slide-bar' => array('style-2', 'style-2-left') )
					),
					'navigation-slide-bar-top-margin' => array(
						'title' => esc_html__('Navigation Slide Bar Top Margin', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'selector' => '.zurf-navigation .zurf-navigation-slide-bar{ margin-top: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed'), 'navigation-slide-bar' => array('enable', 'style-2', 'style-2-left', 'style-dot') )
					),
					'side-header-width-pixel' => array(
						'title' => esc_html__('Header Width Pixel', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '600',
						'default' => '340px',
						'condition' => array('header-style' => array('side', 'side-toggle')),
						'selector' => '.zurf-header-side-nav{ width: #gdlr#; }' . 
							'.zurf-header-side-content.zurf-style-left{ margin-left: #gdlr#; }' .
							'.zurf-header-side-content.zurf-style-right{ margin-right: #gdlr#; }'
					),
					'side-header-side-padding' => array(
						'title' => esc_html__('Header Side Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '70px',
						'condition' => array('header-style' => 'side'),
						'selector' => '.zurf-header-side-nav.zurf-style-side{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.zurf-header-side-nav.zurf-style-left .sf-vertical > li > ul.sub-menu{ padding-left: #gdlr#; }' .
							'.zurf-header-side-nav.zurf-style-right .sf-vertical > li > ul.sub-menu{ padding-right: #gdlr#; }'
					),
					'navigation-text-top-spacing' => array(
						'title' => esc_html__('Navigation Text Top / Bottom Spaces', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '40',
						'data-type' => 'pixel',
						'default' => '16px',
						'selector' => ' .zurf-navigation .sf-vertical > li{ padding-top: #gdlr#; padding-bottom: #gdlr#; }',
						'condition' => array( 'header-style' => array('side') )
					),
					'logo-right-text' => array(
						'title' => esc_html__('Header Right Text', 'zurf'),
						'type' => 'textarea',
						'condition' => array('header-style' => array('bar', 'bar2')),
					),
					'logo-right-text-top-padding' => array(
						'title' => esc_html__('Header Right Text Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '30px',
						'condition' => array('header-style' => array('bar', 'bar2')),
						'selector' => '.zurf-header-style-bar .zurf-logo-right-text{ padding-top: #gdlr#; }'
					),
					'header-shadow-size' => array(
						'title' => esc_html__('Header Shadow Size', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'condition' => array( 'header-style' => 'plain' )
					),
					'header-shadow-color' => array(
						'title' => esc_html__('Header Shadow Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector-extra' => true,
						'selector' => '.zurf-header-style-plain{ ' . 
							'box-shadow: 0px 0px <header-shadow-size>t rgba(#gdlra#, 0.1); ' . 
							'-webkit-box-shadow: 0px 0px <header-shadow-size>t rgba(#gdlra#, 0.1); ' . 
							'-moz-box-shadow: 0px 0px <header-shadow-size>t rgba(#gdlra#, 0.1); }',
						'condition' => array( 'header-style' => 'plain' )
					)
				)
			);
		}
	}

	if( !function_exists('zurf_logo_options') ){
		function zurf_logo_options(){
			return array(
				'title' => esc_html__('Logo', 'zurf'),
				'options' => array(
					'enable-logo' => array(
						'title' => esc_html__('Enable Logo', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'logo' => array(
						'title' => esc_html__('Logo', 'zurf'),
						'type' => 'upload',
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'logo2x' => array(
						'title' => esc_html__('Logo 2x (Retina)', 'zurf'),
						'type' => 'upload',
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'logo-top-padding' => array(
						'title' => esc_html__('Logo Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.zurf-logo{ padding-top: #gdlr#; }',
						'description' => esc_html__('This option will be omitted on splitted menu option.', 'zurf'),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'logo-bottom-padding' => array(
						'title' => esc_html__('Logo Bottom Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.zurf-logo{ padding-bottom: #gdlr#; }',
						'description' => esc_html__('This option will be omitted on splitted menu option.', 'zurf'),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'logo-left-padding' => array(
						'title' => esc_html__('Logo Left Padding', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-logo.zurf-item-pdlr{ padding-left: #gdlr#; }',
						'description' => esc_html__('Leave this field blank for default value.', 'zurf'),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'max-logo-width' => array(
						'title' => esc_html__('Max Logo Width', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '200px',
						'selector' => '.zurf-logo-inner{ max-width: #gdlr#; }',
						'condition' => array( 'enable-logo' => 'enable' )
					),

					'mobile-logo' => array(
						'title' => esc_html__('Mobile/Tablet Logo', 'zurf'),
						'type' => 'upload',
						'description' => esc_html__('Leave this option blank to use the same logo.', 'zurf'),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'max-tablet-logo-width' => array(
						'title' => esc_html__('Max Tablet Logo Width', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 999px){ .zurf-mobile-header .zurf-logo-inner{ max-width: #gdlr#; } }',
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'max-mobile-logo-width' => array(
						'title' => esc_html__('Max Mobile Logo Width', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .zurf-mobile-header .zurf-logo-inner{ max-width: #gdlr#; } }',
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'mobile-logo-position' => array(
						'title' => esc_html__('Mobile Logo Position', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'logo-left' => esc_html__('Logo Left', 'zurf'),
							'logo-center' => esc_html__('Logo Center', 'zurf'),
							'logo-right' => esc_html__('Logo Right', 'zurf'),
						),
						'condition' => array( 'enable-logo' => 'enable' )
					),
				
				)
			);
		}
	}

	if( !function_exists('zurf_navigation_options') ){
		function zurf_navigation_options(){
			return array(
				'title' => esc_html__('Navigation', 'zurf'),
				'options' => array(
					'main-navigation-top-padding' => array(
						'title' => esc_html__('Main Navigation Top Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '25px',
						'selector' => '.zurf-navigation{ padding-top: #gdlr#; }' . 
							'.zurf-navigation-top{ top: #gdlr#; }'
					),
					'main-navigation-bottom-padding' => array(
						'title' => esc_html__('Main Navigation Bottom Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.zurf-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }'
					),
					'main-navigation-item-right-padding' => array(
						'title' => esc_html__('Main Navigation Item Right Padding', 'zurf'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => '.zurf-navigation .zurf-main-menu{ padding-right: #gdlr#; }'
					),
					'main-navigation-right-padding' => array(
						'title' => esc_html__('Main Navigation Wrap Right Padding', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-navigation.zurf-item-pdlr{ padding-right: #gdlr#; }',
						'description' => esc_html__('Leave this field blank for default value.', 'zurf'),
					),
					'enable-main-navigation-submenu-indicator' => array(
						'title' => esc_html__('Enable Main Navigation Submenu Indicator', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable',
					),
					'navigation-right-top-margin' => array(
						'title' => esc_html__('Navigation Right ( search/cart/button ) Top Margin', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.zurf-main-menu-right-wrap{ margin-top: #gdlr#; }'
					),
					'navigation-right-left-margin' => array(
						'title' => esc_html__('Navigation Right ( search/cart/button ) Left Margin ', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.zurf-main-menu-right-wrap{ margin-left: #gdlr# !important; }'
					),
					'enable-main-navigation-search' => array(
						'title' => esc_html__('Enable Main Navigation Search', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'main-navigation-search-icon' => array(
						'title' => esc_html__('Main Navigation Search Icon', 'zurf'),
						'type' => 'text',
						'default' => 'fa fa-search',
						'condition' => array('enable-main-navigation-search' => 'enable')
					),
					'main-navigation-search-icon-top-margin' => array(
						'title' => esc_html__('Main Navigation Search Icon Top Margin', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-main-menu-search{ margin-top: #gdlr#; }',
						'condition' => array('enable-main-navigation-search' => 'enable')
					),
					'enable-main-navigation-cart' => array(
						'title' => esc_html__('Enable Main Navigation Cart ( Woocommerce )', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'description' => esc_html__('The icon only shows if the woocommerce plugin is activated', 'zurf')
					),
					'main-navigation-cart-icon' => array(
						'title' => esc_html__('Main Navigation Cart Icon', 'zurf'),
						'type' => 'text',
						'default' => 'fa fa-shopping-cart',
						'condition' => array('enable-main-navigation-search' => 'enable')
					),
					'main-navigation-cart-icon-top-margin' => array(
						'title' => esc_html__('Main Navigation Cart Icon Top Margin', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel', 
						'selector' => '.zurf-main-menu-cart{ margin-top: #gdlr#; }',
						'condition' => array('enable-main-navigation-search' => 'enable')
					),
					'enable-main-navigation-right-button' => array(
						'title' => esc_html__('Enable Main Navigation Right Button', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('This option will be ignored on header side style', 'zurf')
					),
					'main-navigation-right-button-style' => array(
						'title' => esc_html__('Main Navigation Right Button Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'default' => esc_html__('Default', 'zurf'),
							'round' => esc_html__('Round', 'zurf'),
							'round-with-shadow' => esc_html__('Round With Shadow', 'zurf'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-text' => array(
						'title' => esc_html__('Main Navigation Right Button Text', 'zurf'),
						'type' => 'text',
						'default' => esc_html__('Buy Now', 'zurf'),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link' => array(
						'title' => esc_html__('Main Navigation Right Button Link', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link-target' => array(
						'title' => esc_html__('Main Navigation Right Button Link Target', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'_self' => esc_html__('Current Screen', 'zurf'),
							'_blank' => esc_html__('New Window', 'zurf'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-style-2' => array(
						'title' => esc_html__('Main Navigation Right Button Style 2', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'default' => esc_html__('Default', 'zurf'),
							'round' => esc_html__('Round', 'zurf'),
							'round-with-shadow' => esc_html__('Round With Shadow', 'zurf'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-text-2' => array(
						'title' => esc_html__('Main Navigation Right Button Text 2', 'zurf'),
						'type' => 'text',
						'default' => esc_html__('Buy Now', 'zurf'),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link-2' => array(
						'title' => esc_html__('Main Navigation Right Button Link 2', 'zurf'),
						'type' => 'text',
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link-target-2' => array(
						'title' => esc_html__('Main Navigation Right Button Link Target 2', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'_self' => esc_html__('Current Screen', 'zurf'),
							'_blank' => esc_html__('New Window', 'zurf'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'enable-secondary-menu' => array(
						'title' => esc_html__('Enable Secondary Menu', 'zurf'),
						'type' => 'checkbox', 
						'default' => 'enable'
					),
					'right-menu-type' => array(
						'title' => esc_html__('Secondary/Mobile Menu Type', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left Slide Menu', 'zurf'),
							'right' => esc_html__('Right Slide Menu', 'zurf'),
							'overlay' => esc_html__('Overlay Menu', 'zurf'),
						),
						'default' => 'right'
					),
					'right-menu-style' => array(
						'title' => esc_html__('Secondary/Mobile Menu Style', 'zurf'),
						'type' => 'combobox',
						'options' => array(
							'hamburger-with-border' => esc_html__('Hamburger With Border ( Font Awesome )', 'zurf'),
							'hamburger' => esc_html__('Hamburger', 'zurf'),
							'hamburger-small' => esc_html__('Hamburger Small', 'zurf'),
						),
						'default' => 'hamburger-with-border'
					),
					'right-menu-left-margin' => array(
						'title' => esc_html__('Secondary Menu Left Margin', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'selector' => '.zurf-right-menu-button{ margin-left: #gdlr#; }'
					),
					'side-content-menu' => array(
						'title' => esc_html__('Side Content Menu', 'zurf'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'side-content-menu-left-margin' => array(
						'title' => esc_html__('Secondary Menu Left Margin', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'selector' => '.zurf-side-content-menu-button{ margin-left: #gdlr#; }'
					),
					'side-content-widget' => array(
						'title' => esc_html__('Choose Side Content Widget', 'zurf'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'condition' => array( 'side-content-menu' => 'enable' )
					),
					'side-content-background-color' => array(
						'title' => esc_html__('Side Content Background Color', 'zurf'),
						'type' => 'colorpicker',
						'selector' => '.zurf-header-side-content, #zurf-side-content-menu{ background-color: #gdlr#; }',
						'condition' => array( 'side-content-menu' => 'enable' )
					),
					'side-content-text-color' => array(
						'title' => esc_html__('Side Content Text Color', 'zurf'),
						'type' => 'colorpicker',
						'selector' => '#zurf-side-content-menu .widget{ color: #gdlr#; }',
						'condition' => array( 'side-content-menu' => 'enable' )
					),
					'side-content-shadow-size' => array(
						'title' => esc_html__('Side Content Shadow Size', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'condition' => array( 'side-content-menu' => 'enable' )
					),
					'side-content-shadow-opacity' => array(
						'title' => esc_html__('Side Content Shadow Opacity', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '0.1',
						'condition' => array( 'side-content-menu' => 'enable' ),
						'selector-extra' => true,
						'selector' => '#zurf-side-content-menu{ box-shadow: 0px 0px <side-content-shadow-size>t rgba(0, 0, 0, #gdlr#); -webkit-box-shadow: 0px 0px <side-content-shadow-size>t rgba(0, 0, 0, #gdlr#); }'
					),
					
				) // logo-options
			);
		}
	}

	if( !function_exists('zurf_fixed_navigation_options') ){
		function zurf_fixed_navigation_options(){
			return array(
				'title' => esc_html__('Fixed Navigation', 'zurf'),
				'options' => array(

					'enable-main-navigation-sticky' => array(
						'title' => esc_html__('Enable Fixed Navigation Bar', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'enable-logo-on-main-navigation-sticky' => array(
						'title' => esc_html__('Enable Logo on Fixed Navigation Bar', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
						'description' => esc_html__('This option will be omitted when the logo is disabeld', 'zurf'),
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' )
					),
					'fixed-navigation-bar-logo' => array(
						'title' => esc_html__('Fixed Navigation Bar Logo', 'zurf'),
						'type' => 'upload',
						'description' => esc_html__('Leave blank to show default logo', 'zurf'),
						'condition' => array( 'enable-main-navigation-sticky' => 'enable', 'enable-logo-on-main-navigation-sticky' => 'enable' )
					),
					'fixed-navigation-bar-logo2x' => array(
						'title' => esc_html__('Fixed Navigation Bar Logo 2x (Retina)', 'zurf'),
						'type' => 'upload',
						'description' => esc_html__('Leave blank to show default logo', 'zurf'),
						'condition' => array( 'enable-main-navigation-sticky' => 'enable', 'enable-logo-on-main-navigation-sticky' => 'enable' )
					),
					'fixed-navigation-max-logo-width' => array(
						'title' => esc_html__('Fixed Navigation Max Logo Width', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.zurf-fixed-navigation.zurf-style-slide .zurf-logo-inner img{ max-height: none !important; }' .
							'.zurf-animate-fixed-navigation.zurf-header-style-plain .zurf-logo-inner, ' . 
							'.zurf-animate-fixed-navigation.zurf-header-style-boxed .zurf-logo-inner{ max-width: #gdlr#; }' . 
							'.zurf-mobile-header.zurf-fixed-navigation .zurf-logo-inner{ max-width: #gdlr#; }'
					),
					'fixed-navigation-logo-top-padding' => array(
						'title' => esc_html__('Fixed Navigation Logo Top Padding', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '20px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.zurf-animate-fixed-navigation.zurf-header-style-plain .zurf-logo, ' . 
							'.zurf-animate-fixed-navigation.zurf-header-style-boxed .zurf-logo{ padding-top: #gdlr#; }'
					),
					'fixed-navigation-logo-bottom-padding' => array(
						'title' => esc_html__('Fixed Navigation Logo Bottom Padding', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '20px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.zurf-animate-fixed-navigation.zurf-header-style-plain .zurf-logo, ' . 
							'.zurf-animate-fixed-navigation.zurf-header-style-boxed .zurf-logo{ padding-bottom: #gdlr#; }'
					),
					'fixed-navigation-top-padding' => array(
						'title' => esc_html__('Fixed Navigation Top Padding', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '30px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.zurf-animate-fixed-navigation.zurf-header-style-plain .zurf-navigation, ' . 
							'.zurf-animate-fixed-navigation.zurf-header-style-boxed .zurf-navigation{ padding-top: #gdlr#; }' . 
							'.zurf-animate-fixed-navigation.zurf-header-style-plain .zurf-navigation-top, ' . 
							'.zurf-animate-fixed-navigation.zurf-header-style-boxed .zurf-navigation-top{ top: #gdlr#; }' .
							'.zurf-animate-fixed-navigation.zurf-navigation-bar-wrap .zurf-navigation{ padding-top: #gdlr#; }'
					),
					'fixed-navigation-bottom-padding' => array(
						'title' => esc_html__('Fixed Navigation Bottom Padding', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '25px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.zurf-animate-fixed-navigation.zurf-header-style-plain .zurf-navigation .sf-menu > li > a, ' . 
							'.zurf-animate-fixed-navigation.zurf-header-style-boxed .zurf-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }' .
							'.zurf-animate-fixed-navigation.zurf-navigation-bar-wrap .zurf-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }' .
							'.zurf-animate-fixed-navigation .zurf-main-menu-right{ margin-bottom: #gdlr#; }'
					),
					'enable-fixed-navigation-slide-bar' => array(
						'title' => esc_html__('Enable Fixed Navigation Slide Bar', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'fixed-navigation-slide-bar-top-margin' => array(
						'title' => esc_html__('Fixed Navigation Slide Bar Top Margin', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'selector' => '.zurf-fixed-navigation .zurf-navigation .zurf-navigation-slide-bar{ margin-top: #gdlr#; }',
						'condition' => array('enable-fixed-navigation-slide-bar' => 'enable')
					),
					'fixed-navigation-anchor-offset' => array(
						'title' => esc_html__('Fixed Navigation Anchor Offset ( Fixed Navigation Height )', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '75px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
					),
					'enable-mobile-navigation-sticky' => array(
						'title' => esc_html__('Enable Mobile Fixed Navigation Bar', 'zurf'),
						'type' => 'checkbox',
						'default' => 'enable',
					),

				)
			);
		}
	}

	if( !function_exists('zurf_header_color_options') ){
		function zurf_header_color_options(){

			return array(
				'title' => esc_html__('Header', 'zurf'),
				'options' => array(
					'top-bar-background-color' => array(
						'title' => esc_html__('Top Bar Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#222222',
						'selector' => '.zurf-top-bar-background, .zurf-mobile-header-wrap .zurf-top-bar{ background-color: #gdlr#; }'
					),
					'top-bar-bottom-border-color' => array(
						'title' => esc_html__('Top Bar Bottom Border Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'selector-extra' => true,
						'default' => '#ffffff',
						'selector' => '.zurf-body .zurf-top-bar{ border-bottom-color: #gdlr#; border-bottom-color: rgba(#gdlra#, <top-bar-bottom-border-opacity>t); }' .
							'.zurf-top-bar.zurf-splited-border .zurf-top-bar-right-social a:after{ border-color: #gdlr#; }' .
							'.zurf-top-bar-left-text .zurf-with-divider:before{ border-color: #gdlr#; }'
					),
					'top-bar-bottom-border-opacity' => array(
						'title' => esc_html__('Top Bar Bottom Border Opacity', 'zurf'),
						'type' => 'text',
						'default' => '1',
						'description' => esc_html__('Fill the number between 0.01 to 1', 'zurf')
					),
					'top-bar-text-color' => array(
						'title' => esc_html__('Top Bar Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-top-bar{ color: #gdlr#; }'
					),
					'top-bar-link-color' => array(
						'title' => esc_html__('Top Bar Link Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-body .zurf-top-bar a{ color: #gdlr#; }'
					),
					'top-bar-link-hover-color' => array(
						'title' => esc_html__('Top Bar Link Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-body .zurf-top-bar a:hover{ color: #gdlr#; }'
					),
					'top-bar-social-color' => array(
						'title' => esc_html__('Top Bar Social Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-top-bar .zurf-top-bar-right-social a, .zurf-header-style-side .zurf-header-social a{ color: #gdlr#; }'
					),
					'top-bar-social-hover-color' => array(
						'title' => esc_html__('Top Bar Social Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e44444',
						'selector' => '.zurf-top-bar .zurf-top-bar-right-social a:hover, .zurf-header-style-side .zurf-header-social a:hover{ color: #gdlr#; }'
					),
					'header-background-color' => array(
						'title' => esc_html__('Header Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-header-background, .zurf-sticky-menu-placeholder, .zurf-header-style-boxed.zurf-fixed-navigation, body.single-product .zurf-header-background-transparent{ background-color: #gdlr#; }'
					),
					'header-plain-bottom-border-color' => array(
						'title' => esc_html__('Header Bottom Border Color ( Header Plain Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e8e8e8',
						'selector' => '.zurf-header-wrap.zurf-header-style-plain{ border-color: #gdlr#; }'
					),
					'logo-background-color' => array(
						'title' => esc_html__('Logo Background Color ( Header Side Menu Toggle Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.zurf-header-side-nav.zurf-style-side-toggle .zurf-logo{ background-color: #gdlr#; }'
					),
					'secondary-menu-icon-color' => array(
						'title' => esc_html__('Secondary Menu Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector'=> '.zurf-top-menu-button i, .zurf-mobile-menu-button i{ color: #gdlr#; }' . 
							'.zurf-main-menu-right-wrap .tourmaster-user-top-bar, .zurf-mobile-menu-right .tourmaster-user-top-bar-name, .zurf-mobile-menu-right .tourmaster-user-top-bar.tourmaster-guest .tourmaster-text{ color: #gdlr#; }' .
							'.zurf-mobile-button-hamburger:before, ' . 
							'.zurf-mobile-button-hamburger:after, ' . 
							'.zurf-mobile-button-hamburger span, ' . 
							'.zurf-mobile-button-hamburger-small:before, ' . 
							'.zurf-mobile-button-hamburger-small:after, ' . 
							'.zurf-mobile-button-hamburger-small span{ background: #gdlr#; }' .
							'.zurf-side-content-menu-button span,' .
							'.zurf-side-content-menu-button:before, ' .
							'.zurf-side-content-menu-button:after{ background: #gdlr#; }'
					),
					'secondary-menu-border-color' => array(
						'title' => esc_html__('Secondary Menu Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#dddddd',
						'selector'=> '.zurf-main-menu-right .zurf-top-menu-button, .zurf-mobile-menu .zurf-mobile-menu-button{ border-color: #gdlr#; }'
					),
					'search-overlay-background-color' => array(
						'title' => esc_html__('Search Overlay Background Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector'=> '.zurf-top-search-wrap{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.88); }'
					),
					'top-cart-background-color' => array(
						'title' => esc_html__('Top Cart Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.zurf-top-cart-content-wrap .zurf-top-cart-content{ background-color: #gdlr#; }'
					),
					'top-cart-title-color' => array(
						'title' => esc_html__('Top Cart Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector'=> '.zurf-top-cart-content-wrap .zurf-top-cart-title, .zurf-top-cart-item .zurf-top-cart-item-title, ' . 
							'.zurf-top-cart-item .zurf-top-cart-item-remove{ color: #gdlr#; }'
					),
					'top-cart-info-color' => array(
						'title' => esc_html__('Top Cart Info Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#6c6c6c',
						'selector'=> '.zurf-top-cart-content-wrap .woocommerce-Price-amount.amount{ color: #gdlr#; }'
					),
					'top-cart-view-cart-color' => array(
						'title' => esc_html__('Top Cart : View Cart Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#323232',
						'selector'=> '.zurf-body .zurf-top-cart-button-wrap .zurf-top-cart-button, .zurf-body .zurf-top-cart-button-wrap .zurf-top-cart-button:hover{ color: #gdlr#; }'
					),
					'top-cart-view-cart-background-color' => array(
						'title' => esc_html__('Top Cart : View Cart Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f4f4f4',
						'selector'=> '.zurf-body .zurf-top-cart-button-wrap .zurf-top-cart-button{ background-color: #gdlr#; }'
					),
					'top-cart-checkout-color' => array(
						'title' => esc_html__('Top Cart : Checkout Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.zurf-body .zurf-top-cart-button-wrap .zurf-top-cart-button-2{ color: #gdlr#; }'
					),
					'top-cart-checkout-background-color' => array(
						'title' => esc_html__('Top Cart : Checkout Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector'=> '.zurf-body .zurf-top-cart-button-wrap .zurf-top-cart-button-2{ background-color: #gdlr#; }'
					),
					'breadcrumbs-text-color' => array(
						'title' => esc_html__('Breadcrumbs ( Plugin ) Text Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#c0c0c0',
						'selector'=> '.zurf-body .zurf-breadcrumbs, .zurf-body .zurf-breadcrumbs a span, ' . 
							'.gdlr-core-breadcrumbs-item, .gdlr-core-breadcrumbs-item a span{ color: #gdlr#; }'
					),
					'breadcrumbs-text-active-color' => array(
						'title' => esc_html__('Breadcrumbs ( Plugin ) Text Active Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#777777',
						'selector'=> '.zurf-body .zurf-breadcrumbs span, .zurf-body .zurf-breadcrumbs a:hover span, ' . 
							'.gdlr-core-breadcrumbs-item span, .gdlr-core-breadcrumbs-item a:hover span{ color: #gdlr#; }'
					),
				) // header-options
			);

		}
	}

	if( !function_exists('zurf_navigation_color_options') ){
		function zurf_navigation_color_options(){

			return array(
				'title' => esc_html__('Menu', 'zurf'),
				'options' => array(

					'navigation-bar-background-color' => array(
						'title' => esc_html__('Navigation Bar Background Color ( Header Bar Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#f4f4f4',
						'selector' => '.zurf-navigation-background{ background-color: #gdlr#; }'
					),
					'navigation-bar-top-border-color' => array(
						'title' => esc_html__('Navigation Bar Top Border Color ( Header Bar Style )', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#e8e8e8',
						'selector' => '.zurf-navigation-bar-wrap{ border-color: #gdlr#; }'
					),
					'navigation-slide-bar-color' => array(
						'title' => esc_html__('Navigation Slide Bar Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2d9bea',
						'selector' => '.zurf-navigation .zurf-navigation-slide-bar, ' . 
							'.zurf-navigation .zurf-navigation-slide-bar-style-dot:before{ border-color: #gdlr#; }' . 
							'.zurf-navigation .zurf-navigation-slide-bar:before{ border-bottom-color: #gdlr#; }'
					),
					'main-menu-text-color' => array(
						'title' => esc_html__('Main Menu Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#999999',
						'selector' => '.sf-menu > li > a, .sf-vertical > li > a{ color: #gdlr#; }'
					),
					'main-menu-text-hover-color' => array(
						'title' => esc_html__('Main Menu Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector' => '.sf-menu > li > a:hover, ' . 
							'.sf-menu > li.current-menu-item > a, ' .
							'.sf-menu > li.current-menu-ancestor > a, ' .
							'.sf-vertical > li > a:hover, ' . 
							'.sf-vertical > li.current-menu-item > a, ' .
							'.sf-vertical > li.current-menu-ancestor > a{ color: #gdlr#; }'
					),
					'sub-menu-background-color' => array(
						'title' => esc_html__('Sub Menu Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#2e2e2e',
						'selector'=> '.sf-menu > .zurf-normal-menu li, .sf-menu > .zurf-mega-menu > .sf-mega, ' . 
							'.sf-vertical ul.sub-menu li, ul.sf-menu > .menu-item-language li{ background-color: #gdlr#; }'
					),
					'sub-menu-text-color' => array(
						'title' => esc_html__('Sub Menu Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#bebebe',
						'selector'=> '.sf-menu > li > .sub-menu a, .sf-menu > .zurf-mega-menu > .sf-mega a, ' . 
							'.sf-vertical ul.sub-menu li a{ color: #gdlr#; }'
					),
					'sub-menu-text-hover-color' => array(
						'title' => esc_html__('Sub Menu Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.sf-menu > li > .sub-menu a:hover, ' . 
							'.sf-menu > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-menu > li > .sub-menu .current-menu-ancestor > a, '.
							'.sf-menu > .zurf-mega-menu > .sf-mega a:hover, '.
							'.sf-menu > .zurf-mega-menu > .sf-mega .current-menu-item > a, '.
							'.sf-vertical > li > .sub-menu a:hover, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-ancestor > a{ color: #gdlr#; }'
					),
					'sub-menu-text-hover-background-color' => array(
						'title' => esc_html__('Sub Menu Text Hover Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#393939',
						'selector'=> '.sf-menu > li > .sub-menu a:hover, ' . 
							'.sf-menu > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-menu > li > .sub-menu .current-menu-ancestor > a, '.
							'.sf-menu > .zurf-mega-menu > .sf-mega a:hover, '.
							'.sf-menu > .zurf-mega-menu > .sf-mega .current-menu-item > a, '.
							'.sf-vertical > li > .sub-menu a:hover, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-ancestor > a{ background-color: #gdlr#; }'
					),
					'sub-mega-menu-title-color' => array(
						'title' => esc_html__('Sub Mega Menu Title Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.zurf-navigation .sf-menu > .zurf-mega-menu .sf-mega-section-inner > a{ color: #gdlr#; }'
					),
					'sub-mega-menu-divider-color' => array(
						'title' => esc_html__('Sub Mega Menu Divider Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#424242',
						'selector'=> '.zurf-navigation .sf-menu > .zurf-mega-menu .sf-mega-section{ border-color: #gdlr#; }'
					),
					'sub-menu-shadow-size' => array(
						'title' => esc_html__('Sub Menu Shadow Size', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
					),
					'sub-menu-shadow-opacity' => array(
						'title' => esc_html__('Sub Menu Shadow Opacity', 'zurf'),
						'type' => 'text',
						'default' => '0.15',
					),
					'sub-menu-shadow-color' => array(
						'title' => esc_html__('Sub Menu Shadow Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector-extra' => true,
						'selector' => '.zurf-navigation .sf-menu > .zurf-normal-menu .sub-menu, .zurf-navigation .sf-menu > .zurf-mega-menu .sf-mega{ ' . 
							'box-shadow: 0px 0px <sub-menu-shadow-size>t rgba(#gdlra#, <sub-menu-shadow-opacity>t); ' .
							'-webkit-box-shadow: 0px 0px <sub-menu-shadow-size>t rgba(#gdlra#, <sub-menu-shadow-opacity>t); ' .
							'-moz-box-shadow: 0px 0px <sub-menu-shadow-size>t rgba(#gdlra#, <sub-menu-shadow-opacity>t); }',
					),
					'fixed-menu-shadow-size' => array(
						'title' => esc_html__('Fixed Menu Shadow Size', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
					),
					'fixed-menu-shadow-opacity' => array(
						'title' => esc_html__('Fixed Menu Shadow Opacity', 'zurf'),
						'type' => 'text',
						'default' => '0.15',
					),
					'fixed-menu-shadow-color' => array(
						'title' => esc_html__('Fixed Menu Shadow Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector-extra' => true,
						'selector' => '.zurf-fixed-navigation.zurf-style-fixed, .zurf-fixed-navigation.zurf-style-slide{ ' . 
							'box-shadow: 0px 0px <fixed-menu-shadow-size>t rgba(#gdlra#, <fixed-menu-shadow-opacity>t); ' .
							'-webkit-box-shadow: 0px 0px <fixed-menu-shadow-size>t rgba(#gdlra#, <fixed-menu-shadow-opacity>t); ' .
							'-moz-box-shadow: 0px 0px <fixed-menu-shadow-size>t rgba(#gdlra#, <fixed-menu-shadow-opacity>t); }',
					),
					'side-menu-text-color' => array(
						'title' => esc_html__('Side Menu Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#979797',
						'selector'=> '.mm-navbar .mm-title, .mm-navbar .mm-btn, ul.mm-listview li > a, ul.mm-listview li > span{ color: #gdlr#; }' . 
							'ul.mm-listview li a{ border-color: #gdlr#; }' .
							'.mm-arrow:after, .mm-next:after, .mm-prev:before{ border-color: #gdlr#; }'
					),
					'side-menu-text-hover-color' => array(
						'title' => esc_html__('Side Menu Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.mm-navbar .mm-title:hover, .mm-navbar .mm-btn:hover, ' .
							'ul.mm-listview li a:hover, ul.mm-listview li > span:hover, ' . 
							'ul.mm-listview li.current-menu-item > a, ul.mm-listview li.current-menu-ancestor > a, ul.mm-listview li.current-menu-ancestor > span{ color: #gdlr#; }'
					),
					'side-menu-background-color' => array(
						'title' => esc_html__('Side Menu Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#1f1f1f',
						'selector'=> '.mm-menu{ background-color: #gdlr#; }'
					),
					'side-menu-border-color' => array(
						'title' => esc_html__('Side Menu Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#626262',
						'selector'=> 'ul.mm-listview li{ border-color: #gdlr#; }'
					),
					'overlay-menu-background-color' => array(
						'title' => esc_html__('Overlay/Modern Menu Background Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector'=> '.zurf-overlay-menu-content{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.88); }'  . 
							'.zurf-modern-menu-display{ background: #gdlr#; }'
					),
					'overlay-menu-border-color' => array(
						'title' => esc_html__('Overlay/Modern Menu Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#424242',
						'selector'=> '.zurf-overlay-menu-content ul.menu > li, .zurf-overlay-menu-content ul.sub-menu ul.sub-menu{ border-color: #gdlr#; }' . 
							'.zyth-modern-menu-nav ul li a:after{ background: #gdlr#; }'
					),
					'overlay-menu-text-color' => array(
						'title' => esc_html__('Overlay/Modern Menu Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.zurf-overlay-menu-content ul li a, .zurf-overlay-menu-content .zurf-overlay-menu-close{ color: #gdlr#; }' . 
							'.zyth-modern-menu-content .zyth-modern-menu-close, .zyth-modern-menu-nav-back, ' . 
							'.zyth-modern-menu-nav ul li a, .zyth-modern-menu-nav ul li a:hover, .zyth-modern-menu-nav ul li i{ color: #gdlr#; }'
					),
					'overlay-menu-text-hover-color' => array(
						'title' => esc_html__('Overlay/Modern Menu Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#a8a8a8',
						'selector'=> '.zurf-overlay-menu-content ul li a:hover{ color: #gdlr#; }'
					),
					'anchor-bullet-background-color' => array(
						'title' => esc_html__('Anchor Bullet Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#777777',
						'selector'=> '.zurf-bullet-anchor a:before{ background-color: #gdlr#; }'
					),
					'anchor-bullet-background-active-color' => array(
						'title' => esc_html__('Anchor Bullet Background Active', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.zurf-bullet-anchor a:hover, .zurf-bullet-anchor a.current-menu-item{ border-color: #gdlr#; }' .
							'.zurf-bullet-anchor a:hover:before, .zurf-bullet-anchor a.current-menu-item:before{ background: #gdlr#; }'
					),		
				) // navigation-menu-options
			);	

		}
	}

	if( !function_exists('zurf_navigation_right_color_options') ){
		function zurf_navigation_right_color_options(){

			return array(
				'title' => esc_html__('Navigation Right', 'zurf'),
				'options' => array(

					'navigation-bar-right-icon-color' => array(
						'title' => esc_html__('Navigation Bar Right Icon Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector'=> '.zurf-main-menu-search i, .zurf-main-menu-cart i{ color: #gdlr#; }'
					),
					'woocommerce-cart-icon-number-background' => array(
						'title' => esc_html__('Woocommmerce Cart\'s Icon Number Background', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#bd584e',
						'selector'=> '.zurf-main-menu-cart > .zurf-top-cart-count{ background-color: #gdlr#; }'
					),
					'woocommerce-cart-icon-number-color' => array(
						'title' => esc_html__('Woocommmerce Cart\'s Icon Number Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.zurf-main-menu-cart > .zurf-top-cart-count{ color: #gdlr#; }'
					),
					'navigation-right-button-text-color' => array(
						'title' => esc_html__('Navigation Right Button Text Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector'=> '.zurf-body .zurf-main-menu-right-button{ color: #gdlr#; }'
					),
					'navigation-right-button-text-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#555555',
						'selector'=> '.zurf-body .zurf-main-menu-right-button:hover{ color: #gdlr#; }'
					),
					'navigation-right-button-background-color' => array(
						'title' => esc_html__('Navigation Right Button Background Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '',
						'selector'=> '.zurf-body .zurf-main-menu-right-button{ background-color: #gdlr#; }'
					),
					'navigation-right-button-background-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Background Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '',
						'selector'=> '.zurf-body .zurf-main-menu-right-button:hover{ background-color: #gdlr#; }'
					),
					'navigation-right-button-border-color' => array(
						'title' => esc_html__('Navigation Right Button Border Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector'=> '.zurf-body .zurf-main-menu-right-button{ border-color: #gdlr#; }'
					),
					'navigation-right-button-border-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Border Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'default' => '#555555',
						'selector'=> '.zurf-body .zurf-main-menu-right-button:hover{ border-color: #gdlr#; }'
					),
					'navigation-right-button2-text-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Text Color', 'zurf'),
						'type' => 'colorpicker',
						'selector'=> '.zurf-body .zurf-main-menu-right-button.zurf-button-2{ color: #gdlr#; }'
					),
					'navigation-right-button2-text-hover-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Text Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'selector'=> '.zurf-body .zurf-main-menu-right-button.zurf-button-2:hover{ color: #gdlr#; }'
					),
					'navigation-right-button2-background-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Background Color', 'zurf'),
						'type' => 'colorpicker',
						'selector'=> '.zurf-body .zurf-main-menu-right-button.zurf-button-2{ background-color: #gdlr#; }'
					),
					'navigation-right-button2-background-hover-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Background Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'selector'=> '.zurf-body .zurf-main-menu-right-button.zurf-button-2:hover{ background-color: #gdlr#; }'
					),
					'navigation-right-button2-border-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Border Color', 'zurf'),
						'type' => 'colorpicker',
						'selector'=> '.zurf-body .zurf-main-menu-right-button.zurf-button-2{ border-color: #gdlr#; }'
					),
					'navigation-right-button2-border-hover-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Border Hover Color', 'zurf'),
						'type' => 'colorpicker',
						'selector'=> '.zurf-body .zurf-main-menu-right-button.zurf-button-2:hover{ border-color: #gdlr#; }'
					),
					'navigation-right-button-shadow-color' => array(
						'title' => esc_html__('Main Navigation Right Button Shadow Color', 'zurf'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector' => '.zurf-main-menu-right-button.zurf-style-round-with-shadow{ box-shadow: 0px 4px 18px rgba(#gdlra#, 0.11); -webkit-box-shadow: 0px 4px 18px rgba(#gdlra#, 0.11); } '
					),

				)
			);

		}
	}