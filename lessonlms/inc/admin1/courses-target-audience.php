<?php
/**
 * Courses Target Audience
 * 
 * @package lessonlms
 */

function lessonlms_courses_target_audience(){
 $meta_box_id = 'courses_target_audience';
 $meta_box_title = __('Who This Course is For', 'lessonlms');
 $callback_function = 'lessonlms_courses_target_audience_callback';
 $post_type = 'courses';
 $context = 'normal';
 $priority = 'high'; // sidebar
 
 add_meta_box(
    $meta_box_id,
    $meta_box_title,
    $callback_function,
    $post_type,
    $context,
    $priority
);
}
add_action('add_meta_boxes', 'lessonlms_courses_target_audience');

function lessonlms_courses_target_audience_callback( $post ){
    $audience = get_post_meta( $post->ID, '_course_target_audience', true );
    if(!$audience && !is_array($audience)){
        $audience = [];
    }
    wp_nonce_field('save_course_target_audience', 'course_target_audience_nonce');
    ?>
    <div id="audience-wrapper">
        <div class="audience-input-btn">
            <input type="text" id="new-audience-input" class="form-control" placeholder="Enter new item" />
            <button type="button" class="add-btn">Add</button>
        </div>

        <!-- show list -->
         <?php if(!empty($audience) && is_array($audience)):?>
         <div class="audience-list">
            <ul id="audience-listed">
                <?php foreach( $audience as $single_audience):?>
                    <li data-index="<?php echo esc_attr($single_audience)?>">
                        <input type="hidden" name="course_target_audience[]" value="<?php echo esc_attr($single_audience)?>">
                        <span class="audience-text">
                            <?php echo esc_html($single_audience);?>
                        </span>
                        <div class="audience-action">
                            <button class="edit-audience" type="button"> Edit</button>
                            <button type="button"class="delete-audience">
                             Delete
                            </button>
                        </div>
                    </li>

                <?php endforeach;?>
            </ul>
         </div>
         <?php endif;?>
    </div>

<?php
}