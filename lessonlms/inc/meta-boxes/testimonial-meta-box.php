<?php
/**
 * Testimonial meta box
 * 
 * @package lessonlms
 */
function lessonlms_testimonial_add_meta_box()
    {
        add_meta_box(
            'testimonial_details',
            'Testimonial Details',
            'lessonlms_testimonial_add_meta_box_callback',
            'testimonials',
            'normal',
            'high'
        );

    }
    add_action('add_meta_boxes', 'lessonlms_testimonial_add_meta_box');
    
    require_once get_template_directory() . '/inc/meta-fields/testimonial-meta-fields.php';
    function lessonlms_testimonial_save_meta_data($post_id)
    {
        $fields = [
            'student_designation',
        ];
        
        foreach($fields as $field){
            if(isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));

            }
        }
    }
    add_action('save_post_testimonials', 'lessonlms_testimonial_save_meta_data');