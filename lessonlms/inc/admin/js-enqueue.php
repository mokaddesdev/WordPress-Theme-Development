<?php
/**
 * Enqueue JavaScript for admin panel
 * 
 * @package lessonlms
 */

$theme_uri = get_template_directory_uri();
    // jQuery
    wp_enqueue_script('jquery');

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