<?php
/**
 * Enqueue CSS and JavaScript for Admin Panel
 * 
 * @package  lessonlms
 */
function lessonlms_admin_enqueue() {
    require __DIR__ . '/css-enqueue.php';
     wp_register_script( 'module-js', $theme_uri . '/assets/js/admin/delete-module.js', array('jquery'), time(), true );
     
    $screen = get_current_screen();
    if ( empty( $screen ) ) {
        return;
    }
    if ( $screen && 'lessons' === $screen->post_type ) {
        wp_enqueue_script( 'module-js' );
    }

    wp_enqueue_script(
        'add-module-js',
        $theme_uri . '/assets/js/admin/add-module.js',
        array('jquery'),
        time(),
        true
    );
}
add_action('admin_enqueue_scripts', 'lessonlms_admin_enqueue');
