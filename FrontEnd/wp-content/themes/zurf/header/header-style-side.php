<?php
	/* a template for displaying the header area */

	$header_side_style = zurf_get_option('general', 'header-side-style', 'top-left');
	$header_class = 'zurf-' . zurf_get_option('general', 'header-side-align', 'left') . '-align';
?>	
<header class="zurf-header-wrap zurf-header-style-side <?php echo esc_attr($header_class); ?>" >
	<?php

		$logo_wrap_class = '';
		$navigation_class = '';
		if( zurf_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
			$navigation_class .= 'zurf-navigation-submenu-indicator ';
		}
		if( in_array($header_side_style, array('middle-left-2', 'middle-right-2')) ){
			$logo_wrap_class .= 'zurf-pos-middle ';
		}else if( in_array($header_side_style, array('middle-left', 'middle-right')) ){
			$navigation_class .= 'zurf-pos-middle ';
		} 

		echo zurf_get_logo(array('padding' => false, 'wrapper-class' => $logo_wrap_class));
	?>
	<div class="zurf-navigation clearfix <?php echo esc_attr($navigation_class); ?>" >
	<?php
		// print main menu
		if( has_nav_menu('main_menu') ){
			echo '<div class="zurf-main-menu" id="zurf-main-menu" >';
			wp_nav_menu(array(
				'theme_location'=>'main_menu', 
				'container'=> '', 
				'menu_class'=> 'sf-vertical'
			));
			echo '</div>';
		}

		// menu right side
		$enable_search = (zurf_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
		$enable_cart = (zurf_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
		if( $enable_search || $enable_cart ){
			echo '<div class="zurf-main-menu-right-wrap clearfix" >';

			// search icon
			if( $enable_search ){
				$search_icon = zurf_get_option('general', 'main-navigation-search-icon', 'fa fa-search');
				echo '<div class="zurf-main-menu-search" id="zurf-top-search" >';
				echo '<i class="' . esc_attr($search_icon) . '" ></i>';
				echo '</div>';
				zurf_get_top_search();
			}

			// cart icon
			if( $enable_cart ){
				$cart_icon = zurf_get_option('general', 'main-navigation-cart-icon', 'fa fa-shopping-cart');
				echo '<div class="zurf-main-menu-cart" id="zurf-main-menu-cart" >';
				echo '<i class="' . esc_attr($cart_icon) . '" data-zurf-lb="top-bar" ></i>';
				zurf_get_woocommerce_bar();
				echo '</div>';
			}

			echo '</div>'; // zurf-main-menu-right-wrap
		}
	?>
	</div><!-- zurf-navigation -->
	<?php
		// social network
		$top_bar_social = zurf_get_option('general', 'enable-top-bar-social', 'enable');
		if( $top_bar_social == 'enable' ){

			$top_bar_social_class = '';
			if( in_array($header_side_style, array('top-left', 'top-right', 'middle-left', 'middle-right')) ){
				$top_bar_social_class .= 'zurf-pos-bottom ';
			}

			echo '<div class="zurf-header-social ' . esc_attr($top_bar_social_class) . '" >';
			get_template_part('header/header', 'social');
			echo '</div>';
			
			zurf_set_option('general', 'enable-top-bar-social', 'disable');
		}
	?>
</header><!-- header -->