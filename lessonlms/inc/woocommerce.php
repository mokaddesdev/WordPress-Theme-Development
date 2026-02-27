<?php
/**
 * Woocommerce customize
 */
if ( ! function_exists( 'lessonlms_custom_checkout_product_name' ) ) {
    function lessonlms_custom_checkout_product_name( $product_name, $cart_item, $cart_item_key ) {
    if( is_checkout() ) {
        $product_name = "My Custom Product Title";
    }
    return $product_name;
}
add_filter( 'woocommerce_cart_item_name', 'lessonlms_custom_checkout_product_name', 10, 3 );
}

// 1️⃣ Redirect single product → linked course page
add_action('template_redirect', 'redirect_product_to_course_page');
function redirect_product_to_course_page() {
    if ( is_singular('product') ) {
        global $post;
        $linked_course_id = get_post_meta($post->ID, '_course_product', true); // ✅ your meta key

        if ( $linked_course_id ) {
            wp_safe_redirect( get_permalink($linked_course_id) );
            exit;
        }
    }
}

// 2️⃣ Shop loop / product grid link → course page
add_filter('woocommerce_loop_product_link', 'course_page_loop_link', 10, 2);
function course_page_loop_link($link, $product) {
    $linked_course_id = get_post_meta($product->get_id(), '_course_product', true); // ✅ your meta key
    if ( $linked_course_id ) {
        return get_permalink($linked_course_id);
    }
    return $link;
}

// 3️⃣ Change product name in checkout / cart to course title
add_filter('woocommerce_cart_item_name', 'lessonlms_custom_checkout_product_name', 10, 3);
function lessonlms_custom_checkout_product_name( $product_name, $cart_item, $cart_item_key ) {

    $product_id = $cart_item['product_id'];
    $linked_course_id = get_post_meta($product_id, '_course_product', true); // ✅ your meta key

    if ( $linked_course_id ) {
        $product_name = get_the_title($linked_course_id);
    }

    return $product_name;
}


add_action('woocommerce_cart_is_empty', function() {
    echo '<p class="empty-cart-message">Your cart is empty! Browse our courses to get started.</p>';
});

add_action('woocommerce_before_main_content', function() {
    echo 'Hello test';
} );

// These are actions you can unhook/remove!
 
add_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
 
add_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
 
add_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
 
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 ); 
 
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
 
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
 
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
 
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
 
add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
 
add_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

add_action( 'woocommerce_before_shop_loop_item', 'custom_course_link_open', 10 );

function custom_course_link_open() {
    global $product;

    $course_id = get_post_meta( $product->get_id(), '_linked_course', true );

    if ( $course_id ) {
        echo '<a href="' . get_permalink( $course_id ) . '">';
    }
}