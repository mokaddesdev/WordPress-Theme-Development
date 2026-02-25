<?php
/**
 * Enqueue CSS for admin panel
 * 
 * @package lessonlms
 */
    $theme_uri = get_template_directory_uri();

    $admin_styles = array(
        'amars-admin-css' => array(
            'path'      => '/css/amars-admin.css',
            'deps'      => array(),
            'version'   => time(),
        ),

        'admin-module-css' => array(
            'path'      => '/assets/css/admin-modules.css',
            'deps'      => array(),
            'version'   => time(),
        ),

    );
    if ( empty( $admin_styles ) || ! is_array( $admin_styles ) ) {
        return;
    }
    foreach ( $admin_styles as $handle => $style ) {
        wp_register_style(
            $handle,
            $theme_uri . $style['path'],
            $style['deps'],
            $style['version']
        );

        wp_enqueue_style( $handle );
    }