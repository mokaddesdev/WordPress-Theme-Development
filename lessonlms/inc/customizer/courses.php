<?php 
/**
 * Courses Section Settings
 *
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_courses_customize_register' ) ) {
    function lessonlms_courses_customize_register( $wp_customize ) {

        lessonlms_add_section_setting( $wp_customize, 'course_settings', 'Popular Course Settings', 60 );

        lessonlms_text_field_customize( $wp_customize, 'course_section_title', 'Our popular courses', 'Course Section Title', 'course_settings' );

        lessonlms_textarea_field_customize( $wp_customize, 'course_section_description', 'Build new skills with new trendy courses and shine for the next future career.', 'Course Section Description', 'course_settings' );

        }
    }

add_action( 'customize_register', 'lessonlms_courses_customize_register' );