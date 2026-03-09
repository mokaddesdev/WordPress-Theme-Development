<?php
/**
 * Course module details for single course
 * 
 * @package lessonlms
 */
function lessonlms_show_course_module_detail() {
    add_submenu_page(
        null,
        'Course Modules',
        'Course Modules',
        'manage_options',
        'lessonlms_show_modules',
        'lessonlms_modules_page_callback'
    );
}
add_action( 'admin_menu', 'lessonlms_show_course_module_detail' );

//? callback function
/**
 * Course module list
 * 
 * @package lessonlms
 */
function lessonlms_modules_page_callback()
{
    $course_id = isset( $_GET['course_id'] ) ? intval($_GET['course_id']) : 0;

    if ( ! $course_id ) {
        return;
    }

    $course_title = get_the_title( $course_id );
    $modules = get_posts( array(
        'post_type'         => 'course_modules',
        'post_parent'       => $course_id,
        'posts_per_page'    => -1,
        'orderby'           => 'date',
        'order'             => 'DESC'
    ) );
    ?>
    <div class="module-wrap">
        <h2>
            <?php echo esc_html( 'Modules for: ' . $course_title ); ?>
        </h2>

        <div class="add-back-btn">
            <button class="lessonlms-back-btn">
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=lesslms_courses_modules_slug' ) ); ?>">
                    <?php echo esc_html__( 'Add module', 'lessonlms' ); ?>
                </a>
            </button>
        </div>

        <!-- Wrap table in a form -->
            <table class="wp-list-table widefat fixed striped modules-table">
                <thead>
                    <tr>
                        <th class="module-name-list">
                            <?php echo esc_html__( 'Module Name', 'lessonlms' ); ?>
                        </th>
                        <th>
                            <?php echo esc_html__( 'Status', 'lessonlms' ); ?>
                        </th>
                        <th>
                            <?php echo esc_html__( 'Actions', 'lessonlms' ); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( ! empty( $modules ) ) : ?>
                        <?php foreach ( $modules as $module ):
                            $status = get_post_meta( $module->ID, 'module_status', true );
                            ?>
                            <tr>
                                <td>
                                    <?php echo esc_html( $module->post_title ); ?>
                                </td>
                                <td>
                                    <?php if ( $status ) : ?>
                                    <span class="lessonlms-status <?php echo esc_attr( $status ); ?>">
                                        <?php echo esc_html( ucfirst( $status ) ); ?> 
                                        <!-- ucfirst() uppercase first letter => capitalize -->
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="lessonlms-edit" data-nonce="<?php echo wp_create_nonce( 'module-edit-nonce' ); ?>"
                                        data-id="<?php echo esc_attr( $module->ID ); ?>">
                                        <?php echo esc_html__( 'Edit', 'lessonlms' ); ?>
                                    </button>
                                    <form method="post">
                                    <button class="lessonlms-delete" type="submit" name="lessonlms_delete_module"
                                        value="<?php echo esc_attr( $module->ID ); ?>"
                                        onclick="return confirm( 'Are you sure? This module will be permanently deleted!' )">
                                        <?php echo esc_html__( 'Delete', 'lessonlms' ); ?>
                                    </button>
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">
                                <?php echo esc_html__( 'No modules found for this course.', 'lessonlms' ); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>
    </div>
    <?php
}

// Delete handling
if ( isset( $_POST['lessonlms_delete_module'] ) ) {
    $module_id = absint( $_POST['lessonlms_delete_module'] );
    if ( $module_id ) {
        wp_delete_post($module_id, true);
        wp_redirect($_SERVER['REQUEST_URI']);
        exit;
    }
}
?>
<style>
    .edit-module-form{
        display: none;
    }
</style>
<div class="edit-module-form">
    <h2>
        <?php echo esc_html__( 'Edit Course Module', 'lessonlms' ); ?>
    </h2>
    <form action="edit-module" method="post" data-nonce="<?php wp_create_nonce("edit-module-nonce"); ?>">
        <label for="module-name"> Module Name</label>
        <input type="text" id="module-name" name="module-name" value="<?php echo esc_html__( 'Module', 'lessonlms' ); ?>">
    </form>
</div>