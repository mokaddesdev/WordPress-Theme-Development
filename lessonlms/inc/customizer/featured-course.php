<?php 
/**
 * Featured courses section settings
 *
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_featured_courses_customize_register' ) ) {
    function lessonlms_featured_courses_customize_register( $wp_customize ) {

        lessonlms_add_section_setting( $wp_customize, 'featured_course_settings', 'Featured Course Settings', 55 );

        lessonlms_text_field_customize( $wp_customize, 'featured_course_title', 'Our Featured Courses', 'Featured Course Title', 'featured_course_settings' );

        lessonlms_textarea_field_customize( $wp_customize, 'featured_course_description', 'Discover courses designed to help you excel in your professional and personal growth.', 'Featured Course Description', 'featured_course_settings' );

        }
    }

add_action( 'customize_register', 'lessonlms_featured_courses_customize_register' );