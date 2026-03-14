<?php
/**
 * Theme Function
 * 
 * @package lessonlms
 */

if ( ! defined( 'THEME_DIR' ) ) {
    define( 'THEME_DIR', get_template_directory() );
}

if ( ! defined( 'THEME_URI' ) ) {
    define( 'THEME_URI', get_template_directory_uri() );
}
function lessonlms_login_header() {
get_header();
}
add_action( 'login_header', 'lessonlms_login_header' );

function lessonlms_login_footer() {
 get_footer();
}
add_action( 'login_footer', 'lessonlms_login_footer' );


    // Theme includes
    $theme_dir = get_template_directory();
    $user = wp_get_current_user();
    // Core functions
    include_once THEME_DIR . '/inc/enqueue.php';
    include_once THEME_DIR . '/inc/admin/admin-enqueue.php';
    include_once THEME_DIR . '/inc/default.php';
    include_once THEME_DIR . '/inc/woocommerce.php';
    require_once THEME_DIR . '/inc/admin/admin.php';
    // include_once $theme_dir . '/def.php';

    // add module & details module page
    require_once THEME_DIR . '/inc/add-menu-pages/add-module.php';
    require_once THEME_DIR . '/inc/add-menu-pages/module-details.php';
    
    // Pagination
    include_once THEME_DIR . '/inc/pagination.php';

    // Reviews & enroll
    include_once THEME_DIR . '/inc/reviews.php';
    include_once THEME_DIR . '/inc/enroll.php';

    // Submit feedback
    include_once THEME_DIR . '/inc/submit-feedback.php'; 

    // Custom Post Types
    include_once THEME_DIR . '/inc/cpt/courses.php';
    include_once THEME_DIR . '/inc/cpt/testimonial.php';
    include_once THEME_DIR . '/inc/cpt/lessons.php';
    include_once THEME_DIR . '/inc/cpt/modules.php';
   

    // Customizer
    include_once THEME_DIR . '/inc/customizer.php';
    include_once THEME_DIR . '/inc/customizer.php';

    // Helpers
    include_once THEME_DIR . '/inc/helpers/number-format.php';
    include_once THEME_DIR . '/inc/helpers/image-structure.php';
    include_once THEME_DIR . '/inc/helpers/enroll-course-count.php';
    include_once THEME_DIR . '/inc/helpers/details-module-table.php';
/**
 * lessonlms start session with checking
 */
function lessonlms_start_session() {
    if ( session_status() === PHP_SESSION_NONE && ! headers_sent() ) {
        session_start();
    }
}
add_action( 'init', 'lessonlms_start_session' );

/**
 * Set Session and Cookie
 */
function lessonlms_set_otp_user_session( $user_id ) {
    
    if ( session_status() === PHP_SESSION_NONE ) {
        session_start();
    }

    $_SESSION['lessonlms_otp_user_id'] = $user_id;

    set_transient('lessonlms_otp_user_' . $user_id, $user_id, 5 * MINUTE_IN_SECONDS );
    //cookie set for 0.5hour or 30minute or 1800second
    setcookie( 'lessonlms_otp_user_id', $user_id, time() + 1800, '/');
}

function lessonlms_get_otp_user_id() {

    if ( isset( $_SESSION['lessonlms_otp_user_id'] ) ) {
        return intval( $_SESSION['lessonlms_otp_user_id'] );
    }

    if ( isset( $_GET['user_id'] ) ) {
        $user_id = intval( $_GET['user_id'] );
        lessonlms_set_otp_user_session( $user_id );
        return $user_id;
    }

    if ( isset( $_COOKIE['lessonlms_otp_user_id'] ) ) {
        return intval( $_COOKIE['lessonlms_otp_user_id'] );
    }
    return 0;
}

function lessonlms_clear_otp_user_session() {

    unset( $_SESSION['lessonlms_otp_user_id'] );

    setcookie( 'lessonlms_otp_user_id', '', time() - 1800, '/' );
}

if ( isset( $_POST['student_change_password_submit'] ) ) {

    if ( ! isset( $_POST['student_change_password_nonce'] ) 
        || ! wp_verify_nonce( $_POST['student_change_password_nonce'], 'student_change_password' ) ) {
        wp_die( esc_html__( 'Security check failed.', 'lessonlms' ) );
    }

    $current_user = wp_get_current_user();
    $current_password = sanitize_text_field( $_POST['current_password'] );
    $new_password     = sanitize_text_field( $_POST['new_password'] );
    $confirm_password = sanitize_text_field( $_POST['confirm_password'] );

    // Check current password
    if ( ! wp_check_password( $current_password, $current_user->user_pass, $current_user->ID ) ) {
        echo '<p style="color:red;">' . esc_html__( 'Current password is incorrect.', 'lessonlms' ) . '</p>';
    } 
    // Check new password match
    elseif ( $new_password !== $confirm_password ) {
        echo '<p style="color:red;">' . esc_html__( 'New passwords do not match.', 'lessonlms' ) . '</p>';
    } 
    // Change password
    else {
        wp_set_password( $new_password, $current_user->ID );
        echo '<p style="color:green;">' . esc_html__( 'Password changed successfully.', 'lessonlms' ) . '</p>';
    }
}

add_action('wp_ajax_filter_courses', 'lessonlms_filter_courses');
add_action('wp_ajax_nopriv_filter_courses', 'lessonlms_filter_courses');

function lessonlms_filter_courses(){
    $tax_query = [];
    $meta_query = [];

    if (!empty($_POST['category'])) {
        $tax_query[] = [
            'taxonomy' => 'course_category',
            'field' => 'term_id',
            'terms' => array_map('intval', $_POST['category']),
        ];
    }

    if (!empty($_POST['level'])) {
        $tax_query[] = [
            'taxonomy' => 'course_level',
            'field' => 'term_id',
            'terms' => array_map('intval', $_POST['level']),
        ];
    }

    if (!empty($_POST['language'])) {
        $meta_query[] = [
            'key' => 'language',
            'value' => array_map('sanitize_text_field', $_POST['language']),
            'compare' => 'IN',
        ];
    }

    $args = [
        'post_type' => 'courses',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    ];

    if (!empty($tax_query)) {
        $args['tax_query'] = array_merge(['relation' => 'AND'], $tax_query);
    }

    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/commom/course', 'card');
        endwhile;
    else :
        echo '<h2>Courses Not Found</h2>';
    endif;

    wp_die();
}


