<?php
/**
 * Blog Customizer Settings
 *
 * @package lessonlms
 */

if ( ! function_exists( 'lessonlms_blog_customize_register' ) ) {
	function lessonlms_blog_customize_register( $wp_customize ) {

		lessonlms_add_section_setting( $wp_customize, 'blog_settings', 'Blog Settings', 120 );

        lessonlms_text_field_customize( $wp_customize, 'blog_section_title', 'Our Blog', 'Blog Section Title', 'blog_settings' );

        lessonlms_textarea_field_customize( $wp_customize, 'blog_section_description', 'Read our regular travel blog and know the latest update of tour and travel', 'Blog Section Description', 'blog_settings' );
        
        lessonlms_text_field_customize( $wp_customize, 'blog_button_text', 'See Blogs', 'Blog Button Text', 'blog_settings' );

        lessonlms_url_field_customize( $wp_customize, 'blog_button_url', home_url( '/blog/' ), 'Blog Button URL', 'blog_settings' );
	}
}

add_action( 'customize_register', 'lessonlms_blog_customize_register' );