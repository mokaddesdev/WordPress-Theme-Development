<?php
/**
 * Template Name: Verify OTP
 * 
 * @package lessonlms
 */

get_header();

// Get user ID from session
$user_id = lessonlms_get_otp_user_id();

// Check if user ID exists
if (!$user_id || $user_id <= 0) {
    echo '<div class="container"><div class="alert alert-danger">User session expired. Please try again.</div></div>';
    get_footer();
    return;
}

// Get user info
$user = get_user_by('ID', $user_id);
if (!$user) {
    echo '<div class="container"><div class="alert alert-danger">User not found.</div></div>';
    get_footer();
    return;
}

// Check if already verified
$verified = get_user_meta($user_id, 'lessonlms_otp_verified', true);
if ($verified == 1) {
    wp_redirect(home_url('/student-dashboard/'));
    exit;
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Verify OTP</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        We have sent an OTP to <strong><?php echo esc_html($user->user_email); ?></strong><br>
                        Please enter the 4-digit OTP to verify your account.
                    </p>
                    
                    <div class="otp-container text-center">
                        <h5>Enter OTP</h5>
                        <div id="otp-box-list-id" class="otp-box-list mb-4">
                            <input type="text" class="otp-box form-control text-center" maxlength="1" style="width: 60px; height: 60px; font-size: 24px; display: inline-block; margin: 0 5px;" />
                            <input type="text" class="otp-box form-control text-center" maxlength="1" style="width: 60px; height: 60px; font-size: 24px; display: inline-block; margin: 0 5px;" />
                            <input type="text" class="otp-box form-control text-center" maxlength="1" style="width: 60px; height: 60px; font-size: 24px; display: inline-block; margin: 0 5px;" />
                            <input type="text" class="otp-box form-control text-center" maxlength="1" style="width: 60px; height: 60px; font-size: 24px; display: inline-block; margin: 0 5px;" />
                        </div>
                        
                        <div class="mb-3">
                            <button id="send-otp-btn" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-paper-plane"></i> Send OTP
                            </button>
                            <button id="verify-otp-btn" class="btn btn-success btn-lg" style="display:none;">
                                <i class="fas fa-check"></i> Verify OTP
                            </button>
                        </div>
                        
                        <div id="otp-expires-id" class="text-danger mb-3" style="font-size: 14px;"></div>
                        
                        <div id="otp-message" class="alert" style="display:none;"></div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="text-muted">
                            Didn't receive OTP? <a href="#" id="resend-otp-link">Click to resend</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden field to store user ID -->
<input type="hidden" id="lessonlms-user-id" value="<?php echo esc_attr($user_id); ?>">

<?php get_footer(); ?>