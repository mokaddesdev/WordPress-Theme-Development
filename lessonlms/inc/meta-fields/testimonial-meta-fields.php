<?php
/**
 * Testimonial meta fields
 * 
 * @package lessonlms
 */

 function lessonlms_testimonial_add_meta_box_callback($post)
    {
        $student_designation = get_post_meta($post->ID, 'student_designation', true);
        ?>
        <div class="">
            <label for="student_designation"> Student Destination / Course Name </label>
            <input type="text" name="student_designation" id="student_designation" value="<?php echo esc_attr($student_designation);?>">
        </div>
        <?php
    }