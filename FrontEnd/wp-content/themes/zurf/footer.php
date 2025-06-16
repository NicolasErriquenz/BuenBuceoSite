<?php
/**
 * The template for displaying the footer
 */
	
	$post_option = zurf_get_post_option(get_the_ID());
	if( empty($post_option['enable-footer']) || $post_option['enable-footer'] == 'default' ){
		$enable_footer = zurf_get_option('general', 'enable-footer', 'enable');
	}else{
		$enable_footer = $post_option['enable-footer'];
	}	
	if( empty($post_option['enable-copyright']) || $post_option['enable-copyright'] == 'default' ){
		$enable_copyright = zurf_get_option('general', 'enable-copyright', 'enable');
	}else{
		$enable_copyright = $post_option['enable-copyright'];
	}

	$fixed_footer = zurf_get_option('general', 'fixed-footer', 'disable');
	echo '</div>'; // zurf-page-wrapper

	if( $enable_footer == 'enable' || $enable_copyright == 'enable' ){

		if( $fixed_footer == 'enable' ){
			echo '</div>'; // zurf-body-wrapper

			echo '<footer class="zurf-fixed-footer" id="zurf-fixed-footer" >';
		}else{
			echo '<footer>';
		}

		if( $enable_footer == 'enable' ){

			$zurf_footer_layout = array(
				'footer-1'=>array('zurf-column-60'),
				'footer-2'=>array('zurf-column-15', 'zurf-column-15', 'zurf-column-15', 'zurf-column-15'),
				'footer-3'=>array('zurf-column-15', 'zurf-column-15', 'zurf-column-30',),
				'footer-4'=>array('zurf-column-20', 'zurf-column-20', 'zurf-column-20'),
				'footer-5'=>array('zurf-column-20', 'zurf-column-40'),
				'footer-6'=>array('zurf-column-40', 'zurf-column-20'),
				'footer-7'=>array('zyth-column-15', 'zyth-column-30', 'zyth-column-15'),
			);
			$footer_style = zurf_get_option('general', 'footer-style');
			$footer_style = empty($footer_style)? 'footer-2': $footer_style;

			$count = 0;
			$has_widget = false;
			foreach( $zurf_footer_layout[$footer_style] as $layout ){ $count++;
				if( is_active_sidebar('footer-' . $count) ){ $has_widget = true; }
			}

			if( $has_widget ){ 	

				$footer_column_divider = zurf_get_option('general', 'enable-footer-column-divider', 'enable');
				$extra_class  = ($footer_column_divider == 'enable')? ' zurf-with-column-divider': '';

				echo '<div class="zurf-footer-wrapper ' . esc_attr($extra_class) . '" >';
				echo '<div class="zurf-footer-container zurf-container clearfix" >';
				
				$count = 0;
				foreach( $zurf_footer_layout[$footer_style] as $layout ){ $count++;
					echo '<div class="zurf-footer-column zurf-item-pdlr ' . esc_attr($layout) . '" >';
					if( is_active_sidebar('footer-' . $count) ){
						dynamic_sidebar('footer-' . $count); 
					}
					echo '</div>';
				}
				
				echo '</div>'; // zurf-footer-container
				echo '</div>'; // zurf-footer-wrapper 
			}
		} // enable footer

		if( $enable_copyright == 'enable' ){
			$copyright_style = zurf_get_option('general', 'copyright-style', 'center');
			
			if( $copyright_style == 'center' ){
				$copyright_text = zurf_get_option('general', 'copyright-text');

				if( !empty($copyright_text) ){
					echo '<div class="zurf-copyright-wrapper" >';
					echo '<div class="zurf-copyright-container zurf-container">';
					echo '<div class="zurf-copyright-text zurf-item-pdlr">';
					echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_text));
					echo '</div>';
					echo '</div>';
					echo '</div>'; // zurf-copyright-wrapper
				}
			}else if( $copyright_style == 'left-right' ){
				$copyright_left = zurf_get_option('general', 'copyright-left');
				$copyright_right = zurf_get_option('general', 'copyright-right');

				if( !empty($copyright_left) || !empty($copyright_right) ){
					echo '<div class="zurf-copyright-wrapper" >';
					echo '<div class="zurf-copyright-container zurf-container clearfix">';
					if( !empty($copyright_left) ){
						echo '<div class="zurf-copyright-left zurf-item-pdlr">';
						echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_left));
						echo '</div>';
					}

					if( !empty($copyright_right) ){
						echo '<div class="zurf-copyright-right zurf-item-pdlr">';
						echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_right));
						echo '</div>';
					}
					echo '</div>';
					echo '</div>'; // zurf-copyright-wrapper
				}
			}
		}

		echo '</footer>';

		if( $fixed_footer == 'disable' ){
			echo '</div>'; // zurf-body-wrapper
		}
		echo '</div>'; // zurf-body-outer-wrapper

	// disable footer	
	}else{
		echo '</div>'; // zurf-body-wrapper
		echo '</div>'; // zurf-body-outer-wrapper
	}

	$header_style = zurf_get_option('general', 'header-style', 'plain');
	
	if( $header_style == 'side' || $header_style == 'side-toggle' ){
		echo '</div>'; // zurf-header-side-nav-content
	}

	$back_to_top = zurf_get_option('general', 'enable-back-to-top', 'disable');
	if( $back_to_top == 'enable' ){
		echo '<a href="#zurf-top-anchor" class="zurf-footer-back-to-top-button" id="zurf-footer-back-to-top-button"><i class="fa fa-angle-up" ></i></a>';
	}

	// side content menu
	$side_content_menu = (zurf_get_option('general', 'side-content-menu', 'disable') == 'enable')? true: false;
	if( $side_content_menu ){
		$side_content_widget = zurf_get_option('general', 'side-content-widget', '');	

		if( is_active_sidebar($side_content_widget) ){ 
			echo '<div id="zurf-side-content-menu" >';
			echo '<i class="zurf-side-content-menu-close ion-android-close" ></i>';
			dynamic_sidebar($side_content_widget); 
			echo '</div>';
		}
	}	
?>

<?php wp_footer(); ?>

</body>
</html>