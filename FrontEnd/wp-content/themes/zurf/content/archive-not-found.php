<?php
/**
 * The template for displaying archive not found
 */

	echo '<div class="zurf-not-found-wrap" id="zurf-full-no-header-wrap" >';
	echo '<div class="zurf-not-found-background" ></div>';
	echo '<div class="zurf-not-found-container zurf-container">';
	echo '<div class="zurf-header-transparent-substitute" ></div>';
	
	echo '<div class="zurf-not-found-content zurf-item-pdlr">';
	echo '<h1 class="zurf-not-found-head" >' . esc_html__('Not Found', 'zurf') . '</h1>';
	echo '<div class="zurf-not-found-caption" >' . esc_html__('Nothing matched your search criteria. Please try again with different keywords.', 'zurf') . '</div>';

	echo '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">';
	echo '<input type="text" class="search-field zurf-title-font" placeholder="' . esc_attr__('Type Keywords...', 'zurf') . '" value="" name="s">';
	echo '<div class="zurf-top-search-submit"><i class="fa fa-search" ></i></div>';
	echo '<input type="submit" class="search-submit" value="Search">';
	echo '</form>';
	echo '<div class="zurf-not-found-back-to-home" ><a href="' . esc_url(home_url('/')) . '" >' . esc_html__('Or Back To Homepage', 'zurf') . '</a></div>';
	echo '</div>'; // zurf-not-found-content

	echo '</div>'; // zurf-not-found-container
	echo '</div>'; // zurf-not-found-wrap