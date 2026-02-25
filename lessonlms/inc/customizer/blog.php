<?php 

/**
 * Blog Customizer
 */
function lessonlms_blog_customize_register($wp_customize) {

  $wp_customize->add_section('blog_settings', array(
      'title'=> __('Blog Settings','lessonlms'),
      'priority' => 120,
  ));

  // Blog Section Title
  $wp_customize->add_setting('blog_section_title',array(
      'default'=> 'Our Blog',
  ));

  $wp_customize->add_control('blog_section_title',array(
      'label'=> __('Blog Section Title','lessonlms'),
      'section'=> 'blog_settings',
      'type'=> 'text',
  ));

  // Blog Section Description
  $wp_customize->add_setting('blog_section_description',array(
      'default'=> 'Read our regular travel blog and know the latest update of tour and travel',
  ));

  $wp_customize->add_control('blog_section_description',array(
      'label'=> __('Blog Section Description','lessonlms'),
      'section'=> 'blog_settings',
      'type'=> 'textarea',
  ));

    $wp_customize->add_setting('blog_button_text' ,array(
        'default' => 'See Blogs',
    ));
    $wp_customize->add_control('blog_button_text',array(
        'label' => __('Blog Button Text', 'lessonlms'),
        'section' => 'blog_settings',
         'type' => 'text',
    ));

       $wp_customize->add_setting('blog_button_url' ,array(
        'default' => 'http://localhost/wordpress/index.php/blog/',
    ));
    $wp_customize->add_control('blog_button_url',array(
        'label' => __('Blog Button URL', 'lessonlms'),
        'section' => 'blog_settings',
         'type' => 'url',
    ));
}
add_action('customize_register','lessonlms_blog_customize_register');
