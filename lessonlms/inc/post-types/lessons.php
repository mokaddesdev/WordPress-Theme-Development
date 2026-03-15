<?php
/**
 * Register Custom Post Type Lessons
 * 
 * @package  lessonlms
 */
function lessonlms_custome_lessons_register(){
    $labels = array(
        'name'                  => __( 'Lessons', 'lessonlms' ),
        'singular_name'         => __( 'Lesson', 'lessonlms' ),
        'menu_name'             => __( 'Lessons', 'lessonlms' ),
        'name_admin_bar'        => __( 'Lesson', 'lessonlms' ),
        'add_new'               => __( 'Add New', 'lessonlms' ),
        'add_new_item'          => __( 'Add New Lesson', 'lessonlms' ),
        'new_item'              => __( 'New Lesson', 'lessonlms' ),
        'edit_item'             => __( 'Edit Lesson', 'lessonlms' ),
        'view_item'             => __( 'View Lesson', 'lessonlms' ),
        'all_items'             => __( 'All Lessons', 'lessonlms' ),
        'search_items'          => __( 'Search Lessons', 'lessonlms' ),
        'parent_item_colon'     => __( 'Parent Lessons:', 'lessonlms' ),
        'not_found'             => __( 'No Lessons found.', 'lessonlms' ),
        'not_found_in_trash'    => __( 'No Lessons found in Trash.', 'lessonlms' ),
    );     
    $args = array(
        'labels'             => $labels,
        'description'        => 'Lessons custom post type for courses lesson',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
         'rewrite'            => array( 'slug' => 'lessons_slug' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-video-alt3',
        'menu_position'      => 29,
        'supports'           => array( 'title', 'editor', 'author' ),
        'show_in_rest'       => false,
    );
  
    register_post_type( 'lessons', $args );
}
add_action( 'init', 'lessonlms_custome_lessons_register' );

include_once get_template_directory() . '/inc/meta-boxes/lesson-meta-box.php';