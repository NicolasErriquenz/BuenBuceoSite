<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

if( class_exists('gdlr_core_pb_element_product') ){
	get_template_part('woocommerce/custom', 'product');
}else{

	get_header( 'shop' );

	/**
	 * Hook: woocommerce_before_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 * @hooked WC_Structured_Data::generate_website_data() - 30
	 */
	do_action( 'woocommerce_before_main_content' );

	?>
	<header class="woocommerce-products-header">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
		<?php endif; ?>

		<?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
		?>
	</header>
	<?php
	if ( woocommerce_product_loop() ) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked wc_print_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );

		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();

				/**
				 * Hook: woocommerce_shop_loop.
				 *
				 * @hooked WC_Structured_Data::generate_product_data() - 10
				 */
				do_action( 'woocommerce_shop_loop' );

				?>
<li <?php wc_product_class( '', $product ); ?>>
<?php
	global $product;

	echo '<div class="gdlr-core-product-default gdlr-core-item-mgb gdlr-core-button-style-plain gdlr-core-without-frame" >';
	
	$feature_image = get_post_thumbnail_id();
	if( !empty($feature_image) ){
		echo '<div class="gdlr-core-product-thumbnail gdlr-core-media-image" >';
		echo '<a href="' . get_permalink() . '" >';
		echo gdlr_core_get_image($feature_image, 'full', array('placeholder' => false));
		echo '</a>';
		echo '</div>';
	}
	
	
	echo '<div class="gdlr-core-product-grid-content gdlr-core-skin-e-background clearfix" >';
	echo '<div class="gdlr-core-product-grid-info clearfix" >';
	echo '<div class="gdlr-core-product-price gdlr-core-title-font">' . $product->get_price_html() . '</div>';

	$average = $product->get_average_rating();
	$rating_count = $product->get_rating_count();
	echo wc_get_rating_html($average, $rating_count);
	echo '</div>';

	echo '<h3 class="gdlr-core-product-title gdlr-core-skin-title" >';
	echo '<a href="' . get_permalink() . '" >';
	echo get_the_title();
	echo '</a>';
	echo '</h3>';

	woocommerce_template_loop_add_to_cart();
	echo '</div>'; // gdlr-core-product-grid-content
	echo '</div>'; // gdlr-core-product-grid
?>
</li>
				<?php
			}
		}

		woocommerce_product_loop_end();

		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action( 'woocommerce_no_products_found' );
	}

	/**
	 * Hook: woocommerce_after_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );

	get_footer( 'shop' );

}
?>