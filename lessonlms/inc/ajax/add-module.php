<?php
add_action( 'wp_ajax_lessonlms_add_module', 'lessonlms_add_course_module' );

function lessonlms_add_course_module() {

    if (
        ! isset( $_POST['lessonlms_add_module_nonce_field'] ) ||
        ! wp_verify_nonce(
            $_POST['lessonlms_add_module_nonce_field'],
            'lessonlms_add_module_nonce'
        )
    ) {
        wp_send_json_error( 'Security check failed' );
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( 'Permission denied' );
    }

    wp_send_json_success( 'AJAX handler reached successfully 🎯' );
}
