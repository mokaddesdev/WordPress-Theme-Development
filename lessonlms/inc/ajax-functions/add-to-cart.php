<?php
/**
 * Add to cart ajax function
 * 
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_add_to_cart_ajax' ) ) {
    function lessonlms_add_to_cart_ajax() {
        if ( ! isset( $_POST['add_to_cart_nonce'] ) ) {
            wp_send_json_error( 'Oh! please try again.' );
        }
        $nonce = $_POST['add_to_cart_nonce'];
        if (  ! wp_verify_nonce( $nonce, 'add_to_cart_nonce_action' ) ) {
            wp_send_json_error( 'Oh! please try again.' );
        }
        if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            wp_send_json_error( 'Oh! please try again.' );
        }
        $course = $_POST['course_id'];
        $course_id = isset( $course ) ? intval( $course ) : 0;

        if ( $course_id <= 0 ) {
            wp_send_json_error( 'Invalid course id.' );
        }

        $user_login = is_user_logged_in();
        $user_id    = get_current_user_id();
        if ( ! $user_login ) {
            wp_send_json_error( 'Please login for course add to cart' );
        }

        $user_carts = get_post_meta( $course_id, '_user_carts', true );

        if ( ! empty( $user_carts ) && ! is_array( $user_carts ) ) {
            $user_carts = [];
        }

        $user_carts[] = array(
            'course_id'     => $course_id,
            'date'          =>current_time( 'mysql' ),
        );

        update_post_meta( $course_id, '_user_carts', true );
        if ( isset( $_POST['add_to_cart'] ) ) {
            $add_to_cart = sanitize_text_field( $_POST['add_to_cart'] );
        }
    }
}
add_action( 'wp_ajax_lessonlms_add_to_cart_ajax', 'lessonlms_add_to_cart_ajax' );