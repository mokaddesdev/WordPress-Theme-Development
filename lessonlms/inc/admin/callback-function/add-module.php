<?php
/**
 * Add module callback function
 * 
 * @package lessonlms
 */
function lessonlms_add_module_callback()
{
    $user_id = get_current_user_id();
    ?>
    <div class="lessonlms-wrap">
        <div class="course-module-form">
            <h2><?php echo esc_html__('Add Course Module', 'lessonlms'); ?></h2>

            <form id="lessonlms-module-form" method="post">
                <input type="hidden" name="action" value="lessonlms_add_module">

                <?php wp_nonce_field(
                    'add_module_nonce',
                    'add_module_nonce_field'
                ); ?>
                <p>
                    <label for="select_course"><?php echo esc_html__('Select Course', 'lessonlms'); ?></label>
                    <select name="select_course" id="select_course">
                        <option value="">
                            ---
                            <?php echo esc_html__('Select Course', 'lessonlms'); ?>
                            ---
                        </option>
                        <?php
                        $courses = get_posts(array(
                            'post_type' => 'courses',
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'post_status' => 'publish',
                            'author' => $user_id,
                        ));
                        foreach ($courses as $course):
                            ?>
                            <option value="<?php echo esc_attr($course->ID); ?>">
                                <?php echo esc_html($course->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <label for="module_name"><?php echo esc_html__('Module Name', 'lessonlms'); ?></label>
                    <input type="text" name="module_name" id="module_name">
                </p>

                <p>
                    <label for="module_status">
                        <input type="checkbox" id="module_status" name="module_status" value="enabled">
                        <?php echo esc_html__('Enable this Course Module', 'lessonlms'); ?>
                    </label>
                </p>

                <p>
                    <button id="submit-course-module" type="submit" class="button button-primary">
                        <?php echo esc_html__('Save Module', 'lessonlms'); ?>
                    </button>
                </p>
            </form>
        </div>
        <div id="course-modules-table-wrapper">
            <?php lessonlms_modules_table_callback(); ?>
        </div>
    </div>
    <?php
}