<?php
/**
 * Add custom user roles.
 * 
 * @package lessonlms
 */

/**
 * Register custom roles for LessonLms
 * 
 * @return void
 */
function lessonlms_add_custom_roles() {
    add_role(
        'student',
        'Student',
        get_role('subscriber')->capabilities
    );

    add_role(
        'instructor',
        'Instructor',
        get_role('author')->capabilities
    );
}
add_action('init', 'lessonlms_add_custom_roles');