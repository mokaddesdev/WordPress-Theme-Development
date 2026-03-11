<?php
add_action('wp_ajax_lessonlms_fetch_modules', function() {
    check_ajax_referer('select-course-nonce', 'select_nonce');

    $course_id = intval($_POST['course_id']);

    if (!$course_id) {
        wp_send_json_error(['message' => 'Invalid course ID']);
    }

    // For testing, just return course_id
    wp_send_json_success(['course_id' => $course_id, 'message' => 'AJAX working']);
});