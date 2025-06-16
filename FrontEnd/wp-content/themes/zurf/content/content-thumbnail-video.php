<?php
/**
 * The template part for displaying the video post format thumbnail
 */

global $pages;

if( !preg_match('#^https?://\S+#', $pages[0], $match) ){
	if( !preg_match('#^\[video\s.+\[/video\]#', $pages[0], $match) ){
		if( !preg_match('#^\[embed.+\[/embed\]#', $pages[0], $match) ){
			preg_match('#\<figure.+\<\/figure\>#sim', $pages[0], $match_html);
		}
	}
}

if( !empty($match[0]) ){
	echo '<div class="zurf-single-article-thumbnail zurf-media-video" >';
	echo gdlr_core_get_video($match[0], 'full');
	echo '</div>';

	$pages[0] = str_replace($match[0], '', $pages[0]);
}else if( !empty($match_html[0]) ){
	echo '<div class="zurf-single-article-thumbnail zurf-media-video" >';
	echo gdlr_core_content_filter($match_html[0]);
	echo '</div>';

	$pages[0] = str_replace($match_html[0], '', $pages[0]);
}