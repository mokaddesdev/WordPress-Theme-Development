<?php
/**
 * Enqueue CSS and JavaScript for Admin Panel
 * 
 * @package  lessonlms
 */
function lessonlms_admin_enqueue() {
    require __DIR__ . '/css-enqueue.php';
    $theme_uri = get_template_directory_uri();
    wp_enqueue_script(
        'admin-module-js',
        $theme_uri . '/assets/js/admin/delete-module.js',
        array('jquery'),
        time(),
        true
    );

    wp_enqueue_script(
        'add-module-js',
        $theme_uri . '/assets/js/admin/add-module.js',
        array('jquery'),
        time(),
        true
    );
}
add_action('admin_enqueue_scripts', 'lessonlms_admin_enqueue');
