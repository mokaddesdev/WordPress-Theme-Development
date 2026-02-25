<?php
    /**
     * Enroll Functionality
     * 
     * @package lessonlms
     */

    /**
     * Handle course enrollment via AJAX
     */
    function lessonlms_handle_enrollmemt() {
        check_ajax_referer( 'lessonlms_enroll_nonce', 'nonce' );

        $course    = $_POST['course_id'];
        $course_id = isset( $course ) ? intval( $course ) : 0;

        if ( $course_id <= 0 ) {
            wp_send_json_error( 'Invalid course ID' );
        }

        $user_id = get_current_user_id();
        if ( $user_id === 0 ) {
            wp_send_json_error( 'Please login first to enroll' );
        }

        $user_enrollments = get_user_meta( $user_id, '_user_enrollments', true );
        if ( ! is_array( $user_enrollments ) ) {
            $user_enrollments = [];
        }

        foreach ( $user_enrollments as $enrollment ) {
            if ( intval( $enrollment['course_id'] ) === $course_id ) {
                wp_send_json_error( 'Already enrolled' );
            }
        }

        $current_enroll   = get_post_meta( $course_id, '_enrolled_students', true ) ?: 0;
        $new_enroll_count = intval( $current_enroll + 1 );
        update_post_meta( $course_id, '_enrolled_students', $new_enroll_count );

        $user_enrollments[] = [
            'course_id' => $course_id,
            'date'      => current_time( 'mysql' ),
        ];

        update_user_meta( $user_id, '_user_enrollments', $user_enrollments );

        $formatted_enroll_count = number_format( $new_enroll_count );
        wp_send_json_success( $formatted_enroll_count );
    }
    add_action( 'wp_ajax_lessonlms_enroll_course', 'lessonlms_handle_enrollmemt' );
    add_action( 'wp_ajax_nopriv_lessonlms_enroll_course', 'lessonlms_handle_enrollmemt' );

    /**
     * Localize AJAX script variables
     */
    function lessonlms_ajax_script() {
        ?>
        <script type="text/javascript">
            var ajax_object = {
                ajaxurl: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
                nonce: '<?php echo esc_js( wp_create_nonce( 'lessonlms_enroll_nonce' ) ); ?>'
            };
        </script>
        <?php
    }
    add_action( 'wp_head', 'lessonlms_ajax_script' );

    /**
     * Dashboard widget for enrollments
     */
    function lessonlms_dashboard_enrollment_widget() {

       $data = total_enroll_course_count();
       
       global $wpdb;
       
        $recent_enrollments = $wpdb->get_results(
            "SELECT u.user_login, p.post_title, um.meta_value
            FROM $wpdb->usermeta um
            JOIN $wpdb->users u ON u.ID = um.user_id 
            JOIN $wpdb->posts p ON um.meta_value LIKE CONCAT('%i:', p.ID, ';%')
            WHERE um.meta_key = '_user_enrollments'
            ORDER BY um.umeta_id DESC
            LIMIT 5"
        );
        ?>
        <div class="enrollment-dashboard-widget">
            <!-- total_course -->
            <div class="total-courses-count">
                <div class="total-course-stats">
                    <span class="stat-number"><?php echo number_format( $data['courses'] ?: 0 ); ?></span>
                    <span class="stat-label"><?php echo esc_html__( 'Total Course Count', 'lessonlms' ); ?> : </span>
                </div>
            </div>

            <h3><?php echo esc_html__( 'Enrollment Status', 'lessonlms' ); ?></h3>

            <div class="enrollment-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo number_format(  $data['enrollments'] ?: 0 ); ?></span>
                    <span class="stat-label"><?php echo esc_html__( 'Total Enrollments', 'lessonlms' ); ?>:</span>
                </div>
            </div>

            <?php if ( $recent_enrollments ) : ?>
                <div class="recent-enrollments">
                    <h4><?php echo esc_html__( 'Last Enrollments', 'lessonlms' ); ?>:</h4>
                    <ul>
                        <?php foreach ( $recent_enrollments as $recent_enrollment ) : ?>
                            <li>
                                <strong><?php echo esc_html( $recent_enrollment->user_login ); ?></strong>
                                - <?php echo esc_html( $recent_enrollment->post_title ); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else : ?>
                <p><?php echo esc_html__( 'No recent enrollments found.', 'lessonlms' ); ?></p>
            <?php endif; ?>

        </div>
        <?php
    }

    /**
     * Add dashboard widget
     */
    function lessonlms_add_enrollment_dashboard_widget() {
        wp_add_dashboard_widget(
            'enrollment_dashboard_widget',
            esc_html__( 'Course Enrollment Status', 'lessonlms' ),
            'lessonlms_dashboard_enrollment_widget'
        );
    }
    add_action( 'wp_dashboard_setup', 'lessonlms_add_enrollment_dashboard_widget' );
