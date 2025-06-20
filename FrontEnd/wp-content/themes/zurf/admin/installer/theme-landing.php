<?php
	/*	
	*	Goodlayers Getting Start
	*	---------------------------------------------------------------------
	*	This file contains function for getting start page
	*	---------------------------------------------------------------------
	*/
	
	if( !class_exists('zurf_theme_landing') ){
		class zurf_theme_landing{

			private $settings;
			private $is_verified;
			private $error_message;

			function __construct( $settings = array() ){
				
				$this->settings = wp_parse_args($settings, array(
					'parent-slug' => 'goodlayers_main_menu',
					'page-title' => 'Getting Start / Import',
					'menu-title' => 'Getting Start / Import',
					'capability' => 'edit_theme_options',
					'capability' => 'edit_theme_options',
					'slug' => 'theme_landing'
				));

				// add action to create dashboard
				if( class_exists('gdlr_core_admin_option') ){
					gdlr_core_admin_menu::register_menu(array(
						'parent-slug' => $this->settings['parent-slug'],
						'page-title' => $this->settings['page-title'], 
						'menu-title' =>$this->settings['menu-title'], 
						'capability' => $this->settings['capability'], 
						'menu-slug' => $this->settings['slug'], 
						'function' => array(&$this, 'theme_landing_content')
					));
				}else{
					gdlr_core_admin_menu::register_menu(array(
						'main-menu' => true,
						'main-menu-title' => esc_html__('Goodlayers', 'zurf'),
						'parent-slug' => '',
						'page-title' => $this->settings['page-title'], 
						'menu-title' =>$this->settings['menu-title'], 
						'capability' => $this->settings['capability'], 
						'menu-slug' => $this->settings['slug'], 
						'function' => array(&$this, 'theme_landing_content'),
						'icon-url' => get_template_directory_uri() . '/admin/installer/images/admin-option-icon.png',
						'position' => '2.2',
					));
				}

				// enqueue script for getting start page
				add_action('admin_enqueue_scripts', array(&$this, 'enqueue_script'));
				
				// do the form action
				add_action('init', array(&$this, 'check_form'));

				// redirect to landing page upon theme activation
				add_action('after_switch_theme', array(&$this, 'swith_theme_redirect'), 9999); 	

				// add action when finish install plugins
				add_action('zurf_tgmpa_no_item_redirect', array(&$this, 'tgmpa_no_item_redirect'));
			}

			function tgmpa_no_item_redirect(){
				echo '<script type="text/javascript">';
				echo 'window.location = \'' . admin_url('admin.php?page=' . $this->settings['slug']) . '\';';
				echo '</script>';
			}

			// switch theme redirect
			function swith_theme_redirect(){
				wp_redirect(admin_url('admin.php?page=' . $this->settings['slug']));
			}
			
			function check_form(){
				global $pagenow;
				
				// form variable submission
				if( !empty($_GET['page']) && $_GET['page'] == $this->settings['slug'] ){
					if( !empty($_POST['purchase_code']) ){
						try{
							$register = empty($_POST['register'])? 0: 1;
							zurf_verify_purchase($_POST['purchase_code'], $register);
							wp_redirect(admin_url('admin.php?page=' . $this->settings['slug']));
							exit;
						}catch(Exception $e){
							$this->error_message = $e->getMessage();
							if( empty($this->error_message) ){
								$this->error_message = esc_html__('Unknown Error, please contact adminiatrator', 'zurf');
							}
						}
					}
				}
				
			}

			// script for getting start page
			function enqueue_script($hook){
				if( strpos($hook, 'page_' . $this->settings['slug']) !== false ){

					if( function_exists('gdlr_core_include_utility_script') ){
						gdlr_core_include_utility_script();
					}

					// include the admin style
					wp_enqueue_style('font-awesome', get_template_directory_uri() . '/plugins/font-awesome/css/font-awesome.min.css');
					wp_enqueue_style('gdlr-core-getting-start', get_template_directory_uri() . '/admin/installer/css/getting-start.css');
					wp_enqueue_style('open-sans-css', 'https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,latin-ext');
					
					// include the admin script
					wp_enqueue_script('gdlr-core-getting-start', get_template_directory_uri() . '/admin/installer/js/getting-start.js', array('jquery'), false, true);
					wp_localize_script('gdlr-core-getting-start', 'gdlr_core_ajax_message', array(
						'ajaxurl' => admin_url('admin-ajax.php'),
						'error_head' => esc_html__('An error occurs', 'zurf'),
						'error_message' => esc_html__('Please try again. If the problem still persists, please contact administrator for this.', 'zurf'),
						'nonce' => wp_create_nonce('gdlr_core_demo_import'),

						'importing_head' => esc_html__('Importing demo content. Please wait...', 'zurf'),
						'importing_content' => esc_html__('If you choose to download images from demo site, it can take up to 7-8 minutes so please be patient.', 'zurf'),
					));	

					// init variable
					$this->is_verified = zurf_is_purchase_verified();
				}				
			}	

			// generate content for getting start page
			function get_theme_landing_content(){

				$content = array();

				// registration
				$content['registration'] = array(
					'title' => esc_html__('Registration', 'zurf'),
					'type' => 'registration'
				);

				// install plugins section
				if( $this->is_verified ){
					$plugins_complete = zurf_tgmpa_complete();
					if( !$plugins_complete ){
						$content['required-plugins'] = array(
							'title' => esc_html__('Required Plugins', 'zurf'),
							'type' => 'page',
							'content' => '<p>' . wp_kses(__('<strong>Before moving on, please make sure that all required plugins are installed and activated</strong><br>This is very important step to make the theme run properly.', 'zurf'), array('strong'=>array(), 'br'=>array()) ) . 
								'</p><a class="gdlr-core-button" href="' . esc_attr(menu_page_url('tgmpa-install-plugins', false)) . '" >' . esc_html__('Install Required Plugins', 'zurf') . '</a>' .
								'<h3>' . esc_html__('1. Install plugins then click on \'Return To Require Plugins Installer', 'zurf') . '</h3><img src="' . esc_url(get_template_directory_uri() . '/images/getting-start/require-plugin1.jpg') . '" alt="zurf" />' .
								'<h3>' . esc_html__('2. Activate plugins', 'zurf') . '</h3><img src="' . esc_url(get_template_directory_uri() . '/images/getting-start/require-plugin2.jpg') . '" alt="' . esc_attr__('Required Plugin', 'zurf') . '" />'
						);
					}
				}

				// guidelines
				$content['guidelines'] = array(
					'title' => esc_html__('Guidelines', 'zurf'),
					'type' => 'page',
					'content' => 
						wp_kses(__('<h4>1.) Installation</h4>', 'zurf'), array('h4'=>array())) . '<iframe width="560" height="315" src="https://www.youtube.com/embed/_b6dpkJImuY" frameborder="0" allowfullscreen></iframe>' .
						wp_kses(__('<h4>2.) Importing Demo</h4>', 'zurf'), array('h4'=>array())) . '<iframe width="560" height="315" src="https://www.youtube.com/embed/3YmMFTXiWZU" frameborder="0" allowfullscreen></iframe>' .
						wp_kses(__('<h4>3.) Creating Portfolio</h4>', 'zurf'), array('h4'=>array())) . '<iframe width="560" height="315" src="https://www.youtube.com/embed/XFrtHJuPW_4" frameborder="0" allowfullscreen></iframe>' . 
						wp_kses(__('<h4>4.) Creating Personnel</h4>', 'zurf'), array('h4'=>array())) . '<iframe width="560" height="315" src="https://www.youtube.com/embed/MwFxxSlYuAA" frameborder="0" allowfullscreen></iframe>' . 
						wp_kses(__('<h4>5.) Creating Blog</h4>', 'zurf'), array('h4'=>array())) . '<iframe width="560" height="315" src="https://www.youtube.com/embed/fqcdMzTjvrE" frameborder="0" allowfullscreen></iframe>' .
						wp_kses(__('<h4>6.) Goodlayers Page Builder</h4>', 'zurf'), array('h4'=>array())) . '<iframe width="560" height="315" src="https://www.youtube.com/embed/N0haJbDM8ac" frameborder="0" allowfullscreen></iframe>'
				);

				// import demo
				if( $this->is_verified ){
					$content['import-demo'] = array(
						'title' => esc_html__('Import Demo', 'zurf'),
						'type' => 'demo',
						'content' => wp_kses(__('<strong>Get import error?</strong> Please make sure that your server has PHP max_execution_time at least 300, memory_limit at least 512MB. You may set these values temporaly and change it back after finish importing.<br><strong>If you\'re importing main demo (Full Version), PHP max_input_vars is recommended to be at least 4000</strong>', 'zurf'), array('strong'=>array(), 'br'=>array())),
						'demo-content' => wp_kses(
							__('<strong>Main demo (Full verion)</strong> - include all pages shown in demo such as elements, features, about us, services contact, all portfolio pages, all blog pages. It\'s 100+ pages and 170+ images in total.', 'zurf') . '<br><br>' . 
							__('<strong>Main demo (Lite verion)</strong> - include about us, services, few portfolios, few blog pages. Element and feature page are not included.', 'zurf') . '<br><br>' . 
							__('Please also be cautious that over 1000+ images will be generated in main demo.', 'zurf'), 
							array('strong'=>array(), 'br'=>array())),
					);
				}
				

				// system status
				$content['system-status'] = array(
					'title' => esc_html__('System Status', 'zurf'),
					'type' => 'system-status',
					'content' => wp_kses(__('<strong>To import demo content</strong>, PHP max_execution_time at least 300 secs and  memory_limit at least 512MB is recommended. <strong><br>If you\'re importing main demo (Full Version)</strong>, PHP max_input_vars is recommended to be at least 4000.', 'zurf'), array('strong'=>array(), 'br'=>array()))
				);

				// obtain product validation link
				if( !empty($GLOBALS['tgmpa']) ){
					$plugin_slug = 'envato-market';
					$plugin_url = 'envato-market';
					$product_validation_url = zurf_tgmpa_auto_install_url($plugin_slug,  $plugin_url);

					$tgmpa = call_user_func(array(get_class($GLOBALS['tgmpa']), 'get_instance'));
					if( !$tgmpa->is_plugin_installed($plugin_slug) ){
						$content['get-automatic-updates'] = array(
							'title' => esc_html__('Get Automatic Updates', 'zurf'),
							'type' => 'page',
							'content' => wp_kses(__('<p><strong>To get automatic updates, you need to install and activate the plugin \'Envato Market\'</strong>.<br>You\'ll also need API Personal Token for verification. Please read for instruction in plugin settings.</p>', 'zurf'), array('strong'=>array(), 'br'=>array(), 'p'=> array()) ) . 
								'<a class="gdlr-core-button" href="' . esc_url($product_validation_url) . '" >' . esc_html__('Get envato market plugin now!', 'zurf') . '</a>'
						);
					}else{
						$content['get-automatic-updates'] = array(
							'title' => esc_html__('Get Automatic Updates', 'zurf'),
							'type' => 'page',
							'content' => wp_kses(__('<p><strong>To get automatic updates</strong>, you need to fill the infomation in \'Envato Market\' plugin page.<br>You need to retrieve API Personal Token for verification. Please read for instruction in plugin settings.</p>', 'zurf'), array('strong'=>array(), 'br'=>array(), 'p'=> array()) ) . 
								'<a class="gdlr-core-button" href="' . esc_url($product_validation_url) . '" >' . esc_html__('Go to plugin settings!', 'zurf') . '</a>'
						);
					}
				}

				// support
				$content['support'] = array(
					'title' => esc_html__('Support', 'zurf'),
					'type' => 'page',
					'content' => wp_kses(__('<p><strong>Have questions about how to use the theme?</strong></p><p>Make sure that you read all through the document we provided. The document is contained in main package that you downloaded from Themeforest. It\'s in the folder \'Document-Instruction\', open the file \'index.html\' with your browser. Or you can view online document here.</p>', 'zurf'), array('strong'=>array(), 'br'=>array(), 'p'=> array()) ) . 
						'<a class="gdlr-core-button" target="_blank" href="http://demo.goodlayers.com/document/zurf" >' . esc_html__('View Online Document', 'zurf') . '</a><br><br>' .
						wp_kses(__('<p><strong>Have problems or can\'t find answer in the document?</strong></p><p>1. Make sure that you are running the latest version of the theme.<br>2. Make sure that you deeply checked theme\'s instruction and try to search for public tickets in case of someone else asked the same question before. <br> 3. Try to deactivate all plugins (Except Goodlayers plugins) and see if the problem resolved or not.</p>', 'zurf'), array('strong'=>array(), 'br'=>array(), 'p'=> array()) ) .
						wp_kses(sprintf(__('<p>After doing these steps and still see the problem, feel free to submit tickets in our support website. Our supporter are happy to help you.<br><strong>Please note that you will need Purchase code to submit the ticket</strong> - <a href="%s" target="_blank" >How to get purchased code?</a></p>', 'zurf'), 'https://help.market.envato.com/hc/en-us/articles/202822600'), array('strong'=>array(), 'br'=>array(), 'p'=> array(), 'a'=>array('href'=>array(), 'target'=>array())) ) .
						'<a class="gdlr-core-button" target="_blank" href="http://support.goodlayers.com" >' . esc_html__('Go to support website', 'zurf') . '</a>'
				);

				return $content;
			}

			function theme_landing_content(){

				$content = $this->get_theme_landing_content();

				echo '<div class="gdlr-core-getting-start-wrap clearfix" >';
				$this->get_header();
				$this->get_content($content);
				echo '</div>'; // gdlr-core-getting-start-wrap

				if( isset($_GET['phpinfo']) ) print_r( phpinfo() );
			}

			// header section
			function get_header(){
				echo '<div class="gdlr-core-getting-start-header clearfix" >';
				echo '<div class="gdlr-core-getting-start-header-image" >';
				echo gdlr_core_get_image(get_template_directory_uri() . '/images/getting-start/header.png');

				$theme_info = wp_get_theme();
				echo '<div class="gdlr-core-getting-start-header-info">';
				echo '<span class="gdlr-core-head" >' . $theme_info->get('Name') . '</span>';
				echo '<span class="gdlr-core-sep" ></span>';
				echo '<span class="gdlr-core-tail" >VER. ' . $theme_info->get('Version') . '</span>';
				echo '</div>';
				echo '</div>'; // gdlr-core-getting-start-header-info

				$this->is_verified = zurf_is_purchase_verified();
				if( $this->is_verified ){
					echo '<div class="gdlr-core-getting-start-header-content zurf-verified" >';
					echo '<p>';
					echo '<i class="fa fa-check" ></i>' . esc_html__('License Registered!', 'zurf');
					echo '<span>(<a href="https://goodlayers.com/licenses/" target="_blank">' . esc_html__('manage your license', 'zurf') . '<i class="fa fa-external-link"></i></a>)</span>';
					echo '</p>';
					
					echo '<h3 class="gdlr-core-getting-start-header-title" >' . esc_html__('Congratulations !', 'zurf') . '</h3>';
					echo '<div class="gdlr-core-getting-start-header-caption" >';
					echo '<strong>' . esc_html__('zurf', 'zurf') . '</strong> ' . esc_html__('WordPress theme is now installed and ready to use. Thank you so much for choosing Goodlayers!', 'zurf');
					echo '</div>';
				}else{
					echo '<div class="gdlr-core-getting-start-header-content zurf-not-verified" >';
					echo '<p><i class="fa fa-close" ></i>' . esc_html__('Unregistered', 'zurf') . '</p>';
					echo '<h3 class="gdlr-core-getting-start-header-title" >' . esc_html__('Please Register Your Website', 'zurf') . '</h3>';
					echo '<div class="gdlr-core-getting-start-header-caption" >';
					echo esc_html__('Zurf requires license registration in order to install the theme\'s core features, import demo content and to be able to update the theme’s core functionalities in the future.', 'zurf');
					echo '</div>';
				}

				
				echo '</div>'; // gdlr-core-getting-start-header-content
				echo '</div>'; // gdlr-core-getting-start-header
			}

			// content section
			function get_content( $options ){
				echo '<div class="gdlr-core-getting-start-content-wrap clearfix" >';

				// nav bar
				$has_active = false;
				echo '<div class="gdlr-core-getting-start-nav" id="gdlr-core-getting-start-nav" >';
				foreach( $options as $slug => $option ){
					if( !empty($option) ){
						echo '<a ';
						if( empty($has_active) && $option['type'] != 'link' ){
							echo ' class="gdlr-core-active" ';
							$has_active = true;
						}
						switch( $option['type'] ){
							case 'link': 
								echo 'href="' . esc_url($option['url']) . '" ';
								echo empty($option['target'])? 'target="_self" ': 'target="' . esc_attr($option['target']) . '" ';
								break;
							default :
								echo 'href="#" data-page="' . esc_attr($slug) . '" ';
						}
						echo ' >' . $option['title'] . '</a>';
					}
				}
				echo '</div>';

				// nav content
				$has_active = false;
				echo '<div class="gdlr-core-getting-start-content" id="gdlr-core-getting-start-content" >';
				foreach( $options as $slug => $option ){
					if( !empty($option) && $option['type'] != 'link' ){
						echo '<div class="gdlr-core-getting-start-page ' . (!$has_active? 'gdlr-core-active': '') . '" data-page="' . esc_attr($slug) . '" >';
						if( !empty($option['content']) ){
							echo '<div class="gdlr-core-getting-start-page-content" >';
							echo gdlr_core_escape_content($option['content']);
							echo '</div>';
						}
						switch( $option['type'] ){
							case 'demo': 
								$content = empty($option['demo-content'])? '': $option['demo-content'];
								$this->get_demo_import($content);
								break;
							case 'system-status':
								$this->get_system_status();
								break;
							case 'registration':
								$this->get_registration();
								break;
						}
						echo '</div>';

						$has_active = true;
					}
				}
				echo '</div>';

				echo '</div>'; // gdlr-core-getting-start-content-wrap
			}

			// registration
			function get_registration(){

				if( $this->is_verified ){
					echo '<div class="zurf-registered" >';
					echo '<h3><i class="fa fa-lock" ></i>' . esc_html__('Your website is registered', 'zurf') . '</h3>';
					echo '<p>';
					echo '<strong>' . esc_html__('You can manage your site\'s registration(such as revoking) via our license portal here :', 'zurf') . '</strong>';
					echo '<a href="https://goodlayers.com/licenses/" target="_blank">https://goodlayers.com/licenses/</a> ';
					echo '<span>(' . esc_html__('You need to create a new account. The account is not the same account in our support portal.', 'zurf') .')<span>';
					echo '</p>';

					$purchase_code = zurf_get_purchase_code();
					echo '<strong class="zurf-large" >' . esc_html__('Your Purchase Code', 'zurf') . ':</strong>';
					echo '<form id="zurf-registration" method="post" >';
					echo '<div class="zurf-input-placeholder" >';
					echo gdlr_core_text_filter($purchase_code);
					echo '</div>';
					echo '<input type="hidden" name="purchase_code" value="' . esc_attr($purchase_code) . '" />';
					echo '<input type="submit" value= "' . esc_html__('Refresh Status', 'zurf') . '" />';
					echo '</form>';
					echo '</div>';

				}else{
					
					if( !empty($this->error_message) ){
						echo '<div class="zurf-notification" ><i class="fa fa-info-circle"></i><p>';
						echo gdlr_core_text_filter($this->error_message);
						echo '</p></div>';
					}else if( function_exists('init_goodlayers_core_system') ){
						echo '<div class="zurf-notification" ><i class="fa fa-info-circle"></i><p>';
						echo esc_html__('You will still be able to use the theme without registration but you will NOT be able to update the core features and the slider. To ensure that you website works smoothly with latest WordPress version and to get latest security improvements, please register your website.', 'zurf');
						echo '</p></div>';
					}

					echo '<h3><i class="fa fa-lock" ></i>' . esc_html__('Register Your Website', 'zurf') . '</h3>';
					echo '<p class="zurf-large" >' . esc_html__('Please enter your theme\'s purchase code to install the theme\'s core features, import demo content and to be able to update the theme\'s core functionalities in the future.', 'zurf') . '</p>';
					
					echo '<form id="zurf-registration" method="post" >';
					echo '<input type="text" name="purchase_code" placeholder="' . esc_html__('Fill purchase code. Ex. baf6XXXX-b2BB-XXXX-cAAb-22XXXXf357A', 'zurf') . '" />';
					echo '<input type="hidden" name="register" value="1" />';
					echo '<input type="submit" value="' . esc_html__('Register Now', 'zurf') . '" />';
					echo '</form>';

					echo '<h4><i class="fa fa-question-circle"></i>' . esc_html__('How to get my purchase code?', 'zurf') . '</h4>';
					echo '<ul>';
					echo '<li>1. Login to your Envato Market (using the account that purchased the item).</li>';
					echo '<li>2. Hover the mouse over your username at the top of the screen.</li>';
					echo '<li>3. Click \'Downloads\' from the drop-down menu.</li>';
					echo '<li>4. Click \'License certificate & purchase code\' (available as PDF or text file)</li>';
					echo '<li>5. Open the file and see the section \'Item Purchase Code\'. It should be looking like this format :</li>';
					echo '</ul>';
					echo '<em>baf6XXXX-b2BB-XXXX-cAAb-22XXXXf357A</em>';

					echo '<p>To learn more aboutthis, please visit: <a href="https://support.goodlayers.com/purchasecode.png" target="_blank">https://support.goodlayers.com/purchasecode.png</a></p>';
				}
				
			}

			// demo import
			function get_demo_import($content){
				echo '<div class="gdlr-core-demo-import-wrap clearfix" id="gdlr-core-demo-import-form" >';

				echo '<div class="gdlr-core-demo-import-success" id="gdlr-core-demo-import-success" ></div>';

				// first
				echo '<div class="gdlr-core-demo-import-section-wrap clearfix" >';
				echo '<div class="gdlr-core-demo-import-section-head" >';
				echo '<span class="gdlr-core-steps">1</span>';
				echo '<span class="gdlr-core-head">' . esc_html__('Select Demo', 'zurf') . '</span>';
				echo '</div>';

				$demo_options = apply_filters('gdlr_core_demo_options', array());

				$first_url = '';
				echo '<div class="gdlr-core-demo-import-list">';
				echo '<div class="gdlr-core-demo-import-combobox" >';
				echo '<select data-name="demo-id" id="gdlr-core-demo-import-option" >';
				foreach( $demo_options as $option_slug => $options ){
					echo '<option value="' . esc_attr($option_slug) . '" data-url="' . esc_url($options['url']) . '" >' . $options['title'] . '</option>';
					$first_url = empty($first_url)? $options['url']: $first_url;
				}	
				echo '</select>';
				echo '</div>';

				echo '<a href="' . esc_url($first_url) . '" class="gdlr-core-view-demo-button" id="gdlr-core-view-demo-button" target="_blank">' . esc_html__('View Demo', 'zurf') . '<i class="fa fa-external-link" ></i></a>';
				
				echo '<div class="gdlr-core-demo-import-list-content" >' . $content . '</div>';
				echo '</div>'; // gdlr-core-demo-import-list
				echo '</div>'; // gdlr-core-demo-import-section-wrap

				// second
				echo '<div class="gdlr-core-demo-import-section-wrap clearfix" >';
				echo '<div class="gdlr-core-demo-import-section-head" >';
				echo '<span class="gdlr-core-steps">2</span>';
				echo '<span class="gdlr-core-head">' . esc_html__('Import Settings', 'zurf') . '</span>';
				echo '</div>';
				echo '<div class="gdlr-core-demo-import-section-option" >';

				echo '<div class="gdlr-core-demo-import-option" >';
				echo '<input type="checkbox" data-name="navigation" checked >';
				echo '<span class="gdlr-core-option-text" >' . esc_html__('Include menu navigation', 'zurf') . '</span>';
				echo '</div>';

				echo '<div class="gdlr-core-demo-import-option" >';
				echo '<input type="checkbox" data-name="post" checked >';
				echo '<span class="gdlr-core-option-text" >' . esc_html__('Include blog posts content from the demo', 'zurf') . '</span>';
				echo '</div>';

				echo '<div class="gdlr-core-demo-import-option" >';
				echo '<input type="checkbox" data-name="portfolio" checked >';
				echo '<span class="gdlr-core-option-text" >' . esc_html__('Include portfolio posts from the demo', 'zurf') . '</span>';
				echo '</div>';

				$image_license_content  = wp_kses(__('Some of the images used in the demo site are licensed. When you import the demo content, your server will download images from our server, which we cannot prevent due to the nature of WordPress XML importing behavior. If you intend to use these images in the final product, <strong>please ensure that you purchase the appropriate licenses</strong>. The links to the images can be found in the main package you downloaded from Themeforest, specifically in the <strong>\'Demo Stuffs > Image Links\' folder(or other similar files)</strong>. Please note that the image files themselves are not directly included in the theme package.', 'zurf'), array('strong' => array()));
				$image_license_content .= '<br><br>';
				$image_license_content .= wp_kses(__('However, it\'s possible that some licensed images may not be listed because they have been removed from the stock photo websites. In this case, we suggest you to change to other images. And some images that are not listed may be freely available to use, such as photos from Unsplash, Rawpixel, Pexels website(but please check terms and conditions on their website first, some websites may require you to create an account and require you to download images from their website directly to create a free license). Please note that free images may not included in some of our themes. ', 'zurf'), array('strong' => array()));
				$image_license_content .= '<br><br>';
				$image_license_content .= wp_kses(__('<strong>We strongly recommend that you replace the images with your own and remove any unused images from the Media section</strong>. Alternatively, ensure that you purchase the proper licenses for the listed images. If you have any doubts about specific images, feel free to contact us, and we will assist you in checking on them.', 'zurf'), array('strong' => array()));
				$image_license_content .= '<br><br>';
				$image_license_content .= wp_kses(__('* We will not assume any responsibility if you fail to follow our instructions, and legal actions are taken against your website by the copyright owner of the photos or their representatives.' , 'zurf'), array('strong' => array()));
				
				echo '<div class="gdlr-core-demo-import-option" >';
				echo '<input type="checkbox" data-name="image" checked >';
				echo '<span class="gdlr-core-option-text" >' . esc_html__('Download images from demo site', 'zurf') . ' ( <a href="#" id="gdlr-core-image-condition" >' . esc_html__('read conditions', 'zurf') . '</a> )</span>';
				echo '<div class="gdlr-core-image-condition-wrap" style="width: 800px; margin-left: -320px; margin-top: -290px;" id="gdlr-core-image-condition-wrap" >';
				echo '<div class="gdlr-core-image-condition-content" >' . $image_license_content . '</div>';
				echo '<div class="gdlr-core-condition-close" ><i class="fa fa-remove" ></i>' . esc_html__('Close', 'zurf') . '</div>';
				echo '</div>';
				echo '</div>';

				$js_image_license_content  = wp_kses(__('You\'re downloading images from our demo website. Please read the statement below carefully.', 'zurf'), array('strong' => array()));
				$js_image_license_content .= '<br><br>';
				$js_image_license_content .= $image_license_content;
				$js_image_license_content .= '<br><br>';
				$js_image_license_content .= wp_kses(__('Please confirm if you want to proceed this.' , 'zurf'), array('strong' => array()));
				$js_image_license_content .= '<br><br>';
				$js_image_license_content .= wp_kses(__('* Please noted that this process could not be undone.' , 'zurf'), array('strong' => array()));
				echo '<script>';
				echo 'window.jsImageLicenseContent = \'' . str_replace("'", "\'", $js_image_license_content) . '\'; ';
				echo '</script>';

				echo '<div class="gdlr-core-demo-import-option" >';
				echo '<input type="checkbox" data-name="theme-option" checked >';
				echo '<span class="gdlr-core-option-text" >' . esc_html__('Import theme options', 'zurf') . ' ( <span class="gdlr-core-red">' . esc_html__('Noted that the current theme option will be overridden', 'zurf') . '</span> )</span>';
				echo '</div>';

				echo '<div class="gdlr-core-demo-import-option" >';
				echo '<input type="checkbox" data-name="widget" checked >';
				echo '<span class="gdlr-core-option-text" >' . esc_html__('Import widget (sidebar & footer)', 'zurf') . '</span>';
				echo '</div>';

				echo '<a class="gdlr-core-demo-import-button" id="gdlr-core-demo-import-submit" >' . esc_html__('Start Import Demo!', 'zurf') . '</a>';
				echo '</div>';
				echo '</div>'; // gdlr-core-demo-import-section-wrap

				echo '</div>'; // gdlr-core-demo-import-wrap
			}

			// system status
			function get_system_status(){
				echo '<div class="gdlr-core-system-status-wrap" >';
				echo '<div class="gdlr-core-system-status-head" >' . esc_html__('System Status', 'zurf') . '</div>';
				echo '<table><tbody>';

				// debug
				echo '<tr>';
				echo '<td class="gdlr-core-table-head" >' . esc_html__('Debug Mode', 'zurf') . '</td>';
				echo '<td class="gdlr-core-table-content" >';
				if( defined('WP_DEBUG') && WP_DEBUG ){
					echo esc_html__('On', 'zurf');
					echo '<span class="gdlr-core-recommendation">' . esc_html__('You should turn debug mode off when you make your site live', 'zurf') . '</div>';
				}else{
					echo esc_html__('Off', 'zurf');
				}
				echo '</td>';
				echo '</tr>';

				// php version
				echo '<tr>';
				echo '<td class="gdlr-core-table-head" >' . esc_html__('PHP Version', 'zurf') . '</td>';
				echo '<td class="gdlr-core-table-content" >';
				if( function_exists('phpversion') ){
					echo phpversion();
				}else{
					echo '-';
				}
				echo '</td>';
				echo '</tr>';

				// wp upload max size
				echo '<tr>';
				echo '<td class="gdlr-core-table-head" >' . esc_html__('wp_max_upload_size', 'zurf') . '</td>';
				echo '<td class="gdlr-core-table-content" >';
				$wp_max_upload_size = wp_max_upload_size();
				echo intval($wp_max_upload_size / 1048576) . 'M';
				echo '</td>';
				echo '</tr>';

				if( function_exists('ini_get') ){

					// upload max size
					echo '<tr>';
					echo '<td class="gdlr-core-table-head" >' . esc_html__('upload_max_filesize', 'zurf') . '</td>';
					echo '<td class="gdlr-core-table-content" >';
					echo ini_get('upload_max_filesize');
					echo '</td>';
					echo '</tr>';

					// post max size
					echo '<tr>';
					echo '<td class="gdlr-core-table-head" >' . esc_html__('post_max_size', 'zurf') . '</td>';
					echo '<td class="gdlr-core-table-content" >';
					echo ini_get('post_max_size');
					echo '</td>';
					echo '</tr>';

					// max execution time
					echo '<tr>';
					echo '<td class="gdlr-core-table-head" >' . esc_html__('max_execution_time', 'zurf') . '</td>';
					echo '<td class="gdlr-core-table-content" >';
					$max_execution_time = ini_get('max_execution_time');
					echo gdlr_core_escape_content($max_execution_time);
					if( $max_execution_time < 300 ){
						echo '<span class="gdlr-core-recommendation">' . esc_html__('Recommend to be over 300 for demo import process', 'zurf') . '</div>';
					}
					echo '</td>';
					echo '</tr>';

					// memory limit
					echo '<tr>';
					echo '<td class="gdlr-core-table-head" >' . esc_html__('memory_limit', 'zurf') . '</td>';
					echo '<td class="gdlr-core-table-content" >';
					$memory_limit = ini_get('memory_limit');
					echo gdlr_core_escape_content($memory_limit);
					$memory_limit = intval(str_replace('M', '', $memory_limit));
					if( $memory_limit < 512 ){
						echo '<span class="gdlr-core-recommendation">' . esc_html__('Recommend to be 512M for demo import process', 'zurf') . '</div>';
					}
					echo '</td>';
					echo '</tr>';

					// max input var
					echo '<tr>';
					echo '<td class="gdlr-core-table-head" >' . esc_html__('max_input_vars', 'zurf') . '</td>';
					echo '<td class="gdlr-core-table-content" >';
					$max_input_vars = ini_get('max_input_vars');
					echo gdlr_core_escape_content($max_input_vars);
					if( $max_input_vars < 4000 ){
						echo '<span class="gdlr-core-recommendation">' . esc_html__('Recommend value is 4000 for full demo import process', 'zurf') . '</div>';
					}
					echo '</td>';
					echo '</tr>';

					// default_socket_timeout
					echo '<tr>';
					echo '<td class="gdlr-core-table-head" >' . esc_html__('default_socket_timeout', 'zurf') . '</td>';
					echo '<td class="gdlr-core-table-content" >';
					$default_socket_timeout = ini_get('default_socket_timeout');
					echo gdlr_core_escape_content($default_socket_timeout);
					// if( $default_socket_timeout < 300 ){
					// 	echo '<span class="gdlr-core-recommendation">' . esc_html__('Recommend value to be over 300 for images import process', 'zurf') . '</div>';
					// }
					echo '</td>';
					echo '</tr>';

					// suhosin
					echo '<tr>';
					echo '<td class="gdlr-core-table-head" >' . esc_html__('suhosin', 'zurf') . '</td>';
					echo '<td class="gdlr-core-table-content" >';
					if( extension_loaded( 'suhosin' ) ){
						echo esc_html__('On', 'zurf');
					}else{
						echo esc_html__('Off', 'zurf');
					}
					echo '</td>';
					echo '</tr>';
					
					if( extension_loaded( 'suhosin' ) ){
						
						// post max var
						echo '<tr>';
						echo '<td class="gdlr-core-table-head" >' . esc_html__('suhosin.post.max_vars', 'zurf') . '</td>';
						echo '<td class="gdlr-core-table-content" >';
						echo ini_get('suhosin.post.max_vars');
						echo '</td>';
						echo '</tr>';

						// request max var
						echo '<tr>';
						echo '<td class="gdlr-core-table-head" >' . esc_html__('suhosin.request.max_vars', 'zurf') . '</td>';
						echo '<td class="gdlr-core-table-content" >';
						echo ini_get('suhosin.request.max_vars');
						echo '</td>';
						echo '</tr>';
					}

				}

				echo '</tbody></table>';

				echo '<div class="gdlr-core-system-status-footer" >' . esc_html__('You can change these values by editing php.ini file directly. Or you can ask your hosting provider to do it for you.', 'zurf') . '</div>';
				echo '</div>';
			}

		} // zurf_theme_landing
	} // class_exists