function my_ajax_function() {
    if( isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'my_ajax_action') ) :
        // echo 'Test';
          $arg = array(
            // 'post_type' => 'post',
            'post_type' => 'page',
            'post_per_page' => 1,
            'p' => $_POST['page_id_get'],
            // 'post_per_page' => 3,
            'post_status' => 'publish',
            'order' => 'date',
            'orderby' => 'DESC',
          );
    $blog_posts = new WP_Query( $arg );
    if ( $blog_posts->have_posts() ):
                while ( $blog_posts->have_posts() ):
                    $blog_posts->the_post();
                    ?>
                    <li><?php echo esc_html(get_the_content()); ?></li>
                    <?php
                endwhile;
                wp_reset_postdata();
                else : '<p> No post found';
            endif;
    else :
        echo 'error';
    endif;
    wp_die();
}
add_action( 'wp_ajax_my_ajax_action', 'my_ajax_function' );
add_action( 'wp_ajax_nopriv_my_ajax_action', 'my_ajax_function' );

function my_shortcode() {
    ob_start();
    ?>
 <!-- <button data-nonce="<?php echo wp_create_nonce( 'my_ajax_action' )?>" class="my-ajax-trigger">Test</button> -->
 <button data_id="8" data-nonce="<?php echo wp_create_nonce( 'my_ajax_action' )?>" class="my-ajax-trigger">Test</button>
 <ul class="show-data"></ul>
    <script>
    jQuery(document).ready(function($){
    $(".my-ajax-trigger").on("click", function(){
        const $nonce = $(this).data('nonce');
        // const $data = $(this).data('id');
        const $data = $(this).attr('data_id');
        $.ajax({
            url: '<?php echo esc_url( admin_url("admin-ajax.php")); ?>',
            type : 'POST',
            data : {
                action: 'my_ajax_action',
                nonce: $nonce,
                page_id_get : $data,
            },
            beforeSend: function( reponse){
                $(".show-data").empty();
                $(".show-data").append( 'loading.....' );
            },
            success: function( response ){
               $(".show-data").empty();
               $(".show-data").append( response );
            }
        })
    });
});
    </script>
<?php
return ob_get_clean();
}
add_shortcode( 'contact_test', 'my_shortcode' );

function sidebar_menu_ajax_handler() {

    check_ajax_referer(
        'sidebar_menu_ajax_action',
        'nonce'
    );

    if ( empty($_POST['tab']) ) {
        wp_send_json_error('No tab found');
    }

    $tab = sanitize_text_field($_POST['tab']);

    ob_start();

    if ( $tab === 'dashboard' ) {
        get_template_part('template-parts/student-dashboard/student', 'dashboard');
    }

    if ( $tab === 'profile' ) {
        get_template_part('template-parts/student-dashboard/student', 'profile');
    }

    if ( $tab === 'enrollments' ) {
        get_template_part('template-parts/student-dashboard/student', 'enrollemts');
    }

    wp_send_json_success( ob_get_clean() );
}
add_action( 'wp_ajax_sidebar_menu_ajax_action', 'sidebar_menu_ajax_handler' );

// Reset Password Function
function lessonlms_reset_password_link_action() {

    check_ajax_referer( 'lessonlms_reset_password_nonce', 'security' );

    $user_login = sanitize_text_field( $_POST['user_login'] ?? '' );
     $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

    if ( ! $user_login ) {
        wp_send_json_error( [
            'message' => 'User name / Email is required.',
        ] );
    }

    if ( empty( $recaptcha_response ) ) {
        wp_send_json_error([
            'message' => 'Please verify reCAPTCHA.',
        ]);
    }

    $user = get_user_by( 'login', $user_login ) ?? get_user_by( 'email', $user_login );

    if ( ! $user ) {
        wp_send_json_error( [
            'message' => 'User not found with this username or email.',
        ] );
    }

    $key = get_password_reset_key( $user );
    wp_schedule_single_event(
        time(),
        'lessonlms_send_reset_password_email',
        array( $user->ID, $key )
    );
    wp_send_json_success( array(
        'message'      => 'If the account exists, a password reset link will be sent shortly. Please check your email',
     ) );
}

add_action( 'wp_ajax_lessonlms_reset_password_link_action', 'lessonlms_reset_password_link_action' );
add_action( 'wp_ajax_nopriv_lessonlms_reset_password_link_action', 'lessonlms_reset_password_link_action' );

function lessonlms_send_reset_password_email_callback( $user_id, $key ) {

    $user = get_user_by( 'ID', $user_id );
    if ( ! $user ) {
        return;
    }

    $reset_link = network_site_url(
        'wp-login.php?action=rp&key=' . $key . '&login=' . rawurlencode( $user->user_login ),
        'login'
    );

    $message  = "Hello {$user->user_login},\n\n";
    $message .= "You requested a password reset.\n";
    $message .= "Click the link below to set your new password:\n\n";
    $message .= $reset_link . "\n\n";
    $message .= "If you did not request this, please ignore this email.";

    wp_mail(
        $user->user_email,
        'Password Reset Request',
        $message,
        [ 'Content-Type: text/plain; charset=UTF-8' ]
    );
}
add_action( 'lessonlms_send_reset_password_email', 'lessonlms_send_reset_password_email_callback', 10, 2 );


add_filter( 'send_password_change_email', '__return_false' );
add_filter( 'send_email_change_email', '__return_false' );

// Disable default registration email
add_filter( 'wp_new_user_notification_email', '__return_false' );
add_filter( 'wp_new_user_notification_email_admin', '__return_false' );

function lessonlms_custom_register_fields() {
    ?>
    <div class="custom-register-wrap">
        <p>
            <label for="user_password">
                 <?php echo esc_html__('Password', 'lessonlms') ?><br>
                <input type="password" name="user_password" id="user_password" class="input" value="" size="20" autocapitalize="off" autocomplete="user_password">
            </label>
        </p>

        <p>
            <label for="user_confirm_password">
                <?php echo esc_html__('Confirm Password', 'lessonlms') ?>
                <br>
                <input type="password" id="user_confirm_password" autocomplete="off" autocapitalize="off" name="user_confirm_password">
            </label>
        </p>
    </div>
    <?php
}
add_action('register_form', 'lessonlms_custom_register_fields');

