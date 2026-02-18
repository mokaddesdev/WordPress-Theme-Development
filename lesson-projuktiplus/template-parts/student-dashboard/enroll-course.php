<?php
    /**
     * Template Name: Student Enrollemts
     * 
     * @package lessonlms
     */
    $current_user        = wp_get_current_user();
    if ( $current_user && $current_user->ID > 0 ) {
        $current_user_id = $current_user->ID;
    }
    $enrolled_courses    = get_user_meta( $current_user_id, '_user_enrollments', true );
?>
<div class="student-enrollment-section-wrapper">
    <div class="student-enrollment-card-grid">
        <?php
        if ( ! empty( $enrolled_courses ) && is_array( $enrolled_courses ) ) :
         foreach ( $enrolled_courses as $enrollment ) :
            $course_id = intval( $enrollment['course_id'] );
            $course    = get_post( $course_id );
            $single_course_url = home_url( '/start-your-learning/?course_id=' . $course_id );
            if ( $course && $course->post_status == 'publish' ) :
                $thumbnail = get_the_post_thumbnail(
                    $course_id,
                    'medium',
                    array(
                        'class'   => 'course-thumb',
                        'loading' => 'lazy',
                        'alt'     => $course->post_title,
                    )
                );
        ?>
            <div class="student-enrollment-card-item">
                <div class="student-enrollment-card-image">
                    <?php echo $thumbnail; ?>
                </div>

                <div class="student-enrollment-card-content">
                    <h3 class="student-enrollment-course-title">
                        <?php echo esc_html( $course->post_title ); ?>
                    </h3>
                    <p class="student-enrollment-date">
                        <?php
                        echo esc_html( 'Enrolled date: ' );
                        echo esc_html( date( 'M j, Y', strtotime( $course->post_date ) ) );
                        ?>
                    </p>
                    <a href="<?php echo esc_url( $single_course_url ); ?>"
                       class="student-enrollment-start-learning-btn">
                        <?php esc_html_e( 'Start Learning', 'lessonlms' ); ?>
                    </a>
                </div>
            </div>
        <?php
            endif;
            endforeach;
            else :
                echo '<h3> No Course Purchase </h3>';
            endif;
        ?>
    </div>
</div>