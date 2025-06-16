<?php
/**
 * The template part for displaying single posts
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="zurf-single-article zurf-style" >
		<?php
			ob_start();
			the_post_thumbnail('full');
			$post_thumbnail = ob_get_contents();
			ob_end_clean();

			if( !empty($post_thumbnail) ){
				echo '<div class="zurf-single-article-thumbnail zurf-media-image" >';
				echo gdlr_core_escape_content($post_thumbnail);
				if( is_sticky() ){
					echo '<div class="zurf-sticky-banner zurf-title-font" ><i class="fa fa-bolt" ></i>' . esc_html__('Sticky Post', 'zurf') . '</div>';
				}
				echo '</div>';
			}else{
				if( is_sticky() ){
					echo '<div class="zurf-sticky-banner zurf-title-font" ><i class="fa fa-bolt" ></i>' . esc_html__('Sticky Post', 'zurf') . '</div>';
				}
			}

			echo '<header class="zurf-single-article-head clearfix" >';
			echo '<h3 class="zurf-single-article-title"><a href="' . get_permalink() . '" >' . get_the_title() . '</a></h3>';
			
			if( get_post_type() == 'post' ){
				$blog_info_atts = array( 'wrapper' => true );
				$blog_info_atts['display'] = zurf_get_option('general', 'meta-option', '');
				echo zurf_get_blog_info($blog_info_atts);
			}

			echo '</header>';

			echo '<div class="zurf-single-article-content">';
			the_excerpt();
			echo '</div>';

			if( get_post_type() == 'post' ){
				echo '<a class="zurf-excerpt-read-more" href="' . get_permalink() . '">Read More <i class="fa fa-long-arrow-right"></i></a>';
			}
		?>
	</div><!-- zurf-single-article -->
</article><!-- post-id -->