// Registration Function 
function lessonlms_custom_register_validation_action() {

    // Verify nonce first
    check_ajax_referer( 'lessonlms_custom_register_nonce', 'security' );

    // Sanitize form inputs
    $user_name       = sanitize_text_field( $_POST['user_login'] ?? '' );
    $user_email      = sanitize_email( $_POST['user_email'] ?? '' );
    $user_pass       = $_POST['user_password'] ?? '';
    $user_confi_pass = $_POST['user_confirm_password'] ?? '';
    // $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

    // Validation
    if ( ! $user_name ) {
        wp_send_json_error([ 'message' => 'User name field is required.' ]);
    }
    if ( ! $user_email ) {
        wp_send_json_error([ 'message' => 'User email field is required.' ]);
    }
    if ( ! $user_pass ) {
        wp_send_json_error([ 'message' => 'Password field is required.' ]);
    }
    if ( $user_pass !== $user_confi_pass ) {
        wp_send_json_error([ 'message' => 'Passwords do not match.' ]);
    }

    //   if ( empty( $recaptcha_response ) ) {
    //     wp_send_json_error([
    //         'message' => 'Please verify reCAPTCHA.',
    //     ]);
    // }

    // Check if username or email exists
    if ( username_exists( $user_name ) ) {
        wp_send_json_error([ 'message' => 'Username already exists.' ]);
    }
    if ( email_exists( $user_email ) ) {
        wp_send_json_error([ 'message' => 'Email already exists.' ]);
    }

    // Create user
    $user_id = wp_create_user( $user_name, $user_pass, $user_email );
    if ( is_wp_error( $user_id ) ) {
        wp_send_json_error([ 'message' => $user_id->get_error_message() ]);
    }

    // Mark unverified and generate OTP
    update_user_meta( $user_id, 'lessonlms_otp_verified', 0 );
    lessonlms_generate_otp_send_otp( $user_id );

    // SET USER ID IN SESSION - FIXED
    lessonlms_set_otp_user_session( $user_id );

    // Return JSON success
    wp_send_json_success([
        'message'      => 'OTP sent successfully.',
        'user_id'      => $user_id,
        'redirect_url' => home_url('/verify-otp/?user_id=' . $user_id),
    ]);
}
add_action( 'wp_ajax_lessonlms_custom_register_validation_action', 'lessonlms_custom_register_validation_action' );
add_action( 'wp_ajax_nopriv_lessonlms_custom_register_validation_action', 'lessonlms_custom_register_validation_action' );

/**
 *  Generate OTP & send custom email
 */
function lessonlms_generate_otp_send_otp( $user_id ) {
    // Generate random 4-digit OTP
    $generate_otp = rand( 1000, 9999 );
    update_user_meta( $user_id, 'store_user_otp', $generate_otp );
    update_user_meta( $user_id, 'store_user_time', time() );

    // Get user data
    $user_data = get_userdata( $user_id );
    if ( ! $user_data ) return;

    // Send custom OTP email
    wp_mail(
        $user_data->user_email,
        'Verify your account',
        "Hello {$user_data->user_login},\n\nYour OTP is: {$generate_otp}\nThis OTP is valid for 5 minutes.",
        [ 'Content-Type: text/plain; charset=UTF-8' ]
    );
}

/**
 * Save user password after registration
 */
function save_custom_register_data( $user_id ) {
    if ( ! empty( $_POST['user_password'] ) ) {
        wp_set_password( $_POST['user_password'], $user_id );
    }
}
add_action( 'user_register', 'save_custom_register_data' );

//delete otp after 5minute expire
function lessonlms_otp_expire_after_five_minute( $user_id ) {
    $get_otp_time = get_user_meta( $user_id, 'store_user_time', true );

    if ( ! $get_otp_time ) {
        return true;
    }

    if ( time() - (int) $get_otp_time > 300 ) {
        delete_user_meta( $user_id, 'store_user_otp' );
        delete_user_meta( $user_id, 'store_user_time' );
        return true;
    }
    return false;
}

// Verify OTP Function
function lessonlms_verify_user_otp( $user_id = null, $input_otp = null ) {

    if ( ! $user_id ) {
        $user_id = intval( $_POST['user_id'] ?? 0 );
    }

    if ( ! $input_otp ) {
        $input_otp = sanitize_text_field( $_POST['otp'] ?? '');
    }

    // First check if OTP is expired
    if ( lessonlms_otp_expire_after_five_minute( $user_id ) ) {
        return new WP_Error( 'otp_expired', 'OTP expired. Please resend OTP.' );
    }

    $stored_otp  = get_user_meta( $user_id, 'store_user_otp', true );
    $stored_time = get_user_meta( $user_id, 'store_user_time', true );

    if ( ! $stored_otp || ! $stored_time ) {
        return new WP_Error( 'otp_missing', 'OTP not found. Please resend OTP.' );
    }

    if ( (string) $stored_otp !== (string) $input_otp ) {
        return new WP_Error('otp_invalid', 'Invalid OTP.');
    }

    // SUCCESS
    update_user_meta( $user_id, 'lessonlms_otp_verified', 1 );
    delete_user_meta( $user_id, 'store_user_otp' );
    delete_user_meta( $user_id, 'store_user_time' );
    
    // Clear session after verification
    lessonlms_clear_otp_user_session();
    
    // Auto login user after verification
    if ( ! is_user_logged_in() ) {
        $user = get_user_by( 'ID', $user_id );
        if ( $user ) {
            wp_clear_auth_cookie();
            wp_set_current_user( $user_id );
            wp_set_auth_cookie( $user_id );
        }
    }
    
    return true;
}

/**
 * AJAX: Resend OTP
 */
function lessonlms_resend_otp() {

    check_ajax_referer('lessonlms_otp_nonce', 'security');
    
    // Get user_id from POST or session
    $user_id = intval( $_POST['user_id'] ?? 0 );
    
    if ( ! $user_id ) {
        $user_id = lessonlms_get_otp_user_id();
    }
    
    if ( ! $user_id || $user_id <= 0 ) {
        wp_send_json_error( array(
            'message' => 'User ID not found. Please try again.',
        ) );
    }
    
    lessonlms_generate_otp_send_otp( $user_id );
    
    // Update session
    lessonlms_set_otp_user_session( $user_id );
    
    wp_send_json_success([
        'message' => 'OTP resent successfully', 
        'expires_in' => 300,
        'user_id' => $user_id,
    ]);
}
add_action('wp_ajax_lessonlms_resend_otp', 'lessonlms_resend_otp');
add_action('wp_ajax_nopriv_lessonlms_resend_otp', 'lessonlms_resend_otp');

