<?php
/**
 * Enqueue CSS and JavaScript for Admin Panel
 * 
 * @package  lessonlms
 */
function lessonlms_admin_enqueue() {
    if ( ! is_admin() ) {
        return;
    }

    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    wp_register_style(
        'lesson-css', $theme_uri . '/assets/css/admin-lesson.css',
        array(),filemtime( $theme_dir . '/assets/css/admin-lesson.css' ), 'all'
    );
     wp_register_style(
        'modules-css', $theme_uri . '/assets/css/admin-modules.css',
        array(),filemtime( $theme_dir . '/assets/css/admin-modules.css' ), 'all'
    );

    $screen = get_current_screen();
    if ( empty( $screen ) ) {
        return;
    }
    if ( $screen && 'lessons' === $screen->post_type ) {
        wp_enqueue_style( 'lesson-css' );
    }
    wp_enqueue_style( 'modules-css' );
    
     wp_register_script( 'module-js', $theme_uri . '/assets/js/admin/delete-module.js', array('jquery'), time(), true );

        wp_enqueue_script( 'module-js' );
}
add_action('admin_enqueue_scripts', 'lessonlms_admin_enqueue');