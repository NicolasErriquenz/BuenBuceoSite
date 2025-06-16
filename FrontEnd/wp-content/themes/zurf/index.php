<?php
/**
 * The main template file
 */ 


	get_header();

	echo '<div class="zurf-content-container zurf-container">';
	echo '<div class="zurf-sidebar-style-none" >'; // for max width

	get_template_part('content/archive', 'default');

	echo '</div>'; // zurf-content-area
	echo '</div>'; // zurf-content-container

	get_footer(); 
