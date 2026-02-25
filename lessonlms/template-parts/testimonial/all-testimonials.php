<?php 
/**
 * All Testimonials Card Section
 * 
 * @package lessonlms
 */
?>
   <section class="testimonial">
    <div class="container">
        <div class="all-testimonial-items">
            <?php
            $arg = array(
                'post_type' => 'testimonials',
                'posts_per_page' => get_post('post_per_page'),
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $new_testimonial = new WP_Query($arg);

            if ($new_testimonial->have_posts()) :
                while ($new_testimonial->have_posts()) :
                    $new_testimonial->the_post();
                    ?>

 <div class="all-testimonial-wrapper">
    <!-- student box -->
    <div class="student-details-card">
        <div class="student-image">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')); ?>"
                    alt="<?php echo esc_attr(get_the_title()); ?>"
                    style="width:72px; height:72px; object-fit:cover; border-radius:9999px;">
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/client-img.png"
                    alt="Client image" style="width:72px; height:72px; border-radius:9999px;">
            <?php endif; ?>
        </div>

        <div class="name">
            <h3><?php the_title(); ?></h3>
            <span>
                <?php
                $student_designation = get_post_meta(get_the_ID(), "student_designation", true);
                if (!empty($student_designation)) {
                    echo esc_html(wp_trim_words($student_designation, 7, '...'));
                }
                ?>
            </span>
        </div>
    </div>

    <!-- review box -->
    <div class="reviews">
        <p>
            <?php
            $content = get_the_content();
            echo esc_html(wp_trim_words(wp_strip_all_tags($content), 35, '...'));
            ?>
        </p>
    </div>
</div>

           <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>' . __('No testimonials found', 'lessonlms') . '</p>';
            endif;
            ?>
        </div>
    </div>
</section>

 <style>
                        .student-details-card{
                            display: flex;
                            gap: 10px;
                            align-items: center;
                            justify-items: center;
                        }
                    </style>
