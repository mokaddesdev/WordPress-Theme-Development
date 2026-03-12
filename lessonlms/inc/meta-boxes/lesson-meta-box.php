<?php
/**
 * Lesson Meta Box
 *
 * @package lessonlms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register lesson meta box.
 */
if ( ! function_exists( 'lessonlms_register_lesson_meta_box' ) ) {
	function lessonlms_register_lesson_meta_box( $post_type )
	{
		if ( $post_type !== 'lessons' ) {
			return;
		}

		add_meta_box(
			'lesson_meta_box',
			__( 'Lesson Details Information', 'lessonlms' ),
			'lessonlms_lesson_meta_box_callback',
			'lessons',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'lessonlms_register_lesson_meta_box' );

/**
 * Lesson meta box callback function
 */
if ( ! function_exists(  'lessonlms_lesson_meta_box_callback' ) ) {
	function lessonlms_lesson_meta_box_callback( $post )
	{
		$user_id = get_current_user_id();

		$modules = get_posts(
			array(
				'post_type' 	  => 'course_modules',
				'post_status' 	  => 'publish',
				'posts_per_page'  => -1,
				'orderby' 		  => 'date',
				'order' 		  => 'DESC',
				'author' 		  => $user_id,
				'meta_query' 	  => array(
					array(
						'key'   => 'module_status',
						'value' => 'enabled',
					),
				),
			)
		);

		$course_ids = array();

		if ( ! empty( $modules ) ) {
			foreach ( $modules as $module ) {
				if ( $module->post_parent ) {
					$course_ids[] = $module->post_parent;
				}
			}
		}

		$course_ids = array_unique( $course_ids );
		$courses = array();

		if ( ! empty( $course_ids ) ) {
			$courses = get_posts(
				array(
					'post_type'   	 => 'courses',
					'post_status' 	 => 'publish',
					'post__in' 		 => $course_ids,
					'posts_per_page' => -1,
					'orderby' 		 => 'date',
					'order' 		 => 'DESC',
				)
			);
		}

		$selected_course  = get_post_meta( $post->ID, '_selected_course', true );
		$selected_module  = get_post_meta( $post->ID, '_select_module', true );
		$video_duration   = get_post_meta( $post->ID, '_video_duration', true );
		$free_lesson 	  = get_post_meta( $post->ID, '_free_lesson', true );
		$lesson_status 	  = get_post_meta( $post->ID, '_lesson_status', true );
		$video_url 		  = get_post_meta( $post->ID, '_video_url', true );

		$modules_for_course = array();

		if ( $selected_course ) {
			$modules_for_course = get_posts(
				array(
					'post_type' 	 => 'course_modules',
					'post_status' 	 => 'publish',
					'post_parent' 	 => $selected_course,
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
		}
		?>

		<div class="lesson-meta-box">
			<?php
			wp_nonce_field( 'lesson_meta_box', 'lesson_meta_box_nonce' );
			?>
			<div class="meta-box-left">

				<p class="title">
					<label class="label" for="select-course">
						<?php echo esc_html__( 'Select Course', 'lessonlms' ); ?>
						<span class="required">*</span>
					</label>
					<select class="select" name="_selected_course" id="select-course" required
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'select-course-nonce' ) ); ?>">
						<option value="">
							--- <?php echo esc_html__( 'Select Course', 'lessonlms' ); ?> ---
						</option>

						<?php if ( ! empty( $courses ) ) : ?>
							<?php foreach ( $courses as $course ) : ?>
								<option value="<?php echo esc_attr( $course->ID ); ?>" <?php selected( $selected_course, $course->ID ); ?>>
									<?php echo esc_html( $course->post_title ); ?>
								</option>
							<?php endforeach; ?>
						<?php else : ?>
							<option value="">
								<?php echo esc_html__( 'No course added with module', 'lessonlms' ); ?>
							</option>
						<?php endif; ?>
					</select>
				</p>

				<div class="show-module">
					<p>
					<label class="label" for="select-module">
						<?php echo esc_html__('Select Module', 'lessonlms'); ?>
						<!-- <span class="required">*</span> -->
					</label>
					<select class="select" name="_select_module" id="select-module" >
						<option value="">
							--- <?php echo esc_html__('Select Module', 'lessonlms'); ?> ---
						</option>
						<?php foreach ( $modules_for_course as $module ) : ?>
							<option value="<?php echo esc_attr( $module->ID ); ?>" <?php selected( $selected_module, $module->ID ); ?>>
								<?php echo esc_html( $module->post_title ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				 </p>
				</div>

				<p class="checkbox-label">
					<label class="label" >
						<?php echo esc_html__( 'Active Lesson', 'lessonlms' ); ?>
					</label>
					<label class="switch" for="lesson-status">
						<input type="checkbox" name="_lesson_status" id="lesson-status" value="1" <?php checked( $lesson_status, '1' ); ?> />
						<span class="slider"></span>
					</label>
				</p>
			</div>

			<div class="meta-box-right">
				<p>
					<label class="label" for="video-url">
						<?php echo esc_html__( 'Video URL', 'lessonlms' ); ?>
						<!-- <span class="required">*</span> -->
					</label>
					<input class="input-data" type="url" name="_video_url" id="video-url"
						value="<?php echo esc_url( $video_url ); ?>" placeholder="https://example.com/video.mp4"/>
				</p>

				<p>
					<label class="label" for="video_duration">
						<?php echo esc_html__( 'Video Duration', 'lessonlms' ); ?>
					</label>
					<input class="input-data" type="number" step="0.1" name="video_duration" id="video_duration"
					value="<?php echo esc_attr( $video_duration ); ?>"/>
				</p>

				<p class="checkbox-label">
					<label class="label" for="free-lesson">
						<?php echo esc_html__( 'Free Lesson', 'lessonlms' ); ?>
					</label>

					<label class="switch">
						<input type="checkbox" name="_free_lesson" id="free-lesson" value="1" <?php checked( $free_lesson, '1' ); ?> />
						<span class="slider"></span>
					</label>
				</p>

			</div>

		</div>

		<?php
	}
}


/**
 * Save lesson meta.
 */
if (!function_exists('lessonlms_save_lesson_meta_box')) {
	function lessonlms_save_lesson_meta_box($post_id)
	{

		if (!isset($_POST['lesson_meta_box_nonce'])) {
			return;
		}

		if (!wp_verify_nonce($_POST['lesson_meta_box_nonce'], 'lesson_meta_box')) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		if ('lessons' !== get_post_type($post_id)) {
			return;
		}

		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		if (isset($_POST['_selected_course'])) {
			update_post_meta($post_id, '_selected_course', absint($_POST['_selected_course']));
		}

		if (isset($_POST['_select_module'])) {
			update_post_meta($post_id, '_select_module', absint($_POST['_select_module']));
		}

		if (isset($_POST['video_duration'])) {
			update_post_meta($post_id, '_video_duration', floatval($_POST['video_duration']));
		}

		update_post_meta($post_id, '_lesson_status', isset($_POST['_lesson_status']) ? '1' : '0');

		update_post_meta($post_id, '_free_lesson', isset($_POST['_free_lesson']) ? '1' : '0');

		if (isset($_POST['_video_url'])) {
			update_post_meta($post_id, '_video_url', esc_url_raw($_POST['_video_url']));
		}
	}
}
add_action('save_post_lessons', 'lessonlms_save_lesson_meta_box');