/**
 * AJAX: Verify OTP
 */
function lessonlms_verify_otp_ajax() {

    check_ajax_referer('lessonlms_otp_nonce', 'security');
    
    // Get user_id from POST or session
    $user_id = intval( $_POST['user_id'] ?? 0 );
    
    if ( ! $user_id ) {
        $user_id = lessonlms_get_otp_user_id();
    }
    
    $input_otp = sanitize_text_field( $_POST['otp'] ?? '' );

    if ( ! $user_id || $user_id <= 0 ) {
        wp_send_json_error( array(
            'message' => 'User ID not found. Please try again.',
        ) );
    }
    
    if ( ! $input_otp ) {
        wp_send_json_error( array(
            'message' => 'OTP field required',
        ) );
    }

    $verify = lessonlms_verify_user_otp( $user_id, $input_otp );

    if ( is_wp_error( $verify ) ) {
        wp_send_json_error( array(
            'message' => $verify->get_error_message()
        ) );
    }

    wp_send_json_success([
        'message' => 'OTP verified successfully',
        'redirect_url' => home_url('/student-dashboard/')
    ]);
}
add_action('wp_ajax_lessonlms_verify_otp', 'lessonlms_verify_otp_ajax');
add_action('wp_ajax_nopriv_lessonlms_verify_otp', 'lessonlms_verify_otp_ajax');

function lessonlms_enroll_in_course_nopriv() {
    wp_send_json_error(['message' => 'Please login to enroll in courses.']);
}

// Initialize user progress
function lessonlms_initialize_user_progress($user_id, $course_id) {
    global $wpdb;
    
    $modules_table = $wpdb->prefix . 'lessonlms_course_modules';
    $content_table = $wpdb->prefix . 'lessonlms_course_content';
    $progress_table = $wpdb->prefix . 'lessonlms_user_progress';
    
    // Get all content for this course
    $contents = $wpdb->get_results($wpdb->prepare(
        "SELECT c.content_id FROM $content_table c
         JOIN $modules_table m ON c.module_id = m.module_id
         WHERE m.course_id = %d",
        $course_id
    ));
    
    foreach ($contents as $content) {
        // Check if progress already exists
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $progress_table 
             WHERE user_id = %d AND content_id = %d",
            $user_id, $content->content_id
        ));
        
        if (!$exists) {
            $wpdb->insert($progress_table, array(
                'user_id' => $user_id,
                'content_id' => $content->content_id,
                'progress_status' => 'not_started',
                'started_at' => null,
                'completed_at' => null
            ));
        }
    }
}

// Track video progress
function lessonlms_track_video_progress() {
    check_ajax_referer('lessonlms_progress_nonce', 'security');
    
    $user_id = get_current_user_id();
    $content_id = intval($_POST['content_id']);
    $percentage = intval($_POST['percentage']);
    $current_time = intval($_POST['current_time']); // in seconds
    
    if (!$user_id) {
        wp_send_json_error(['message' => 'User not logged in']);
    }
    
    global $wpdb;
    $progress_table = $wpdb->prefix . 'lessonlms_user_progress';
    
    // Get current progress
    $progress = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $progress_table WHERE user_id = %d AND content_id = %d",
        $user_id, $content_id
    ));
    
    if (!$progress) {
        wp_send_json_error(['message' => 'Progress record not found']);
    }
    
    $update_data = array(
        'video_watched_percentage' => $percentage,
        'video_last_position' => $current_time,
        'updated_at' => current_time('mysql')
    );
    
    // Mark as in progress if not started
    if ($progress->progress_status === 'not_started') {
        $update_data['progress_status'] = 'in_progress';
        $update_data['started_at'] = current_time('mysql');
    }
    
    // Mark as completed if watched 90% or more
    if ($percentage >= 90 && $progress->progress_status !== 'completed') {
        $update_data['progress_status'] = 'completed';
        $update_data['completed_at'] = current_time('mysql');
    }
    
    $wpdb->update(
        $progress_table,
        $update_data,
        array('user_id' => $user_id, 'content_id' => $content_id)
    );
    
    // Update overall course progress
    $course_progress = lessonlms_calculate_course_progress($user_id, $content_id);
    
    wp_send_json_success([
        'message' => 'Progress updated',
        'course_progress' => $course_progress
    ]);
}
add_action('wp_ajax_lessonlms_track_video_progress', 'lessonlms_track_video_progress');


// Calculate course progress percentage
function lessonlms_calculate_course_progress($user_id, $content_id = null) {
    global $wpdb;
    
    $content_table = $wpdb->prefix . 'lessonlms_course_content';
    $modules_table = $wpdb->prefix . 'lessonlms_course_modules';
    $progress_table = $wpdb->prefix . 'lessonlms_user_progress';
    $enrollments_table = $wpdb->prefix . 'lessonlms_user_enrollments';
    
    // If content_id provided, get course_id from it
    if ($content_id) {
        $course_id = $wpdb->get_var($wpdb->prepare(
            "SELECT m.course_id FROM $modules_table m
             JOIN $content_table c ON m.module_id = c.module_id
             WHERE c.content_id = %d",
            $content_id
        ));
    } else {
        // Get from enrollment
        $course_id = $wpdb->get_var($wpdb->prepare(
            "SELECT course_id FROM $enrollments_table 
             WHERE user_id = %d AND enrollment_status = 'active'",
            $user_id
        ));
    }
    
    if (!$course_id) {
        return 0;
    }
    
    // Get all content for this course
    $all_content = $wpdb->get_results($wpdb->prepare(
        "SELECT c.content_id, c.required_for_completion, c.points 
         FROM $content_table c
         JOIN $modules_table m ON c.module_id = m.module_id
         WHERE m.course_id = %d",
        $course_id
    ));
    
    $total_content = count($all_content);
    $completed_content = 0;
    $total_points = 0;
    $earned_points = 0;
    
    foreach ($all_content as $content) {
        $total_points += $content->points;
        
        $progress = $wpdb->get_row($wpdb->prepare(
            "SELECT progress_status, mcq_score, mcq_total, assignment_score 
             FROM $progress_table 
             WHERE user_id = %d AND content_id = %d",
            $user_id, $content->content_id
        ));
        
        if ($progress) {
            // Check if content is completed
            $is_completed = false;
            
            if ($progress->progress_status === 'completed') {
                $is_completed = true;
            } elseif ($progress->progress_status === 'graded' && $progress->assignment_score >= 70) {
                $is_completed = true;
            } elseif ($progress->mcq_total > 0 && $progress->mcq_score >= ($progress->mcq_total * 0.7)) {
                $is_completed = true;
            }
            
            if ($is_completed) {
                $completed_content++;
                $earned_points += $content->points;
            }
        }
    }
    
    // Calculate percentages
    $progress_percentage = $total_content > 0 ? ($completed_content / $total_content) * 100 : 0;
    $points_percentage = $total_points > 0 ? ($earned_points / $total_points) * 100 : 0;
    
    // Overall progress (weighted average)
    $overall_progress = ($progress_percentage * 0.7) + ($points_percentage * 0.3);
    
    return array(
        'percentage' => round($overall_progress, 1),
        'completed_content' => $completed_content,
        'total_content' => $total_content,
        'earned_points' => $earned_points,
        'total_points' => $total_points,
        'progress_percentage' => round($progress_percentage, 1),
        'points_percentage' => round($points_percentage, 1)
    );
}

