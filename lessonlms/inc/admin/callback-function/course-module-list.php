<?php
/**
 * Show course name with modules
 * 
 * @package lessonlms
 */
function  lessonlms_modules_table_callback() {
    $user_id = get_current_user_id();
    ?>
 <div class="modules-lists">
            <h2>
                <?php echo esc_html__( 'Course List with module', 'lessonlms' ); ?>
            </h2>
            <table class="wp-list-table widefat fixed striped modules-table" id="course-modules-table">
                <thead>
                    <tr>
                        <th class="table-course-list">
                            <?php echo esc_html__( 'Course Name', 'lessonlms' ); ?>
                        </th>
                        <th>
                            <?php echo esc_html__( 'Module Count', 'lessonlms' ); ?>
                        </th>
                        <th>
                            <?php echo esc_html__( 'Actions', 'lessonlms' ); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      $courses = get_posts( array(
                            'post_type'      => 'courses',
                            'posts_per_page' => -1,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                            'post_status'    => 'publish',
                            'author'         => $user_id,
                        ) );
                        if ( ! empty( $courses ) ) :
                        foreach ( $courses as $course ) :
                            $modules_count = count( get_posts( array(
                                'post_type'      => 'course_modules',
                                'meta_key'       => '_lessonlms_course_id',
                                'meta_value'     => $course->ID,
                                'posts_per_page' => -1,
                                'author'         => $user_id,
                            ) ) );

                            if ( $modules_count === 0 ) {
                                continue;
                            }
                            $has_module = true;
                            $course_title = $course->post_title ? $course->post_title : '-';
                    ?>
                        <tr>
                            <td>
                                <?php echo esc_html( $course_title ); ?>
                            </td>
                            <td class="module-name-count">
                                <?php echo esc_html( $modules_count ); ?>
                            </td>
                            <td>
                            <a href="<?php echo admin_url('admin.php?page=lessonlms_show_modules&course_id=' . $course->ID); ?>">
                                <?php echo esc_html__( 'View Modules', 'lessonlms' ); ?>
                            </a>

                            </td>
                        </tr>
                    <?php
                        endforeach;
                        if ( ! $has_module ) :
                    ?>
                    <tr>
                        <td colspan="3"><?php echo esc_html__( 'No courses with modules found.', 'lessonlms' ); ?></td>
                    </tr>
                    <?php
                    endif;
                    else :
                    ?>
                        <tr>
                            <td colspan="4"><?php echo esc_html__( 'No modules found.', 'lessonlms' ); ?></td>
                        </tr>
                    <?php
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
<?php
}