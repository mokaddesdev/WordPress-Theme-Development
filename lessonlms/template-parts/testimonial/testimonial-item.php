<div class="testimonial-wrapper">
    <!-- student box -->
    <div class="student-details">
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
        <div class="absolute-svg">
            <?php get_template_part('template-parts/testimonial/testimonial', 'svg'); ?>
        </div>
        <p>
            <?php
            $content = get_the_content();
            echo esc_html(wp_trim_words(wp_strip_all_tags($content), 35, '...'));
            ?>
        </p>
    </div>
</div>
