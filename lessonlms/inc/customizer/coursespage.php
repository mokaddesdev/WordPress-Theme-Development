<?php 
/**
 * Courses Page Customizer
 */

function lessonlms_courses_page_customizer_register($wp_customize) {

 $wp_customize->add_section('courses_page_settings',array(
    'title' => __('Courses Page Settings', 'lessonlms'),
    'priority'=> 180,
 ));
  $wp_customize->add_setting('courses_page_title',array(
      'default'=> 'All Courses',
  ));

   $wp_customize->add_control('courses_page_title',array(
      'label'=> __('Course Page Title','lessonlms'),
      'section'=> 'courses_page_settings',
      'type'=> 'text',
  ));

   $wp_customize->add_setting('courses_page_description',array(
      'default'=> 'Build new skills with new trendy courses and shine for the next future career.',
  ));

  $wp_customize->add_control('courses_page_description',array(
      'label'=> __('Course Section Description','lessonlms'),
      'section'=> 'courses_page_settings',
      'type'=> 'textarea',
  ));
}
add_action('customize_register','lessonlms_courses_page_customizer_register');
