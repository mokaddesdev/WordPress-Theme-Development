<?php
/**
 * Course module details for single course
 * 
 * @package lessonlms
 */
function lessonlms_show_course_module_detail() {
    add_submenu_page(
        null,
        'Course Modules',
        'Course Modules',
        'manage_options',
        'lessonlms_show_modules',
        'lessonlms_modules_page_callback'
    );
}
add_action( 'admin_menu', 'lessonlms_show_course_module_detail' );

//? callback function
require_once get_template_directory() . '/inc/admin/callback-function/modules-list.php';