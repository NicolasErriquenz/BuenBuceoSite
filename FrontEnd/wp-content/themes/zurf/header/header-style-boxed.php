<?php
	/* a template for displaying the header area */

	// header container
	$header_width = zurf_get_option('general', 'header-width', 'boxed');
	
	if( $header_width == 'boxed' ){
		$header_container_class = ' zurf-container';
	}else if( $header_width == 'custom' ){
		$header_container_class = ' zurf-header-custom-container';
	}else{
		$header_container_class = ' zurf-header-full';
	}

	$header_style = zurf_get_option('general', 'header-boxed-style', 'menu-right');
	$navigation_offset = zurf_get_option('general', 'fixed-navigation-anchor-offset', '');

	$header_wrap_class  = ' zurf-style-' . $header_style;
	$header_wrap_class .= ' zurf-sticky-navigation zurf-style-slide';
?>	
<header class="zurf-header-wrap zurf-header-style-boxed <?php echo esc_attr($header_wrap_class); ?>" <?php
		if( !empty($navigation_offset) ){
			echo 'data-navigation-offset="' . esc_attr($navigation_offset) . '" ';
		}
	?> >
	<div class="zurf-header-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<div class="zurf-header-container-inner clearfix">	

			<div class="zurf-header-background  zurf-item-mglr" ></div>
			<div class="zurf-header-container-item clearfix">
				<?php

					if( $header_style == 'splitted-menu' ){
						global $zurf_center_nav_item;
						$zurf_center_nav_item = zurf_get_logo();
					}else{
						echo zurf_get_logo();
					}

					$navigation_class = '';
					if( zurf_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
						$navigation_class = 'zurf-navigation-submenu-indicator ';
					}
				?>
				<div class="zurf-navigation zurf-item-pdlr clearfix <?php echo esc_attr($navigation_class); ?>" >
				<?php
					// print main menu
					if( has_nav_menu('main_menu') ){
						echo '<div class="zurf-main-menu" id="zurf-main-menu" >';
						wp_nav_menu(array(
							'theme_location'=>'main_menu', 
							'container'=> '', 
							'menu_class'=> 'sf-menu',
							'walker' => new zurf_menu_walker()
						));
						
						zurf_get_navigation_slide_bar();
						
						echo '</div>';
					}

					if( $header_style == 'splitted-menu' ){
						$zurf_center_nav_item = '';
					}

					// menu right side
					$menu_right_class = '';
					if( $header_style == 'center-menu' || $header_style == 'splitted-menu' ){
						$menu_right_class = ' zurf-item-mglr zurf-navigation-top zurf-navigation-right';
					}

					$enable_search = (zurf_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
					$enable_cart = (zurf_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
					$enable_right_button = (zurf_get_option('general', 'enable-main-navigation-right-button', 'disable') == 'enable')? true: false;
					$custom_main_menu_right = apply_filters('zurf_custom_main_menu_right', '');
					$side_content_menu = (zurf_get_option('general', 'side-content-menu', 'disable') == 'enable')? true: false;
					if( has_nav_menu('right_menu') || $enable_search || $enable_cart || $enable_right_button || !empty($custom_main_menu_right) || $side_content_menu ){
						echo '<div class="zurf-main-menu-right-wrap clearfix ' . esc_attr($menu_right_class) . '" >';

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

						// custom menu right
						if( !empty($custom_main_menu_right) ){
							echo gdlr_core_text_filter($custom_main_menu_right);
						}

						// menu right button
						if( $enable_right_button ){
							$button_class = 'zurf-style-' . zurf_get_option('general', 'main-navigation-right-button-style', 'default');
							$button_link = zurf_get_option('general', 'main-navigation-right-button-link', '');
							$button_link_target = zurf_get_option('general', 'main-navigation-right-button-link-target', '_self');
							if( !empty($button_link) ){
								echo '<a class="zurf-main-menu-right-button zurf-button-1 ' . esc_attr($button_class) . '" href="' . esc_url($button_link) . '" target="' . esc_attr($button_link_target) . '" >';
								echo zurf_get_option('general', 'main-navigation-right-button-text', '');
								echo '</a>';
							}
							
							$button_class = 'zurf-style-' . zurf_get_option('general', 'main-navigation-right-button-style-2', 'default');
							$button_link = zurf_get_option('general', 'main-navigation-right-button-link-2', '');
							$button_link_target = zurf_get_option('general', 'main-navigation-right-button-link-target-2', '_self');
							if( !empty($button_link) ){
								echo '<a class="zurf-main-menu-right-button zurf-button-2 ' . esc_attr($button_class) . '" href="' . esc_url($button_link) . '" target="' . esc_attr($button_link_target) . '" >';
								echo zurf_get_option('general', 'main-navigation-right-button-text-2', '');
								echo '</a>';
							}
						}

						// print right menu
						$secondary_menu = zurf_get_option('general', 'enable-secondary-menu', 'enable');
						if( has_nav_menu('right_menu') && $secondary_menu == 'enable' && $header_style != 'splitted-menu' ){
							zurf_get_custom_menu(array(
								'container-class' => 'zurf-main-menu-right',
								'button-class' => 'zurf-right-menu-button zurf-top-menu-button',
								'icon-class' => 'fa fa-bars',
								'id' => 'zurf-right-menu',
								'theme-location' => 'right_menu',
								'type' => zurf_get_option('general', 'right-menu-type', 'right')
							));
						}

						if( $side_content_menu ){
							$side_content_widget = zurf_get_option('general', 'side-content-widget', '');
							if( is_active_sidebar($side_content_widget) ){ 
								echo '<div class="zurf-side-content-menu-button" ><span></span></div>';
							}
						}

						echo '</div>'; // zurf-main-menu-right-wrap

						if( has_nav_menu('right_menu') && $header_style == 'splitted-menu' ){
							echo '<div class="zurf-main-menu-left-wrap clearfix zurf-item-pdlr zurf-navigation-top zurf-navigation-left" >';
							zurf_get_custom_menu(array(
								'container-class' => 'zurf-main-menu-right',
								'button-class' => 'zurf-right-menu-button zurf-top-menu-button',
								'icon-class' => 'fa fa-bars',
								'id' => 'zurf-right-menu',
								'theme-location' => 'right_menu',
								'type' => zurf_get_option('general', 'right-menu-type', 'right')
							));
							echo '</div>';
						}
					}
				?>
				</div><!-- zurf-navigation -->

			</div><!-- zurf-header-container-inner -->
		</div><!-- zurf-header-container-item -->
	</div><!-- zurf-header-container -->
</header><!-- header -->