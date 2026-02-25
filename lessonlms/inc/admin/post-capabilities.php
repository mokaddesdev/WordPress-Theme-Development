<?php
/**
 * Handle post capabilities
 * 
 * @package lessonlms
 */

/**
 * Manage own post for instructor role but show only other post.
 *
 * @param WP_Query $query The current WP_Query instance.
 * @return void
 */
function lessonlms_show_own_courses_only( $query ) {
    if ( ! is_admin() || $query->is_main_query() ) {
        return;
    }
    
    $user = wp_get_current_user();

    if ( in_array( 'instructor', (array) $user->roles ) ) {
        $query->set( 'author', $user->ID );
    }
}
add_action( 'pre_get_posts', 'lessonlms_show_own_courses_only' );