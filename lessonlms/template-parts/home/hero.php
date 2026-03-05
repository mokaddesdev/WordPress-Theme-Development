<?php
/**
 * Hero Section Template Part
 * 
 * @package lessonlms
 */
$hero_image         = get_theme_mod('hero_image');
$default_img_uri    = get_template_directory_uri();
$hero_title         = get_theme_mod( 'hero_section_title', 'Learn without limits and spread knowledge.' );
$hero_description   = get_theme_mod( 'hero_section_description', 'Build new skills for that “this is my year” feeling with courses, certificates, and degrees from world-class universities and companies.' );
$course_url         = get_post_type_archive_link( 'courses' );
$course_btn_text    = get_theme_mod( 'courses_button_text', 'See Courses' );
$see_vedio_btn      = get_theme_mod( 'watch_button_text', 'Watch Video' );
$see_vedio_btn_url  = get_theme_mod( 'watch_button_url', '#' );
$engagement_text    = get_theme_mod( 'recent_engagement_text', 'Recent engagement' );
$student_label      = get_theme_mod( 'student_label_text', 'Students' );
$course_label       = get_theme_mod( 'course_label_text', 'Courses' );
$top_categories     = get_terms( array(
                'taxonomy'   => 'course_category',
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => 3,
                'hide_empty' => true,
            ));

    if ( ! empty( $top_categories ) && ( ! is_array( $top_categories ) ) ) :
                $top_categories = [];
            endif;
$data               = total_enroll_course_count();
$total_course_count = $data['courses'];
$total_enrollments  = $data['enrollments'];
    if ( ! empty( $total_course_count ) && ! is_array($total_course_count) ) {
    $format_total_course_count = lessonlms_count_number_format($total_course_count);
    }
    if ( ! empty( $total_enrollments ) && ! is_array( $total_enrollments ) ) {
        $format_total_enrollments = lessonlms_count_number_format($total_enrollments);
        }
?>
<section class="hero">
    <div class="container">
        <div class="hero-wrapper">
            <div class="hero-img-box">
                <?php if ( $hero_image ) : ?>
                    <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( get_bloginfo('name') ); ?>">
                <?php else: ?>
                    <img src="<?php echo $default_img_uri ?>/assets/images/heor-img.png" alt="<?php echo esc_attr__( 'hero-img', 'lessonlms' ) ?>">
                <?php endif; ?>

                <!----- absolute card box ----->
                <div class="card-box">
                    <?php if ( ! empty( $top_categories ) && is_array($top_categories ) ) :
                        $icons = ['design.svg', 'development.svg', 'marketing.svg'];
                        foreach ( $top_categories as $index => $top_category ) : ?>
                            <div class="card-items item<?php echo esc_attr( $index + 1 ); ?>">
                                <?php
                                echo lessonlms_asset_svg('hero-section', $icons[$index] ?? 'default.svg', $top_category->name . 'svg');
                                ?>
                                <div class="text">
                                    <span>
                                        <?php
                                        echo esc_html($top_category->count) . ' ';
                                        echo esc_attr__('Courses', 'lessonlms');
                                        ?>
                                    </span>
                                    <p class="common-heading-two">
                                        <?php echo esc_html($top_category->name); ?>
                                    </p>
                                </div>
                            </div>
                    <?php endforeach;
                        wp_reset_postdata();
                    endif; ?>
                </div>
            </div>
            <div class="hero-text-box">
                <h1><?php echo esc_html( $hero_title ); ?></h1>
                <p><?php echo esc_html( $hero_description ); ?></p>

                <div class="hero-btns">
                    <div class="yellow-bg-btn See-Courses-btn">
                        <a href="<?php echo esc_url($course_url); ?>">
                            <?php echo esc_html($course_btn_text); ?>
                        </a>
                    </div>
                    <a class="popup-vimeo" href="https://vimeo.com/1170557176?share=copy&fl=sv&fe=ci">
                        <div class="watch-video-btn">
                        <div class="play-btn">
                            <i class="fa-solid fa-play"></i>
                        </div>
                        <span>
                            Watch Vedio
                        </span>
                    </div>
                    </a><br>
                </div>

                <div class="engagement">
                    <span>
                        <?php echo esc_html($engagement_text); ?>
                    </span>
                    <div class="engagement-wrapper">
                        <h3>
                            <?php echo esc_html($format_total_enrollments); ?>
                            <span>
                                <i class="fa-solid fa-plus"></i>
                                <?php echo esc_html($student_label); ?>
                            </span>
                        </h3>
                        <h3>
                            <?php echo esc_html( $format_total_course_count ); ?>
                            <span>
                                <i class="fa-solid fa-plus"></i>
                                <?php echo esc_html( $course_label ); ?>
                            </span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>