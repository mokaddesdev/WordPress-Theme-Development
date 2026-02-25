<?php
/**
 * Register Courses Content Custom Post Type
 * 
 * @package lessonlms
 */

function lessonlms_custom_courses_content_post_type() {
    $labels = array(
        'name'               => __( 'Courses Content', 'lessonlms' ),
        'singular_name'      => __( 'Course Content', 'lessonlms' ),
        'menu_name'          => __( 'Courses Contents','lessonlms' ),
        'name_admin_bar'     => __( 'Course Content','lessonlms' ),
        'add_new'            => __( 'Add New Course Content', 'lessonlms' ),
        'add_new_item'       => __( 'Add New Course Content', 'lessonlms' ),
        'edit_item'          => __( 'Edit Course Content', 'lessonlms'),
        'view_item'          => __( 'View Course Content', 'lessonlms'),
        'all_items'          => __( 'View All Course Content', 'lessonlms' ),
        'search_items'       => __( 'Search Course Content', 'lessonlms' ),
        'parent_item_colon'  => __( 'Parent Course Content', 'lessonlms' ),
        'not_found'          => __( 'No Course Content Found', 'lessonlms') ,
        'not_found_in_trash' => __( 'No Course Content Found in Trash', 'lessonlms' ),
    );

    $args = array(
        'labels'             => $labels,
        'description'        => 'Course Content custom post type for add course content',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'courses_content' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'menu_position'      => 30,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'author' ),
        'show_in_rest'       => true
    );

    register_post_type( 'courses_contents', $args );
}
add_action( 'init', 'lessonlms_custom_courses_content_post_type' );

require_once get_template_directory() . '/inc/meta-boxes/courses-content-meta-box.php';
