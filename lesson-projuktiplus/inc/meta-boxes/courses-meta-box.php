<?php
/**
 * Courses Post Type Meta Box
 * 
 * @package lessonlms
 */

require_once get_template_directory() . '/inc/meta-fields/course-meta-fields.php';

/**
 * Add Courses Meta Box
 */
function lessonlms_courses_add_meta_box(){
    add_meta_box(
        'courses_details',
        'Courses Details',
        'lessonlms_couses_add_meta_box_callback',
        'courses',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'lessonlms_courses_add_meta_box');

/**
 * Save Courses Meta Data
 */
function lessonlms_courses_save_meta_data( $post_id ){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if (
        ! isset( $_POST[ 'lessonlms_courses_meta_nonce_field' ] ) ||
        ! wp_verify_nonce(
            $_POST['lessonlms_courses_meta_nonce_field'],
            'lessonlms_courses_meta_nonce'
        )
    ) {
        return;
    }

    $sections = lessonlms_get_course_meta_fields();

    foreach ( $sections as $fields ) {
        foreach ( $fields as $key => $field ) {
            if ( isset( $_POST[$key] ) ) {

                if ( $field['type'] === 'textarea' ) {
                    update_post_meta(
                        $post_id,
                        $key,
                        sanitize_textarea_field( $_POST[$key] )
                    );
                } else {
                    update_post_meta(
                        $post_id,
                        $key,
                        sanitize_text_field( $_POST[$key] )
                    );
                }

            }
        }
    }
}
add_action('save_post_courses', 'lessonlms_courses_save_meta_data');

/**
 * Featured Courses Meta Box
 */
function lessonlms_courses_featured_meta_box(){
    add_meta_box(
        'courses_featured',
        'Featured',
        'lessonlms_courses_featured_callback',
        'courses',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'lessonlms_courses_featured_meta_box');

function lessonlms_courses_featured_callback($post){
    $featured = get_post_meta($post->ID, '_is_featured', true);
    ?>
    <div class="featured-check">
        <label for="_is_featured">Show Featured Course:</label>
        <input type="checkbox" value="yes" name="_is_featured" id="_is_featured" <?php checked( $featured, 'yes' ); ?>>
    </div>
    <?php
}
// Add meta box
add_action('add_meta_boxes', function() {
    add_meta_box(
        'course_product',
        'Select Course Product',
        'course_product_callback',
        'courses',
        'side'
    );
});

function course_product_callback($post) {
    wp_nonce_field('save_course_product', 'course_product_nonce');

    $products = get_posts([
        'post_type' => 'product',
        'numberposts' => -1
    ]);

    $selected = get_post_meta($post->ID, '_course_product', true);

    echo '<select name="course_product" style="width:100%">';
    echo '<option value="">Select Product</option>';
    foreach ($products as $product) {
        echo '<option value="'.esc_attr($product->ID).'" '.selected($selected, $product->ID, false).'>'.esc_html($product->post_title).'</option>';
    }
    echo '</select>';
}

// Save meta box value
add_action('save_post', function($post_id) {

    if(get_post_type($post_id) !== 'courses') return;
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(!isset($_POST['course_product_nonce']) || !wp_verify_nonce($_POST['course_product_nonce'], 'save_course_product')) return;
    if(!current_user_can('edit_post', $post_id)) return;

    if(isset($_POST['course_product'])){
        update_post_meta($post_id, '_course_product', sanitize_text_field($_POST['course_product']));
    }
});

/**
 * Save Featured Courses Meta
 */
function lessonlms_courses_save_featured_meta($post_id){
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( !current_user_can('edit_post', $post_id) ) return;

    if ( isset($_POST['_is_featured']) && $_POST['_is_featured'] === 'yes' ) {
        update_post_meta($post_id, '_is_featured', sanitize_text_field($_POST['_is_featured']));
    } else {
        delete_post_meta($post_id, '_is_featured');
    }
}
add_action('save_post_courses', 'lessonlms_courses_save_featured_meta');
