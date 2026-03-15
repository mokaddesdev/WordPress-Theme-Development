<?php
/**
 * Customizer helper function
 * 
 * @package lessonlms
 */

/**
 * Add section setting
 */

if ( ! function_exists( 'lessonlms_add_section_setting') ) {
    function lessonlms_add_section_setting( $wp_customize, $id, $title, $priority ) {
        $wp_customize->add_section( $id, array(
            'title'     => $title,
            'priority'  => $priority,
        ) );
    }
}
/**
 * Add text field
 */
if ( ! function_exists( 'lessonlms_text_field_customize' ) ) {
    function lessonlms_text_field_customize( $wp_customize, $id, $default = '', $label, $section = '') {

        $wp_customize->add_setting( $id, array(
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( $id, array(
            'label'   => __( $label, 'lessonlms' ),
            'section' => $section,
            'type'    => 'text',
        ) );
    }
}

/**
 * Add text area field
 */

if ( ! function_exists( 'lessonlms_textarea_field_customize' ) ) {
    function lessonlms_textarea_field_customize( $wp_customize, $id, $default = '', $label, $section = '' ) {

        $wp_customize->add_setting( $id, array(
            'default'           => $default,
            'sanitize_callback' => 'sanitize_textarea_field',
        ) );

        $wp_customize->add_control( $id, array(
            'label'   => __( $label, 'lessonlms' ),
            'section' => $section,
            'type'    => 'textarea',
        ) );
    }
}

/**
 * Add image field
 */

if ( ! function_exists( 'lessonlms_image_customize' ) ) {
    function lessonlms_image_customize( $wp_customize, $id, $image_name = '', $label, $section = '' ) {
        $wp_customize->add_setting( $id, array(
            'default'           => THEME_URI . "/assets/images/$image_name",
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control(
            $wp_customize,
            $id,
            array(
                'label'   => __( $label, 'lessonlms' ),
                'section' => $section,
                'settings'=> $id,
            )
        ) );
    }
}

/**
 * Add url field
 */

if ( ! function_exists( 'lessonlms_url_field_customize' ) ) {
    function lessonlms_url_field_customize( $wp_customize, $id, $default = '', $label, $section = '' ) {

        $wp_customize->add_setting(
            $id,
            array(
                'default'           => $default,
                'sanitize_callback' => 'esc_url_raw',
            )
        );

        $wp_customize->add_control(
            $id,
            array(
                'label'   => sprintf( __('%s URL', 'lessonlms'), $label ),
                'section' => $section,
                'type'    => 'url',
            )
        );
    }
}

/**
 * Add email field
 */

if ( ! function_exists( 'lessonlms_email_field_customize' ) ) {
   function lessonlms_email_field_customize( $wp_customize, $id, $default = '', $label, $section = '' ) {
        $wp_customize->add_setting(
            $id,
            array(
                'default'           => $default,
                'sanitize_callback' => 'sanitize_email',
                )
            );
        $wp_customize->add_control(
            $id,
            array(
                'label'     => __( $label, 'lessonlms' ),
                'section'   => $section,
                'type'      => 'email',
                )
            );
    }
}