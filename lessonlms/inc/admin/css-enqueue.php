<?php
/**
 * Enqueue CSS for admin panel
 * 
 * @package lessonlms
 */
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
        array(), filemtime( $theme_dir . '/assets/css/admin-modules.css' ), 'all'
    );

    wp_register_style(
        'admin-css', $theme_uri . '/assets/css/amars-admin.css',
        array(), filemtime( $theme_dir . '/assets/css/amars-admin.css' ), 'all'
    );

    $screen = get_current_screen();
    if ( empty( $screen ) ) {
        return;
    }
    if ( $screen && 'lessons' === $screen->post_type ) {
        wp_enqueue_style( 'lesson-css' );
    }
    if ( 'lesslms_courses_modules_slug' === $screen->post_type ) {
        wp_enqueue_style( 'modules-css' );
    }