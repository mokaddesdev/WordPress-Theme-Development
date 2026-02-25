<?php
/**
 * Course Meta Box
 * 
 * @package lessonlms
 */
 function lessonlms_register_course(){
        $args = array(
            'labels' => array(
                    'name'          => __('Courses', 'lessonlms'),
                    'singular_name' => __('Course', 'lessonlms'),
                    'add_new'       => __('Add New Course', 'lessonlms'),
                    'add_new_item'  => __('Add New Course', 'lessonlms'),
                    'edit_item'     => __('Edit Course', 'lessonlms'),
                    'new_item'      => __('New Course', 'lessonlms'),
                    'search_items'  => __('Search Courses', 'lessonlms'),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array('slug' => 'course'),
            'supports'    => array('title', 'editor', 'thumbnail', 'author'),
            'menu_icon'   => 'dashicons-welcome-learn-more',
            );

            register_post_type( 'course', $args );
    }
    add_action('init','lessonlms_register_course');
    
    function lessonlms_course_meta_box() {
        add_meta_box(
            'course_details',
            'Course Details',
            'lessonlms_course_meta_box_callback',
            'course',
            'normal',
            'high'
        );
    }
    add_action( 'add_meta_boxes', 'lessonlms_course_meta_box' );

    function lessonlms_course_meta_fields() {
        return array(
            'price'                  => 'number',
            'original_price'         => 'number',
            'video_hours'            => 'float',
            'article_count'          => 'number',
            'downloadable_resources' => 'number',
            'language'               => 'text',
            'subtitles'              => 'text',
            'learn_points'           => 'textarea',
            'requirements'           => 'textarea',
            'target_audience'        => 'textarea',
        );
    }

    function lessonlms_get_course_meta( $post_id, $meta_key ) {
        $meta_value = get_post_meta( $post_id, $meta_key, true );
        if ( is_array( $meta_value ) ) {
            return implode( "\n", $meta_value ) ?? '';
        }
        return $meta_value ?? '';
    }

    function lessonlms_course_meta_box_callback( $post ) {
        wp_nonce_field( 'lessonlms_course_meta_nonce', 'lessonlms_course_meta_nonce' );

        $field_name = array();
        
        foreach ( lessonlms_course_meta_fields() as $meta_key => $type ) {
            $field_name[ $meta_key ] = lessonlms_get_course_meta( $post->ID, $meta_key );
        }

         $fields = array(
                'price'        => array(
                     'label' => 'Price',
                     'type'  => 'number',
                ),
                'original_price' => array(
                    'label' => 'Original Price',
                    'type'  => 'number',
                ),
                'video_hours' => array(
                    'label' => 'Video Hours',
                    'type'  => 'number',
                    'step'  => '0.1',
                ),
                'article_count' => array(
                    'label' => 'Article Count',
                    'type'  => 'number',
                ),
                'downloadable_resources' => array(
                    'label' => 'Downloadable Resources',
                    'type'  => 'number',
                ),
                'language' => array(
                    'label' => 'Language',
                    'type'  => 'text',
                ),
                'subtitles' => array(
                    'label' => 'Subtitles',
                    'type'  => 'text',
                ),
                'learn_points' => array(
                    'label' => "What You'll Learn",
                    'type'  => 'textarea',
                ),
                'requirements' => array(
                    'label' => 'Requirements',
                    'type'  => 'textarea',
                ),
                'target_audience' => array(
                    'label' => 'Who this course is for',
                    'type'  => 'textarea',
                ),
            );
?>
        <div>
            <?php foreach ( $fields as $name => $field ) : ?>
            <p>
                <label for="<?php echo esc_attr( $name ); ?>"> 
                    <?php echo esc_html( $field['label'] );?></label> <br>
                <?php if ( 'textarea' === $field['type'] ) : ?>
                <textarea
                id="<?php echo esc_attr( $name ); ?>"
                name="<?php echo esc_attr( $name ); ?>"
                rows="5"
                style="width:100%;"
            ><?php echo esc_textarea( $field_name[ $name ] ); ?></textarea>
            <?php else : ?>
                <input
                id="<?php echo esc_attr( $name ); ?>"
                type="<?php echo esc_attr( $field['type'] ); ?>"
                name="<?php echo esc_attr( $name ); ?>"
                step="<?php echo esc_attr( $field['step'] ?? '1' ); ?>"
                value="<?php echo esc_attr( $field_name[ $name ] ); ?>"
            >
        <?php endif; ?>
            </p>
        <?php endforeach; ?>
        </div>

        <?php
    }

    function lessonlms_save_course_meta( $post_id ) {
        if ( 
            ! isset( $_POST['lessonlms_course_meta_nonce'] ) ||
            ! wp_verify_nonce( $_POST['lessonlms_course_meta_nonce'], 'lessonlms_course_meta_nonce' )
            ) {
                return;
            }

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return;
        }
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        foreach ( lessonlms_course_meta_fields() as $field => $type ) {
            if( isset( $_POST[ $field ] ) ) {
                switch( $type ) {
                    case 'number' :
                        $value = intval( $_POST[ $field ] );
                        break;
                    case 'float' :
                        $value = floatval( $_POST[ $field ] );
                        break;
                    case 'textarea' :
                        $value = sanitize_textarea_field( $_POST[ $field ] );
                        break;
                    default :
                    $value = sanitize_text_field( $_POST[ $field ] );
                }
                update_post_meta( $post_id, $field, $value );
            }
        }
    }
    add_action( 'save_post_course', 'lessonlms_save_course_meta' );