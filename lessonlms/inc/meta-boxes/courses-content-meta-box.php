<?php
/**
 * Courses Content Meta Box
 * 
 * @package lessonlms
 */

function lessonlms_courses_content_meta_box() {
    add_meta_box(
    'courses_content',
    'Course Conetent',
    'lessonlms_course_content_callback',
    'courses_contents',
    'normal',
    'high',
    );
}
add_action('add_meta_boxes', 'lessonlms_courses_content_meta_box');
function lessonlms_course_content_callback( $post ) {

    wp_nonce_field( 'lessonlms_course_content_nonce', 'lessonlms_course_content_nonce_field' );

    $selected_course = get_post_meta( $post->ID, '_lessonlms_selected_course', true );

    $course_content_status = get_post_meta( $post->ID, '_lessonlms_course_status', true );

    if ( empty( $course_content_status ) ) {
        $course_content_status = 'disabled';
    }

    $user_id = get_current_user_id();

    $args = array(
        'post_type'      => 'courses',
        'author'         => $user_id,
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    );

    $courses = get_posts( $args );

    if ( empty( $courses ) ) {
        echo '<p>No courses found.</p>';
        return;
    }
    ?>

    <p>
        <label for="select_courses">
            <strong>Select Course</strong>
        </label>
        <select name="lessonlms_select_course" id="select_courses" style="width:100%;" required >
            <option value="">— Select Course —</option>
            <?php foreach ( $courses as $course ) : ?>
                <option value="<?php echo esc_attr( $course->ID ); ?>"
                    <?php selected( $selected_course, $course->ID ); ?>>
                    <?php echo esc_html( $course->post_title ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label>
            <input type="checkbox"
                   name="lessonlms_course_status"
                   value="enabled"
                <?php checked( $course_content_status, 'enabled' ); ?>>
            Enable this content
        </label>
    </p>

    <?php
}


function lessonlms_save_course_content( $post_id ) {

    // nonce check
    if (
        ! isset( $_POST['lessonlms_course_content_nonce_field'] ) ||
        ! wp_verify_nonce(
            $_POST['lessonlms_course_content_nonce_field'],
            'lessonlms_course_content_nonce'
        )
    ) {
        return;
    }

    // autosave check
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // permission check
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    /* ---------- SAVE SELECT COURSE ---------- */
    if ( isset( $_POST['lessonlms_select_course'] ) ) {
        update_post_meta(
            $post_id,
            '_lessonlms_selected_course',
            intval( $_POST['lessonlms_select_course'] )
        );
    }

    /* ---------- SAVE ENABLE / DISABLE STATUS ---------- */
    if (
        isset( $_POST['lessonlms_course_status'] ) &&
        $_POST['lessonlms_course_status'] === 'enabled'
    ) {
        update_post_meta( $post_id, '_lessonlms_course_status', 'enabled' );
    } else {
        update_post_meta( $post_id, '_lessonlms_course_status', 'disabled' );
    }
}
add_action( 'save_post', 'lessonlms_save_course_content' );
