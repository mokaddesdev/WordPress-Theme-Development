<?php 
/**
 * Template Name: Submit Feedback Function
 * 
 * @package lessonlms
 */

function lessonlms_ajax_feedback(){

    if ( isset( $_POST['submit_testimonial_form'] ) && $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        // nonce check
        if( isset($_POST['security']) && wp_verify_nonce($_POST['security'], 'lessonlms_ajax_feedback_nonce') ){

        //  data sanitize
        $student_name        = !empty($_POST['student_name']) ? sanitize_text_field($_POST['student_name']) : '';
        $student_designation = !empty($_POST['student_designation']) ? sanitize_text_field($_POST['student_designation']) : '';
        $student_feedback    = !empty($_POST['student_feedback']) ? sanitize_textarea_field($_POST['student_feedback']) : '';

        // validation
        if (empty($student_name)) {
            wp_send_json_error("Name field are required.");
        }
        if (empty($student_designation)) {
            wp_send_json_error("Student designation field are required.");
        }
        if (empty($student_feedback)) {
            wp_send_json_error("Feedback message field are required.");
        }
        $user_id = get_current_user_id();

        $existing_testimonial = get_posts( array(
            'post_type'      => 'testimonials',
            'posts_per_page' => 1,
            'meta_key'       => 'testimonial_user_id',
            'meta_value'     => $user_id,
            'post_status'    => ['pending', 'publish', 'draft'],
        ) );

        $post_id = 0;
        $is_update = false;

        // ========== UPDATE OR INSERT ==========
        if ( ! empty( $existing_testimonial ) ) {
            // UPDATE Logic
            $post_id = $existing_testimonial[0]->ID;
            $updated_post = [
                'ID'           => $post_id,
                'post_title'   => $student_name,
                'post_content' => $student_feedback,
            ];
            wp_update_post( $updated_post );
            update_post_meta( $post_id, 'student_designation', $student_designation );
            $is_update = true;

        } else {
            // INSERT Logic
            $new_testimonial = [
                'post_title'   => $student_name,
                'post_content' => $student_feedback,
                'post_type'    => 'testimonials',
                'post_status'  => 'pending'
            ];
            $post_id = wp_insert_post( $new_testimonial );

            if ( $post_id ) {
                update_post_meta( $post_id, 'testimonial_user_id', $user_id );
                update_post_meta( $post_id, 'student_designation', $student_designation );
            } else {
                wp_send_json_error( "Oh! Please Try Again" );
            }
        }

        // ========== IMAGE UPLOAD LOGIC (NEW) ==========
        $new_image_url = ''; 
        
        if ( $post_id && ! empty( $_FILES['student_image']['name'] ) ) {
            
            // These files are needed to use media_handle_upload
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            // Upload to Media Library
            $attachment_id = media_handle_upload('student_image', $post_id);

            if ( is_wp_error( $attachment_id ) ) {
                // Optional: Handle upload error (e.g. file too big)
                wp_send_json_error( "Image upload error: " . $attachment_id->get_error_message() );
            } else {
                // Set as Featured Image
                set_post_thumbnail( $post_id, $attachment_id );
                $new_image_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );
            }
        }
        // ==============================================
        // SUCCESS RESPONSE
        $message = $is_update ? "Your testimonial has been updated successfully!" : "Your testimonial has been added successfully!";

        wp_send_json_success( array(
            "message"             => $message,
            "student_name"        => $student_name,
            "student_feedback"    => $student_feedback,
            "student_designation" => $student_designation,
            "new_image_url"       => $new_image_url
        ) );
    } else {
         wp_send_json_error("Security verification failed!");
        }
    }

    wp_send_json_error("Invalid Request!");
     }

add_action('wp_ajax_lessonlms_ajax_feedback', 'lessonlms_ajax_feedback');
add_action('wp_ajax_nopriv_lessonlms_ajax_feedback', 'lessonlms_ajax_feedback');
