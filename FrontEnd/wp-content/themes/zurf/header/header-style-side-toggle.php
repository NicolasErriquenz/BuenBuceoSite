<?php
	/* a template for displaying the header area */
?>	
<header class="zurf-header-wrap zurf-header-style-side-toggle" >
	<?php
		$display_logo = zurf_get_option('general', 'header-side-toggle-display-logo', 'enable');
		if( $display_logo == 'enable' ){
			echo zurf_get_logo(array('padding' => false));
		}

		$navigation_class = '';
		if( zurf_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
			$navigation_class = 'zurf-navigation-submenu-indicator ';
		}
	?>
	<div class="zurf-navigation clearfix <?php echo esc_attr($navigation_class); ?>" >
	<?php
		// print main menu
		if( has_nav_menu('main_menu') ){
			zurf_get_custom_menu(array(
				'container-class' => 'zurf-main-menu',
				'button-class' => 'zurf-side-menu-icon',
				'icon-class' => 'fa fa-bars',
				'id' => 'zurf-main-menu',
				'theme-location' => 'main_menu',
				'type' => zurf_get_option('general', 'header-side-toggle-menu-type', 'overlay')
			));
		}
	?>
	</div><!-- zurf-navigation -->
	<?php

		// menu right side
		$enable_search = (zurf_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
		$enable_cart = (zurf_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
		if( $enable_search || $enable_cart ){ 
			echo '<div class="zurf-header-icon zurf-pos-bottom" >';

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
</header><!-- header -->