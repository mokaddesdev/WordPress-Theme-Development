<?php 

/**
 * Footer Customizer
 */


function lessonlms_footer_customize_register( $wp_customize ) {

    // Footer Section
    $wp_customize->add_section('footer_settings', array(
        'title'=> __('Footer Settings','lessonlms'),
        'priority' => 130,
    ));

    // Footer Logo
    $wp_customize->add_setting('footer_logo');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo',array(
        'label'=> __('Footer Logo','lessonlms'),
        'settings'=> 'footer_logo',
        'section'=> 'footer_settings',
    )));

    // Social Media Links
    $socials = array('twitter','facebook','linkedin','instagram');
    foreach ($socials as $social) {
        $wp_customize->add_setting("footer_{$social}_link", array(
            "default"=> '#',
        ));
        $wp_customize->add_control("footer_{$social}_link", array(
            "label"=> sprintf( __("%s URL","lessonlms"), ucfirst($social)),
            "section"=> "footer_settings",
            "type"=> 'url',
        ));
    }

    // Footer About Text
    $wp_customize->add_setting('footer_about_text',array(
        'default'=> 'Need to help for your dream Career? trust us. With Lesson, study becomes a lot easier with us.',
    ));
    $wp_customize->add_control('footer_about_text',array(
        'label'=> __('About Text','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'textarea',
    ));

    // Footer Menu Titles
    $wp_customize->add_setting('footer_menu1_title',array('default'=> 'Company'));
    $wp_customize->add_control('footer_menu1_title',array(
        'label'=> __('Footer Menu1 Title','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'text',
    ));

    $wp_customize->add_setting('footer_menu2_title',array('default'=> 'Support'));
    $wp_customize->add_control('footer_menu2_title',array(
        'label'=> __('Footer Menu2 Title','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'text',
    ));

    // Footer Contact Info
    $wp_customize->add_setting('footer_address',array('default'=> 'Address'));
    $wp_customize->add_control('footer_address',array(
        'label'=> __('Address Title','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'text',
    ));

    $wp_customize->add_setting('footer_location_title',array('default'=> 'Location:'));
    $wp_customize->add_control('footer_location_title',array(
        'label'=> __('Location Title','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'text',
    ));

    $wp_customize->add_setting('footer_location_description',array('default'=> '27 Division St, New York, NY 10002, USA'));
    $wp_customize->add_control('footer_location_description',array(
        'label'=> __('Location Description','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'text',
    ));

    // Email
    $wp_customize->add_setting('footer_email_title',array('default'=> 'Email:'));
    $wp_customize->add_control('footer_email_title',array(
        'label'=> __('Email Title','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'text',
    ));

    $wp_customize->add_setting('footer_email',array('default'=> 'email@gmail.com'));
    $wp_customize->add_control('footer_email',array(
        'label'=> __('Footer Email','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'email',
    ));

    // Phone
    $wp_customize->add_setting('footer_phone_title',array('default'=> 'Phone:'));
    $wp_customize->add_control('footer_phone_title',array(
        'label'=> __('Phone Title','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'text',
    ));

    $wp_customize->add_setting('footer_phone_description',array('default'=> '+ 000 1234 567 890'));
    $wp_customize->add_control('footer_phone_description',array(
        'label'=> __('Phone Description','lessonlms'),
        'section'=> 'footer_settings',
        'type'=> 'tel',
    ));

}
add_action('customize_register','lessonlms_footer_customize_register');
