<?php
/**
 * Delete Module Ajax
 * 
 * @package  lessonlms
 */
function lessonlms_delete_module()
    {
        if (!isset($_POST['nonce'])) {
            wp_send_json_error( array(
                'msg' => 'Nonce Miss',
            ));
        }

        if (!wp_verify_nonce($_POST['nonce'], 'lessonlms_delete_module')) {
            wp_send_json_error( array(
                'msg' => 'Nonce verify mismatch',
            ));
        }
        if (!current_user_can('manage_options')) {
            wp_send_json_error( array(
                'msg' => 'Permision Denied',
            ));
        }
        // Get module ID from AJAX
        $module_id = absint($_POST['module_id'] ?? 0);
        $course_id = absint($_POST['course_id'] ?? 0); 
        $paged     = absint($_POST['paged'] ?? 1);

    if (!$module_id || !$course_id) {
        wp_send_json_error(['msg' => 'Invalid Module ID or Course ID']);
    }

        if (!$module_id) {
            wp_send_json_error( array(
                'msg' => 'Invalid Module ID',
            ) );
        }

        // Delete the module
        $deleted = wp_delete_post($module_id, true);
        $html = lessonlms_render_modules_table($course_id, $paged );
        if ($deleted) {
            wp_send_json_success( array(
                'msg' => 'Module deleted successfully.',
                'html' => $html
            ) );
        }
             wp_send_json_success( array(
                'msg'  => 'Failed to delete module.',
                'html' => $html
            ) );
    }
    add_action('wp_ajax_lessonlms_delete_module', 'lessonlms_delete_module');