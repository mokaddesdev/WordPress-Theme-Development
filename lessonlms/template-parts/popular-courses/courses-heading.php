<?php
/**
 * Popular Course Heading
 * 
 * @package lessnlms
 */
    $course_section_title       = get_theme_mod('course_section_title', 'Our Popular Courses');
    $course_section_description = get_theme_mod('course_section_description', 'Build new skills with trendy courses and shine for the next future career.');
?>

<div class="heading courses-heading">
    <?php if ( $course_section_title ) : ?>
        <h2><?php echo esc_html( $course_section_title ); ?></h2>
    <?php endif; ?>

    <?php if ( $course_section_description ) : ?>
        <p><?php echo esc_html( $course_section_description ); ?></p>
    <?php endif; ?>
</div>
