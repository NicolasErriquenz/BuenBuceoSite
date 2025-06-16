<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	$zurf_admin_option->add_element(array(
	
		// typography head section
		'title' => esc_html__('Typography', 'zurf'),
		'slug' => 'zurf_typography',
		'icon' => get_template_directory_uri() . '/include/options/images/typography.png',
		'options' => array(
		
			// starting the subnav
			'font-family' => array(
				'title' => esc_html__('Font Family', 'zurf'),
				'options' => array(
					'google-font-display' => array(
						'title' => esc_html__('Google Font Display', 'zurf'),
						'type' => 'combobox',
						'options' => array( 
							'' => esc_html__('Auto', 'zurf'),
							'block' => esc_html__('Block', 'zurf'),
							'swap' => esc_html__('Swap', 'zurf'),
							'fallback' => esc_html__('Fall Back', 'zurf'),
							'optional' => esc_html__('Optional', 'zurf'),
						),
						'default' => 'optional',
						'description' => wp_kses(__('This option could increase the page speed result of your site. You can learn more about the font display <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/@font-face/font-display" target="_blank" >here</a>', 'zurf'), array('a'=>array('href'=>array(), 'target'=>array())))
					),
					'heading-font' => array(
						'title' => esc_html__('Heading Font', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.zurf-body h1, .zurf-body h2, .zurf-body h3, ' . 
							'.zurf-body h4, .zurf-body h5, .zurf-body h6, .zurf-body .zurf-title-font,' .
							'.zurf-body .gdlr-core-title-font{ font-family: #gdlr#; }' . 
							'.woocommerce-breadcrumb, .woocommerce span.onsale, ' .
							'.single-product.woocommerce div.product p.price .woocommerce-Price-amount, .single-product.woocommerce #review_form #respond label{ font-family: #gdlr#; }'
					),
					'navigation-font' => array(
						'title' => esc_html__('Navigation Font', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.zurf-navigation .sf-menu > li > a, .zurf-navigation .sf-vertical > li > a, .zurf-navigation-font{ font-family: #gdlr#; }'
					),	
					'content-font' => array(
						'title' => esc_html__('Content Font', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.zurf-body, .zurf-body .gdlr-core-content-font, ' . 
							'.zurf-body input, .zurf-body textarea, .zurf-body button, .zurf-body select, ' . 
							'.zurf-body .zurf-content-font, .gdlr-core-audio .mejs-container *{ font-family: #gdlr#; }'
					),
					'info-font' => array(
						'title' => esc_html__('Info Font', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.zurf-body .gdlr-core-info-font, .zurf-body .zurf-info-font{ font-family: #gdlr#; }'
					),
					'blog-info-font' => array(
						'title' => esc_html__('Blog Info Font', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.zurf-body .gdlr-core-blog-info-font, .zurf-body .zurf-blog-info-font{ font-family: #gdlr#; }'
					),
					'quote-font' => array(
						'title' => esc_html__('Quote Font', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.zurf-body .gdlr-core-quote-font, blockquote{ font-family: #gdlr#; }'
					),
					'testimonial-font' => array(
						'title' => esc_html__('Testimonial Font', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.zurf-body .gdlr-core-testimonial-content{ font-family: #gdlr#; }'
					),
					'additional-font' => array(
						'title' => esc_html__('Additional Font', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'customizer' => false,
						'default' => 'Georgia, serif',
						'description' => esc_html__('Additional font you want to include for custom css.', 'zurf'),
						'selector' => '.zurf-additional-font{ font-family: #gdlr# !important; }'
					),
					'additional-font2' => array(
						'title' => esc_html__('Additional Font2', 'zurf'),
						'type' => 'font',
						'data-type' => 'font',
						'customizer' => false,
						'default' => 'Georgia, serif',
						'description' => esc_html__('Additional font you want to include for custom css.', 'zurf'),
						'selector' => '.zurf-additional-font2{ font-family: #gdlr# !important; }'
					),
					
				) // font-family-options
			), // font-family-nav
			
			'font-size' => array(
				'title' => esc_html__('Font Size', 'zurf'),
				'options' => array(
				
					'h1-font-size' => array(
						'title' => esc_html__('H1 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '52px',
						'selector' => '.zurf-body h1{ font-size: #gdlr#; }'
					),					
					'h2-font-size' => array(
						'title' => esc_html__('H2 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '48px',
						'selector' => '.zurf-body h2, #poststuff .gdlr-core-page-builder-body h2{ font-size: #gdlr#; }' 
					),					
					'h3-font-size' => array(
						'title' => esc_html__('H3 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '36px',
						'selector' => '.zurf-body h3{ font-size: #gdlr#; }' 
					),					
					'h4-font-size' => array(
						'title' => esc_html__('H4 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '28px',
						'selector' => '.zurf-body h4{ font-size: #gdlr#; }' 
					),					
					'h5-font-size' => array(
						'title' => esc_html__('H5 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '22px',
						'selector' => '.zurf-body h5{ font-size: #gdlr#; }' 
					),					
					'h6-font-size' => array(
						'title' => esc_html__('H6 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '18px',
						'selector' => '.zurf-body h6{ font-size: #gdlr#; }' 
					),				
					'header-font-weight' => array(
						'title' => esc_html__('Header Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-body h1, .zurf-body h2, .zurf-body h3, .zurf-body h4, .zurf-body h5, .zurf-body h6{ font-weight: #gdlr#; }' . 
							'#poststuff .gdlr-core-page-builder-body h1, #poststuff .gdlr-core-page-builder-body h2{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),
					'content-font-size' => array(
						'title' => esc_html__('Content Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.zurf-body{ font-size: #gdlr#; }' 
					),
					'content-font-weight' => array(
						'title' => esc_html__('Content Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-body{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),
					'content-line-height' => array(
						'title' => esc_html__('Content Line Height', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '1.7',
						'selector' => '.zurf-body, .zurf-line-height, .gdlr-core-line-height{ line-height: #gdlr#; }'
					),
					
				) // font-size-options
			), // font-size-nav			
			
			'mobile-font-size' => array(
				'title' => esc_html__('Mobile Font Size', 'zurf'),
				'options' => array(

					'mobile-h1-font-size' => array(
						'title' => esc_html__('Mobile H1 Size', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .zurf-body h1{ font-size: #gdlr#; } }' 
					),
					'mobile-h2-font-size' => array(
						'title' => esc_html__('Mobile H2 Size', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .zurf-body h2, #poststuff .gdlr-core-page-builder-body h2{ font-size: #gdlr#; } }' 
					),
					'mobile-h3-font-size' => array(
						'title' => esc_html__('Mobile H3 Size', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .zurf-body h3{ font-size: #gdlr#; } }' 
					),
					'mobile-h4-font-size' => array(
						'title' => esc_html__('Mobile H4 Size', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .zurf-body h4{ font-size: #gdlr#; } }' 
					),
					'mobile-h5-font-size' => array(
						'title' => esc_html__('Mobile H5 Size', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .zurf-body h5{ font-size: #gdlr#; } }' 
					),
					'mobile-h6-font-size' => array(
						'title' => esc_html__('Mobile H6 Size', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .zurf-body h6{ font-size: #gdlr#; } }' 
					),					
					'mobile-content-font-size' => array(
						'title' => esc_html__('Mobile Content Font Size', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .zurf-body{ font-size: #gdlr#; } }' 
					),

				)
			),

			'navigation-font-size' => array(
				'title' => esc_html__('Navigation Font Size', 'zurf'),
				'options' => array(	
					'navigation-font-size' => array(
						'title' => esc_html__('Navigation Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '14px',
						'selector' => '.zurf-navigation .sf-menu > li > a, .zurf-navigation .sf-vertical > li > a{ font-size: #gdlr#; }' 
					),	
					'navigation-font-weight' => array(
						'title' => esc_html__('Navigation Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '800',
						'selector' => '.zurf-navigation .sf-menu > li > a, .zurf-navigation .sf-vertical > li > a{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),	
					'navigation-font-letter-spacing' => array(
						'title' => esc_html__('Navigation Font Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-navigation .sf-menu > li > a, .zurf-navigation .sf-vertical > li > a{ letter-spacing: #gdlr#; }'
					),
					'navigation-text-transform' => array(
						'title' => esc_html__('Navigation Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'uppercase',
						'selector' => '.zurf-navigation .sf-menu > li > a, .zurf-navigation .sf-vertical > li > a{ text-transform: #gdlr#; }',
					),
					'sub-navigation-font-size' => array(
						'title' => esc_html__('Sub Navigation Font Size', 'zurf'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.zurf-navigation .sf-menu > .zurf-normal-menu .sub-menu, .zurf-navigation .sf-menu>.zurf-mega-menu .sf-mega-section-inner .sub-menu a{ font-size: #gdlr#; }' 
					),
					'sub-navigation-font-weight' => array(
						'title' => esc_html__('Sub Navigation Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '800',
						'selector' => '.zurf-navigation .sf-menu > .zurf-normal-menu .sub-menu, .zurf-navigation .sf-menu>.zurf-mega-menu .sf-mega-section-inner .sub-menu a{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),	
					'sub-navigation-font-letter-spacing' => array(
						'title' => esc_html__('Sub Navigation Font Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-navigation .sf-menu > .zurf-normal-menu .sub-menu, .zurf-navigation .sf-menu>.zurf-mega-menu .sf-mega-section-inner .sub-menu a{ letter-spacing: #gdlr#; }'
					),
					'sub-navigation-text-transform' => array(
						'title' => esc_html__('Sub Navigation Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'uppercase',
						'selector' => '.zurf-navigation .sf-menu > .zurf-normal-menu .sub-menu, .zurf-navigation .sf-menu>.zurf-mega-menu .sf-mega-section-inner .sub-menu a{ text-transform: #gdlr#; }',
					),
					'navigation-right-button-font-size' => array(
						'title' => esc_html__('Navigation Right Button Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '11px',
						'selector' => '.zurf-main-menu-right-button{ font-size: #gdlr#; }' 
					),	
					'navigation-right-button-font-weight' => array(
						'title' => esc_html__('Navigation Right Button Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-main-menu-right-button{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),	
					'navigation-right-button-font-letter-spacing' => array(
						'title' => esc_html__('Navigation Right Button Font Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-main-menu-right-button{ letter-spacing: #gdlr#; }'
					),
					'navigation-right-button-text-transform' => array(
						'title' => esc_html__('Navigation Right Button Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'uppercase',
						'selector' => '.zurf-main-menu-right-button{ text-transform: #gdlr#; }',
					),
				) // font-size-options
			), // font-size-nav
			
			'footer-font-size' => array(
				'title' => esc_html__('Sidebar / Footer Font Size', 'zurf'),
				'options' => array(
					
					'widget-h1-font-size' => array(
						'title' => esc_html__('Widget H1 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '52px',
						'selector' => '.zurf-widget h1{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'widget-h2-font-size' => array(
						'title' => esc_html__('Widget H2 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '48px',
						'selector' => '.zurf-widget h2{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'widget-h3-font-size' => array(
						'title' => esc_html__('Widget H3 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '36px',
						'selector' => '.zurf-widget h3{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'widget-h4-font-size' => array(
						'title' => esc_html__('Widget H4 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '28px',
						'selector' => '.zurf-widget h4{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'widget-h5-font-size' => array(
						'title' => esc_html__('Widget H5 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '22px',
						'selector' => '.zurf-widget h5{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'widget-h6-font-size' => array(
						'title' => esc_html__('Widget H6 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '18px',
						'selector' => '.zurf-widget h6{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),
					'widget-heading-font-weight' => array(
						'title' => esc_html__('Widget Heading Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-widget h1, .zurf-widget h2, .zurf-widget h3, .zurf-widget h4, .zurf-widget h5, .zurf-widget h6{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),	
					'widget-heading-letter-spacing' => array(
						'title' => esc_html__('Widget Heading Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-widget h1, .zurf-widget h2, .zurf-widget h3, .zurf-widget h4, .zurf-widget h5, .zurf-widget h6{ letter-spacing: #gdlr#; }'
					),
					'widget-heading-text-transform' => array(
						'title' => esc_html__('Widget Heading Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'none',
						'selector' => '.zurf-widget h1, .zurf-widget h2, .zurf-widget h3, .zurf-widget h4, .zurf-widget h5, .zurf-widget h6{ text-transform: #gdlr#; }',
					),

					'sidebar-title-font-size' => array(
						'title' => esc_html__('Sidebar Title Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '13px',
						'selector' => '.zurf-sidebar-area .zurf-widget-title{ font-size: #gdlr#; }' 
					),
					'sidebar-title-font-weight' => array(
						'title' => esc_html__('Sidebar Title Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-sidebar-area .zurf-widget-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),	
					'sidebar-title-font-letter-spacing' => array(
						'title' => esc_html__('Sidebar Title Font Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-sidebar-area .zurf-widget-title{ letter-spacing: #gdlr#; }'
					),
					'sidebar-title-text-transform' => array(
						'title' => esc_html__('Sidebar Title Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'uppercase',
						'selector' => '.zurf-sidebar-area .zurf-widget-title{ text-transform: #gdlr#; }',
					),
					'footer-title-font-size' => array(
						'title' => esc_html__('Footer Title Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '13px',
						'selector' => '.zurf-footer-wrapper .zurf-widget-title{ font-size: #gdlr#; }' 
					),
					'footer-title-font-weight' => array(
						'title' => esc_html__('Footer Title Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-footer-wrapper .zurf-widget-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),	
					'footer-title-font-letter-spacing' => array(
						'title' => esc_html__('Footer Title Font Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-footer-wrapper .zurf-widget-title{ letter-spacing: #gdlr#; }' . 
							'.zurf-footer-wrapper .zurf-widget h1, .zurf-footer-wrapper .zurf-widget h2, .zurf-footer-wrapper .zurf-widget h3, .zurf-footer-wrapper .zurf-widget h4, .zurf-footer-wrapper .zurf-widget h5, .zurf-footer-wrapper .zurf-widget h6{ letter-spacing: #gdlr#; }'
					),
					'footer-title-text-transform' => array(
						'title' => esc_html__('Footer Title Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'uppercase',
						'selector' => '.zurf-footer-wrapper .zurf-widget-title{ text-transform: #gdlr#; }',
					),
					'footer-h1-font-size' => array(
						'title' => esc_html__('Footer H1 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '52px',
						'selector' => '.zurf-footer-wrapper .zurf-widget h1{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'footer-h2-font-size' => array(
						'title' => esc_html__('Footer H2 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '48px',
						'selector' => '.zurf-footer-wrapper .zurf-widget h2{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'footer-h3-font-size' => array(
						'title' => esc_html__('Footer H3 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '36px',
						'selector' => '.zurf-footer-wrapper .zurf-widget h3{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'footer-h4-font-size' => array(
						'title' => esc_html__('Footer H4 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '28px',
						'selector' => '.zurf-footer-wrapper .zurf-widget h4{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'footer-h5-font-size' => array(
						'title' => esc_html__('Footer H5 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '22px',
						'selector' => '.zurf-footer-wrapper .zurf-widget h5{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),					
					'footer-h6-font-size' => array(
						'title' => esc_html__('Footer H6 Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '18px',
						'selector' => '.zurf-footer-wrapper .zurf-widget h6{ font-size: #gdlr#; }',
						'description' => esc_html__('For Heading Widget item', 'zurf')
					),
					'footer-font-size' => array(
						'title' => esc_html__('Footer Content Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.zurf-footer-wrapper{ font-size: #gdlr#; }' 
					),
					'footer-content-font-weight' => array(
						'title' => esc_html__('Footer Content Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-footer-wrapper .widget_text{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),	
					'footer-content-text-transform' => array(
						'title' => esc_html__('Footer Content Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'none',
						'selector' => '.zurf-footer-wrapper .widget_text{ text-transform: #gdlr#; }',
					),
					'footer-content-line-height' => array(
						'title' => esc_html__('Footer Content Line Height', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '1.7',
						'selector' => '.zurf-footer-wrapper .widget_text{ line-height: #gdlr#; }'
					),
					'copyright-font-size' => array(
						'title' => esc_html__('Copyright Font Size', 'zurf'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '14px',
						'selector' => '.zurf-copyright-text, .zurf-copyright-left, .zurf-copyright-right{ font-size: #gdlr#; }' 
					),
					'copyright-font-weight' => array(
						'title' => esc_html__('Copyright Font Weight', 'zurf'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.zurf-copyright-text, .zurf-copyright-left, .zurf-copyright-right{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'zurf')
					),	
					'copyright-font-letter-spacing' => array(
						'title' => esc_html__('Copyright Font Letter Spacing', 'zurf'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.zurf-copyright-text, .zurf-copyright-left, .zurf-copyright-right{ letter-spacing: #gdlr#; }'
					),
					'copyright-text-transform' => array(
						'title' => esc_html__('Copyright Text Transform', 'zurf'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'zurf'),
							'lowercase' => esc_html__('Lowercase', 'zurf'),
							'capitalize' => esc_html__('Capitalize', 'zurf'),
							'none' => esc_html__('None', 'zurf'),
						),
						'default' => 'uppercase',
						'selector' => '.zurf-copyright-text, .zurf-copyright-left, .zurf-copyright-right{ text-transform: #gdlr#; }',
					),
				)
			),

			'font-upload' => array(
				'title' => esc_html__('Font Uploader', 'zurf'),
				'reload-after' => true,
				'customizer' => false,
				'options' => array(
					
					'font-upload' => array(
						'title' => esc_html__('Upload Fonts', 'zurf'),
						'type' => 'custom',
						'item-type' => 'fontupload',
						'wrapper-class' => 'gdlr-core-fullsize',
					),
					
				) // fontupload-options
			), // fontupload-nav
		
		) // typography-options
		
	), 4);