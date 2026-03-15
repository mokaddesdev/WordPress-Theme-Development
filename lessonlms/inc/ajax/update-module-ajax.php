<?php

/**
 * Update Module Ajax Function
 * 
 * @package lessonlms
 */

if (! function_exists('lessonlms_update_module_ajax')) {
    function lessonlms_update_module_ajax()
    {
        if ( ! isset( $_POST['edit_module_nonce'] ) || ! wp_verify_nonce( $_POST['edit_module_nonce'], 'edit_module_nonce' ) ) {
    wp_send_json_error( array(
        'message' => __( 'Security check failed', 'lessonlms' ),
    ) );
}
        if ( ! isset( $_POST['module_id'], $_POST['module_name'], $_POST['module_status'], $_POST['course_id'] ) ) {
            wp_send_json_error( array(
                'message' => __( 'Missing required data', 'lessonlms' ),
            ) );
        }

        $module_id      = absint( $_POST['module_id'] );
        $module_name    = sanitize_text_field( $_POST['module_name'] );
        $module_status  = sanitize_text_field( $_POST['module_status'] );

        $updated = wp_update_post( array(
            'ID'         => $module_id,
            'post_title' => $module_name
        ), true);

        update_post_meta( $module_id, 'module_status', $module_status );

        if ( is_wp_error( $updated ) ) {
            wp_send_json_error( array(
                'message' => 'Update failed',
                ) );
        }
        $module_id = absint( $_POST['module_id'] ?? 0 );
        $course_id = absint( $_POST['course_id'] ?? 0 );
        $paged     = absint( $_POST['paged'] ?? 1 );
        $html      = lessonlms_render_modules_table( $course_id, $paged );
        wp_send_json_success( array(
            'message' => 'Module updated successfully',
            'html'   => $html,
        ) );
    }
}
add_action('wp_ajax_lessonlms_update_module_ajax', 'lessonlms_update_module_ajax');
add_action('wp_ajax_nopriv_lessonlms_update_module_ajax', 'lessonlms_update_module_ajax');
