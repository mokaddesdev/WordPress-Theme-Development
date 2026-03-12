<?php

/**
 * Add course module in admin dashboard
 * 
 * @package lessonlms
 */
if (! function_exists('lessonlms_add_course_module_in_admin')) {
    function lessonlms_add_course_module_in_admin()
    {
        add_menu_page(
            'Course Modules',
            'Course Modules',
            'manage_options',
            'courses_modules_slug',
            'lessonlms_add_module_callback',
            'dashicons-category',
            28
        );
    }
}
add_action('admin_menu', 'lessonlms_add_course_module_in_admin');

if ( ! function_exists('lessonlms_add_module_callback')) {
    function lessonlms_add_module_callback()
    {

        $user_id         = get_current_user_id();

        $courses = get_posts( array(
            'post_type'      => 'courses',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'author'         => $user_id,
        ) );
        ?>
        <div class="lessonlms-wrap">
            <div class="course-module-form">
                <h2>
                    <?php echo esc_html__( 'Add Course Module', 'lessonlms' ); ?>
                </h2>

                <form id="lessonlms-module-form" method="post" data-nonce="<?php echo wp_create_nonce( 'add_module_nonce' ); ?>">
                    <input type="hidden" name="action" value="lessonlms_add_module">

                    <p>
                        <label for="select_course">
                            <?php echo esc_html__( 'Select Course', 'lessonlms' ); ?>
                        </label>

                        <select name="select_course" id="select_course">

                            <option value="">
                                ---
                                <?php echo esc_html__( 'Select Course', 'lessonlms' ); ?>
                                ---
                            </option>

                            <?php foreach ( $courses as $course ) : ?>

                                <option value="<?php echo esc_attr( $course->ID ); ?>">
                                <?php echo esc_html( $course->post_title ); ?>
                                </option>

                            <?php endforeach; ?>

                        </select>
                    </p>

                    <p>
                        <label for="module_name">
                            <?php echo esc_html__( 'Module Name', 'lessonlms' ); ?>
                        </label>

                        <input type="text" name="module_name" id="module_name">

                    </p>

                    <p class="enable-module-title">
                        <label for="module_status" class="switch">
                            <input type="checkbox" id="module_status" name="module_status" value="enabled">
                            <span class="slider"></span>
                        </label>
                        <span>
                            <?php echo esc_html__( 'Enable this Course Module', 'lessonlms' ); ?>
                        </span>
                    </p>

                    <p>
                        <button id="submit-course-module" type="submit" class="button button-primary">
                            <?php echo esc_html__( 'Save Module', 'lessonlms' ); ?>
                        </button>
                    </p>

                </form>
            </div>

       <div id="course-modules-table-wrapper" class="modules-lists">
    <h2><?php echo esc_html__('Courses & Modules', 'lessonlms'); ?></h2>

    <table class="modules-table">
        <thead>
            <tr>
                <th>
                    <?php echo esc_html__( 'Course Name', 'lessonlms' ); ?>
                </th>
                <th>
                    <?php echo esc_html__( 'Total Module', 'lessonlms' ); ?>
                </th>
                <th>
                    <?php echo esc_html__( 'Module Details', 'lessonlms' ); ?>
                </th>
            </tr>
        </thead>

        <tbody class="course-module-table">

        <?php if ( ! empty( $courses ) ) : ?>

        <?php foreach( $courses as $course ) : ?>

        <tr>
            <td>
                <?php echo esc_html( $course->post_title ); ?>
            </td>

            <td>
                <?php
                $modules = get_posts(array(
                    'post_type'      => 'course_modules',
                    'posts_per_page' => -1,
                    'post_parent'    => $course->ID,
                    'author'         => $user_id,
                ));

                $module_count = count($modules);
                ?>

                <?php echo esc_html( $module_count ); ?>
            </td>

            <td>
                <a class="lessonlms-view-btn"
                   href="<?php echo esc_url( admin_url('admin.php?page=lessonlms_show_modules&course_id=' . $course->ID) ); ?>">
                   <?php echo esc_html__( 'View Details', 'lessonlms' ); ?>
                </a>
            </td>
        </tr>

        <?php endforeach; ?>

        <?php else : ?>

        <tr>
            <td colspan="3">
                <?php echo esc_html__('No courses found', 'lessonlms'); ?>
            </td>
        </tr>

        <?php endif; ?>

        </tbody>
    </table>

</div>

<?php
    }
}