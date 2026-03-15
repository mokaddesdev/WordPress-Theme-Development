<?php
/**
 * Features Customizer
 *
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_features_customize_register' ) ) {

    function lessonlms_features_customize_register( $wp_customize ) {

        lessonlms_add_section_setting( $wp_customize, 'features_section', 'Features Settings', 100 );

        lessonlms_text_field_customize( $wp_customize, 'features_title', 'Learner outcomes through our awesome platform', 'Features Title', 'features_section' );

        // Features Description One
        lessonlms_textarea_field_customize( $wp_customize, 'features_description_one', '87% of people learning for professional development report career benefits like getting a promotion, a raise, or starting a new career.', 'Features Description One', 'features_section' );

        lessonlms_textarea_field_customize( $wp_customize, 'features_description_two', 'Lesson Impact Report (2022)', 'Features Description Two', 'features_section' );

        lessonlms_text_field_customize( $wp_customize, 'features_button_text', 'Sign Up', 'Features Button Text', 'features_section' );

        // Features Image One
        lessonlms_image_customize( $wp_customize, 'features_image_one', 'feature1.png', 'Features Image One', 'features_section' );

        // Features Image Two
        lessonlms_image_customize( $wp_customize, 'features_image_two', 'feature2.png', 'Features Image Two', 'features_section' );
    }
}

add_action( 'customize_register', 'lessonlms_features_customize_register' );