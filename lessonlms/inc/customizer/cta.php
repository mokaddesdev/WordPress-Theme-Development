<?php

/**
 * CTA Settings
 * 
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_cta_customize_register' ) ) {
    function lessonlms_cta_customize_register( $wp_customize ) {

        lessonlms_add_section_setting( $wp_customize, 'lessonlms_cta_section', 'CTA Settings', 105 );

        //   CTA Title
        lessonlms_text_field_customize( $wp_customize, 'cta_title', 'Take the next step toward your personal and professional goals with Lesson.', 'CTA Title', 'lessonlms_cta_section' );

        // cta_description
        lessonlms_textarea_field_customize( $wp_customize, 'cta_description', 'Take the next step toward. Join now to receive personalized and more recommendations from the full Coursera catalog.', 'CTA Description', 'lessonlms_cta_section' );

        // CTA Button Text
        lessonlms_text_field_customize( $wp_customize, 'cta_button_text', 'Join now', 'CTA Button Text', 'lessonlms_cta_section' );

        // CTA Image
        lessonlms_image_customize( $wp_customize, 'cta_image', 'cta-right.png', 'CTA Image', 'lessonlms_cta_section' );

    }
}

add_action( 'customize_register', 'lessonlms_cta_customize_register' );
