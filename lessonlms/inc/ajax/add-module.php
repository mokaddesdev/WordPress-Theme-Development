<?php

if ( ! function_exists( 'lessonlms_add_course_module' ) ) {
    function lessonlms_add_course_module() {
        if ( ! isset( $_POST['lessonlms_add_module_nonce_field'] ) ) {
            return;
        }
        $nonce = $_POST['lessonlms_add_module_nonce_field'];
        if ( ! wp_verify_nonce( $nonce, 'lessonlms_add_module_nonce'
        ) ) {
            return;
        }
    }
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    wp_send_json_success( 'AJAX handler reached successfully' );
}
add_action( 'wp_ajax_lessonlms_add_module', 'lessonlms_add_course_module' );

