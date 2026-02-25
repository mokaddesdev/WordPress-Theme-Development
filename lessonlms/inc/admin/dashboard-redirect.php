<?php
/**
 * Dashboard redirect after login
 * 
 * @package lessonlms
 */

/**
 * Redirect user to specific dashboard based on role
 * 
 * @param string $redirect_to The redirect destination URL.
 * @param string $request The requested redirect URL.
 * @param WP_User $user WP_User objcet
 * @return string
 */
function lessonlms_login_redirect( $redirect_to, $request, $user ) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {

        if(
            in_array( 'administrator', $user->roles )  || 
            in_array( 'instructor', $user->roles )
            ) {
            return admin_url();
        } elseif( in_array( 'student', $user->roles ) ) {
            return home_url('/student-dashboard');
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'lessonlms_login_redirect', 10, 3);