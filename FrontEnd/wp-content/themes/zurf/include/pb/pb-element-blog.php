<?php 

	add_filter('gdlr_core_blog_info_prefix', 'zurf_gdlr_core_blog_info_prefix');
	if( !function_exists('zurf_gdlr_core_blog_info_prefix') ){
		function zurf_gdlr_core_blog_info_prefix(){
			return array(
				'date' => '<i class="gdlr-icon-clock" ></i>',
				'tag' => '<i class="icon_tags_alt" ></i>',
				'category' => '<i class="icon_folder-alt" ></i>',
				'comment' => '<i class="icon_comment_alt" ></i>',
				'like' => '<i class="icon_heart_alt" ></i>',
				'author' => '<i class="icon_documents_alt" ></i>',
				'comment-number' => '<i class="icon_comment_alt" ></i>',
			);
		}
	}