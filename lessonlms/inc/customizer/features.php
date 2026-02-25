 <?php

 /**
  * Features Customizer
  */

function lessonlms_features_customize_register($wp_customize) {
  $wp_customize->add_section('features_section' ,array(
      'title' => __('Features Settings', 'lessonlms'),
      'priority' => 100,
  ));

  // Features Title
  $wp_customize->add_setting('features_title',array(
      'default'=> 'Learner outcomes through our awesome platform',
  ));

  $wp_customize->add_control('features_title',array(
      'label'=> __('Features Title','lessonlms'),
      'section'=> 'features_section',
      'type'=> 'textarea',
  ));

  //Features Description One
  $wp_customize->add_setting('features_description_one',array(
      'default'=> '87% of people learning for professional development report career benefits like getting a promotion, a raise, or starting a new career.',
  ));

  $wp_customize->add_control('features_description_one',array(
      'label'=> __('Features Description One','lessonlms'),
      'section'=> 'features_section',
      'type'=> 'textarea',
  ));
//Features Description Two
$wp_customize->add_setting('features_description_two',array(
    'default'=> 'Lesson Impact Report (2022)',
));

$wp_customize->add_control('features_description_two',array(
    'label'=> __('Features Description Two','lessonlms'),
    'section'=> 'features_section',
    'type'=> 'textarea',
));

//Features Button Text
$wp_customize->add_setting('features_button_text',array(
    'default'=> 'sign up',
));

$wp_customize->add_control('features_button_text',array(
    'label'=> __('Features Button Text','lessonlms'),
    'section'=> 'features_section',
    'type'=> 'text',
));

//Features Button URL

$wp_customize->add_setting('features_button_url',array(
    'default'=> '#',
));

$wp_customize->add_control('features_button_url',array(
    'label'=> __('Features Button URL','lessonlms'),
    'section'=> 'features_section',
    'type'=> 'url',
));

//Features Image One
$wp_customize->add_setting('features_image_one',array(
    'default'=> get_template_directory_uri() . '/assets/images/feature1.png',
));

$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'features_image_one',array(
    'label'=> __('Features Image One','lessonlms'),
    'section'=> 'features_section',
    'settings'=> 'features_image_one',
)));

// Feature Image Two
$wp_customize->add_setting('features_image_two',array(
    'default'=> get_template_directory_uri() . '/assets/images/feature2.png',
));

$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'features_image_two',array(
    'label'=> __('Features Image Two','lessonlms'),
    'section'=> 'features_section',
    'settings'=> 'features_image_two',
)));
}
add_action('customize_register','lessonlms_features_customize_register');