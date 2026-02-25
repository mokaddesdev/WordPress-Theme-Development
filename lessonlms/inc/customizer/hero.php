<?php

/**
 * Hero Customizer
 */

function lessonlms_hero_customize_register($wp_customize) {
$wp_customize->add_section('hero_section', array(
    'title' => __('Hero Settings', 'lessonlms'),
    'priority' => 30,
));

// Hero Image
$wp_customize->add_setting('hero_image', array(
    'default' => get_template_directory_uri() . '/assets/images/heor-img.png',
));
$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
    'label' => __('Hero Image', 'lessonlms'),
    'settings' => 'hero_image',
    'section' => 'hero_section',
)));

//Hero Section Title
$wp_customize->add_setting('hero_section_title', array(
    'default' => 'Learn without limits and spread knowledge.',
));

$wp_customize->add_control('hero_section_title', array(
    'label' => __('Hero Title', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));

// Hero Section Description
$wp_customize->add_setting('hero_section_description', array(
    'default' => 'Build new skills for that “this is my year” feeling with courses, certificates, and degrees from world-class universities and companies.',
));

$wp_customize->add_control('hero_section_description', array(
    'label' => __('Hero Description', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'textarea',
));

//Courses Button Text
$wp_customize->add_setting('courses_button_text', array(
    'default' => 'See Courses',
));

$wp_customize->add_control('courses_button_text', array(
    'label' => __('Courses Button Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));

//Courses Button URL
$wp_customize->add_setting('courses_button_url', array(
    'default' => '#',
));

$wp_customize->add_control('courses_button_url', array(
    'label' => __('Courses Button URL', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'url',
));


//Watch Button Text
$wp_customize->add_setting('watch_button_text', array(
    'default' => 'Watch Video',
));

$wp_customize->add_control('watch_button_text', array(
    'label' => __('Vedio Button Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));

//Courses Button URL
$wp_customize->add_setting('watch_button_url', array(
    'default' => '#',
));

$wp_customize->add_control('watch_button_url', array(
    'label' => __('Vedio Button URL', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'url',
));



//   Recent engagement
$wp_customize->add_setting('recent_engagement_text', array(
    'default' => 'Recent engagement',
));

$wp_customize->add_control('recent_engagement_text', array(
    'label' => __('Recent Engagement Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));

// students count
$wp_customize->add_setting('student_count_text', array(
    'default' => '50K',
    'lessonlms'
));

$wp_customize->add_control('student_count_text', array(
    'label' => __('Student Count Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));

//    students label

$wp_customize->add_setting('student_label_text', array(
    'default' => 'Students',
));

$wp_customize->add_control('student_label_text', array(
    'label' => __('Student Label Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));

// Cources Count
$wp_customize->add_setting('course_count_text', array(
    'default' => '70+',
    'lessonlms'
));

$wp_customize->add_control('course_count_text', array(
    'label' => __('Course Count Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));

// Courses Label
$wp_customize->add_setting('course_label_text', array(
    'default' => 'Courses',
));

$wp_customize->add_control('course_label_text', array(
    'label' => __('Course Label Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));


// UI/UX Design Count
$wp_customize->add_setting('uiux_design_count', array(
    'default' => '20',
    'lessonlms'
));

$wp_customize->add_control('uiux_design_count', array(
    'label' => __('UI/UX Design Count', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'number',
));

// UI/UX Design Label
$wp_customize->add_setting('uiux_design_label', array(
    'default' => 'UI/UX Design',
));

$wp_customize->add_control('uiux_design_label', array(
    'label' => __('UI/UX Design Label', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));

// Development Count
$wp_customize->add_setting('development_count', array(
    'default' => '30',
    'lessonlms'
));

$wp_customize->add_control('development_count', array(
    'label' => __('Development Count Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'number',
));

// Development Count Label
$wp_customize->add_setting('development_label_text', array(
    'default' => 'Development',
));

$wp_customize->add_control('development_label_text', array(
    'label' => __('Development Label Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));



// Marketing Count
$wp_customize->add_setting('marketing_count', array(
    'default' => '20',
    'lessonlms'
));

$wp_customize->add_control('marketing_count', array(
    'label' => __('Marketing Count', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'number',
));

// Marketing Count Label
$wp_customize->add_setting('marketing_label_text', array(
    'default' => 'Marketing',
));

$wp_customize->add_control('marketing_label_text', array(
    'label' => __('Marketing Label Text', 'lessonlms'),
    'section' => 'hero_section',
    'type' => 'text',
));
}
add_action('customize_register','lessonlms_hero_customize_register');