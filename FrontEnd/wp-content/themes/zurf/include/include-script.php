<?php 
	/*	
	*	Goodlayers Script Inclusion File
	*	---------------------------------------------------------------------
	*	This file contains the script that helps you include the script to 
	* 	the location you want
	*	---------------------------------------------------------------------
	*/	

	// return the custom stylesheet path
	if( !function_exists('zurf_get_style_custom') ){
		function zurf_get_style_custom($local = false){

			$upload_dir = wp_upload_dir();
			$filename = '/zurf-style-custom.css';
			$local_file = $upload_dir['basedir'] . $filename;
			
			if( $local ){
				return $local_file;
			}else{
				if( file_exists($local_file) ){
					$filemtime = filemtime($local_file);

					if( is_ssl() ){
						$upload_dir['baseurl'] = str_replace('http://', 'https://', $upload_dir['baseurl']);
					}
					return $upload_dir['baseurl'] . $filename . '?' . $filemtime;
				}else{
					return get_template_directory_uri() . '/css/style-custom.css';
				}
			}
		}
	}

	// use to load theme style.css and necessary wordpress script on specific page
	add_action( 'wp_enqueue_scripts', 'zurf_include_scripts', 11 );
	if( !function_exists('zurf_include_scripts') ){
		function zurf_include_scripts(){
			
			// include plugin css
			if( !function_exists('gdlr_core_front_script') ){
				wp_enqueue_style('zurf-simpleline', get_template_directory_uri() . '/plugins/simpleline/simpleline.css');
				wp_enqueue_style('zurf-gdlr-custom-icon', get_template_directory_uri() . '/plugins/gdlr-custom-icon/gdlr-custom-icon.css');
				wp_enqueue_style('zurf-font-awesome', get_template_directory_uri() . '/plugins/font-awesome/css/font-awesome.min.css');
				wp_enqueue_style('zurf-elegant-font', get_template_directory_uri() . '/plugins/elegant-font/style.css');

				wp_enqueue_style('zurf-google-font-dm-sans', 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=auto');
				wp_enqueue_style('zurf-google-font-merriweather', 'https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=auto');
				wp_enqueue_style('zurf-google-font-open-sans', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=auto');
			}

			// include site style
			wp_enqueue_style('zurf-style-core', get_template_directory_uri() . '/css/style-core.css');
			if( is_rtl() ){
				wp_enqueue_style('zurf-frontend-rtl', get_template_directory_uri() . '/css/frontend-rtl.css');
			}
			
			if( !is_customize_preview() ){
				wp_enqueue_style('zurf-custom-style', zurf_get_style_custom());
			}
			
			// include site script
			wp_enqueue_script('zurf-jquery-mmenu', get_template_directory_uri() . '/js/jquery.mmenu.js', array('jquery', 'jquery-effects-core'), '1.0.0', true );
			wp_enqueue_script('zurf-jquery-superfish', get_template_directory_uri() . '/js/jquery.superfish.js', array('jquery', 'jquery-effects-core'), '1.0.0', true );
			wp_enqueue_script('zurf-script-core', get_template_directory_uri() . '/js/script-core.js', array('jquery', 'jquery-effects-core'), '1.0.0', true );

			// wordpress comments script
			if( is_singular() && comments_open() && get_option('thread_comments') ){
				wp_enqueue_script( 'comment-reply' );
			}			

			// lower than ie9 script
			wp_enqueue_script('html5js', get_template_directory_uri() . '/js/html5.js');
			wp_script_add_data('html5js', 'conditional', 'lt IE 9');
		
		}
	}
	add_action( 'wp_enqueue_scripts', 'zurf_include_child_scripts', 999 );
	if( !function_exists('zurf_include_child_scripts') ){
		function zurf_include_child_scripts(){
			if( is_child_theme() ){
				wp_enqueue_style('zurf-child-theme-style', get_stylesheet_uri());
			}
		}
	}