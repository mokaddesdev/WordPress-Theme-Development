<?php
/**
 * Hero section setting
 * 
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_hero_customize_register' ) ) {
    function lessonlms_hero_customize_register( $wp_customize ) {

    lessonlms_add_section_setting( $wp_customize, '_hero_section', 'Hero Settings', 'Hero Section Title', 70 );

    lessonlms_image_customize( $wp_customize, 'hero_image', 'heor-img.png', 'Hero Image', '_hero_section' );

    lessonlms_text_field_customize( $wp_customize, 'hero_section_title', 'Learn without limits and spread knowledge.', 'Hero Section Title', '_hero_section' );

    lessonlms_textarea_field_customize( $wp_customize, 'hero_section_description', 'Build new skills for that “this is my year” feeling with courses, certificates, and degrees from world-class universities and companies.', 'Hero Description', '_hero_section' );

     lessonlms_text_field_customize( $wp_customize, 'courses_button_text', 'See Courses', 'Courses Button Text', '_hero_section' );

     lessonlms_text_field_customize( $wp_customize, 'watch_button_text', 'Watch Video', 'Vedio Button Text', '_hero_section' );

     lessonlms_text_field_customize( $wp_customize, 'recent_engagement_text', 'Recent engagement', 'Recent Engagement Text', '_hero_section' );

     lessonlms_text_field_customize( $wp_customize, 'student_label_text', 'Students', 'Student Label Text', '_hero_section' );

     lessonlms_text_field_customize( $wp_customize, 'course_label_text', 'Courses', 'Course Label Text', '_hero_section' );
  }
}
add_action('customize_register','lessonlms_hero_customize_register');