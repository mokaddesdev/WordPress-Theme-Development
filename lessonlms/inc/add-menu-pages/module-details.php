<?php
/**
 * Course module details for single course.
 *
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_show_course_module_detail' ) ) {
    function lessonlms_show_course_module_detail() {
        add_submenu_page(
            null,
            __( 'Course Modules', 'lessonlms' ),
            __( 'Course Modules', 'lessonlms' ),
            'manage_options',
            'lessonlms_show_modules',
            'lessonlms_modules_details_callback'
        );
    }
}
add_action( 'admin_menu', 'lessonlms_show_course_module_detail' );


if ( ! function_exists( 'lessonlms_modules_details_callback' ) ) {

    /**
     * Callback for the modules submenu page.
     */
    function lessonlms_modules_details_callback() {
        $course_id = isset( $_GET['course_id'] ) ? intval( $_GET['course_id'] ) : 0;

        if ( ! $course_id ) {
            return;
        }

        $course_title = get_the_title( $course_id );
        $paged        = isset( $_GET['paged'] ) ? intval( $_GET['paged'] ) : 1;
        ?>
        <div class="module-wrap">
            <input type="hidden" id="course_id" value="<?php echo esc_attr( $course_id ); ?>">

            <h2><?php echo esc_html__( 'Modules for: ', 'lessonlms' ) . esc_html( $course_title ); ?></h2>

            <div class="module-back-btn">
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=courses_modules_slug' ) ); ?>">
                    <?php echo esc_html__( 'Add module', 'lessonlms' ); ?>
                </a>
            </div>

            <!-- Confirm Modal -->
            <div id="confirm-modal" class="edit-module-popup">
                <div class="module-modal confirm-modal-wrapper">
                    <p><?php echo esc_html__( 'Are you sure you want to delete this module?', 'lessonlms' ); ?></p>
                    <div style="text-align:center;">
                        <button id="confirm-yes"><?php echo esc_html__( 'Yes', 'lessonlms' ); ?></button>
                        <button id="confirm-no"><?php echo esc_html__( 'No', 'lessonlms' ); ?></button>
                    </div>
                </div>
            </div>

            <div class="table-wrapper">
                <?php
                echo lessonlms_render_modules_table( $course_id, $paged );
                ?>
            </div>
        </div>
        <?php
    }
}