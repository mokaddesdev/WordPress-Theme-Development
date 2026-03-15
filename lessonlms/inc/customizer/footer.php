<?php 
/**
 * Footer Setting
 * 
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_footer_customize_register' ) ) {
    function lessonlms_footer_customize_register( $wp_customize ) {

        // Footer Section
        $wp_customize->add_section(
            'footer_settings',
            array(
                'title'     => __( 'Footer Settings', 'lessonlms' ),
                'priority'  => 130,
                )
            );

        lessonlms_image_customize( $wp_customize, 'footer_logo', 'footer-logo.png', 'Footer Logo', 'footer_settings' );

        // Social Media Links
        $socials = array( 'twitter', 'facebook', 'linkedin', 'instagram' );

        foreach ( $socials as $social ) {
            lessonlms_url_field_customize( $wp_customize, "footer_{$social}_link", "https://$social.com", $social, 'footer_settings' );
            }

        lessonlms_textarea_field_customize( $wp_customize, 'footer_about_text', 'Need to help for your dream Career? trust us. With Lesson, study becomes a lot easier with us.', 'About Text', 'footer_settings' );

        // Footer Menu Titles
        lessonlms_text_field_customize( $wp_customize, 'footer_menu1_title', 'Company', 'Footer Menu1 Title', 'footer_settings' );

         lessonlms_text_field_customize( $wp_customize, 'footer_menu2_title', 'Support', 'Footer Menu2 Title', 'footer_settings' );

         lessonlms_text_field_customize( $wp_customize, 'footer_address', 'Address', 'Footer Menu3 Title', 'footer_settings' );

         lessonlms_text_field_customize( $wp_customize, 'footer_location_title', 'Location:', 'Location Title', 'footer_settings' );

         lessonlms_textarea_field_customize( $wp_customize, 'footer_location_description', '27 Division St, New York, NY 10002, USA', 'Location Description', 'footer_settings' );

         lessonlms_text_field_customize( $wp_customize, 'footer_email_title', 'Email:', 'Email Title', 'footer_settings' );

         lessonlms_email_field_customize( $wp_customize, 'footer_email', 'email@gmail.com', 'Footer Email', 'footer_settings');

        lessonlms_text_field_customize( $wp_customize, 'footer_phone_title', 'Phone:', 'Phone Title', 'footer_settings' );

        lessonlms_text_field_customize( $wp_customize, 'footer_phone_description', '+ 000 1234 567 890', 'Phone Description', 'footer_settings' );
    }
}

add_action( 'customize_register', 'lessonlms_footer_customize_register' );