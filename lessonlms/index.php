<?php

/**
 * 
 * Blog Page
 * 
 * @package lessonlms
 */
get_header();
get_template_part("sections/pageTitle");

$blog_page_heading = get_theme_mod("blog_page_title", "Our All Blog");

$blog_page_description = get_theme_mod("blog_page_description", "Read our regular travel blog and know the latest update of tour and travel");
?>


<section class="see-all-blog" style="padding: 60px 0px 60px 0px;">
    <div class="container">
        <div class="blog-page-left">
            <div class="blog-heading">
                <h3>
                    <?php if ($blog_page_heading): ?>
                    <?php echo esc_html($blog_page_heading); ?>
                    <?php endif; ?>
                </h3>
                <p>
                    <?php if ($blog_page_heading): ?>
                    <?php echo esc_html($blog_page_description); ?>
                    <?php endif; ?>
                </p>
            </div>


            <div class="" style="display: grid; gap: 20px; grid-template-columns: repeat(2, 1fr);">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => get_option('posts_per_page'),
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'paged' => $paged,
                );

                $blog_post = new WP_Query($args);
                if ($blog_post->have_posts()):
                    while ($blog_post->have_posts()):
                        $blog_post->the_post();
                        get_template_part("template-parts/commom/blog", "card");
                    endwhile;
                endif;
                ?>
            </div>
            <?php echo lessonlms_all_pagination(); ?>

        </div>

        <div class="blog-page-right">
            <?php get_sidebar(); ?>
        </div>


    </div>

</section>

<?php get_footer(); ?>