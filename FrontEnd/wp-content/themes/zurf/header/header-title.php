<?php
	/* a template for displaying the page title */

	$page_title = '';
	$page_caption = '';

	$title_style = zurf_get_option('general', 'default-title-style', 'small');
	$title_align = zurf_get_option('general', 'default-title-align', 'left');

	// header gradient
	$header_gradient = zurf_get_option('general', 'page-title-top-bottom-gradient', 'none');

	// for index page
	if( is_home() ){
		$main_head = true;
		$page_title = esc_html__('Blog', 'zurf');

	// tribe event
	}else if( is_singular( 'tribe_events' ) ){

		global $zurf_event_id;

		$page_title = get_the_title($zurf_event_id);

		$events_label_plural = tribe_get_event_label_plural();
		$event_link  = '<div class="zurf-page-title-event-link" >';
		$event_link .= '<a href="' . esc_url(tribe_get_events_link()) . '">';
		$event_link .= sprintf('&laquo; ' . esc_html_x('All %s', '%s Events plural label', 'zurf'), $events_label_plural);
		$event_link .= '</a>';
		$event_link .= '</div>';

		$event_time = tribe_events_event_schedule_details($zurf_event_id, '', '');
		if( tribe_get_cost($zurf_event_id) ){
			$event_time .= '<span class="tribe-events-cost">' . tribe_get_cost($zurf_event_id, true) . '</span>';
		}
		if( !empty($event_time) ){
			$event_time = '<div class="zurf-page-title-event-time" >' . $event_time . '</div>';
		}

	// for single post
	}else if( is_single() && get_post_type() == 'post' ){

	}else if( is_single() && get_post_type() == 'room' ){

	}else if( is_single() && get_post_type() == 'tour' ){


	// for single product
	}else if( is_single() && get_post_type() == 'product' ){

		echo '<div class="zurf-header-transparent-substitute" ></div>';

	// for pages
	}else if( is_page() || is_single() ){
		$post_option = zurf_get_post_option(get_the_ID());

		$main_head = true;
		$page_title = get_the_title();
		$page_caption = empty($post_option['page-caption'])? '': $post_option['page-caption'];

		if( !empty($post_option['title-background']) ){
			$title_background = $post_option['title-background'];
		}
		if( !empty($post_option['title-background-radius']) ){
			$title_background_radius = $post_option['title-background-radius'];
		}

		$title_color = empty($post_option['title-color'])? '': $post_option['title-color'];
		$caption_color = empty($post_option['caption-color'])? '': $post_option['caption-color'];
		$background_overlay_color = empty($post_option['title-background-overlay-color'])? '': $post_option['title-background-overlay-color'];
		if( !empty($post_option['title-align']) && $post_option['title-align'] != 'default' ){
			$title_align = $post_option['title-align'];
		}

		if( !empty($post_option['title-style']) && $post_option['title-style'] != 'default' ){
			$title_style = $post_option['title-style'];

			if( $post_option['title-style'] == 'custom' ){
				$title_size = empty($post_option['title-font-size'])? '': $post_option['title-font-size'];
				$title_weight = empty($post_option['title-font-weight'])? '': $post_option['title-font-weight'];
				$title_transform = empty($post_option['title-font-transform'])? '': $post_option['title-font-transform'];
				$title_spacing = empty($post_option['title-spacing'])? array(): $post_option['title-spacing'];
				$title_overlay_opacity = empty($post_option['title-background-overlay-opacity'])? '': $post_option['title-background-overlay-opacity'];
			}
		}

		// gradient
		if( !empty($post_option['top-bottom-gradient']) && $post_option['top-bottom-gradient'] != 'default' ){
			$header_gradient = $post_option['top-bottom-gradient'];
		}

		// breadcrumbs
		if( empty($post_option['enable-breadcrumbs']) || $post_option['enable-breadcrumbs'] == 'default' ){
			$breadcrumbs = zurf_get_option('general', 'enable-breadcrumbs', 'disable');
		}else{
			$breadcrumbs = $post_option['enable-breadcrumbs'];
		}


	// 404 page
	}else if( is_404() ){

	// search page
	}else if( is_search() ){

		if( have_posts() ){
			$page_title = esc_html__('Search Results', 'zurf');
			$page_caption = get_search_query();
		}else{
			get_template_part('content/archive', 'not-found');
		}

	// archive page
	}else if( is_archive() ){

		if( !class_exists('gdlr_core_pb_element_product') && 
			((function_exists('is_shop') && is_shop()) || is_tax('product_cat') || is_tax('product_tag')) ){
			$page_title = '';
			$page_caption = '';
			echo '<div class="zurf-header-transparent-substitute" ></div>';

		}else if( is_category() || is_tax('portfolio_category') || is_tax('product_cat') ){
			$page_title = esc_html__('Category', 'zurf');

			if( is_tax('product_cat') && function_exists('woocommerce_breadcrumb') ){
				ob_start();
				woocommerce_breadcrumb();
				$page_caption = ob_get_contents();
				ob_end_clean();
			}else{
				$page_caption = single_cat_title('', false);
			}
		}else if( is_tag() || is_tax('portfolio_tag') || is_tax('product_tag') ){
			$page_title = esc_html__('Tag', 'zurf');
			
			if( is_tax('product_cat') && function_exists('woocommerce_breadcrumb') ){
				ob_start();
				woocommerce_breadcrumb();
				$page_caption = ob_get_contents();
				ob_end_clean();
			}else{
				$page_caption = single_cat_title('', false);
			}
		}else if( is_day() ){
			$page_title = esc_html__('Day','zurf');
			$page_caption = get_the_date('F j, Y');
		}else if( is_month() ){
			$page_title = esc_html__('Month','zurf');
			$page_caption = get_the_date('F Y');
		}else if( is_year() ){
			$page_title = esc_html__('Year','zurf');
			$page_caption = get_the_date('Y');
		}else if( is_author() ){
			$page_title = esc_html__('By','zurf');
			
			$author_id = get_query_var('author');
			$author = get_user_by('id', $author_id);
			$page_caption = $author->display_name;					
		}else if( is_post_type_archive('product') ){
			$page_title = esc_html__('Shop', 'zurf');
			$page_caption = '';
		}else{
			$page_title = get_the_title();
			$page_caption = '';
		}

	}

	if( (empty($post_option['enable-page-title']) || $post_option['enable-page-title'] == 'enable') && (!empty($page_title) || !empty($page_caption)) ){	

		$page_title = apply_filters('zurf_page_title', $page_title);
		$page_caption = apply_filters('zurf_page_caption', $page_caption);

		$extra_class  = ' zurf-style-' . $title_style;
		$extra_class .= ' zurf-' . $title_align . '-align';

		echo '<div class="zurf-page-title-wrap ' . esc_attr($extra_class) . '" ' . gdlr_core_esc_style(array(
			'background-image' => empty($title_background)? '': $title_background,
			'border-radius' => empty($title_background_radius)? '': $title_background_radius
		)) . '>';
		echo '<div class="zurf-header-transparent-substitute" ></div>';
		echo '<div class="zurf-page-title-overlay" ' . gdlr_core_esc_style(array(
			'opacity' => empty($title_overlay_opacity)? '': $title_overlay_opacity,
			'background-color' => empty($background_overlay_color)? '': $background_overlay_color
		)) . ' ></div>';
		if( $header_gradient == 'top' || $header_gradient == 'both' ){
			echo '<div class="zurf-page-title-top-gradient" ></div>';
		}
		if( $header_gradient == 'bottom' || $header_gradient == 'both' ){
			echo '<div class="zurf-page-title-bottom-gradient" ></div>';
		}
		echo '<div class="zurf-page-title-container zurf-container" >';
		echo '<div class="zurf-page-title-content zurf-item-pdlr" ' . gdlr_core_esc_style(array(
			'padding-top' => empty($title_spacing['padding-top'])? '': $title_spacing['padding-top'],
			'padding-bottom' => empty($title_spacing['padding-bottom'])? '': $title_spacing['padding-bottom']
		)) . ' >';
		
		if( !empty($page_title) ){
			if( !empty($main_head) ){
				echo '<h1 class="zurf-page-title" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['title-size'])? '': $title_size['title-size'],
					'font-weight' => empty($title_weight['title-weight'])? '': $title_weight['title-weight'],
					'text-transform' => (empty($title_transform) || $title_transform == 'default')? '': $title_transform,
					'letter-spacing' => empty($title_size['title-letter-spacing'])? '': $title_size['title-letter-spacing'],
					'color' => empty($title_color)? '': $title_color
				)) . ' >' . $page_title . '</h1>';
			}else{
				echo '<h3 class="zurf-page-title" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['title-size'])? '': $title_size['title-size'],
					'font-weight' => empty($title_weight['title-weight'])? '': $title_weight['title-weight'],
					'text-transform' => (empty($title_transform) || $title_transform == 'default')? '': $title_transform,
					'letter-spacing' => empty($title_size['title-letter-spacing'])? '': $title_size['title-letter-spacing'],
					'color' => empty($title_color)? '': $title_color
				)) . ' >' . $page_title . '</h3>';
			}
		}

		if( !empty($page_caption) ){
			echo '<div class="zurf-page-caption" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['caption-size'])? '': $title_size['caption-size'],
					'font-weight' => empty($title_weight['caption-weight'])? '': $title_weight['caption-weight'],
					'letter-spacing' => empty($title_size['caption-letter-spacing'])? '': $title_size['caption-letter-spacing'],
					'margin-top' => empty($title_spacing['caption-top-margin'])? '': $title_spacing['caption-top-margin'],
					'color' => empty($caption_color)? '': $caption_color
				)) . ' >' . $page_caption . '</div>';
		}

		if( !empty($event_time) ){
			echo gdlr_core_text_filter($event_time);
		}
		if( !empty($event_link) ){
			echo gdlr_core_text_filter($event_link);
		}
		
		echo '</div>'; // zurf-page-title-content
		echo '</div>'; // zurf-page-title-container
		echo '</div>'; // zurf-page-title-wrap

		// breadcrumbs
		if( function_exists('bcn_display') && $breadcrumbs == 'enable' ){
			$breadcrumbs_padding = empty($post_option['breadcrumbs-padding'])? array(): $post_option['breadcrumbs-padding'];

			echo '<div class="zurf-breadcrumbs" ' . gdlr_core_esc_style(array(
				'padding-top' => empty($breadcrumbs_padding['padding-top'])? '': $breadcrumbs_padding['padding-top'],
				'padding-bottom' => empty($breadcrumbs_padding['padding-bottom'])? '': $breadcrumbs_padding['padding-bottom'],
			)) . ' >';
			echo '<div class="zurf-breadcrumbs-container zurf-container" >';
			echo '<div class="zurf-breadcrumbs-item zurf-item-pdlr" >';
       		bcn_display();
       		echo '</div>';
       		echo '</div>';
       		echo '</div>';
    	}
	}
?>