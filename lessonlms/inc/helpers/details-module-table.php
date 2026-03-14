<?php
/**
 * Show all module in table
 * 
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_render_modules_table' ) ) {
    function lessonlms_render_modules_table( $course_id, $paged = 1 ) {
        $args = array(
            'post_type'      => 'course_modules',
            'post_parent'    => $course_id,
            'posts_per_page' => 10,
            'paged'          => $paged,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        $modules = new WP_Query( $args );

        ob_start();
        ?>
<table class="wp-list-table widefat fixed striped modules-table">
    <thead>
        <tr>
            <th><?php echo esc_html__( 'Module Name', 'lessonlms' ); ?></th>
            <th><?php echo esc_html__( 'Status', 'lessonlms' ); ?></th>
            <th><?php echo esc_html__( 'Actions', 'lessonlms' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if ( $modules->have_posts() ) : ?>
            <?php while ( $modules->have_posts() ) : $modules->the_post(); 
                $module_id = get_the_ID();
                $status    = get_post_meta( $module_id, 'module_status', true );
            ?>
        <tr>
            <td>
                <?php the_title(); ?>
            </td>
            <td>
                <?php if ( $status ) : ?>
                    <span class="lessonlms-status <?php echo esc_attr( $status ); ?>">
                        <?php echo esc_html( ucfirst( $status ) ); ?>
                    </span>
                <?php endif; ?>
            </td>
            <td>
                <button class="module-edit"
                        data-id="<?php echo esc_attr( $module_id ); ?>"
                        data-name="<?php echo esc_attr( get_the_title() ); ?>"
                        data-module_status="<?php echo esc_attr( $status ); ?>">
                    <?php echo esc_html__( 'Edit', 'lessonlms' ); ?>
                </button>

                <div class="edit-module-popup">
                    <div class="module-modal">
                        <h2>
                            <?php echo esc_html__( 'Edit Module', 'lessonlms' ); ?>
                        </h2>
                        <form class="edit-module-form" method="post" data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_module_nonce' ) ); ?>">
                            <input type="hidden" name="module_id" class="module_id">

                            <label for="module_name">
                                <?php echo esc_html__( 'Name', 'lessonlms' ); ?>
                            </label>
                            <input type="text" name="module_name" class="module_name">

                            <label for="module_status_<?php echo esc_attr( $module_id ); ?>">
                                <?php echo esc_html__( 'Module Status', 'lessonlms' ); ?>
                            </label>
                            <p class="enable-module-title">
                                <label for="module_status_<?php echo esc_attr( $module_id ); ?>" class="switch">
                                    <input type="checkbox" id="module_status_<?php echo esc_attr( $module_id ); ?>" name="module_status" value="enabled">
                                    <span class="slider"></span>
                                </label>
                                <span>
                                    <?php echo esc_html__( 'Enable this Course Module', 'lessonlms' ); ?>
                                </span>
                            </p>

                            <div class="module-modal-buttons">
                                <button type="submit" class="update-module">
                                    <?php echo esc_html__( 'Update Module', 'lessonlms' ); ?>
                                </button>
                                <button type="button" class="cancel-module">
                                    <?php echo esc_html__( 'Cancel', 'lessonlms' ); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <button type="button" class="module-delete"
                        data-id="<?php echo esc_attr( $module_id ); ?>"
                        data-nonce="<?php echo esc_attr( wp_create_nonce( 'lessonlms_delete_module' ) ); ?>">
                    <?php echo esc_html__( 'Delete', 'lessonlms' ); ?>
                </button>
            </td>
        </tr>
            <?php endwhile; wp_reset_postdata(); ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">
                            <?php echo esc_html__( 'No modules found for this course.', 'lessonlms' ); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php
        // Pagination
        if ( $modules->max_num_pages > 1 ) {
            $paginations = paginate_links(
                array(
                    'base'      => add_query_arg( 'paged', '%#%' ),
                    'format'    => '',
                    'current'   => $paged,
                    'total'     => $modules->max_num_pages,
                    'prev_text' => __( '« Prev', 'lessonlms' ),
                    'next_text' => __( 'Next »', 'lessonlms' ),
                    'type'      => 'list',
                )
            );

            if ( $paginations ) {
                echo '<div class="lessonlms-pagination">' . $paginations . '</div>';
            }
        }
        return ob_get_clean();
    }
}