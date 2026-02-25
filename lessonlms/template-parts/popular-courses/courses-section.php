<?php
/**
 * Popular Course Section
 * 
 * @package lessnlms
 */
    $args = array(
        'post_type'      => 'courses',
        'posts_per_page' => 6,
        'meta_key'       => '_enrolled_students',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    );
    $courses         = new WP_Query( $args );
    $courses_btn_url = get_post_type_archive_link('courses');
?>
<section class="courses">
    <div class="container">
        <?php get_template_part( 'template-parts/popular-courses/courses', 'heading' ); ?>
        <div class="courses-wrapper slick-items">
            <?php
            if ( $courses->have_posts() ) :
                while ( $courses->have_posts() ) :
                    $courses->the_post();
                    get_template_part( 'template-parts/commom/course', 'card' );
                endwhile;
                wp_reset_postdata();
            else :
                echo '<h2>' . esc_html__( 'Courses Not Found', 'lessonlms' ) . '</h2>';
            endif;
            ?>
        </div>

        <div class="flex justify-center mt-5">
            <div class="yellow-bg-btn See-Courses-btn">
                <a href="<?php echo esc_url( $courses_btn_url ); ?>">
                    <?php echo esc_html__( 'See All Courses', 'lessonlms' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>
