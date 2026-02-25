<?php
/**
 * Courses meta fields
 * 
 * @package lessonlms
 */

function lessonlms_get_course_meta_fields() {
    return array(
        'course_details' => array(
            'vedio_hourse'       => array(
                'label' => 'Vedio Hours',
                'type'  => 'number',
                'step'  => '0.1',
                'required' => true,
            ),
            'downlable_resource' => array(
                'label' => 'Downlable Resource',
                'type'  => 'number',
                'step'  => '1',
                'required' => true,
            ),
            'total_articles' => array(
                'label' => 'Total Articles',
                'type'  => 'number',
                'required' => true,
            ),
            'language' => array(
                'label' => 'Course Language',
                'type'  => 'text',
                'required' => true,
            ),
            'sub_title_language' => array(
                'label' => 'Sub Title Language',
                'type'  => 'text',
            ),
        ),

        'pricing' => array(
            'regular_price' => array(
                'label' => 'Regular Price',
                'type'  => 'number',
                'step'  => '0.01',
                'required' => true,
            ),
            'original_price' => array(
                'label' => 'Original Price',
                'type'  => 'number',
                'step'  => '0.01',
                'required' => true,
            ),
        ),
         'course_extra_sections' => array(
            'course_learn_point' => array(
                'label' => 'What you’ll learn',
                'type'  => 'textarea',
                'rows'  => 6,
                'required' => true,
            ),
            'course_requirement_points' => array(
                'label' => 'Requirements',
                'type'  => 'textarea',
                'rows'  => 6,
                'required' => true,
            ),
            'who_this_course_for' => array(
                'label' => 'Who this course is for',
                'type'  => 'textarea',
                'rows'  => 6,
                'required' => true,
            ),
         ),
    );

}


/**
 * Courses Meta Box Callback
 */
function lessonlms_couses_add_meta_box_callback($post) {
    wp_nonce_field( 'lessonlms_courses_meta_nonce', 'lessonlms_courses_meta_nonce_field' );

    $section_fields = lessonlms_get_course_meta_fields();

    foreach( $section_fields as $section_key => $fields ) :
    ?>
    <div class="lessonlms-meta-section lessonlms-meta-section-<?php echo esc_attr( $section_key ); ?>">

        <h3 class="lessonlms-section-title">
            <?php echo esc_html( ( $section_key === 'pricing' ) ? 'Pricing' : 'Course Details' ); ?>
        </h3>

        <div class="lessonlms-fields-wrap">
            <?php foreach ( $fields as $key => $field ) :
                $field_value = get_post_meta( $post->ID, $key, true );
            ?>
                <div class="lessonlms-field">
                    <label for="<?php echo esc_attr( $key ); ?>">
                        <?php echo esc_html( $field['label'] ); ?>
                    </label>

                    <?php if ( $field['type'] === 'textarea' ) : ?>
                        <textarea
                            name="<?php echo esc_attr( $key ); ?>"
                            id="<?php echo esc_attr( $key ); ?>"
                            rows="<?php echo esc_attr( $field['rows'] ); ?>"
                            <?php if ( isset( $field['required'] ) && $field['required'] ) : ?>
                                required
                            <?php endif; ?>
                        ><?php echo esc_textarea( $field_value ); ?></textarea>
                    <?php else : ?>
                        <input
                            type="<?php echo esc_attr( $field['type'] ); ?>"
                            name="<?php echo esc_attr( $key ); ?>"
                            id="<?php echo esc_attr( $key ); ?>"
                            value="<?php echo esc_attr( $field_value ); ?>"
                            <?php if ( isset( $field['step'] ) ) : ?>
                                step="<?php echo esc_attr( $field['step'] ); ?>"
                            <?php endif; ?>
                            <?php if ( isset( $field['required'] ) && $field['required'] ) : ?>
                                required
                            <?php endif; ?>
                        >
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    <?php
    endforeach;
}