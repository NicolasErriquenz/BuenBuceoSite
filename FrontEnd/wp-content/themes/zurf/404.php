<?php
/**
 * The template for displaying 404 pages (not found)
 */

	get_header();
	
	?>
	<div class="zurf-not-found-wrap" id="zurf-full-no-header-wrap" >
		<div class="zurf-not-found-background" ></div>
		<div class="zurf-not-found-container zurf-container">
			<div class="zurf-header-transparent-substitute" ></div>
	
			<div class="zurf-not-found-content zurf-item-pdlr">
			<?php
				echo '<h1 class="zurf-not-found-head" >' . esc_html__('404', 'zurf') . '</h1>';
				echo '<h3 class="zurf-not-found-title zurf-content-font" >' . esc_html__('Page Not Found', 'zurf') . '</h3>';
				echo '<div class="zurf-not-found-caption" >' . esc_html__('Sorry, we couldn\'t find the page you\'re looking for.', 'zurf') . '</div>';

				echo '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">';
				echo '<input type="text" class="search-field zurf-title-font" placeholder="' . esc_attr__('Type Keywords...', 'zurf') . '" value="" name="s">';
				echo '<div class="zurf-top-search-submit"><i class="fa fa-search" ></i></div>';
				echo '<input type="submit" class="search-submit" value="Search">';
				echo '</form>';
				echo '<div class="zurf-not-found-back-to-home" ><a href="' . esc_url(home_url('/')) . '" >' . esc_html__('Or Back To Homepage', 'zurf') . '</a></div>';
			?>
			</div>
		</div>
	</div>
	<?php

	get_footer(); 
