 <?php
 /**
  * Explore Category setting
  *
  * @package lessonlms
  */

if ( ! function_exists( 'lessonlms_explore_category_customizer' ) ) {
    function lessonlms_explore_category_customizer( $wp_cutomize ) {

        lessonlms_add_section_setting( $wp_cutomize, '_explore_category_section', 'Explore Category Heading', 45 );

        lessonlms_text_field_customize( $wp_cutomize, '_explore_category_heading', 'Explore Categories', 'Expore Category Title', '_explore_category_section' );

        lessonlms_textarea_field_customize( $wp_cutomize, '_explore_category_desc', 'Discover categories designed to help you excel in your professional and personal growth.', 'Expore Category Description', '_explore_category_section' );
    }
}
add_action( 'customize_register', 'lessonlms_explore_category_customizer' );