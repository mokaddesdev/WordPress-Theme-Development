<?php
/**
 * Template Name: Show All Courses
 * 
 * @package lessonlms
 */

    $page_title =  get_theme_mod('courses_page_title', 'All Courses');
    $page_description = get_theme_mod('courses_page_description', 'Build new skills with new trendy courses and shine for the next future career.');             
    get_header();
    get_template_part('template-parts/commom/breadcrumb');

    if (isset($_POST['selected_category'])) {
    $_SESSION['selected_category'] = intval($_POST['selected_category']);
}

$selected_category = $_SESSION['selected_category'] ?? 0;


 ?>


<!----- Courses section ----->
<section class="all-courses-section">
    <div class="container">
    <!-- courses left side -->
     <div class="all-courses-left-side">
        <?php get_template_part('template-parts/all-courses/all-courses', 'sidebar') ?>
     </div>

    <!-- courses right side -->
     <div class="all-courses-right-side">

        <div class="heading courses-heading">
            <h2><?php echo esc_html($page_title); ?></h2>
            <p><?php echo esc_html($page_description); ?></p>
        </div>

        <div class="courses-all-wrapper">

            <?php
            $args = array(
                "post_type" => "courses",
                'post_status' => 'publish',
                'orderby'        => 'date',
                'order' => 'DESC',
                'posts_per_page' => get_option('posts_per_page'),
                'paged' => $paged,
            );
            
            $couses = new WP_Query($args);
            
            if ($couses->have_posts()):
                while ($couses->have_posts()): $couses->the_post();

             get_template_part('template-parts/commom/course','card');
            endwhile; ?>
            <?php else: ?>
            <h2>Courses Not Found</h2>

            <?php endif;
            wp_reset_postdata(); ?>
        </div>

         <?php echo lessonlms_all_pagination(); ?>
    </div>
 </div>
</section>

<?php get_footer(); ?>