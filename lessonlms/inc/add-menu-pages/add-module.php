<?php
/**
 * Add course module in admin dashboard
 * 
 * @package lessonlms
 */
if ( ! function_exists( 'lessonlms_add_course_module_in_admin' ) ) {
function lessonlms_add_course_module_in_admin()
{
    add_menu_page(
        'Modules',
        'Modules',
        'manage_options',
        'lesslms_courses_modules_slug',
        'lessonlms_add_module_callback',
        'dashicons-welcome-learn-more',
        35
    );
}
}
add_action( 'admin_menu', 'lessonlms_add_course_module_in_admin' );

if ( ! function_exists( 'lessonlms_add_module_callback' ) ) {
function lessonlms_add_module_callback() {

$user_id = get_current_user_id();

/* FIX 1 */
$edit_id = isset( $_GET['module_id'] ) ? intval( $_GET['module_id'] ) : 0;

$selected_course = '';
$module_name     = '';
$module_status   = 'disabled';

if ( ! empty( $edit_id ) ) {
    $module = get_post( $edit_id );

    if ( ! empty( $module ) && $module->post_type === 'course_modules' ) {
        $selected_course = $module->post_parent;
        $module_name     = $module->post_title;
        $module_status   = get_post_meta( $edit_id, 'module_status', true ) ?: 'disabled';
    }
}

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
<?php echo esc_html__( $edit_id ? 'Edit Module' : 'Add Course Module', 'lessonlms'); ?>
</h2>

<form id="lessonlms-module-form" method="post">

<input type="hidden" name="action" value="lessonlms_add_module">
<input type="hidden" name="module_id" value="<?php echo esc_attr( $edit_id )?>">

<?php wp_nonce_field('add_module_nonce', 'add_module_nonce_field'); ?>

<p>
<label for="select_course"><?php echo esc_html__('Select Course', 'lessonlms'); ?></label>

<select name="_select_course" id="select_course">

<option value="">
--- <?php echo esc_html__('Select Course', 'lessonlms'); ?> ---
</option>

<?php foreach ($courses as $course): ?>

<option value="<?php echo esc_attr($course->ID); ?>" <?php selected( $selected_course, $course->ID ); ?>>

<?php echo esc_html($course->post_title); ?>

</option>

<?php endforeach; ?>

</select>
</p>

<p>
<label for="module_name"><?php echo esc_html__('Module Name', 'lessonlms'); ?></label>

<input type="text" name="_module_name" id="module_name" value="<?php echo esc_attr( $module_name ); ?>">

</p>

<p class="enable-module-title">

<label for="module_status" class="switch">

<input type="checkbox" id="module_status" name="_module_status" value="enabled" <?php checked($module_status, 'enabled'); ?>>

<span class="slider"></span>

</label>

<span><?php echo esc_html__('Enable this Course Module', 'lessonlms'); ?></span>

</p>

<p>
<button id="submit-course-module" type="submit" class="button button-primary">

<?php echo esc_html__( $edit_id ? 'Update Module' : 'Save Module', 'lessonlms'); ?>

</button>
</p>

</form>
</div>

<div id="course-modules-table-wrapper">

<table>
<thead>
<tr>
<th>Td</th>
<th>Name</th>
</tr>
</thead>

<tbody>
<tr>
<td>B</td>
<td>C</td>
</tr>
</tbody>
</table>

</div>
</div>

<?php
}
}

/* AJAX */
if ( ! function_exists( 'lessonlms_module_ajax') ) {

function lessonlms_module_ajax() {

if ( ! isset( $_POST['add_module_nonce_field'] ) || ! wp_verify_nonce( $_POST['add_module_nonce_field'], 'add_module_nonce' ) ) {
wp_send_json_error('Security check failed');
}

if ( ! current_user_can('manage_options') ) {
wp_send_json_error('Permission denied');
}

$module_id = intval( $_POST['module_id'] ?? 0 );

/* FIX 2 field names */
$course_id = intval( $_POST['select_course'] ?? 0 );
$module_name = sanitize_text_field($_POST['module_name'] ?? '');
$status = sanitize_text_field($_POST['module_status'] ?? 'disabled');

if ( ! $course_id ) wp_send_json_error('Select a course');

if ( ! $module_name ) wp_send_json_error('Module name is required');

$user_id = get_current_user_id();

if ( $module_id ) {

wp_update_post(array(
'ID'         => $module_id,
'post_title' => $module_name,
'post_parent'=> $course_id,
));

} else {

$module_id = wp_insert_post( array(
'post_title'  => $module_name,
'post_type'   => 'course_modules',
'post_status' => 'publish',
'post_author' => $user_id,
'post_parent' => $course_id,
));

if (is_wp_error($module_id)) wp_send_json_error('Module creation failed');

}

update_post_meta($module_id, 'module_status', $status);

/* FIX 3 success response */
wp_send_json_success([
'message' => 'Module saved successfully'
]);

}

}

/* FIX 4 correct hook */
add_action( 'wp_ajax_lessonlms_add_module', 'lessonlms_module_ajax' );

?>