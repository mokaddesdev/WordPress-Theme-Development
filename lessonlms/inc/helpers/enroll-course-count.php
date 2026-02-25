<?php
    /**
     * Total Enroll and Course Count
     * 
     * @package
     */

    function total_enroll_course_count() {
        global $wpdb;
        $total_course_count = $wpdb->get_var(
            " SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'courses' AND post_status = 'publish'"
        );
        $total_enrollments = $wpdb->get_var(
            "SELECT SUM(meta_value) FROM $wpdb->postmeta WHERE meta_key = '_enrolled_students'"
    );
    return array(
        'courses'     => $total_course_count,
        'enrollments' => $total_enrollments,
    );
    }