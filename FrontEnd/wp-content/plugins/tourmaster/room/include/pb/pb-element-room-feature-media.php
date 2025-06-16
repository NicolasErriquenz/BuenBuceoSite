<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/

	add_action('plugins_loaded', 'tourmaster_add_pb_element_room_feature_media');
	if( !function_exists('tourmaster_add_pb_element_room_feature_media') ){
		function tourmaster_add_pb_element_room_feature_media(){

			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('room_feature_media', 'tourmaster_pb_element_room_feature_media'); 
			}
			
		}
	}
	
	if( !class_exists('tourmaster_pb_element_room_feature_media') ){
		class tourmaster_pb_element_room_feature_media{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-header',
					'title' => esc_html__('Room (Single) Feature Media', 'tourmaster')
				);
			}
			
			// return the element options
			static function get_options(){
				return apply_filters('tourmaster_room_search_item_options', array(		
					'general' => array(
						'title' => esc_html__('General', 'tourmaster'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'tourmaster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => '30px'
							),
						)
					),
				));
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings, true);
				return $content;
			}			

			// get the content from settings
			static function get_content( $settings = array(), $preview = false ){
				
				// default variable
				$settings = empty($settings)? array(): $settings;

				if( !$preview ){
					$room_option = tourmaster_get_post_meta(get_the_ID(), 'tourmaster-room-option');
					$feature_media = tourmaster_get_room_feature_media($room_option);
					if( empty($feature_media) ) return '';
				} 

				$ret  = '<div class="tourmaster-room-feature-media-item tourmaster-item-mglr tourmaster-item-pdb clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != '30px' ){
					$ret .= tourmaster_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				if( $preview ){
					$ret .= '<div class="gdlr-core-external-plugin-message">' . esc_html__('This item display inner feature media for single room. You can set the feature media at room settings area.', 'tourmaster') . '</div>';
				}else{
					$ret .= $feature_media;
				}

				$ret .= '</div>'; // tourmaster-room-title-item
				
				return $ret;
			}		

		} // tourmaster_pb_element_tour
	} // class_exists	

	if( !function_exists('tourmaster_get_room_feature_media') ){
		function tourmaster_get_room_feature_media($room_option){
			$ret = '';

			if( !empty($room_option['inner-feature-image']) && $room_option['inner-feature-image'] == 'gallery' ){
				if( !empty($room_option['inner-image-lb-gallery'][0]['id']) ){
					$thumbnail_size = empty($room_option['inner-feature-image-size'])? 'full': $room_option['inner-feature-image-size']; 
					$ret .= '<div class="tourmaster-room-single-feature-thumbnail tourmaster-item-mglr tourmaster-media-image" >';
					$ret .= tourmaster_get_image($room_option['inner-image-lb-gallery'][0]['id'], $thumbnail_size);
	
					$lb_group = 'tourmaster-single-header-gallery';
					$count = 0;
	
					$ret .= '<div class="tourmaster-single-header-gallery-wrap" >';
					foreach($room_option['inner-image-lb-gallery'] as $slider){ $count++;
						$lightbox_atts = array(
							'url' => tourmaster_get_image_url($slider['id']), 
							'group' => $lb_group
						);
	
						if( $count == 1 ){
							$lightbox_atts['class'] = 'tourmaster-single-header-gallery-button';
							$ret .= '<a ' . tourmaster_get_lightbox_atts($lightbox_atts) . ' >';
							if( function_exists('grindelwald_gdlr_core_use_font_icons') ){
								$ret .= '<i class="gdw-icon-imagesmode" ></i>';
							}else{
								$ret .= '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path d="M3.709 31.401c-0.916 0-1.69-0.317-2.325-0.951s-0.951-1.409-0.951-2.325v-24.257c0-0.916 0.317-1.69 0.951-2.325s1.409-0.951 2.325-0.951h24.257c0.916 0 1.69 0.317 2.325 0.951s0.951 1.409 0.951 2.325v24.257c0 0.916-0.317 1.69-0.951 2.325s-1.409 0.951-2.325 0.951h-24.257zM3.709 28.683h24.257c0.14 0 0.267-0.058 0.383-0.174s0.174-0.244 0.174-0.383v-24.257c0-0.14-0.058-0.267-0.174-0.383s-0.244-0.174-0.383-0.174h-24.257c-0.14 0-0.267 0.058-0.383 0.174s-0.174 0.244-0.174 0.383v24.257c0 0.14 0.058 0.267 0.174 0.383s0.244 0.174 0.383 0.174zM6.323 24.605h19.169l-5.959-7.946-5.089 6.622-3.625-4.636-4.496 5.96zM9.494 11.919c0.627 0 1.162-0.221 1.603-0.662s0.662-0.976 0.662-1.603c0-0.627-0.221-1.162-0.662-1.603s-0.976-0.662-1.603-0.662-1.162 0.221-1.603 0.662c-0.442 0.441-0.662 0.976-0.662 1.603s0.221 1.162 0.662 1.603c0.441 0.442 0.976 0.662 1.603 0.662z"></path></svg>';
							}
							$ret .= '</a>';
						}else{
							$ret .= '<a ' . tourmaster_get_lightbox_atts($lightbox_atts) . ' ></a>';
						}
						
					}
	
					if( !empty($room_option['inner-image-lb-video-url']) ){
						$ret .= '<a ' . tourmaster_get_lightbox_atts(array(
							'class' => 'tourmaster-single-header-gallery-button',
							'type' => 'video', 
							'url' => $room_option['inner-image-lb-video-url']
						)) . ' >';
						if( function_exists('grindelwald_gdlr_core_use_font_icons') ){
							$ret .= '<i class="gdw-icon-play_arrow" ></i>';
						}else{
							$ret .= '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path d="M3.458 28.389v-24.922c0-0.888 0.285-1.585 0.856-2.093s1.237-0.761 1.998-0.761c0.254 0 0.507 0.032 0.761 0.095s0.507 0.159 0.761 0.285l19.595 12.556c0.444 0.317 0.777 0.666 0.999 1.046s0.333 0.824 0.333 1.332-0.111 0.951-0.333 1.332c-0.222 0.38-0.555 0.729-0.999 1.046l-19.595 12.556c-0.254 0.127-0.507 0.222-0.761 0.285s-0.507 0.095-0.761 0.095c-0.761 0-1.427-0.254-1.998-0.761s-0.856-1.205-0.856-2.093zM6.122 28.674l20.166-12.746-20.166-12.746v25.493z"></path></svg>';
						}
						$ret .= '</a>';
					}
	
					$ret .= '</div>';
					$ret .= '</div>';
				}
			}

			return $ret;
		}
	}