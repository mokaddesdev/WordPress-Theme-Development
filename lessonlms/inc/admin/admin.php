<?php

if ( is_admin() && ! wp_doing_ajax() ) {

        $admin_paths = array(
        '/inc/admin/admin-access-control.php',
        '/inc/admin/dashboard-redirect.php',
        '/inc/admin/post-capabilities.php',
        '/inc/admin/user-roles.php',
    );
       foreach ( $admin_paths as $admin ) {
        require_once $theme_dir . $admin;
    }
}

if ( 
    ! is_admin() 
    && is_user_logged_in() 
    && in_array( 'student', (array) $user->roles, true )
) {
	require_once $theme_dir . '/inc/admin/hide-admin-bar.php';
}
// require_once get_template_directory() . '/inc/admin/ajax-function/add-module.php';
// require_once get_template_directory() . '/inc/admin/add-menu-pages/module-details.php';
// require_once get_template_directory() . '/inc/admin/add-menu-pages/course-module-page.php';

// include_once get_template_directory() . '/inc/admin/callback-function/course-module-list.php';