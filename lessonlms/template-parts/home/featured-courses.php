<?php
/**
 * Featured Courses Section
 * 
 * @package lessonlms
 */
 $featured_course_title = get_theme_mod( 'featured_course_title', 'Our Featured Courses' );
$featured_course_desc   = get_theme_mod( 'featured_course_description', 'Discover courses designed to help you excel in your professional and personal growth.' );
?>
<section class="courses">
    <div class="container">

        <div class="heading courses-heading">
            <?php if ( $featured_course_title ) : ?>
                <h2>
                    <?php echo esc_html( $featured_course_title ); ?>
                </h2>
            <?php endif; ?>

            <?php if ( $featured_course_desc ) : ?>
                <p>
                    <?php echo esc_html( $featured_course_desc ); ?>
                </p>
            <?php endif; ?>

        </div>

        <div class="courses-wrapper slick-items">

            <?php
            $args = array(
                    'post_type'      => 'courses',
                    'posts_per_page' => 6,
                    'meta_query'     => array(
                        array(
                            'key'     => '_is_featured',
                            'value'   => 'yes',
                            'compare' => '=',
                        ),
                    ),
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    );

            $courses = new WP_Query( $args );

            if ( $courses->have_posts() ):
                while ( $courses->have_posts() ) : $courses->the_post();
                    get_template_part('template-parts/commom/course', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                ?>

                <h2>
                    <?php echo esc_html__( 'Courses Not Found', 'lessonlms' ); ?>
                </h2>

            <?php
            endif;
            ?>
            
        </div>
    </div>
</section>