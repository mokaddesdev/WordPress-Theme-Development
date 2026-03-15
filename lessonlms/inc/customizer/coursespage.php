<?php
/**
 * Courses Page Customizer Settings
 *
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_courses_page_customize_register' ) ) {
	function lessonlms_courses_page_customize_register( $wp_customize ) {

        lessonlms_add_section_setting( $wp_customize, 'lessonlms_courses_page_settings', 'Courses Page Settings', 180 );

        lessonlms_text_field_customize( $wp_customize, 'courses_page_title', 'All Courses', 'Courses Page Title', 'lessonlms_courses_page_settings' );
        
         lessonlms_textarea_field_customize( $wp_customize, 'courses_page_description', 'Build new skills with new trendy courses and shine for the next future career.', 'Courses Page Description', 'lessonlms_courses_page_settings' );
	}
}

add_action( 'customize_register', 'lessonlms_courses_page_customize_register' );