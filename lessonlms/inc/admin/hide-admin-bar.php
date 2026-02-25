<?php
/**
 * Handle admin bar
 * 
 * @package lessonlms
 */

/**
 * Hide admin bar for student role.
 *
 * @return void
 */
function lessonlms_hide_admin_bar_for_student() {
	if ( is_user_logged_in() ) {

		$user = wp_get_current_user();

		if ( in_array( 'student', (array) $user->roles, true ) ) {
			show_admin_bar( false );
		}
	}
}
add_action( 'after_setup_theme', 'lessonlms_hide_admin_bar_for_student' );