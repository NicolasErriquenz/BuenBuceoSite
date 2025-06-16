<?php
	// mobile menu template
	echo '<div class="zurf-mobile-header-wrap" >';

	// top bar
	$enable_top_bar_mobile = zurf_get_option('general', 'enable-top-bar-on-mobile', 'disable');
	if( $enable_top_bar_mobile == 'enable' ){
		get_template_part('header/header', 'top-bar');
	}

	// header
	$logo_position = zurf_get_option('general', 'mobile-logo-position', 'logo-left');
	$sticky_mobile_nav = zurf_get_option('general', 'enable-mobile-navigation-sticky', 'enable');
	echo '<div class="zurf-mobile-header zurf-header-background zurf-style-slide ';
	if($sticky_mobile_nav == 'enable'){
		echo 'zurf-sticky-mobile-navigation ';
	}
	echo '" id="zurf-mobile-header" >';
	echo '<div class="zurf-mobile-header-container zurf-container clearfix" >';
	echo zurf_get_logo(array(
		'mobile' => true,
		'wrapper-class' => ($logo_position == 'logo-center'? 'zurf-mobile-logo-center': '')
	));

	echo '<div class="zurf-mobile-menu-right" >';

	// search icon
	$enable_search = (zurf_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
	if( $enable_search ){
		echo '<div class="zurf-main-menu-search" id="zurf-mobile-top-search" >';
		echo '<i class="fa fa-search" ></i>';
		echo '</div>';
		zurf_get_top_search();
	}

	// cart icon
	$enable_cart = (zurf_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
	if( $enable_cart ){
		echo '<div class="zurf-main-menu-cart" id="zurf-mobile-menu-cart" >';
		echo '<i class="fa fa-shopping-cart" data-zurf-lb="top-bar" ></i>';
		zurf_get_woocommerce_bar();
		echo '</div>';
	}

	if( $logo_position == 'logo-center' ){
		echo '</div>';
		echo '<div class="zurf-mobile-menu-left" >';
	}

	$enable_top_bar = zurf_get_option('general', 'enable-top-bar', 'enable');
	if( $enable_top_bar == 'disable' || $enable_top_bar_mobile == 'disable' ){
		if( function_exists('tourmaster_user_top_bar') ){
			echo tourmaster_user_top_bar();
		}
	}
		
	// mobile menu
	if( has_nav_menu('mobile_menu') ){
		zurf_get_custom_menu(array(
			'type' => zurf_get_option('general', 'right-menu-type', 'right'),
			'container-class' => 'zurf-mobile-menu',
			'button-class' => 'zurf-mobile-menu-button',
			'icon-class' => 'fa fa-bars',
			'id' => 'zurf-mobile-menu',
			'theme-location' => 'mobile_menu'
		));
	}

	

	echo '</div>'; // zurf-mobile-menu-right/left
	echo '</div>'; // zurf-mobile-header-container
	echo '</div>'; // zurf-mobile-header

	echo '</div>'; // zurf-mobile-header-wrap