<?php
/**
 * Template Name: Course Learning Page
 */
if ( ! is_user_logged_in() ) {
    wp_redirect( wp_login_url() );
    exit;
}
get_header();
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

if ( $course_id <= 0 ) {
    echo '<p>Invalid Course</p>';
    get_footer();
    exit;
}

$course = get_post( $course_id );

if ( ! $course || $course->post_status !== 'publish' ) {
    echo '<p>Course not found</p>';
    get_footer();
    exit;
}
?>

<h1><?php echo esc_html( $course->post_title ); ?></h1>
<p>This is your learning dashboard</p>

<?php get_footer(); ?>
