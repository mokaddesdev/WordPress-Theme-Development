<?php
/**
 * Featured Courses Section
 * 
 * @package lessonlms
 */
$args = array(
    'post_type' => 'courses',
    'posts_per_page' => 6,
    'meta_query' => array(
        array(
            'key' => '_is_featured',
            'value' => 'yes',
            'compare' => '='
        )
    ),
    'orderby' => 'date',
    'order' => 'DESC',
);
$courses = new WP_Query($args);
?>
<section class="courses">
    <div class="container">
        <?php
        /**
         * Featured Courses Heading
         * 
         * @package lessonlms
         */
        $course_section_title = get_theme_mod('course_section_title', 'Featured Courses');
        $course_section_description = get_theme_mod('course_section_description', 'Discover courses designed to help you excel in your professional and personal growth.');
        ?>
        <div class="heading courses-heading">
            <?php if ($course_section_title): ?>
                <h2><?php echo esc_html($course_section_title); ?></h2>
            <?php endif; ?>

            <?php if ($course_section_description): ?>
                <p><?php echo esc_html($course_section_description); ?></p>
            <?php endif; ?>
        </div>

        <div class="courses-wrapper slick-items">
            <?php
            if ($courses->have_posts()):
                while ($courses->have_posts()):
                    $courses->the_post();
                    get_template_part('template-parts/commom/course', 'card');
                endwhile;
                wp_reset_postdata();
            else:
                echo '<h2>' . esc_html__('Courses Not Found', 'lessonlms') . '</h2>';
            endif;
            ?>
        </div>
    </div>
</section>