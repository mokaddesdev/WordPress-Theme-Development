<?php
/**
 * Load Customizer files for Administrator / Super Admin only.
 *
 * @package lessonlms
 */

$user = wp_get_current_user();

if ( $user instanceof WP_User && ( in_array( 'administrator', (array) $user->roles, true ) || is_super_admin() ) && is_user_logged_in() ) {

    $theme_dir = get_template_directory();

    $customizer_files = array(
        '/inc/customizer/blog.php',
        '/inc/customizer/blogpage.php',
        '/inc/customizer/courses.php',
        '/inc/customizer/coursespage.php',
        '/inc/customizer/cta.php',
        '/inc/customizer/features.php',
        '/inc/customizer/footer.php',
        '/inc/customizer/hero.php',
    );

    foreach ( $customizer_files as $file ) {
        require_once $theme_dir . $file;
    }
}