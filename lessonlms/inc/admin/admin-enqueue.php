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

    wp_register_style( 'admin-message-css', THEME_URI . '/assets/css/admin-message.css', array(), filemtime( THEME_DIR . '/assets/css/admin-message.css' ), 'all' );
    // lesson-css
    wp_register_style( 'lesson-css', THEME_URI . '/assets/css/admin-lesson.css', array(), filemtime( THEME_DIR . '/assets/css/admin-lesson.css' ), 'all' );

    // admin-module-details-css
    wp_register_style( 'module-details-css', THEME_URI . '/assets/css/admin-module-details.css', array(), filemtime( THEME_DIR . '/assets/css/admin-module-details.css' ), 'all' );
    

    // modules-css
     wp_register_style( 'modules-css', THEME_URI . '/assets/css/admin-modules.css', array(), filemtime( THEME_DIR . '/assets/css/admin-modules.css' ), 'all' );

    wp_register_script( 'add-module-js', THEME_URI . '/assets/js/admin/add-module.js', array('jquery'), filemtime( THEME_DIR . '/assets/js/admin/add-module.js' ), true );
     wp_register_script( 'delete-module-js', THEME_URI . '/assets/js/admin/delete-module.js', array('jquery'), filemtime( THEME_DIR . '/assets/js/admin/delete-module.js' ), true );

     wp_register_script( 'edit-module-js', THEME_URI . '/assets/js/admin/edit-module.js', array('jquery'), filemtime( THEME_DIR . '/assets/js/admin/edit-module.js' ), true );
        wp_enqueue_script( 'module-js' );

    $screen = get_current_screen();

    if ( $screen && 'lessons' === $screen->post_type ) {
        wp_enqueue_style( 'lesson-css' );
    }
    if ( $screen && 'toplevel_page_courses_modules_slug' === $screen->id ) {
        wp_enqueue_style( 'admin-message-css' );
        wp_enqueue_style( 'modules-css' );
        wp_enqueue_script( 'add-module-js' );
    }
     if ( $screen && 'admin_page_lessonlms_show_modules' === $screen->id ) {
        wp_enqueue_style( 'admin-message-css' );
        wp_enqueue_style( 'module-details-css' );
        wp_enqueue_script( 'edit-module-js' );
        wp_enqueue_script( 'delete-module-js' );
    }
    wp_enqueue_style( 'admin-message-css' );
}
add_action('admin_enqueue_scripts', 'lessonlms_admin_enqueue');