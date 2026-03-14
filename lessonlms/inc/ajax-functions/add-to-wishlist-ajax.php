<?php

/**
 * Add to wishlist ajax
 * 
 * @package lessonlms
 */


if ( ! function_exists( 'lessonlmsadd_to_wishlist_ajax' ) ) {
    function lessonlmsadd_to_wishlist_ajax()
    {
        if ( ! isset($_POST['add_to_wishlist_nonce']) ||
            ! wp_verify_nonce( $_POST['add_to_wishlist_nonce'], 'add_to_wishlist' ) ) {
            wp_send_json_error('Security check failed');
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        $user_id = get_current_user_id();

        if ( $user_id == 0 ) {
            return;
        }

        if ( ! isset( $_POST['course_id'] ) ) {
            wp_send_json_error( 'Invalid course' );
        }

        $course_id = absint( $_POST['course_id'] );
        $wishlists = get_user_meta( $user_id, '_add_to_wishlist', true );

        if ( ! is_array( $wishlists ) ) {
            $wishlists = [];
        }

        foreach ( $wishlists as $wish ) {
            if ( intval( $wish['course_id'] ) === $course_id ) {
                wp_send_json_error( 'Already added' );
            }
        }

        $wishlists_update = array(
            'course_id' => $course_id,
            'date'      => current_time( 'mysql' ),
        );

        $wishlists[] = $wishlists_update;
        update_user_meta( $user_id, '_add_to_wishlist', $wishlists );

        ob_start();
        ?>
        <div class="add-to-wishlist active">
            <a href="<?php echo esc_url( home_url( '/student-wishlist' ) ); ?>">
                <i class="fa-solid fa-heart"></i>
            </a>
        </div>
        <?php
        $html = ob_get_clean();
        wp_send_json_success(
            array(
                'msg'  => 'Added course Ssuccessfully Wishlist.',
                'html' => $html,
            )
        );
    }
}
add_action( 'wp_ajax_lessonlmsadd_to_wishlist_ajax',  'lessonlmsadd_to_wishlist_ajax' );
add_action( 'wp_ajax_nopriv_lessonlmsadd_to_wishlist_ajax',  'lessonlmsadd_to_wishlist_ajax' );
