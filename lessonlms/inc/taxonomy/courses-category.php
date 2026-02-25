<?php
/**
 * Add Courses Category Taxonomy
 * 
 * @package lessonlms
 */
function lessonlms_register_course_category() {
    $labels = array(
        'name'              => 'Courses Categories',
        'singular_name'     => 'Course Category',
        'search_items'      => 'Search Course Categories',
        'all_items'         => 'All Course Categories',
        'edit_item'         => 'Edit Course Category',
        'update_item'       => 'Update Course Category',
        'add_new_item'      => 'Add New Course Category',
        'new_item_name'     => 'New Category Course Name',
        'menu_name'         => 'Courses Categories',
    );
    register_taxonomy( 'course_category', 'courses', array(
        'labels'       => $labels,
        'hierarchical' => true,
        'show_ui'      => true,
        'show_in_rest' => true,
        'rewrite'      => array(
            'slug' => 'course-category'
            ),
    ) );
}
add_action( 'init', 'lessonlms_register_course_category' );