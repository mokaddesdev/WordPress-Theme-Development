<?php 

/**
 * Blog Page Customizer
 */


function lessonlms_blog_page_customize_register($wp_customize) {
 $wp_customize->add_section('blog_page_settings',array(
    'title' => __('Blog Page Settings', 'lessonlms'),
    'priority'=> 190,
 ));
  $wp_customize->add_setting('blog_page_title',array(
      'default'=> 'Our All Blog',
  ));

   $wp_customize->add_control('blog_page_title',array(
      'label'=> __('Blog Page Title','lessonlms'),
      'section'=> 'blog_page_settings',
      'type'=> 'text',
  ));

   $wp_customize->add_setting('blog_page_description',array(
      'default'=> 'Read our regular travel blog and know the latest update of tour and travel',
  ));

  $wp_customize->add_control('blog_page_description',array(
      'label'=> __('Blog Section Description','lessonlms'),
      'section'=> 'blog_page_settings',
      'type'=> 'textarea',
  ));
  }
add_action('customize_register','lessonlms_blog_page_customize_register');