<?php 

/**
 * CTA Customizer
 * 
 * @package lessonlms
 */

   function lessonlms_cta_customize_register($wp_customize) {
  $wp_customize->add_section('cta_section', array(
      'title' => __('CTA Settings', 'lessonlms'),
      'priority' => 105,
  ));


//   CTA Title
$wp_customize->add_setting('cta_title', array(
    'default' => 'Take the next step toward your personal and professional goals with Lesson.',
));

$wp_customize->add_control('cta_title', array(
    'label' => __('CTA Title', 'lessonlms'),
    'section' => 'cta_section',
    'type' => 'text',
));

$wp_customize->add_setting('cta_description', array(
    'default' => 'Take the next step toward. Join now to receive personalized and more recommendations from the full Coursera catalog.',
));

$wp_customize->add_control('cta_description', array(
    'label' => __('CTA Description', 'lessonlms'),
    'section' => 'cta_section',
    'type' => 'textarea',
));

// CTA Button Text
        $wp_customize->add_setting('cta_button_text', array(
            'default' => 'Join now',
        ));

        $wp_customize->add_control('cta_button_text', array(
            'label' => __('CTA Button Text', 'lessonlms'),
            'section' => 'cta_section',
            'type' => 'text',
        ));

// CTA Button URL
$wp_customize->add_setting('cta_button_url', array(
    'default' => '#',
));

$wp_customize->add_control('cta_button_url', array(
    'label' => __('CTA Button URL', 'lessonlms'),
    'section' => 'cta_section',
    'type' => 'url',
));

// CTA Image
$wp_customize->add_setting('cta_image', array(
    'default' => get_template_directory_uri() . '/assets/images/cta-right.png',
));

$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cta_image', array(
    'label' => __('CTA Image', 'lessonlms'),
    'section' => 'cta_section',
    'settings' => 'cta_image',
)));
}
add_action('customize_register','lessonlms_cta_customize_register');