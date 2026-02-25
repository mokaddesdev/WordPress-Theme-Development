<?php
/**
 * Add course module in admin dashboard
 * 
 * @package lessonlms
 */
function lessonlms_add_course_module_in_admin()
{
    add_menu_page(
        'Course Modules',
        'Course Modules',
        'manage_options',
        'lesslms_courses_modules_slug',
        'lessonlms_add_module_callback',
        'dashicons-welcome-learn-more',
        35
    );
}
add_action('admin_menu', 'lessonlms_add_course_module_in_admin');

//? callback function
require_once get_template_directory() . '/inc/admin/callback-function/add-module.php';
