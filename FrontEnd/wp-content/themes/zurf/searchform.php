<?php 
$top_search = zurf_is_top_search();
if( $top_search ){
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<input type="text" class="search-field zurf-title-font" placeholder="<?php esc_attr_e('Search...', 'zurf'); ?>" value="" name="s">
	<div class="zurf-top-search-submit"><i class="fa fa-search" ></i></div>
	<input type="submit" class="search-submit" value="Search">
	<div class="zurf-top-search-close"><i class="icon_close" ></i></div>
	<?php
		echo apply_filters('zurf_top_search_custom_input', '');
	?>
</form>
<?php }else{ ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <input type="search" class="search-field" placeholder="<?php esc_attr_e('Search...', 'zurf'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" />
    <input type="submit" class="search-submit" value="<?php esc_attr_e('Search', 'zurf'); ?>" />
</form>	
<?php } ?>