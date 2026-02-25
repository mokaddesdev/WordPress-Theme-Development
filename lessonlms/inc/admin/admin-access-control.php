<?php
/**
 * Admin access control
 * 
 * @package lessonlms
 */

/**
 * Block student role from accessing admin dashboard
 * 
 * @return void
 */
function lessonlms_block_student_admin_access(){
    if ( is_user_logged_in() && is_admin() && ! defined( 'DOING_AJAX' ) ) {

        $user = wp_get_current_user();

        if ( in_array( 'student', (array) $user->roles ) ) {
            wp_redirect( home_url( '/student-dashboard' ) );
            exit;
        }
    }
}
add_action( 'init', 'lessonlms_block_student_admin_access' );

