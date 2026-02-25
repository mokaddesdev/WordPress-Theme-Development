<?php 
/**
 * Template Name: WP Custom User Register page
 * 
 * @package lesonlms
 */

if ( ! defined("ABSPATH")){
   exit;
}

// Create a Shortcode

add_shortcode( 'create-custom-register-page', 'wpcur__registeration_handler' );

function wpcur__registeration_handler(){
    ob_start();
    lessonlms_wpcur_validate_form_submit();
   lessonlms_wpcur_custom_registeration_page();
    return ob_get_clean();

}

function lessonlms_wpcur_custom_registeration_page(){
    ?>
<form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" method="post">
    <p>
        <label for="first_name"> First Name: </label>
        <input type="text" name="first_name" id="first_name" placeholder="First Name">
    </p>

    <p>
        <label for="last_name"> First Name: </label>
        <input type="text" name="last_name" id="last_name" placeholder="Last Name">
    </p>

    <p>
        <label for="email"> Email: </label>
        <input type="email" name="email" id="email" placeholder="Email">
    </p>

    <p>
        <label for="password">
            Password:
        </label>
        <input type="password" name="password" id="password" placeholder="password">
    </p>

    <p>
        <label for="confirm_password">
            Confirm Password:
        </label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
    </p>

    <p>
        <button name="btn_user_register_page" type="submit">
            Submit
        </button>
    </p>
</form>

<?php
}

function lessonlms_wpcur_validate_form_submit(){
  if( isset($_POST['btn_user_register_page'])){
       $errorobject = new WP_Error();

       $first_name = sanitize_text_field($_POST['first_name']);
       $last_name = sanitize_text_field($_POST['last_name']);
       $email     = sanitize_email($_POST['email']);
       $password  = sanitize_text_field($_POST['password']);
       $confirm_password = sanitize_text_field($_POST['confirm_password']);

    //    print_r($_POST); die;

       if( !isset($first_name) || empty($first_name)){
        $errorobject->add('first_name_error', 'First Name is required');
       }

        if( !isset($last_name) || empty($last_name)){
        $errorobject->add('last_name_error', 'Last Name is required');
       }

        if( !isset($email) || empty($email)){
        $errorobject->add('email_error', 'Email is required');
       }

         if( email_exists($email) ){
        $errorobject->add('email_exits_error', 'Email already taken');
       }

        if( !isset($password) || empty($password)){
        $errorobject->add('password_error', 'Password is required');
       }

        if( !isset($confirm_password) || empty($confirm_password)){
        $errorobject->add('confirm_password_error', 'Confirm Password is required');
       }

       if(!empty($password) && !empty($confirm_password) && $password !== $confirm_password){
        $errorobject->add('password_mismatched_error', 'Password is mismatched. Please retype password');
       }


        // Display error messages
        $error_messages = $errorobject->get_error_messages();

        if ( ! empty( $error_messages ) ) {
            echo '<div class="form-error-wrapper">';
            
            foreach ( $error_messages as $single_error ) {
                echo '<p class="form-error-message">' . esc_html( $single_error ) . '</p>';
            }

            echo '</div>';
        }else{
            lessonlms_add_user_in_site( $first_name, $last_name, $email, $password,$confirm_password );
        }

       
       
  }
}

function  lessonlms_add_user_in_site( $first_name, $last_name, $email, $password,$confirm_password ){
     $userdata = [
        'first_name' => $first_name,
        'last_name'  => $last_name,
        'user_login' => $email,
        'user_email' => $email,
        'user_pass'  => $password,
    ];

    $user_id = wp_insert_user($userdata);

    if( !is_wp_error($user_id)){
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        wp_redirect(home_url());

        exit;

    }else{
        echo " Failed to user register.";
    }
}
?>