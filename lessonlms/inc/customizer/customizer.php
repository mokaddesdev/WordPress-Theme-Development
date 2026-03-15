<?php
/**
 * Load Customizer files for Administrator / Super Admin only.
 *
 * @package lessonlms
 */

if ( current_user_can( 'manage_options' ) || is_super_admin() ) {

    require_once THEME_DIR . '/inc/customizer/hero.php';
    require_once THEME_DIR . '/inc/customizer/explore-category.php';
    require_once THEME_DIR . '/inc/customizer/featured-course.php';
    require_once THEME_DIR . '/inc/customizer/courses.php';
    require_once THEME_DIR . '/inc/customizer/coursespage.php';
    require_once THEME_DIR . '/inc/customizer/cta.php';
    require_once THEME_DIR . '/inc/customizer/features.php';
    require_once THEME_DIR . '/inc/customizer/blog.php';
    require_once THEME_DIR . '/inc/customizer/blogpage.php';
    require_once THEME_DIR . '/inc/customizer/footer.php';
}
