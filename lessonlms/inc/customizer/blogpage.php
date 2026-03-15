<?php
/**
 * Blog Page Customizer Settings
 *
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_blog_page_customize_register' ) ) {

	function lessonlms_blog_page_customize_register( $wp_customize ) {

        lessonlms_add_section_setting( $wp_customize, 'blog_page_settings', 'Blog Page Settings', 190 );

        lessonlms_text_field_customize( $wp_customize, 'blog_page_title', 'Our All Blog', 'Blog Page Title', 'blog_page_settings' );

        lessonlms_textarea_field_customize( $wp_customize, 'blog_page_description', 'Read our regular travel blog and know the latest update of tour and travel', 'Blog Page Description', 'blog_page_settings' );
	}
}

add_action( 'customize_register', 'lessonlms_blog_page_customize_register' );