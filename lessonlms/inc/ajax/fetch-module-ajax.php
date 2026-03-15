<?php

if ( !  function_exists( 'lessonlms_fetch_modules' ) ) {
    function lessonlms_fetch_modules() {
        check_ajax_referer( 'select-course-nonce', 'select_nonce' );

        $course_id = intval( $_POST['course_id'] );

        if ( ! $course_id ) {
        wp_send_json_error( array( 
            'message' => 'Invalid course ID'
            ) );
    }
    ob_start();
    $modules_for_course = get_posts(
				array(
					'post_type' 	 => 'course_modules',
					'post_status' 	 => 'publish',
					'post_parent' 	 => $course_id,
					'posts_per_page' => -1,
					'orderby' 		 => 'menu_order',
					'order' 		 => 'ASC',
					'meta_query' 	 => array(
						array(
							'key'   => 'module_status',
							'value' => 'enabled',
						),
					),
				)
			);
    ?>
    <p>
        <label class="label" for="select-module">
            <?php esc_html_e('Select Module', 'lessonlms'); ?>
        </label>
        <select class="select" name="_select_module" id="select-module" >
            <option value="">
                --- <?php esc_html_e('Select Module', 'lessonlms'); ?> ---
            </option>
            <?php foreach ( $modules_for_course as $module ) : ?>
                <option value="<?php echo esc_attr( $module->ID ); ?>" <?php selected( $course_id, $module->ID ); ?>>
                    <?php echo esc_html( $module->post_title ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        </p>
    <?php
    $html = ob_get_clean();
    wp_send_json_success( array(
        'course_id' => $course_id,
        'html'      => $html,
        ) );
    }
}
add_action( 'wp_ajax_lessonlms_fetch_modules', 'lessonlms_fetch_modules' );