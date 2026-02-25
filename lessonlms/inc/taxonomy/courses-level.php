<?php
/**
 * Courses Level Taxonomy
 * 
 * @package  lessonlms
 */
function lessonlms_register_course_level_taxonomy() {

    $labels = array(
        'name'              => 'Course Levels',
        'singular_name'     => 'Course Level',
        'search_items'      => 'Search Levels',
        'all_items'         => 'All Levels',
        'edit_item'         => 'Edit Level',
        'update_item'       => 'Update Level',
        'add_new_item'      => 'Add New Level',
        'new_item_name'     => 'New Level Name',
        'menu_name'         => 'Course Level',
    );

    register_taxonomy( 'course_level', 'courses', array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'course-level' ),
    ));
}
add_action( 'init', 'lessonlms_register_course_level_taxonomy' );