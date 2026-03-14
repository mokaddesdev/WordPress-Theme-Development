<?php
/**
 * Add Module Ajax
 * 
 * @package lessonlms
 */

function lessonlms_add_module_ajax()
    {
         if ( ! isset( $_POST['nonce'] ) ){
            wp_send_json_error( 'Nonce Miss!' );
         }
         if ( ! wp_verify_nonce( $_POST['nonce'], 'add_module_nonce' ) ) {
        wp_send_json_error( 'Security check failed' );
        }
       if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        wp_send_json_error( 'Already saved.' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'Permission denied' );
        }

        $course_id      = intval($_POST['select_course'] ?? 0);
        $module_name    = sanitize_text_field( $_POST['module_name'] ?? '' );
        $status      = isset( $_POST['module_status'] ) && $_POST['module_status'] === 'enabled' ? 'enabled' : 'disabled';

        if ( ! $course_id ) {
            wp_send_json_error( 'Select a course' );
        }

        if (! $module_name ) {
            wp_send_json_error( 'Module name is required' );
        }

        $user_id = get_current_user_id();

        $module_id = wp_insert_post( array(
                'post_title'  => $module_name,
                'post_type'   => 'course_modules',
                'post_status' => 'publish',
                'post_author' => $user_id,
                'post_parent' => $course_id,
            ) );

            if ( is_wp_error( $module_id ) ) {
                wp_send_json_error('Module creation failed');
            }
        update_post_meta( $module_id, 'module_status', $status );

        $courses = get_posts( array(
            'post_type'      => 'courses',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'author'         => $user_id,
        ) );
        
        ob_start();
        foreach ( $courses as $course ) :
                $modules = get_posts( array(
                    'post_type'      => 'course_modules',
                    'posts_per_page' => -1,
                    'post_parent'    => $course->ID,
                    'author'         => $user_id,
                ));

        $count = count($modules );
        ?>
        <tr>
            <td>
                <?php echo esc_html( $course->post_title ); ?>
            </td>
            <td>
                <?php echo esc_html( $count ) ?>
            </td>
            <td>
               <a href="<?php echo esc_url( admin_url( 'admin.php?page=lessonlms_show_modules&course_id=' . $course->ID ) ); ?>">
                <?php echo esc_html__( 'View Details', 'lessonlms' ); ?>
                </a>
        </td>
    </tr>
    <?php
    endforeach;
    $html = ob_get_clean();
    wp_send_json_success( [
            'html'      => $html,
            'message'   => 'Module saved successfully'
        ] );
    }
add_action('wp_ajax_lessonlms_add_module_ajax', 'lessonlms_add_module_ajax');