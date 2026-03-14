<?php

/**
 * Add course module in admin dashboard
 * 
 * @package lessonlms
 */
if (! function_exists('lessonlms_add_course_module_in_admin')) {
    function lessonlms_add_course_module_in_admin()
    {
        add_menu_page(
            'Course Modules',
            'Course Modules',
            'manage_options',
            'courses_modules_slug',
            'lessonlms_add_module_callback',
            'dashicons-category',
            28
        );
    }
}
add_action('admin_menu', 'lessonlms_add_course_module_in_admin');

// callback function
require_once THEME_DIR . ( '/inc/callback-functions-html/admin/add-module-callback.php');