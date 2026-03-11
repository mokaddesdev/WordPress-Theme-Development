<?php
/**
 * Course module details for single course
 * 
 * @package lessonlms
 */

if ( ! function_exists('lessonlms_show_course_module_detail')) {

    function lessonlms_show_course_module_detail()
    {
        add_submenu_page(
            null,
            'Course Modules',
            'Course Modules',
            'manage_options',
            'lessonlms_show_modules',
            'lessonlms_modules_details_callback'
        );
    }
}
add_action('admin_menu', 'lessonlms_show_course_module_detail');


function lessonlms_render_modules_table($course_id, $paged = 1)
{
    $args = [
        'post_type' => 'course_modules',
        'post_parent' => $course_id,
        'posts_per_page' => 10,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    $modules = new WP_Query($args);

    ob_start();
    ?>
    <table class="wp-list-table widefat fixed striped modules-table">
        <thead>
            <tr>
                <th><?php echo esc_html__('Module Name', 'lessonlms'); ?></th>
                <th><?php echo esc_html__('Status', 'lessonlms'); ?></th>
                <th><?php echo esc_html__('Actions', 'lessonlms'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($modules->have_posts()): ?>
                <?php while ($modules->have_posts()):
                    $modules->the_post();
                    $status = get_post_meta(get_the_ID(), 'module_status', true); ?>
                    <tr>
                        <td><?php the_title(); ?></td>
                        <td>
                            <?php if ($status): ?>
                                <span class="lessonlms-status <?php echo esc_attr($status); ?>">
                                    <?php echo esc_html(ucfirst($status)); ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="module-edit" data-id="<?php echo get_the_ID(); ?>"
                                data-name="<?php echo esc_attr(get_the_title()); ?>"
                                data-module_status="<?php echo esc_attr($status); ?>">
                                Edit
                            </button>
                            <div class="edit-module-popup">
                                <div class="module-modal">
                                    <h2>Edit Module</h2>
                                    <form class="edit-module-form" method="post">
                                        <input type="hidden" name="module_id" class="module_id">
                                        <label for="module_name">Name</label>
                                        <input type="text" name="module_name" class="module_name">
                                        <label for="module_status"> Module Status </label>
                                        <p class="enable-module-title">
                                            <label for="module_status" class="switch">
                                                <input type="checkbox" id="module_status" name="module_status" value="enabled">
                                                <span class="slider"></span>
                                            </label>
                                            <span>
                                                <?php echo esc_html__('Enable this Course Module', 'lessonlms'); ?>
                                            </span>
                                        </p>
                                        <div class="module-modal-buttons">
                                            <button type="submit" class="update-module">Update Module</button>
                                            <button type="button" class="cancel-module">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <button type="button" class="module-delete" data-id="<?php echo get_the_ID(); ?>"
                                data-nonce="<?php echo wp_create_nonce('lessonlms_delete_module'); ?>">
                                <?php echo esc_html__('Delete', 'lessonlms'); ?>
                            </button>
                        </td>
                    </tr>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php else: ?>
                <tr>
                    <td colspan="3"><?php echo esc_html__('No modules found for this course.', 'lessonlms'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php
    // Pagination (after table, always outside the loop)
    if ($modules->max_num_pages > 1):
        $paginations = paginate_links([
            'base' => add_query_arg('paged', '%#%'),
            'format' => '',
            'current' => $paged,
            'total' => $modules->max_num_pages,
            'prev_text' => __('« Prev'),
            'next_text' => __('Next »'),
            'type' => 'list',
        ]);
        if ($paginations):
            echo '<div class="lessonlms-pagination">' . $paginations . '</div>';
        endif;
    endif;

    return ob_get_clean();
}

if (!function_exists('lessonlms_modules_details_callback')) {

    function lessonlms_modules_details_callback()
    {
        $course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
        if (!$course_id)
            return;

        $course_title = get_the_title($course_id);

        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        ?>
        <div class="module-wrap">
            <!-- course_id -->
            <input type="hidden" id="course_id" value="<?php echo esc_attr($course_id); ?>">
            <h2>
                <?php echo esc_html('Modules for: ' . $course_title); ?>
            </h2>

            <div class="module-back-btn">
                <a href="<?php echo esc_url(admin_url('admin.php?page=courses_modules_slug')); ?>">
                    <?php echo esc_html__('Add module', 'lessonlms'); ?>
                </a>
            </div>

            <!-- Custom Confirm Modal -->
            <div id="confirm-modal" class="edit-module-popup">
                <div class="module-modal confirm-modal-wrapper">
                    <p>Are you sure you want to delete this module?</p>
                    <div style="text-align:center;">
                        <button id="confirm-yes">Yes</button>
                        <button id="confirm-no">No</button>
                    </div>
                </div>
            </div>
            
            <div class="table-wrapper">
                <?php
                echo lessonlms_render_modules_table($course_id, $paged);
                global $wp_query;
                if ($wp_query->max_num_pages > 1) {
                    $paginations = paginate_links([
                        'base' => add_query_arg('paged', '%#%'),
                        'format' => '',
                        'current' => $paged,
                        'total' => $wp_query->max_num_pages,
                        'prev_text' => __('« Prev'),
                        'next_text' => __('Next »'),
                        'type' => 'list',
                    ]);
                    if ($paginations) {
                        echo '<div class="lessonlms-pagination">' . $paginations . '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }
}