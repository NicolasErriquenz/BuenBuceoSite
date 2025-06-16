<?php
	/* a template for displaying the top bar */

	if( zurf_get_option('general', 'enable-top-bar', 'enable') == 'enable' ){

		$top_bar_width = zurf_get_option('general', 'top-bar-width', 'boxed');
		$top_bar_container_class = '';

		if( $top_bar_width == 'boxed' ){
			$top_bar_container_class = 'zurf-container ';
		}else if( $top_bar_width == 'custom' ){
			$top_bar_container_class = 'zurf-top-bar-custom-container ';
		}else{
			$top_bar_container_class = 'zurf-top-bar-full ';
		}

		$top_bar_menu = zurf_get_option('general', 'top-bar-menu-position', 'none');
		$top_bar_social = zurf_get_option('general', 'enable-top-bar-social', 'enable');
		$top_bar_social_position = zurf_get_option('general', 'top-bar-social-position', 'right');
		$top_bar_bottom_border = zurf_get_option('general', 'top-bar-bottom-border-style', 'outer');
		$top_bar_split_border = zurf_get_option('general', 'top-bar-split-border', 'disable');

		$header_style = zurf_get_option('general', 'header-style', 'plain');
		$header_plain_style = zurf_get_option('general', 'header-plain-style', 'menu-right');
		$middle_logo = $header_style == 'plain' && $header_plain_style == 'top-bar-logo';

		$top_bar_class  = $top_bar_bottom_border == 'inner'? ' zurf-inner': '';
		$top_bar_class .= $top_bar_split_border == 'enable'? ' zurf-splited-border': '';
		$top_bar_class .= $middle_logo? ' zurf-middle-logo': '';
		echo '<div class="zurf-top-bar ' . esc_attr($top_bar_class) . '" >';
		echo '<div class="zurf-top-bar-background" ></div>';
		echo '<div class="zurf-top-bar-container ' . esc_attr($top_bar_container_class) . '" >';
		echo '<div class="zurf-top-bar-container-inner clearfix" >';

		$language_flag = zurf_get_wpml_flag();
		$left_text = zurf_get_option('general', 'top-bar-left-text', '');
		echo '<div class="zurf-top-bar-left zurf-item-pdlr">';
		ob_start();
		if( $top_bar_menu == 'left' ){
			zurf_get_top_bar_menu('left');
		}
		echo gdlr_core_escape_content($language_flag);
		echo gdlr_core_escape_content(gdlr_core_text_filter($left_text));
		$top_bar_left_text = ob_get_contents();
		ob_end_clean();
		if( !empty($top_bar_left_text) ){
			echo '<div class="zurf-top-bar-left-text">' . $top_bar_left_text . '</div>';
		}

		// social
		if( $top_bar_social == 'enable' && $top_bar_social_position == 'left' ){
			echo '<div class="zurf-top-bar-right-social" >';
			get_template_part('header/header', 'social');
			echo '</div>';	
		}

		// user top bar
		if( function_exists('tourmaster_user_top_bar') ){
			echo tourmaster_user_top_bar();
		}
		echo '</div>';

		if( $middle_logo ){
			echo zurf_get_logo();
		}

		$right_text = zurf_get_option('general', 'top-bar-right-text', '');
		$custom_top_bar_right = apply_filters('zurf_custom_top_bar_right', ''); 

		echo '<div class="zurf-top-bar-right zurf-item-pdlr">';
		if( $top_bar_menu == 'right' ){
			zurf_get_top_bar_menu('right');
		}

		if( !empty($right_text) ){
			echo '<div class="zurf-top-bar-right-text">';
			echo gdlr_core_escape_content(gdlr_core_text_filter($right_text));
			echo '</div>';
		}

		if( $top_bar_social == 'enable' && $top_bar_social_position == 'right' ){
			echo '<div class="zurf-top-bar-right-social" >';
			get_template_part('header/header', 'social');
			echo '</div>';	

			$top_bar_social = 'disable';
		}

		if( !empty($custom_top_bar_right) ){
			echo gdlr_core_text_filter($custom_top_bar_right);
		}
		if( $middle_logo && function_exists('tourmaster_navigation_currency') ){
			echo tourmaster_navigation_currency('');
			remove_filter('zurf_custom_main_menu_right', 'tourmaster_navigation_currency', 9);
		}
		echo '</div>';
			
		echo '</div>'; // zurf-top-bar-container-inner
		echo '</div>'; // zurf-top-bar-container
		echo '</div>'; // zurf-top-bar

	}  // top bar
?>