// Get user progress data
function lessonlms_get_user_progress() {
    check_ajax_referer('lessonlms_progress_nonce', 'security');
    
    $user_id = get_current_user_id();
    $course_id = intval($_POST['course_id']);
    
    if (!$user_id) {
        wp_send_json_error(['message' => 'User not logged in']);
    }
    
    $progress = lessonlms_calculate_course_progress($user_id, null, $course_id);
    
    wp_send_json_success($progress);
}
add_action('wp_ajax_lessonlms_get_user_progress', 'lessonlms_get_user_progress');

// Course learning page template
function lessonlms_course_learning_page() {
    if (!is_user_logged_in()) {
        wp_redirect(home_url('/login/'));
        exit;
    }
    
    $course_id = get_the_ID();
    $user_id = get_current_user_id();
    
    // Check if user is enrolled
    global $wpdb;
    $enrollments_table = $wpdb->prefix . 'lessonlms_user_enrollments';
    
    $is_enrolled = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $enrollments_table 
         WHERE user_id = %d AND course_id = %d AND enrollment_status = 'active'",
        $user_id, $course_id
    ));
    
    if (!$is_enrolled) {
        wp_redirect(get_permalink($course_id));
        exit;
    }
    
    // Get course content structure
    $modules = $wpdb->get_results($wpdb->prepare(
        "SELECT m.*, 
                (SELECT COUNT(*) FROM {$wpdb->prefix}lessonlms_course_content 
                 WHERE module_id = m.module_id) as content_count
         FROM {$wpdb->prefix}lessonlms_course_modules m
         WHERE m.course_id = %d
         ORDER BY m.module_order ASC",
        $course_id
    ));
    
    // Get first content item
    $first_content = null;
    if ($modules) {
        $first_content = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}lessonlms_course_content 
             WHERE module_id = %d 
             ORDER BY content_order ASC LIMIT 1",
            $modules[0]->module_id
        ));
    }
    ?>
    <div class="lessonlms-course-learning-wrapper">
        <div class="course-header">
            <h1><?php the_title(); ?></h1>
            <div class="course-progress-bar">
                <div class="progress-info">
                    <span class="progress-text">Your Progress:</span>
                    <span class="progress-percentage">0%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 0%"></div>
                </div>
            </div>
        </div>
        
        <div class="course-learning-container">
            <div class="course-sidebar">
                <div class="course-modules">
                    <?php foreach ($modules as $module): ?>
                        <div class="module-section" data-module-id="<?php echo $module->module_id; ?>">
                            <h3 class="module-title">
                                <?php echo esc_html($module->module_title); ?>
                                <span class="module-content-count">(<?php echo $module->content_count; ?> items)</span>
                            </h3>
                            <div class="module-content-list">
                                <?php 
                                $contents = $wpdb->get_results($wpdb->prepare(
                                    "SELECT c.*, p.progress_status, p.completed_at 
                                     FROM {$wpdb->prefix}lessonlms_course_content c
                                     LEFT JOIN {$wpdb->prefix}lessonlms_user_progress p 
                                     ON c.content_id = p.content_id AND p.user_id = %d
                                     WHERE c.module_id = %d
                                     ORDER BY c.content_order ASC",
                                    $user_id, $module->module_id
                                ));
                                
                                foreach ($contents as $content): 
                                    $status_class = '';
                                    if ($content->progress_status === 'completed') {
                                        $status_class = 'completed';
                                    } elseif ($content->progress_status === 'in_progress') {
                                        $status_class = 'in-progress';
                                    }
                                ?>
                                    <div class="content-item <?php echo $status_class; ?>" 
                                         data-content-id="<?php echo $content->content_id; ?>"
                                         data-content-type="<?php echo $content->content_type; ?>">
                                        <div class="content-icon">
                                            <?php switch($content->content_type): 
                                                case 'video': ?>
                                                    <i class="dashicons dashicons-video-alt3"></i>
                                                    <?php break; 
                                                case 'assignment': ?>
                                                    <i class="dashicons dashicons-clipboard"></i>
                                                    <?php break; 
                                                case 'mcq': ?>
                                                    <i class="dashicons dashicons-testimonial"></i>
                                                    <?php break; 
                                                default: ?>
                                                    <i class="dashicons dashicons-media-document"></i>
                                            <?php endswitch; ?>
                                        </div>
                                        <div class="content-details">
                                            <h4><?php echo esc_html($content->content_title); ?></h4>
                                            <div class="content-meta">
                                                <?php if ($content->content_type === 'video' && $content->video_duration): ?>
                                                    <span class="duration"><?php echo gmdate("H:i:s", $content->video_duration); ?></span>
                                                <?php endif; ?>
                                                <?php if ($content->points): ?>
                                                    <span class="points"><?php echo $content->points; ?> points</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="content-status">
                                            <?php if ($content->progress_status === 'completed'): ?>
                                                <i class="dashicons dashicons-yes-alt"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="course-content-area">
                <div id="content-player">
                    <?php if ($first_content): ?>
                        <?php lessonlms_render_content($first_content, $user_id); ?>
                    <?php else: ?>
                        <div class="no-content">
                            <p>No content available for this course yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="course-navigation">
                    <button id="prev-content" class="button">Previous</button>
                    <button id="next-content" class="button button-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Global variables
        var currentContentId = <?php echo $first_content ? $first_content->content_id : 0; ?>;
        var videoPlayer = null;
        
        // Load content on click
        $('.content-item').on('click', function() {
            var contentId = $(this).data('content-id');
            loadContent(contentId);
        });
        
        // Load content function
        function loadContent(contentId) {
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'lessonlms_load_content',
                    content_id: contentId,
                    security: '<?php echo wp_create_nonce('lessonlms_content_nonce'); ?>'
                },
                beforeSend: function() {
                    $('#content-player').addClass('loading');
                },
                success: function(response) {
                    if (response.success) {
                        $('#content-player').html(response.data.content);
                        currentContentId = contentId;
                        
                        // Update active state
                        $('.content-item').removeClass('active');
                        $('.content-item[data-content-id="' + contentId + '"]').addClass('active');
                        
                        // Initialize content type specific features
                        initContentFeatures();
                        
                        // Update progress
                        updateProgress();
                    } else {
                        alert(response.data.message);
                    }
                },
                complete: function() {
                    $('#content-player').removeClass('loading');
                }
            });
        }
        
        // Initialize video player tracking
        function initVideoTracking() {
            var video = document.getElementById('course-video');
            if (video) {
                // Track every 10 seconds
                var trackInterval = setInterval(function() {
                    if (!video.paused) {
                        var percentage = (video.currentTime / video.duration) * 100;
                        
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            data: {
                                action: 'lessonlms_track_video_progress',
                                content_id: currentContentId,
                                percentage: Math.round(percentage),
                                current_time: Math.round(video.currentTime),
                                security: '<?php echo wp_create_nonce('lessonlms_progress_nonce'); ?>'
                            }
                        });
                    }
                }, 10000);
                
                // Track on pause as well
                video.addEventListener('pause', function() {
                    var percentage = (video.currentTime / video.duration) * 100;
                    
                    $.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {
                            action: 'lessonlms_track_video_progress',
                            content_id: currentContentId,
                            percentage: Math.round(percentage),
                            current_time: Math.round(video.currentTime),
                            security: '<?php echo wp_create_nonce('lessonlms_progress_nonce'); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                updateProgressBar(response.data.course_progress);
                            }
                        }
                    });
                });
                
                // Store interval for cleanup
                video.trackInterval = trackInterval;
            }
        }
        
        // Initialize MCQ quiz
        function initMCQQuiz() {
            $('.mcq-form').on('submit', function(e) {
                e.preventDefault();
                
                var answers = {};
                $(this).find('input[type="radio"]:checked').each(function() {
                    var question = $(this).data('question');
                    var answer = $(this).val();
                    answers[question] = answer;
                });
                
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'lessonlms_submit_mcq',
                        content_id: currentContentId,
                        answers: JSON.stringify(answers),
                        security: '<?php echo wp_create_nonce('lessonlms_progress_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            var resultHtml = '<div class="quiz-result">';
                            resultHtml += '<h3>Quiz Result: ' + response.data.percentage.toFixed(1) + '%</h3>';
                            resultHtml += '<p>Score: ' + response.data.score + '/' + response.data.total + '</p>';
                            resultHtml += '<p class="' + (response.data.passed ? 'passed' : 'failed') + '">';
                            resultHtml += response.data.message + '</p>';
                            resultHtml += '</div>';
                            
                            $('.mcq-form').replaceWith(resultHtml);
                            
                            // Update progress
                            updateProgress();
                        }
                    }
                });
            });
        }
        
        // Initialize assignment submission
        function initAssignmentSubmission() {
            $('#assignment-form').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);
                formData.append('action', 'lessonlms_submit_assignment');
                formData.append('content_id', currentContentId);
                formData.append('security', '<?php echo wp_create_nonce('lessonlms_progress_nonce'); ?>');
                
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert(response.data.message);
                            updateProgress();
                        }
                    }
                });
            });
        }
        
        // Initialize content features based on type
        function initContentFeatures() {
            // Clean up previous video tracking
            var video = document.getElementById('course-video');
            if (video && video.trackInterval) {
                clearInterval(video.trackInterval);
            }
            
            // Initialize based on content type
            var contentType = $('.content-item.active').data('content-type');
            
            switch(contentType) {
                case 'video':
                    initVideoTracking();
                    break;
                case 'mcq':
                    initMCQQuiz();
                    break;
                case 'assignment':
                    initAssignmentSubmission();
                    break;
            }
        }
        
        // Update progress bar
        function updateProgress() {
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'lessonlms_get_user_progress',
                    course_id: <?php echo $course_id; ?>,
                    security: '<?php echo wp_create_nonce('lessonlms_progress_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        updateProgressBar(response.data);
                    }
                }
            });
        }
        
        function updateProgressBar(progressData) {
            var percentage = progressData.percentage;
            $('.progress-percentage').text(percentage + '%');
            $('.progress-fill').css('width', percentage + '%');
            
            // Update completion badges
            $('.content-item.completed .content-status i').remove();
            $('.content-item.completed .content-status').append('<i class="dashicons dashicons-yes-alt"></i>');
        }
        
        // Navigation
        $('#next-content').on('click', function() {
            var nextItem = $('.content-item.active').next('.content-item');
            if (nextItem.length) {
                loadContent(nextItem.data('content-id'));
            }
        });
        
        $('#prev-content').on('click', function() {
            var prevItem = $('.content-item.active').prev('.content-item');
            if (prevItem.length) {
                loadContent(prevItem.data('content-id'));
            }
        });
        
        // Initialize on page load
        if (currentContentId) {
            $('.content-item[data-content-id="' + currentContentId + '"]').addClass('active');
            initContentFeatures();
            updateProgress();
        }
    });
    </script>
    
    <style>
    .lessonlms-course-learning-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .course-header {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .course-progress-bar {
        margin-top: 15px;
    }
    
    .progress-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    
    .progress-bar {
        height: 10px;
        background: #f0f0f0;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #4CAF50, #8BC34A);
        transition: width 0.5s ease;
    }
    
    .course-learning-container {
        display: flex;
        gap: 20px;
    }
    
    .course-sidebar {
        width: 300px;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .course-content-area {
        flex: 1;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .module-section {
        margin-bottom: 20px;
    }
    
    .module-title {
        font-size: 16px;
        margin: 0 0 10px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .content-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    
    .content-item:hover {
        background: #f5f5f5;
    }
    
    .content-item.active {
        background: #e8f4fd;
        border-left: 4px solid #2196F3;
    }
    
    .content-item.completed {
        background: #f0f9f0;
    }
    
    .content-icon {
        margin-right: 12px;
        color: #666;
    }
    
    .content-details {
        flex: 1;
    }
    
    .content-details h4 {
        margin: 0 0 4px 0;
        font-size: 14px;
    }
    
    .content-meta {
        font-size: 12px;
        color: #888;
    }
    
    .content-status {
        color: #4CAF50;
    }
    
    #content-player {
        min-height: 400px;
    }
    
    .course-navigation {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .video-wrapper {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        height: 0;
    }
    
    .video-wrapper iframe,
    .video-wrapper video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .assignment-form textarea,
    .assignment-form input[type="file"] {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .mcq-question {
        margin-bottom: 20px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 6px;
    }
    
    .mcq-options label {
        display: block;
        margin-bottom: 8px;
        cursor: pointer;
    }
    
    .quiz-result {
        padding: 20px;
        background: #f0f9f0;
        border-radius: 6px;
        text-align: center;
    }
    
    .quiz-result .passed {
        color: #4CAF50;
        font-weight: bold;
    }
    
    .quiz-result .failed {
        color: #f44336;
        font-weight: bold;
    }
    </style>
    <?php
}

// AJAX content loader
function lessonlms_load_content_ajax() {
    check_ajax_referer('lessonlms_content_nonce', 'security');
    
    $content_id = intval($_POST['content_id']);
    $user_id = get_current_user_id();
    
    if (!$content_id || !$user_id) {
        wp_send_json_error(['message' => 'Invalid request']);
    }
    
    global $wpdb;
    $content = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}lessonlms_course_content WHERE content_id = %d",
        $content_id
    ));
    
    if (!$content) {
        wp_send_json_error(['message' => 'Content not found']);
    }
    
    ob_start();
    lessonlms_render_content($content, $user_id);
    $html = ob_get_clean();
    
    wp_send_json_success(['content' => $html]);
}
add_action('wp_ajax_lessonlms_load_content', 'lessonlms_load_content_ajax');

// Render content based on type
function lessonlms_render_content($content, $user_id) {
    global $wpdb;
    $progress_table = $wpdb->prefix . 'lessonlms_user_progress';
    
    $progress = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $progress_table WHERE user_id = %d AND content_id = %d",
        $user_id, $content->content_id
    ));
    ?>
    
    <div class="content-header">
        <h2><?php echo esc_html($content->content_title); ?></h2>
        <?php if ($content->content_description): ?>
            <p class="content-description"><?php echo esc_html($content->content_description); ?></p>
        <?php endif; ?>
    </div>
    
    <div class="content-body">
        <?php switch($content->content_type):
            case 'video': ?>
                <div class="video-wrapper">
                    <?php if (strpos($content->content_url, 'youtube.com') !== false || strpos($content->content_url, 'youtu.be') !== false): ?>
                        <?php 
                        // Extract YouTube ID
                        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $content->content_url, $matches);
                        $youtube_id = $matches[1] ?? '';
                        ?>
                        <iframe 
                            id="course-video"
                            src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>?enablejsapi=1" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    <?php else: ?>
                        <video 
                            id="course-video"
                            controls
                            preload="metadata"
                            style="width: 100%; max-height: 500px;">
                            <source src="<?php echo esc_url($content->content_url); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>
                </div>
                <?php if ($content->video_duration): ?>
                    <p class="video-duration">
                        Duration: <?php echo gmdate("H:i:s", $content->video_duration); ?>
                    </p>
                <?php endif; ?>
                <?php break;
            
            case 'assignment': ?>
                <div class="assignment-content">
                    <?php if ($content->content_description): ?>
                        <div class="assignment-instructions">
                            <h3>Assignment Instructions:</h3>
                            <p><?php echo wp_kses_post($content->content_description); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($content->assignment_deadline): ?>
                        <div class="assignment-deadline">
                            <strong>Deadline:</strong> <?php echo date('F j, Y', strtotime($content->assignment_deadline)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="assignment-submission">
                        <h3>Submit Your Assignment</h3>
                        
                        <?php if ($progress && $progress->assignment_submission): 
                            $submission = json_decode($progress->assignment_submission, true);
                        ?>
                            <div class="previous-submission">
                                <p><strong>Submitted on:</strong> <?php echo date('F j, Y H:i', strtotime($submission['submitted_at'])); ?></p>
                                <?php if (!empty($submission['text'])): ?>
                                    <p><strong>Your answer:</strong> <?php echo wp_kses_post($submission['text']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($submission['attachments'])): ?>
                                    <p><strong>Attachments:</strong></p>
                                    <ul>
                                        <?php foreach ($submission['attachments'] as $attachment): ?>
                                            <li><a href="<?php echo esc_url($attachment); ?>" target="_blank">Download</a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                
                                <?php if ($progress->assignment_score !== null): ?>
                                    <div class="assignment-grade">
                                        <h4>Grade: <?php echo $progress->assignment_score; ?>%</h4>
                                        <?php if ($progress->assignment_score >= 70): ?>
                                            <p class="passed">Assignment passed!</p>
                                        <?php else: ?>
                                            <p class="failed">Assignment needs improvement.</p>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <p><em>Waiting for instructor review...</em></p>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <form id="assignment-form" class="assignment-form">
                                <div class="form-group">
                                    <label for="assignment-text">Your Answer:</label>
                                    <textarea 
                                        id="assignment-text" 
                                        name="submission" 
                                        rows="10" 
                                        placeholder="Type your assignment here..."
                                        required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="assignment-files">Attach Files (optional):</label>
                                    <input 
                                        type="file" 
                                        id="assignment-files" 
                                        name="attachments[]" 
                                        multiple
                                        accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                                    <p class="description">Maximum file size: 10MB each</p>
                                </div>
                                
                                <button type="submit" class="button button-primary">Submit Assignment</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php break;
            
            case 'mcq': ?>
                <div class="mcq-content">
                    <?php if ($content->content_description): ?>
                        <div class="mcq-instructions">
                            <h3>Quiz Instructions:</h3>
                            <p><?php echo wp_kses_post($content->content_description); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php 
                    $questions = json_decode($content->mcq_questions, true);
                    if ($questions && $progress && $progress->progress_status === 'completed'):
                        $answers = json_decode($progress->mcq_answers, true);
                    ?>
                        <div class="quiz-results">
                            <h3>Quiz Results</h3>
                            <p>Score: <?php echo $progress->mcq_score; ?>/<?php echo $progress->mcq_total; ?></p>
                            <p>Percentage: <?php echo round(($progress->mcq_score / $progress->mcq_total) * 100, 1); ?>%</p>
                            
                            <div class="question-review">
                                <?php foreach ($questions as $index => $question): 
                                    $user_answer = $answers[$index] ?? null;
                                    $is_correct = $user_answer == $question['correct_answer'];
                                ?>
                                    <div class="question-item <?php echo $is_correct ? 'correct' : 'incorrect'; ?>">
                                        <p><strong>Q<?php echo $index + 1; ?>: <?php echo esc_html($question['question']); ?></strong></p>
                                        <p>Your answer: <?php echo esc_html($user_answer ?? 'Not answered'); ?></p>
                                        <?php if (!$is_correct): ?>
                                            <p>Correct answer: <?php echo esc_html($question['correct_answer']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php elseif ($questions): ?>
                        <form class="mcq-form">
                            <?php foreach ($questions as $index => $question): ?>
                                <div class="mcq-question">
                                    <p><strong>Q<?php echo $index + 1; ?>: <?php echo esc_html($question['question']); ?></strong></p>
                                    <div class="mcq-options">
                                        <?php foreach ($question['options'] as $option): ?>
                                            <label>
                                                <input 
                                                    type="radio" 
                                                    name="question_<?php echo $index; ?>" 
                                                    value="<?php echo esc_attr($option); ?>"
                                                    data-question="<?php echo $index; ?>"
                                                    required>
                                                <?php echo esc_html($option); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <button type="submit" class="button button-primary">Submit Quiz</button>
                        </form>
                    <?php else: ?>
                        <p>No quiz questions available.</p>
                    <?php endif; ?>
                </div>
                <?php break;
            
            default: ?>
                <div class="text-content">
                    <?php echo wp_kses_post($content->content_description); ?>
                </div>
        <?php endswitch; ?>
    </div>
    <?php
}

// Add custom page template for course learning
function lessonlms_add_course_learning_template($templates) {
    $templates['course-learning.php'] = 'Course Learning';
    return $templates;
}
add_filter('theme_page_templates', 'lessonlms_add_course_learning_template');

function lessonlms_load_course_learning_template($template) {
    if (get_page_template_slug() === 'course-learning.php') {
        $new_template = plugin_dir_path(__FILE__) . 'course-learning.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'lessonlms_load_course_learning_template');
function lessonlms_enqueue_course_scripts() {
    // Video.js for video player (optional)
    wp_enqueue_style('video-js', 'https://vjs.zencdn.net/7.20.3/video-js.css', array(), '7.20.3');
    wp_enqueue_script('video-js', 'https://vjs.zencdn.net/7.20.3/video.min.js', array(), '7.20.3', true);
    
    // YouTube API
    wp_enqueue_script('youtube-api', 'https://www.youtube.com/iframe_api', array(), null, true);
    
    // Custom scripts
    wp_enqueue_script('lessonlms-course', get_template_directory_uri() . '/js/course.js', array('jquery', 'video-js'), '1.0', true);
    
    wp_localize_script('lessonlms-course', 'lessonlms_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('lessonlms_progress_nonce'),
        'content_nonce' => wp_create_nonce('lessonlms_content_nonce'),
        'user_id' => get_current_user_id(),
        'is_user_logged_in' => is_user_logged_in()
    ));
    
    // Styles
    wp_enqueue_style('lessonlms-course', get_template_directory_uri() . '/css/course.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'lessonlms_enqueue_course_scripts');

require_once THEME_DIR . '/inc/ajax-functions/ajax-function.php';
add_filter( 'woocommerce_is_sold_individually', '__return_true' );


if ( ! function_exists( 'lessonlms_enroll_user_after_payment' ) ) {
    function lessonlms_enroll_user_after_payment( $order_id ) {

        $user_login = is_user_logged_in();
        if ( ! $user_login ) {
            return;
        }

        $order   = wc_get_order( $order_id );
        $user_id = $order->get_user_id();

        if ( ! $user_id ) {
            return;
        }

        $enrollments = get_user_meta( $user_id, '_user_enrollments', true );

        if ( empty( $enrollments ) || ! is_array( $enrollments ) ) {
            $enrollments = [];
        }

        $all_items = $order->get_items();

        if ( ! empty( $all_items ) && is_array( $all_items ) ) {
            foreach ( $all_items as $item ) {

                $product_id = $item->get_product_id();

                $courses = get_posts([
                    'post_type'   => 'courses',
                    'meta_key'    => '_course_product',
                    'meta_value'  => $product_id,
                    'fields'      => 'ids',
                    'numberposts' => 1,
                ]);

                if ( ! empty( $courses ) ) {
                    $course_id = $courses[0]->ID;

                    $already_enrolled = false;
                    foreach ( $enrollments as $enroll ) {
                        if ( intval( $enroll['course_id']) === $course_id ) {
                            $already_enrolled = true;
                            break;
                        }
                    }

                    if ( ! $already_enrolled ) {

                         $current_enroll   = get_post_meta( $course_id, '_enrolled_students', true ) ?: 0;
                        $new_enroll_count = absint( $current_enroll + 1 );
                        update_post_meta( $course_id, '_enrolled_students', $new_enroll_count );

                        $enrollments[] = [
                            'course_id' => $course_id,
                            'order_id'  => $order_id,
                            'date'      => current_time( 'mysql' ),
                        ];
                    }
                }
            }
        }
        update_user_meta( $user_id, '_user_enrollments', $enrollments );
    }
}

add_action( 'woocommerce_payment_complete', 'lessonlms_enroll_user_after_payment' );
add_action( 'woocommerce_order_status_completed', 'lessonlms_enroll_user_after_payment' );