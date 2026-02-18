<?php 
/**
 * Template Name: Student Profile
 * 
 * @package lessonlms
 *
 */
$current_user = get_current_user_id();
if ( ! $current_user ) {
    exit;
}
?>
<div>
<form method="post" class="student-change-password-form">
    <p>
        <label for="current_password"><?php esc_html_e('Current Password', 'lessonlms'); ?></label>
        <input type="password" name="current_password" id="current_password" required>
    </p>

    <p>
        <label for="new_password"><?php esc_html_e('New Password', 'lessonlms'); ?></label>
        <input type="password" name="new_password" id="new_password" required>
    </p>

    <p>
        <label for="confirm_password"><?php esc_html_e('Confirm New Password', 'lessonlms'); ?></label>
        <input type="password" name="confirm_password" id="confirm_password" required>
    </p>

    <?php wp_nonce_field( 'student_change_password', 'student_change_password_nonce' ); ?>

    <p>
        <button type="submit" name="student_change_password_submit">
            <?php esc_html_e('Change Password', 'lessonlms'); ?>
        </button>
    </p>
</form>
</div>
