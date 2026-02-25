<?php
/**
 * Add module ajax call function
 * 
 * @package lessonlms
 */
function lessonlms_add_course_module() {

    check_ajax_referer( 'add_module_nonce', 'add_module_nonce_field' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( 'Permission denied' );
    }

    $course_id   = intval( $_POST['select_course'] ?? 0 );
    $module_name = sanitize_text_field( $_POST['module_name'] ?? '' );
    $status      = sanitize_text_field( $_POST['module_status'] ?? 'disabled' );

    if ( ! $course_id ) {
        wp_send_json_error( 'Select course field required' );
    }

     if ( ! $module_name ) {
        wp_send_json_error( 'Module name field required' );
    }

    $module_id = wp_insert_post([
        'post_title'  => $module_name,
        'post_type'   => 'course_modules',
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
    ]);

    if ( is_wp_error( $module_id ) ) {
        wp_send_json_error( 'Insert failed' );
    }

    update_post_meta( $module_id, '_lessonlms_course_id', $course_id );
    update_post_meta( $module_id, '_lessonlms_module_status', $status );
    ob_start();
    lessonlms_modules_table_callback();
    $table_html = ob_get_clean();

    wp_send_json_success([
        'message' => 'Module saved successfully',
        'html'    => $table_html,
    ]);
}
add_action( 'wp_ajax_lessonlms_add_module', 'lessonlms_add_course_module' );