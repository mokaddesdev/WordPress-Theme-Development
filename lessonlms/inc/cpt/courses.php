<?php
/**
 * Register Custom Post Type Courses
 * 
 * @package  lessonlms
 */
function lessonlms_custome_courses_register(){
    $labels = array(
        'name'                  => __( 'Courses', 'lessonlms' ),
        'singular_name'         => __( 'Course', 'lessonlms' ),
        'menu_name'             => __( 'Courses', 'lessonlms' ),
        'name_admin_bar'        => __( 'Course', 'lessonlms' ),
        'add_new'               => __( 'Add New', 'lessonlms' ),
        'add_new_item'          => __( 'Add New Course', 'lessonlms' ),
        'new_item'              => __( 'New Course', 'lessonlms' ),
        'edit_item'             => __( 'Edit Course', 'lessonlms' ),
        'view_item'             => __( 'View Course', 'lessonlms' ),
        'all_items'             => __( 'All Courses', 'lessonlms' ),
        'search_items'          => __( 'Search Courses', 'lessonlms' ),
        'parent_item_colon'     => __( 'Parent Courses:', 'lessonlms' ),
        'not_found'             => __( 'No Courses found.', 'lessonlms' ),
        'not_found_in_trash'    => __( 'No Courses found in Trash.', 'lessonlms' ),
    );     
    $args = array(
        'labels'             => $labels,
        'description'        => 'Courses custom post type.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
         'rewrite'            => array( 'slug' => 'lessonlms_courses_slug' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'menu_position'      => 20,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'author' ),
        'taxonomies'         => array( 'course_category', 'course_level'),
        'show_in_rest'       => true,
    );
  
    register_post_type('courses', $args);
}
add_action( 'init', 'lessonlms_custome_courses_register' );

require_once get_template_directory() . '/inc/taxonomy/courses-category.php';

require_once get_template_directory() . '/inc/taxonomy/courses-level.php';

require_once get_template_directory() . '/inc/meta-boxes/courses-meta-box.php';