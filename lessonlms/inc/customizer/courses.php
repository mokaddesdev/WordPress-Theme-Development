<?php 
/**
 * course section customizer
 */

function lessonlms_courses_customize_register($wp_customize) {
 $wp_customize->add_section('course_settings', array(
      'title'=> __('Course Settings','lessonlms'),
      'priority' => 60,
  ));

  // Courses Section Title
  $wp_customize->add_setting('course_section_title',array(
      'default'=> 'Our popular courses',
  ));

  $wp_customize->add_control('course_section_title',array(
      'label'=> __('Course Section Title','lessonlms'),
      'section'=> 'course_settings',
      'type'=> 'text',
  ));

  // Courses Section Description
  $wp_customize->add_setting('course_section_description',array(
      'default'=> 'Build new skills with new trendy courses and shine for the next future career.',
  ));

  $wp_customize->add_control('course_section_description',array(
      'label'=> __('Course Section Description','lessonlms'),
      'section'=> 'course_settings',
      'type'=> 'textarea',
  ));
  }
add_action('customize_register','lessonlms_courses_customize_register');